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
    protected $users;
    protected $events;
    protected $eventController;
    public function __construct()
    {
        $this->middleware('auth');
        $this->db = app('firebase.firestore')->database();
        $this->eventController = new EventController();
        $this->users = $this->db->collection('users');
        $this->events = $this->db->collection('events');
        $this->requests = $this->db->collection('event_ph_requests');
    }

    public function index(){
        $ph = $this->users
            ->document(Auth::user()->localId)
            ->snapshot();
        $response = $this->getEventsAsPh($ph);
        $events = $response['arrayEvent'];
        $ids = $response['arrayId'];
        $hosts = $this->eventController->getHost($events);
        return view('photographer.home', compact('ph', 'events', 'hosts','ids'));
    }

    public function getEventsId($events){

    }

    public function getEventsAsPh($ph){
        $events = $ph->get('eventsAsPh');
        $arrayEvent = array();
        $arrayId = array();
//        $arrayToReturn = array();
        foreach($events as $key => $evt){
            array_push($arrayEvent, $events[$key]->snapshot()->data());
            array_push($arrayId, $events[$key]->id());
        }
        //        return dd($arrayToReturn);
        return array_combine(
            ['arrayEvent','arrayId'],
            [$arrayEvent, $arrayId]);
    }

    public function hirePh($id){
        $phs = $this->users->where('is_photographer', '==', true)
            ->documents()
            ->rows();
//        return dd($phs);
    //se muestran las solicitudes de trabajo que el evento envio a los ph
        $req = $this->requests
            ->where('status', '==', 'Pending')
            ->where('type', '==', 'eventSent')
            ->documents()
            ->rows();
//        return dd($req[0]->data()['ph_id']->snapshot()->data()['fname']);
        return view('photographer.hire',
            compact(['phs', 'id','req'])
        );
    }






}
