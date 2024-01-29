<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Google\Cloud\Firestore\V1\StructuredQuery\FieldFilter\Operator;
use Google\Type\Date;
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
    protected $ph;
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
        return view('photographer.home', compact('ph'));
    }


    public function getEventsAsPh(){
        $phData = $this->users
            ->document(Auth::user()->localId)
            ->snapshot();
        $eventsPh = $phData->get('eventsAsPh');
        $arrayEvent = array();
        $arrayId = array();
        foreach($eventsPh as $key => $evt){
            array_push($arrayEvent, $eventsPh[$key]->snapshot()->data());
            array_push($arrayId, $eventsPh[$key]->id());
        }
        $arrays = array_combine(['arrayEvent','arrayId'],[$arrayEvent, $arrayId]);
        $events = $arrays['arrayEvent'];
        $ids = $arrays['arrayId'];
        $hosts = $this->eventController->getHost($events);
        return view('photographer.showPhEvents', compact('events', 'hosts','ids'));
    }

    public function getEventsToRequest(){
        $events = $this->db->collection('events')
            ->where('date_event_ini' , '>', Carbon::now()->toDateString())
//            ->where($this->users->document(Auth::user()->localId)->snapshot->data(), Operator::NOT_IN, 'photographers' )
            ->documents()
            ->rows();
        return view('photographer.lookForEvents', compact('events'));
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
