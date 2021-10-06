<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    public function authenticated(Request  $request, $user)
    {
        if($user->active) {
            
            $previous_session = $user->session_id;

            if ($previous_session) {
                Session::getHandler()->destroy($previous_session);
            }

            Auth::user()->session_id = \Session::getId();
            Auth::user()->save();
            return redirect()->intended($this->redirectPath());
        }
        Auth::guard( 'web' )->logout(); 
        return redirect()->intended('/login')
            ->withInput($request->only($this->username(), 'remember'))
            ->with('alert', __('auth.unactive') );
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    
}
