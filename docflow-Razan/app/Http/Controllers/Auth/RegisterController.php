<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Core\Mongo\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuthUtil;

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
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectTo(){

        // User role
        $role = Auth::user()->roleId;

        $redir = AuthUtil::getRoleRedirect($role);

        if($redir){
            return $redir;
        }else{
            return env('AUTH_REDIRECT_TO', '/login');
        }

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
            'roleId' => ['required', 'string', 'max:512'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $data['roleName'] = AuthUtil::getRoleName($data['roleId']);
        $data['roleSlug'] = AuthUtil::getRoleSlug($data['roleId']);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'roleId' => $data['roleId'],
            'roleName' => $data['roleName'],
            'roleSlug' => $data['roleSlug'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
