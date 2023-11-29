<?php

namespace App\Http\Controllers;

use Aws\Rekognition\RekognitionClient;
use Carbon\Carbon;
use Exception;
use Google\Cloud\Firestore\FieldValue;
use Illuminate\Http\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            ->where(
                'host_id',
                '==',
                $this->users->document(\Illuminate\Support\Facades\Auth::user()->localId)
            );
    }

    public function getPhotographersByType($type){
        $auxPending = [];
        $auxAccepted = [];
        $fotografos = [];
        foreach ($fotografos as $ph){
            if($type == 'Pendientes'){
                return "Ph";
            }elseif ($type == 'Aceptados'){
                return "ph";
            }else{
                return "Hola";
            }
        }

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
            $event = $this->events->add([
                'name' => $request['name'],
                'description' => $request['description'],
                'address' => $request['address'],
                'date_event_ini' => $request['date_event_ini'],
                'date_event_ini_lit' => $this->mutateDateTime($request['date_event_ini']),
                'date_event_end' => $request['date_event_end'],
                'date_event_end_lit' => $this->mutateDateTime($request['date_event_end']),
                'code_invitation' => Str::random(16),
                'created_at' => new Carbon(now()),
                'cover_picture' => 'holders/no_cover_picture.jpg',
                'attendants' => [],
                'host_id' => $this->users->document( \Illuminate\Support\Facades\Auth::user()->localId),
            ]);
            $user = $this->users->document(Session::get('uid'));
            $user->update([
                ['path'=>'eventsAsHost', 'value' => FieldValue::arrayUnion([$event])]
            ]);
//            return dd($event->id()   ); //Con este codigo obtengo el id del objeto creado
        }catch (Exception $exception){
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
            throw new Exception("La fecha fin no puede ser menor a la de incio");
        }else{
            return true;
        }
    }

    public function addAttendantByCodeInvitation(Request $request){
        try {
            $this->addAtendantByCondeInvitationPrivate($request);

        }catch (Exception $e){
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
                    throw new Exception("Tu eres el anfitrion del evento.");
                }
            }else{
                throw new Exception("Firestore: El codigo de invitacion no existe.");
            }
        }else{
            throw new Exception("El codigo de invitacion no existe.");
        }
    }

    public function showEventifHost($id){
        $event = $this->events->document($id)->snapshot();
        $photographers = $event->get('photographers');
        $attendants = $event->get('attendants');
        $arrayPh = array();
        $arrayAtt = array();
        foreach ($attendants as $key => $att){
            array_push($arrayAtt, $attendants[$key]->snapshot()->data());
        }
        foreach ($photographers as $key => $ph){
            array_push($arrayPh, $photographers[$key]->snapshot()->data());
        }
//        return dd($event->data(),$arrayPh, $photographers[0]->snapshot()->data() );

        return view('event.show-host', compact('arrayAtt','arrayPh','event','id'));
    }

    public function showEventifAssistant($id){
        $event = $this->events->document($id);
        return view('event.show-attendant',compact('event'));
    }

    public function getHost($events){
        $arrayHost = array();
        for($i = 0; $i < count($events); $i++){
            $arrayHost[] = $events[$i]['host_id']->snapshot()->data();
        }
        return $arrayHost;
    }

    public function uploadAlbum($eventId){
        return view('photographer.upload', compact('eventId'));
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function albumToProcess(Request $request){
        $files = $request->file('album_photos');
        $event = $this->events->document($request->eventId);
        $uploaded = '';
        $phId = \Illuminate\Support\Facades\Auth::user()->localId;
        $pathToS3 = 'gallery/'.$phId.'/'.$event->snapshot()->id();
        $marcaDeAgua = imagecreatefrompng(Storage::disk('s3')->temporaryUrl('holders/marcaDeAgua185px.png', now()->addMinutes(2)));//'Ruta a la marca de agua que debo tener en el filesystem de laravel';

        $client = new RekognitionClient([
            'region' =>  env('AWS_DEFAULT_REGION'),
            'version'=> 'latest'
        ]);


        for($i = 0; $i < count($files); $i++){

            $toPredict = fopen($files[$i]->getPathname(), 'r');
            $bytes = fread($toPredict, $files[$i]->getSize());
            $collectionName = 'photoprosLab';

            $predicted = $client->searchFacesByImage([
                'CollectionId' => $collectionName,
                'FaceMatchThreshold' => 0,
                'Image' => ['Bytes' => $bytes],
                'MaxFaces' => 1,
                'QualityFilter' => 'AUTO'
            ]);
            $predicted = $predicted['FaceMatches'];
            $predicted = array_values($predicted);

            //almacenar en una bd


            //subir a s3, crear galeria si aun no existe
            $existPersonalGallery = Storage::disk('s3')->exists($pathToS3);
            if($existPersonalGallery){
                $uploaded = Storage::disk('s3')->put($pathToS3, $files[$i]); //Si existe la ruta, entonces sube la imagen
            }else{
                $created = Storage::disk('s3')->makeDirectory($pathToS3); //si no existe entonces la crea
                if($created){
                    $uploaded = Storage::disk('s3')->put($pathToS3, $files[$i]);
                }else{
                    echo("No se pudo crear la carpeta personal");
                }
            }

            //Aplicar marca de agua
            $timestamp = (String) now()->getPreciseTimestamp();
            $imagen = imagecreatefromjpeg($files[0]);
            $marginDerecho = 10;
            $marginInferior = 10;
            $sx = imagesx($marcaDeAgua);
            $sy = imagesy($marcaDeAgua);
            imagecopy(
                $imagen,
                $marcaDeAgua,
                imagesx($imagen)- $sx - $marginDerecho,
                imagesy($imagen) - $sy - $marginInferior, 0, 0,
                imagesx($marcaDeAgua), imagesy($marcaDeAgua)
            );

            $existPersonalGalleryLocal = Storage::exists('public/'.$pathToS3);
            if($existPersonalGalleryLocal){
                $fullImagePath = Storage::path('public/'.$pathToS3.'/'.Str::random().'.png');
                imagepng($imagen, $fullImagePath);

            }else{
                $created = Storage::makeDirectory('public/'.$pathToS3); //si no existe entonces la crea
                if($created){
                    $fullImagePath = Storage::path('public/'.$pathToS3.'/'.Str::random().'.png');
                    imagepng($imagen, $fullImagePath);
                }
            }
            imagedestroy($imagen); //para liberar memoria se debe eliminar luego de almacenarla

            //almacenar imagenBase64 en el array <"album"> del docuemento del evento actual
            $dataToStore = [
                'idPh' => Auth::user()->localId,
                'pathToLocal' => Storage::url($fullImagePath),
                'pathToS3' => $uploaded
            ];
            $event->update([
                ['path'=>'album', 'value' => FieldValue::arrayUnion([$dataToStore])],
            ]);

        }

        return redirect()->route('photographer.home');//->with('status','Album subido exitosamente');
    }

    public function showAlbum($eventId){
        $event = $this->events->document($eventId);
        $user = $this->users->document(Auth::user()->localId)->snapshot()->data();
        $isPh = array_key_exists('is_photographer', $user);
//        return dd($isPh);
        $album = $event->snapshot()->data()['album'];
        return view('photographer.album', compact('album','isPh'));
    }
}
