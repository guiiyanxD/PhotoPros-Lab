<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Auth as FirebaseAuth;

class PhController extends Controller
{
    protected $auth;
    protected $db;
    public function __construct()
    {
        $this->middleware('auth');
        $this->db = app('firebase.firestore')->database();
    }

    public function index(){
        return view('photographer.home');
    }

    public function hire(){
        $phs = $this->db->collection('users')
            ->where('is_photographer', '==', true)->documents()->rows();

        return view('photographer.hire', compact('phs'));
    }






}
