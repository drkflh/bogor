<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\App\MmsUtil;
use App\Helpers\App\QontakUtil;
use App\Http\Controllers\Controller;
use App\Jobs\SendWaQontak;
use App\Models\Core\Mongo\ResetPassSession;
use App\Models\Core\Mongo\User;
use App\Models\Mms\NotificationTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getForgot()
    {
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('LOGIN_LAYOUT', $default_layout );

        return view('auth.select_forgot')
            ->with('title', __('Forgot Password'))
            ->with('layout', $layout);
    }

    public function postForgot(Request $request)
    {
        $option = $request->options;
        if ($option == 'email')
        {
            $email = $request->email;

            $id = User::select('_id', 'name')
            ->where('email', '=', $email)
            ->first();
        }else{
            $mobile = $request->mobile;

            $id = User::select('_id', 'name')
            ->where('mobile', '=', $mobile)
            ->first();
        }

        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('LOGIN_LAYOUT', $default_layout );

        $cart = Str::random(16);

        if ($id != null)
        {
            $data['_id'] = Str::random(16);
            $data['id'] = $id['id'];
            $name = $id['name'];

            if ($option == 'email'){

                $rec['to'] = $email;
                $rec['name'] = $name;
                $rec['cc'] = [];
                $rec['bcc'] = [];

                $cartSession = User::where('_id', '=', $id['_id'])
                ->with('email', $rec['to'])
                ->update(['cartSession' => $cart]);

                $data['cartSession'] = $cart;
                $data['url'] =url( 'pass/reset/'.$cart );

                MmsUtil::sendEmail($rec, 'Reset Password' , $data, 'forgot-password');

                return view( 'auth.select_forgot_after' )
                ->with('success', 'Please check your email!')
                ->with('id', $id['_id'])
                ->with('cartSession', $cartSession)
                ->with('title', __('Reset Password'))
                ->with('layout', $layout);

            }else{
                $hp = '62' . $mobile;
                $hpArray = array($hp);
                $recs = $hpArray;
                // $hp
                // $recs = $hpArray;
                // $recs = ['6282111157729'];
                $templateId = 'forgot-password';

                $cartSession = User::where('_id', '=', $id['_id'])
                ->with('mobile', $mobile)
                ->update(['cartSession' => $cart]);

                $urlCartSession = $cart;

                $data['cartSession'] = $cart;
                $data['url'] =url( 'pass/reset/'.$cart );

                $data = [];

                $url = URL::action('Auth\ForgotPasswordController@getNewPassword', [
                    $urlCartSession,
                ]);

                $body_params = [
                    'name' => $name,
                    'url' => $url
                ];

                MmsUtil::sendWhatsApp($recs, $data, $templateId, $body_params);

                return view( 'auth.select_forgot_after' )
                ->with('success', 'Please check your mobile phone!')
                ->with('id', $id['_id'])
                ->with('cartSession', $cartSession)
                ->with('title', __('Reset Password'))
                ->with('layout', $layout);
            }

        } else {
            if ($option == 'email')
            {
                return view( 'auth.select_forgot' )
                ->with('failed', 'This email does not exist in the system')
                ->with('cartSession', $cart)
                ->with('title', __('Forgot Password'))
                ->with('layout', $layout);
            }else{
                return view( 'auth.select_forgot' )
                ->with('failed', 'This mobile does not exist in the system')
                ->with('cartSession', $cart)
                ->with('title', __('Forgot Password'))
                ->with('layout', $layout);
            }

        }

    }

    public function getNewPassword(Request $request)
    {
        $cartSession = $request->cartSession;
        $email = User::select('email')
        ->where('cartSession', '=', $cartSession)
        ->first();

        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('NEW_PASSWORD_LAYOUT', $default_layout );

        return view('auth.select_new_password')
            ->with('cartSession', $cartSession)
            ->with('email', $email['email'])
            ->with('title', __('New Password'))
            ->with('layout', $layout);
    }

    public function postNewPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password-confirm' => ['same:password'],
        ]);

        $cartSession = $request->cartSession;

        $newPassword = Hash::make($request->password);

        $user = User::where('cartSession', '=', $cartSession)
                ->update(['password' => $newPassword]);

        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('LOGIN_LAYOUT', $default_layout );
        $view = env('REGISTER_SUCCESS_VIEW', 'auth.select_login' );

        return view( $view )
            ->with('message', 'You have successfully reset your Password!')
            ->with('cartSession', $cartSession)
            ->with('title', __('Login'))
            ->with('layout', $layout);
    }

    public function WAqontak(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|exists:App\Models\Core\Mongo\User,mobile',
        ]);

        if ($validator->fails()) {
            return redirect('pass/forgot')
                ->withErrors($validator)
                ->withInput();
        }else{
            $mobile = $request->get('mobile');
            $user = User::where('mobile', '=', trim($mobile))->first();


            if($user){

                $qontakUtil = new QontakUtil();

                $rec = $qontakUtil->getWARec($user);

                $expires = Carbon::now(env('DEFAULT_TIME_ZONE', 'Asia/Jakarta'))->addHours(1);

                $session = Str::random(24);
                $reset = new ResetPassSession();
                $reset->userId = $user->_id;
                $reset->name = $user->name;
                $reset->mobile = $rec['to'];
                $reset->session = $session;
                $reset->expires = $expires->timestamp;
                $reset->url = url( 'pass/reset/'.$session );
                $reset->save();

                $tpl = NotificationTemplate::where('slug','=','password-reset')->first();

                /**
                 * TODO: send via WA
                 *
                 */
                if($tpl){

                    $tpl = $tpl->toArray();

                    $tpl_id = $tpl['qontakTplId'];

                    $paramlist = $tpl['paramList'] ?? false;

                    $entity = $reset->toArray();

                    if($paramlist){
                        $body_params = $qontakUtil->getBodyParams($entity, $paramlist);

                        //$qontakUtil->sendWAMessage($rec['to'], $rec['name'], $tpl_id, $body_params  );

                        SendWaQontak::dispatch([$rec], $tpl_id, $body_params );

                        //MmsUtil::sendEmail($rec, 'Reset Password' , $data, 'email-reset-password');

                    }


                }


            }


            return redirect('pass/forgot')
                ->with('success', __('Request processed, reset password link will be sent to your mobile number via WA'))
                ->withInput();
        }

        return view()->make('layouts.nobleui_forgot');
    }
}
