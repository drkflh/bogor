<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
     * @hideFromAPIDocumentation
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->redirectTo = env('AUTH_REDIRECT_TO');
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    public function showLoginForm()
    {
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('LOGIN_LAYOUT', $default_layout );

        return view('auth.select_login')
            ->with('title', __('Login'))
            ->with('layout', $layout);

    }

    public function redirectTo(){

        // User role
        $role = Auth::user()->roleId;

        $redir = AuthUtil::getRoleRedirect($role);

        if($redir){
            return $redir;
        }else{
            return env('AUTH_REDIRECT_TO', '/');
        }

    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('login');

        if(is_numeric($login)){
            $field = 'mobile';
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'username';
        }
        request()->merge([$field => $login]);


        return $field;
    }

    public function username()
    {
        return $this->username;
    }





}
