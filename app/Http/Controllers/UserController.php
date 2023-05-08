<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Storage;



class UserController extends Controller
{
    protected $storage;
    public function __construct(){
        $this->middleware('auth');
        $this->storage = app('firebase.storage')->getBucket();
    }

    public function uploadImageView(){
        return view('user.upload');
    }
    public function uploadImage(Request $request){
        /*$request->validate([
           'image' => 'required|image|max:1024'
        ]);*/

        $image = $request->file('imageProfile');
        if(User::getCountImages() < 3){

            User::incCountImages();
            // Upload the image to Firebase Storage
            $path = 'profileImages/' . Auth::user()->localId . User::getCountImages() .'a.'. $image->getClientOriginalExtension();
            $this->storage->upload($image,['name' => $path] );
        }

        return redirect('home');
    }
}
