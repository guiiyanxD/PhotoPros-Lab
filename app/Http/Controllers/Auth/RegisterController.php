<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Facade\Ignition\Exceptions\ViewException;
use Google\Cloud\Core\Timestamp;
use Google\Type\Date;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return RedirectResponse
     */
    protected function register(Request $request)
    {
        try {
            $birthday = $this->mutateData($request->bday);
//            $this->validator($request->all())->validate();
            $userAuthProperties = [
                'email' => $request['email'],
                'password' => $request['password'],
                'emailVerified' => false,
            ];
            $userFirestorProperties = [
                'fname' => $request['name'],
                'lname' => $request['lname'],
                'bday'  => $birthday,
                'created_at'  => new \DateTime(now()),
            ];
            $authUser = $this->auth->createUser($userAuthProperties);
            $this->db->collection('users')->document($authUser->uid)->set($userFirestorProperties);
            return redirect()->route('login');
        }catch (FirebaseException $e){
            Session::flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    protected function mutateData($birthday){
        $date = new \DateTime($birthday, new \DateTimeZone('America/Caracas'));
        return $date;



    }
}
