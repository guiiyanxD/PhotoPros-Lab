<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FieldValue;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth;

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

        $ph =  $this->user->document($ph_id);
        $event =  $this->event->document($event_id);
        $exist = $this->existRequest($ph,$event);
        try {

            if(!$exist){
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

        }
        catch (\Exception $exception){
            if($sender == 'evt'){
                return redirect()->route('event.show.host',['id'=>$event->id()]); //with mensaje de exitoso
            }else{
                return redirect()->route('ph.lookFor.events')->with('event',"Ya has enviado una solicitud a este evento anteriomente");
            }
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
        if($sender == 'evt'){
            return redirect()->route('event.show.host',['id'=>$event->id()]); //with mensaje de exitoso
        }else{
            return redirect()->route('ph.show.events')->with('event',"Solicitud enviada correctamente");
        }
    }

    /**Funcion que determina si ya existe una una solicitud de trabajo de un ph para un determinado evento
     * @param $ph
     * @param $event
     * @return false|true
     */
    public function existRequest($ph, $event){
        $allEvtRequestedByPh = $this->request->where('event_id', '=', $event)->documents()->rows();
        foreach ($allEvtRequestedByPh as $evt){
            if($evt->data()['ph_id'] == $ph){
                return true;
            }
        }
        return false;

    }

    public  function getRequestsForPh($sender){
        if($sender == 'ph'){
            $ph = $this->user->document(\Illuminate\Support\Facades\Auth::user()->localId);
            $allEvtRequestedByPh = $this->request
                ->where('ph_id', '=', $ph)
                ->where('status', '=', 'Pending')
                ->documents()
                ->rows();
            $array = [];

            foreach ($allEvtRequestedByPh as $evt){
                $evento = $this->event->document( $evt['event_id']->id())->snapshot();
                array_push($array, $evento);
            }
            return view('request.show', compact('array'));
        }else{
            
        }
    }

}
