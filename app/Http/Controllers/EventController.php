<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\DocumentReference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Database\Reference;

class EventController extends Controller
{
    protected $events;
    protected $users;
    protected $db;

    public function __construct(){
        $this->db = app('firebase.firestore')->database();
        $this->users = $this->db->collection('users');
        $this->events = $this->db->collection('events');
        $this->middleware('auth');
    }

    /**
     * This function return all the events by the auth user
     */
    public function index(){

        $user = $this->users->document(Session::get('uid'));
        $events = $this->events->where('host_id', '==', $user );
        return dd($events->documents());

    }


    ///TODO: COMPLETAR FUNCION CON DATOS REALES Y HACER EL FORMULARIO DE CREAR EVENTO

    /**
     * This function creates the event a
     * @param Request $request
     * @return never
     */
    public function create(Request $request){
        $collection = $this->events->add([
            'name' => 'Cumple de chuti loco',
            'addres1' => 'Cumple de chuti loco',
            'addres2' => 'Cumple de chuti loco',
            'addres3' => 'Cumple de chuti loco',
            'photographers' => [''],
            'host_id' => $this->users->document( Session::get('uid')),
        ]);
        return dd($collection->snapshot()->data());
    }



    /**
     *      // Create an initial document to update
            $frankRef = $db->collection('samples/php/users')->document('frank');
            $frankRef->set([
            'first' => 'Frank',
            'last' => 'Franklin',
            'favorites' => ['food' => 'Pizza', 'color' => 'Blue', 'subject' => 'Recess'],
            'age' => 12
            ]);

            // Update age and favorite color
            $frankRef->update([
            ['path' => 'age', 'value' => 13],
            ['path' => 'favorites.color', 'value' => 'Red']
            ]);
     */
}
