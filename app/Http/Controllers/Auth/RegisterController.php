<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\FirebaseException;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $auth;
    protected $db;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( FirebaseAuth $auth)
    {
        $this->middleware('guest');
        $this->auth = $auth;
        $this->db = app('firebase.firestore')->database();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function registerPh(){
        return view('auth.registerph');
    }

    public function becomePh(){
        return view('auth.becomeph');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return RedirectResponse
     */
    protected function register(Request $request)
    {
//        return dd($request);
        try {
//            $userFirestorProperties = [];
            $birthday = $this->mutateData($request->bday);
            $categories = $this->SetCategories($request->categories);
            $userAuthProperties = [
                'email' => $request['email'],
                'password' => $request['password'],
                'emailVerified' => false,
            ];


            if( $request->has('newph&user')) {
                $userFirestorProperties = [
                    'fname' => $request['name'],
                    'lname' => $request['lastname'],
                    'bday' => $birthday,
                    'created_at' => new \DateTime(now()),
                    'is_photographer' => true,
                    'telefono' => $request['telefono'],
                    'price' => $request['price'],
                    'preference' => $request->has('preference'),
                    'categories' => $categories,
                    'profile_picture_path' => 'holders/no_profile_picture.jpg',
                    'eventsAsPh' => [],
                    'face_id' => '',

                ];
            }elseif($request->has('become')){
                $userFirestorProperties = [
                    'is_photographer' => true,
                    'telefono' => $request['telefono'],
                    'price' => $request['price'],
                    'preference' => $request->has('preference'),
                    'categories' => $categories,
                    'eventsAsPh' => [],
                ];
            }else{
                $userFirestorProperties = [
                    'fname' => $request['name'],
                    'lname' => $request['lastname'],
                    'bday'  => $birthday,
                    'created_at'  => new \DateTime(now()),
                    'profile_picture_path' => 'holders/no_profile_picture.jpg',
                    'eventsAsAttendant' => [],
                    'eventsAsHost' => [],
                    'faceId' => '',

                ];
            }

            if($request->has('become')){
                $signInResult = $this->auth->signInWithEmailAndPassword($request['email'], $request['password']);
                $user = $this->db->collection('users')->document($signInResult->firebaseUserId());
                $user->update([
                    ['path' => 'is_photographer', 'value' => true],
                    ['path' => 'telefono', 'value' => $request['telefono']],
                    ['path' => 'price', 'value' => $request['price']],
                    ['path' => 'preference', 'value' => $request->has('preference')],
                    ['path' => 'categories', 'value' => $categories],
                ]);
            }else{
                $authUser = $this->auth->createUser($userAuthProperties);
                $this->db->collection('users')->document($authUser->uid)->set($userFirestorProperties);
            }
            return redirect()->route('welcome');
        }catch (FirebaseException $e){
            Session::flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    protected function mutateData($birthday){
        $date = new \DateTime($birthday, new \DateTimeZone('America/Caracas'));
        return $date;
    }

    protected function setCategories($categories){
        $array = explode(',',$categories);
        return $array;
    }
}
