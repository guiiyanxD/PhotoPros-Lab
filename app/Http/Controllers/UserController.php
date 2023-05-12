<?php

namespace App\Http\Controllers;

use App\User;
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
        return $asAttendant['eventsAsAttendant'];
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
            ->data()['profile_picture_path'];
        if( $path == ''){
            return 'holders/no_profile_picture.png';
        }
        return $path;
    }

    public function uploadImage(Request $request){

        try {
            $image = $request->file('imageProfile');
            $fileName = Auth::user()->localId . '.'. $image->getClientOriginalExtension();
//            return dd($fileName);
            $filePath = 'profile-pictures/'. $fileName;
            $path = Storage::disk('s3')->put($filePath, file_get_contents($request->file('imageProfile')));
            $path = Storage::disk('s3')->url($path);
            $this->updateProfilePicture($filePath);

        }catch (S3Exception $e){
            return redirect()->route('home')->with('status', $e->getMessage());
        }
        return redirect('home')->with('status', 'Tu foto de perfil se actualizo correctamente');
    }

    public function updateProfilePicture($path){
        $this->db->collection('users')
            ->document(Auth::user()->localId)
            ->update([
                ['path'=> 'profile_picture_path', 'value' => $path]
            ]);
    }

}
