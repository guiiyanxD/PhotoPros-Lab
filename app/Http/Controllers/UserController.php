<?php

namespace App\Http\Controllers;

use App\User;
use Aws\Rekognition\RekognitionClient;
use Aws\S3\Exception\S3Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use MongoDB\Driver\Session;

//use Kreait\Firebase\Storage;



class UserController extends Controller
{
    protected $db;
    protected $user;
    protected $events;
    public function __construct(){
        $this->middleware('auth');
        $this->db = app('firebase.firestore')->database();
        $this->events = $this->db->collection('events');
    }

    public function index(){
        $asAttendant = $this->getEventsAsAttendant();
        $path = $this->getProfilePicturePath();
//        return dd($path);
        $events = $this->getEvents()
            ->documents()
            ->rows();
        return view('home', compact(['path','events','asAttendant']));
    }

    public function getEventsAsAttendant(){
        $asAttendant = $this->db->collection('users')
            ->document(Auth::user()->localId)
            ->snapshot()
            ->data();
        if(array_key_exists('asAttendant',$asAttendant)){
            return $asAttendant['eventsAsAttendant'];
        }else{
            return [];
        }
    }
    public function uploadImageView(){
        return view('user.upload');
    }

    /**This function return all the events By Auth User
     * @return mixed
     */
    public function getEvents(){
        $eventController = new EventController();
        return $eventController->getEventsByAuthUser();
    }


    /** This function return the profile picture path of the Auth User
     * @return mixed
     */
    public function getProfilePicturePath(){
        $path = $this->db->collection('users')
            ->document(Auth::user()->localId)
            ->snapshot()
            ->data();
        if(array_key_exists('profile_picture_path', $path)){
            if( $path == ''){
                return 'holders/no_profile_picture.jpg';
            }
            return $path['profile_picture_path'];
        }else{
            return '';
        }
    }

    public function uploadImage(Request $request){
        try {
            $client = new RekognitionClient([
                'region' => env('AWS_DEFAULT_REGION'),
                'version' => 'latest'
            ]);
            $listas = $client->listCollections();
//            return dd($listas);

            $toPredict = fopen($request->file('imageProfile')->getPathName(), 'r');
            $bytes = fread($toPredict, $request->file('imageProfile')->getSize());
            $collectionName = 'photoprosLab';

            $result = $client->indexFaces([
                "CollectionId" => $collectionName,
                'DetectionAttributes' => ['DEFAULT'],
                'ExternalImageId' => '' . Auth::user()->localId . '',
                'Image' => ['Bytes' => $bytes],
                'MaxFaces' => 1,
                'QualityFilter' => 'AUTO',
            ]);

            $result->get('indexFaces');
//            return dd($result);


            $image = $request->file('imageProfile');
            $fileName = Auth::user()->localId . '.'. $image->getClientOriginalExtension();
            $filePath = 'profile-pictures/'. $fileName;
            $path = Storage::disk('s3')->put($filePath, file_get_contents($request->file('imageProfile')));
            $path = Storage::disk('s3')->url($path);
            $this->updateProfilePicture($filePath, $result);


        }catch (S3Exception $e){
            return redirect()->route('home')->with('status', $e->getMessage());
        }
        return redirect('home')->with('status', 'Tu foto de perfil se actualizo correctamente');
    }

    public function updateProfilePicture($path, $result){
        $this->db->collection('users')
            ->document(Auth::user()->localId)
            ->update([
                ['path'=> 'profile_picture_path', 'value' => $path],
                ['path'=> 'face_id', 'value' => $result],
            ]);
    }

}
