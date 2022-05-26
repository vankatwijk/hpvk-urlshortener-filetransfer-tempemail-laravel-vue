<?php

namespace App\Http\Controllers;

use App\Link;
use App\User;
use App\Click;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ShowShortLink;
use App\Http\Requests\StoreShortLink;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\StoreShortLinkUpload;
use App\Http\Resources\Link as LinkResource;

class LinksController extends Controller
{
    public function index()
    {
        $links = $this->getLinksForUserOrGuest();

        return response()->json($links);
    }
    
    public function showclick(Request $request, $link_id)
    {
        $clicks = $this->getclicksForLink($link_id);

        return response()->json($clicks);
    }

    public function indexTrees()
    {
        $links = $this->getTreeLinksForUserOrGuest();

        return response()->json($links);
    }

    public function policy()
    {
        return view('pages.policy');
    }

    public function blog()
    {
        return view('links.create');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function datadeletion()
    {
        return view('pages.datadeletion');
    }

    public function create()
    {
        return view('links.create');
    }

    public function addRemoveTree(Request $request)
    {
        $links = $this->updateLinkTree($request->id);

        return response()->json($links);
    }

    public function removeLink(Request $request)
    {
        $links = $this->removeLinkdb($request->id);

        return response()->json($links);
    }

    public function saveLinkChanges(Request $request)
    {
        $links = $this->saveLinkChangesdb($request);

        return response()->json($links);
    }

    public function saveLinkTreeChanges(Request $request)
    {
        if (auth()->guest()) {
            return auth()->guest();
        }

        $user = auth()->user();
        $user->bg_color = $request->bg_color;
        $user->description = $request->description;
        $user->save();


        return response()->json(auth()->user());
    }

    public function store(StoreShortLink $request)
    {
        $data = $request->validated();

        $link = $this->createLinkForUserOrGuest($data);

        return response()->json(new LinkResource($link));
    }

    public function storetext(Request $request)
    {

        if (auth()->guest()) {
            return Link::create([
                "original" => $request->original,
                "label" => $request->label,
            ]);
        }

        $link = auth()->user()->links()->create([
            "intree" => $request->intree,
            "original" => $request->original,
            "label" => $request->label,
        ]);

        return response()->json(new LinkResource($link));
    }

    public function storeupload(StoreShortLinkUpload $request)
    {

        $data = $request->validated();

        $link = $this->createUploadForUserOrGuest($data);

        return response()->json(new LinkResource($link));
    }

    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }

    public function show(ShowShortLink $request, Link $link)
    {
        $data = $request->validated();
        
        $ip = $this->getIp(); /* Static IP address */
        $currentUserInfo = \Location::get($ip);

        $link->addClick(Carbon::now(),$currentUserInfo);
        

        if($link->original == '@file'){

            if(Storage::disk('public')->assertExists('files/'.$link->folder.'/'.$link->file_name)){
                $full_path = Storage::disk('public')->path('files/'.$link->folder.'/'.$link->file_name);
                $imneType = mime_content_type($full_path);
                
                //if the file is an image display it instead of making it downloadable
                if($imneType == "image/png" || $imneType == "image/jpg" || $imneType == "image/jpeg"){
                    $base64 = base64_encode(Storage::disk('public')->get('files/'.$link->folder.'/'.$link->file_name));
                    $image_data = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
                    
                    //this will generate an image that you cna use inside an email or just right click to download
                    return response()->file($full_path, ['Content-Type',$imneType]);
                    //return view('viewer.image')->with('imageData',$image_data);
                }

                //make file downloadable
                return Storage::disk('public')->download('files/'.$link->folder.'/'.$link->file_name);
            }else{
                return view('links.create');
            }
        }else{

            return redirect()->to($link->original);
        }

    }

    public function showtree($link)
    {
        if (count(app()->encoder->decode($link)) > 0) {
            $decodedId = app()->encoder->decode($link)[0];
            $user = User::where('id', $decodedId)->first();

            return view('links.tree')->with('user',$user)->with('links',$user->treeLinks);
        }

    }

    private function getclicksForLink($id)
    {
        if (auth()->guest()) {
            return [];
        }
        $clicks = Click::where('link_id','=',$id)->latest()->take(5)->get();

        return $clicks;
    }

    private function saveLinkChangesdb($request)
    {
        if (auth()->guest()) {
            return collect();
        }
        $link = Link::where('id','=',$request->id)->update(['label' => $request->label,'bg_color' => $request->bg_color,'order' => $request->order]);

        return auth()->user()->links;
    }

    private function removeLinkdb($id)
    {
        if (auth()->guest()) {
            return collect();
        }
        $link = Link::where('id','=',$id)->delete();


        return auth()->user()->links;
    }

    private function updateLinkTree($id)
    {
        if (auth()->guest()) {
            return collect();
        }
        $link = Link::where('id','=',$id)->first();

        Link::where('id','=',$id)->update(["intree" => ($link->intree == 1 ? 0 : 1) ]);


        return auth()->user()->links;
    }

    private function getTreeLinksForUserOrGuest()
    {
        if (auth()->guest()) {
            return collect();
        }

        return ['user'=>auth()->user(),'link' => app()->encoder->encode(auth()->user()->id),'tree' => auth()->user()->treeLinks];
    }

    private function getLinksForUserOrGuest()
    {
        if (auth()->guest()) {
            return collect();
        }

        return auth()->user()->links;
    }

    private function createLinkForUserOrGuest($data)
    {
        if (auth()->guest()) {
            return Link::create($data);
        }

        return auth()->user()->links()->create($data);
    }

    private function createUploadForUserOrGuest($data)
    {
        $uploadedFile = $data['file'];
        $folderName = time();

        //set the folder name to the current time and store the file within it
        Storage::disk('public')->putFileAs('files/'.$folderName,$uploadedFile,$uploadedFile->getClientOriginalName());

        //file information to store in the db
        $finaldata['original'] = $data['original'];//placeholder with '@file' to mae a difference between files and urls
        $finaldata['folder'] = $folderName; //folder name where the files are stored
        $finaldata['file_name'] = $uploadedFile->getClientOriginalName();//original name of the file - $uploadedFile->getClientOriginalExtension();

        if (auth()->guest()) {
            return Link::create($finaldata);
        }

        return auth()->user()->links()->create($finaldata);
    }
}
