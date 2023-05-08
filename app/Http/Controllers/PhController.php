<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;

class PhController extends Controller
{
    protected $auth;
    protected $db;
    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('photographer');
        $this->auth = $auth;
        $this->db = app('firebase.firestore');
    }

    public function index(){
        return view('photographer.home');
    }

    /*public function register(Request $request){

        $birthday = $this->mutateData($request->bday);
        $userAuthProperties = [
            'email' => $request['email'],
            'password' => $request['password'],
            'emailVerified' => false,
        ];
        $userFirestorProperties = [
            'fname' => $request['name'],
            'lname' => $request['lastname'],
            'bday'  => $birthday,
            'created_at'  => new \DateTime(now()),
        ];

        return dd($request, $request->path(),$request->is('register'));
    }

    protected function login(Request $request){
        $signInResult = $this->auth->signInWithEmailAndPassword($request['email'], $request['password']);
        $ph = new Photographer();
    }*/

}
