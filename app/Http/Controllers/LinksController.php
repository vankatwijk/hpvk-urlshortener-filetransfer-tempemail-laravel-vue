<?php

namespace App\Http\Controllers;

use App\Link;
use Carbon\Carbon;
use App\Http\Requests\ShowShortLink;
use App\Http\Requests\StoreShortLink;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreShortLinkUpload;
use App\Http\Resources\Link as LinkResource;

class LinksController extends Controller
{
    public function index()
    {
        $links = $this->getLinksForUserOrGuest();

        return response()->json($links);
    }

    public function create()
    {
        return view('links.create');
    }

    public function store(StoreShortLink $request)
    {
        $data = $request->validated();

        $link = $this->createLinkForUserOrGuest($data);

        return response()->json(new LinkResource($link));
    }

    public function storeupload(StoreShortLinkUpload $request)
    {

        $data = $request->validated();

        $link = $this->createUploadForUserOrGuest($data);

        return response()->json(new LinkResource($link));
    }

    public function show(ShowShortLink $request, Link $link)
    {
        $data = $request->validated();

        $link->addClick(Carbon::now());

        if($link->original == '@file'){

            if(Storage::disk('public')->assertExists('files/'.$link->folder.'/'.$link->file_name)){
                $full_path = Storage::disk('public')->path('files/'.$link->folder.'/'.$link->file_name);
                $imneType = mime_content_type($full_path);
                
                //if the file is an image display it instead of making it downloadable
                if($imneType == "image/png" || $imneType == "image/jpg" || $imneType == "image/jpeg"){
                    $base64 = base64_encode(Storage::disk('public')->get('files/'.$link->folder.'/'.$link->file_name));
                    $image_data = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
                    return view('viewer.image')->with('imageData',$image_data);
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
