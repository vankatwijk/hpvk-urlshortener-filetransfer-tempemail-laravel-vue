<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }


    public function upload(Request $request)
    {
        
        $user = User::where('id','=',auth()->user()->id)->first();
        $uploadedFile = $request->file;
        $folderName = $user->email;

        //set the folder name to the current time and store the file within it
        Storage::disk('public')->putFileAs('avatar/'.$folderName,$uploadedFile,$user->id.'.'.$uploadedFile->getClientOriginalExtension());
        $user->avatar = 'avatar/'.$folderName.'/'.$user->id.'.'.$uploadedFile->getClientOriginalExtension();
        $user->save();

        return $user;
    }
}
