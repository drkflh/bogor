<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Core\Mongo\ResetPassSession;
use App\Models\Core\Mongo\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    public function getReset($session)
    {
        return view()
            ->make('layouts.nobleui_reset', ['session'=>$session]);
    }

    public function postReset(Request $request, $session)
    {

        $postSession = $request->get('session');

        if($postSession != $session){
            return redirect('pass/reset/'.$session )
                ->with( 'error', 'Reset session is invalid' )
                ->withInput();
        }

        $reset = ResetPassSession::where('session', '=', trim($session))
            ->orderBy('created_at', 'desc')
            ->first();

        if($reset){
            $now = Carbon::now(env('DEFAULT_TIME_ZONE'))->timestamp;
            if( $now > $reset->expires ){
                return redirect('pass/reset/'.$session )
                    ->with( 'error', 'Reset session already expired, please make new reset request' )
                    ->withInput();
            }

            $user = User::find($reset->userId);

            if($user){

                $validator = Validator::make($request->all(), [
                    'password' => 'required|confirmed'
                ]);

                if ($validator->fails()) {
                    return redirect('pass/reset/'.$session)
                        ->withErrors($validator)
                        ->withInput();
                }else{

                    $password = Hash::make($request->get('password'));
                    $user->password = $password;
                    $user->save();

                    return redirect('pass/reset/'.$session )
                        ->with('success', __('Password successfully changed'))
                        ->withInput();
                }

            }else{
                return redirect('pass/reset/'.$session )
                    ->with( 'error', 'User not found' )
                    ->withInput();
            }

        }else{
            return redirect('pass/reset/'.$session )
                ->with( 'error', 'Reset session is invalid' )
                ->withInput();
        }
    }
}
