<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home.blade.php screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $auth;
    protected $firestoreUser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('guest')->except('logout');
        $this->auth = $auth;
        $this->firestoreUser = app('firebase.firestore')->database();

    }

    protected function login(Request $request){
        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($request['email'], $request['password']);
            $user = new User($signInResult->data());
            $ph = $this->firestoreUser
                ->collection('users')
                ->document($signInResult->firebaseUserId())
                ->snapshot()
                ->data();

//            return dd($ph['is_photographer'], $user['is_photographer']);
            //uid Session
            $loginuid = $signInResult->firebaseUserId();
            Session::put('uid',$loginuid);

            if( $request->has('photographer')){
                if($ph['is_photographer']){
                    Session::put('is_photographer',$loginuid.'ph');
                }

                Auth::login($user);
                if($ph['is_photographer']){
                    return redirect()->route('photographer.home');
                }
            }

            Auth::login($user);
            return redirect($this->redirectPath());

        } catch (FirebaseException $e) {
            throw ValidationException::withMessages([$this->username() => [trans('auth.failed')],]);
        }
    }
}
