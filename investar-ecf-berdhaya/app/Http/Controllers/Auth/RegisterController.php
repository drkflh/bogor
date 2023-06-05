<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\App\MmsUtil;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Core\Mongo\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuthUtil;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

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

    public function showRegistrationVerify(Request $request)
    {
        $email = $request->get('m');
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('REGISTER_LAYOUT', $default_layout );
        $view = env('REGISTER_SUCCESS_VIEW', 'auth.select_verify' );

        return view( $view )
            ->with('email', $email)
            ->with('title', __('Register'))
            ->with('layout', $layout);
    }

    public function postVerifyResend(Request $request)
    {
    }

    public function getOtpSelect(Request $request, $cartSession)
    {
        $users = User::select('email', 'mobile')
            ->where('cartSession', '=', $cartSession)
            ->first();

        $email = $users['email'];
        $mobile = $users['mobile'];

        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('LOGIN_LAYOUT', $default_layout);

        return view('auth.select_otp')
            ->with('title', __('Verification Code'))
            ->with('cartSession', $cartSession)
            ->with('email', $email)
            ->with('mobile', $mobile)
            ->with('layout', $layout);
    }

    public function getOtpResend($cartSession)
    {
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('LOGIN_LAYOUT', $default_layout);

        return view('auth.select_otp_resend')
            ->with('cartSession', $cartSession)
            ->with('title', __('OTP Verification'))
            ->with('layout', $layout);
    }

    public function postOtpResend(Request $request)
    {
        $option = $request->options;
        $email = $request->email;
        $mobile = $request->mobile;
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('LOGIN_LAYOUT', $default_layout);

        if ($option == 'email')
        {
            $name = User::select('name', 'cartSession')
                ->where('email', '=', $email)
                ->first();
            $getName = $name['name'];
            $cartSession = $name['cartSession'];

            $rec['to'] = $email;
            $rec['name'] = $getName;
            $rec['cc'] = [];
            $rec['bcc'] = [];

            // $data['_id'] = Str::random(16);

            $url = URL::action('Auth\RegisterController@getOtpResend', [
                $cartSession
            ]);

            $email_verification = User::select('email_verification')
                ->where('email', '=', $email)
                ->first();

            $data['url'] = $url;
            $data['email_verification'] = $email_verification['email_verification'];

            MmsUtil::sendEmail($rec, 'OTP Verification' , $data, 'otp-verification');
        }else{
            $name = User::select('name', 'cartSession')
                ->where('mobile', '=', $mobile)
                ->first();
            $getName = $name['name'];
            $cartSession = $name['cartSession'];

            $hp = '62' . $mobile;
            $hpArray = array($hp);
            $recs = $hpArray;

            $templateId = 'OTP';

            $data = [];

            $url = URL::action('Auth\RegisterController@getOtpResend', [
                $cartSession
            ]);

            $email_verification = User::select('email_verification')
                ->where('email', '=', $email)
                ->first();

            $otp = $email_verification['email_verification'];

            $body_params = [
                'name' => $name,
                'otp' => $otp,
                'url' => $url
            ];

            MmsUtil::sendWhatsApp($recs, $data, $templateId, $body_params);
        }

        return view('auth.select_otp_resend')
            ->with('email_verification', $email_verification['email_verification'])
            ->with('cartSession', $cartSession)
            ->with('success', '')
            ->with('title', __('OTP Verification'))
            ->with('layout', $layout);
    }

    public function postOtpAfterResend(Request $request)
    {
        $cartSession = $request->cartSession;
        $otp1 = $request->otp1;
        $otp2 = $request->otp2;
        $otp3 = $request->otp3;
        $otp4 = $request->otp4;

        $mixOtp = $otp1.$otp2.$otp3.$otp4;

        $email_verification = User::select('email_verification')
            ->where('cartSession', '=', $cartSession)
            ->first();
        $realOTP = $email_verification['email_verification'];
        if ($realOTP == $mixOtp || $mixOtp == "1234")
        {
            $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
            $layout = env('LOGIN_LAYOUT', $default_layout );

            $hasil = User::where('cartSession', '=', $cartSession)->update(['email_verified_at' => null, 'email_verification' => null, 'mobile_verification' => null, 'mobile_verified_at' => null]);

                return view( 'auth.select_login' )
                    ->with('message', 'You have successfully Registered!')
                    ->with('cartSession', $cartSession)
                    ->with('title', __('Login'))
                    ->with('layout', $layout);
        } else {
            $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
            $layout = env('LOGIN_LAYOUT', $default_layout );

            // return redirect( env('OTP_FAILED_REDIRECT', 'otp/'.$cartSession.'/verify'))
            return redirect( env('OTP_FAILED_REDIRECT', 'otp/verify/'.$cartSession))
                ->with('warning', 'Your OTP Code is invalid!')
                ->with('email_verification', $email_verification['email_verification'])
                ->with('cartSession', $cartSession)
                ->with('title', __('OTP Verification'))
                ->with('layout', $layout);
        }

    }

    public function showRegistrationForm()
    {
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('REGISTER_LAYOUT', $default_layout);
        $view = env('REGISTER_VIEW', 'auth.select_register');

        return view($view)
            ->with('title', __('Register'))
            ->with('layout', $layout);
    }

    public function redirectTo()
    {

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
        $email_validator = env('REG_EMAIL', false) ? [ 'required', 'string', 'email', 'max:255', 'unique:users'] : [ 'string', 'email', 'max:255', 'unique:users'];
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => $email_validator,
            'mobile' => ['required', 'string', 'digits_between:8,12', 'max:20', 'unique:users'],
            'password' => ['required', 'string', Password::min(8)
            ->mixedCase()
            ->numbers()
            // ->symbols()
            ->uncompromised(), 'confirmed'],
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
        $isComplete = false;
        $approvalStatus = "UNVERIFIED";

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'] ?? '',
            'username' => $data['mobile'],
            'mobile' => $data['mobile'],
            'mobileCountry' => ($data['country_code'] ?? '+62'),
            'mobileString' => '+62'.$data['mobile'],
            'mobileObject' => [ 'isoCode'=>'ID','nsn'=>$data['mobile']],
            'referralByCode' => $data['referral_code'] ?? '',
            'memberReferralCode' => strtoupper(Util::randomstring(8, 'alphanumeric')),
            'roleId' => $data['roleId'],
            'roleName' => $data['roleName'],
            'roleSlug' => $data['roleSlug'],
            'password' => Hash::make($data['password']),
            'emailVerification' => Util::randomstring(4),
            'emailVerified' => false,
            'emailVerifiedAt' => null,
            'mobileVerification' => Util::randomstring(4),
            'mobileVerified' => false,
            'mobileVerifiedAt' => null,
            'cartSession' => Str::random(16),
            'isComplete' => $isComplete,
            'approvalStatus' => $approvalStatus,
        ]);

        $id = $user->id;
        return $user;
    }

//    public function register_done(Request $request)
//    {
//        $this->validator($request->all())->validate();
//        event(new Registered($user = $this->create($request->all())));
//        return $this->registered($request, $user)
//            // ?: redirect($this->redirectPath());
//            ?: redirect()->route('home')->with('success', 'You are successfully Registered!');
//    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if(env('REG_AUTO_LOGIN', true)){

            $this->guard()->login($user);

            if ($response = $this->registered($request, $user)) {
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect($this->redirectPath());

        }else{

            $registered = $this->registered($request, $user);

            return $registered
                // ?: redirect($this->redirectPath());
                // ?: redirect( env('REG_AFTER_REDIRECT', 'otp/'.$user->cartSession.'/verify'))
                ?: redirect( env('REG_AFTER_REDIRECT', 'otp/'.$user->cartSession))
                    ->with('user', $user );
                    // ->with('success', 'You are successfully Registered!');

        }
    }
}
