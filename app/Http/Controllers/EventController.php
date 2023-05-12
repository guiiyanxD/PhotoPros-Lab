<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\FieldValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Database\Reference;
use Ramsey\Uuid\Generator\RandomGeneratorFactory;

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
    public function index(): void
    {
        $user = $this->users->document(Session::get('uid'));
        $events = $this->events->where('host_id', '==', $user );
//        return dd($events->documents());
    }

    public function getEventsByAuthUser(){
        return $this->events
            ->where('host_id', '==', $this->users->document(\Illuminate\Support\Facades\Auth::user()->localId))
            ->limit(10);
    }

    /**
     * This function creates the event a
     * @param Request $request
     * @return never
     */
    public function create(){
        return view('event.create');
    }
    public function store(Request $request){
        try {
            $this->checkDates($request['date_event_ini'], $request['date_event_end']);
            $collection = $this->events->newDocument()->set([
                'name' => $request['name'],
                'description' => $request['description'],
                'address' => $request['address'],
                'date_event_ini' => $request['date_event_ini'],
                'date_event_ini_lit' => $this->mutateDateTime($request['date_event_ini']),
                'date_event_end' => $request['date_event_end'],
                'date_event_end_lit' => $this->mutateDateTime($request['date_event_end']),
                'code_invitation' => Str::random(16),
                'created_at' => new Carbon(now()),
                'host_id' => $this->users->document( \Illuminate\Support\Facades\Auth::user()->localId),
            ]);
        }catch (\Exception $exception){
            return redirect()->back()->with('event', $exception->getMessage());
        }

        return redirect()->route('home');
    }
    protected function mutateDateTime($date_ini){
        $carbon = new Carbon();
        $data = $carbon->carbonize($date_ini);
        $now = Carbon::createFromFormat('Y-m-d H:i:s', $data );
        $date = $now->format('l d M Y');
        $time = $now->format('H:i a');
        return $date . ' a las ' . $time;
    }
    protected function checkDates($date_event_ini, $date_event_end){
        $inicio = new Carbon($date_event_ini) ;
        $final = new Carbon($date_event_end);
        if( $inicio->greaterThan($final) ){
            throw new \Exception("La fecha fin no puede ser menor a la de incio");
        }else{
            return true;
        }
    }

    public function addAttendantByCodeInvitation(Request $request){
        try {
            $this->addAtendantByCondeInvitationPrivate($request);

        }catch (\Exception $e){
            return redirect('home')->with('event-error', $e->getMessage());
        }
        return redirect('home')->with('event-error','Ahora formas parte del evento');
    }
    private function addAtendantByCondeInvitationPrivate( Request $request){
        if($request->has('code_invitation')){ //Si por alguna razon se envia el formulario vacio
            $event = $this->events->where('code_invitation', '==', $request['code_invitation']);
            if($event->documents()->rows() != null){ //No existe ningun evento en firestore
                $user = $this->users->document(Session::get('uid'));
                $eventData = $event->documents()->rows()[0];
                if( $eventData->data()['host_id'] != $user ){
                    $targetEvent = $this->events->document($eventData->id());
                    $targetEvent->update([
                        ['path'=>'attendants', 'value' => FieldValue::arrayUnion([$user])]
                    ]);
                    $user->update([
                        ['path'=>'eventsAsAttendant', 'value' => FieldValue::arrayUnion([$targetEvent])]
                    ]);
                }else{
                    throw new \Exception("Tu eres el anfitrion del evento.");
                }
            }else{
                throw new \Exception("Firestore: El codigo de invitacion no existe.");
            }
        }else{
            throw new \Exception("El codigo de invitacion no existe.");
        }
    }

    public function showEventifHost($id){
        $event = $this->events->document($id);
//        return dd($event->snapshot()->data()['attendants'][0]->snapshot());
        return view('event.show-host', compact('event'));
    }

    public function showEventifAssistant($id){
        $event = $this->events->document($id);
        return view('event.show-attendant',compact('event'));
    }


}
