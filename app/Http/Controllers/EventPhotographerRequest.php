<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FieldValue;
use Illuminate\Http\Request;

class EventPhotographerRequest extends Controller
{
    protected $event;
    protected $user;
    protected $ph;
    protected $request;
    protected $db;

    public function __construct(){
        $this->db = app('firebase.firestore')->database();
        $this->request = $this->db->collection('event_ph_requests');
        $this->event = $this->db->collection('events');
        $this->user = $this->db->collection('users');
        $this->middleware('auth');
    }

    public function indexForEvents($id)
    {
        $request = $this->request->where('event_id', '==',$id);
        return $request;
    }

    public function indexForPh()
    {
        $request = $this->request;
    }

    public function storeNewReq($event_id,$ph_id,$sender){


        /**
         * Codigo usado para crear solicitudes de amistad
         */
        try {
            $ph =  $this->user->document($ph_id);
            $event =  $this->event->document($event_id);
            if($sender == 'evt'){                                                   //El evento solicita a un fotografo
                $this->request->add([
                    'event_id' => $event,
                    'ph_id' => $ph,
                    'status' => 'Pending',
                    'type' => 'eventSent'
                ]);
            }else{                                                               //si el fotografo solicita a un evento
                $this->request->add([
                    'event_id' => $event,
                    'ph_id' => $ph,
                    'status' => 'Pending',
                    'type' => 'phSent'
                ]);
            }
        }
        catch (\Exception $exception){
            return redirect()->back()->with('event',$exception->getMessage());
        }

        /*$ph =  $this->user->document($ph_id);
        $event =  $this->event->document($event_id);
        $ph->update([
            [
                'path' => 'eventsAsPh',
                'value' => FieldValue::arrayUnion([$event])
            ]
        ]);
        $event->update([
            [
                'path' => 'photographers',
                'value' => FieldValue::arrayUnion([$ph])
            ]
        ]);*/

        return redirect()->route('event.show.host',['id'=>$event->id()]); //with mensaje de exitoso
    }

}
