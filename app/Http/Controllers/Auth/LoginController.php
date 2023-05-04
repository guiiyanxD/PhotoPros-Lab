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


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('guest')->except('logout');
        $this->auth = $auth;
    }

    protected function login(Request $request){
        try {
//            return dd($request);
            $signInResult = $this->auth->signInWithEmailAndPassword($request['email'], $request['password']);
            $user = new User($signInResult->data());

            //uid Session
            $loginuid = $signInResult->firebaseUserId();
            Session::put('uid',$loginuid);

            Auth::login($user);
//            return ddd($this);
            return redirect($this->redirectPath());
        } catch (FirebaseException $e) {
            throw ValidationException::withMessages([$this->username() => [trans('auth.failed')],]);
        }
    }
}
