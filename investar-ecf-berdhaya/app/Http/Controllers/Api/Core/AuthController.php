<?php
namespace App\Http\Controllers\Api\Core;

use App\Helpers\App\MmsUtil;
use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Core\Mongo\Member;
use App\Models\Core\Mongo\ResetPassSession;
use App\Models\Core\Mongo\TokenBlacklist;
use App\Models\Core\Mongo\TokenWhitelist;
use App\Models\Core\Mongo\Uploaded;
use App\Models\Core\Mongo\User;

use App\Helpers\Prefs;


use Carbon\Carbon;
use Config;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @group Authentication & User Management
 *
 * APIs for authenticating & managing users
 */
class AuthController extends Controller {

    public $controller_name = '';

    public $usermodel;

    public $userenv;

	public function  __construct()
	{

        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );

        $this->userenv = env('USER_API_MODEL', 'MONGO');

        if( $this->userenv == 'SQL'){
            $this->usermodel = new \App\Models\Core\MySql\User();
        }else{
            $this->usermodel = new \App\Models\Core\Mongo\User();
        }

    }

    /**
     * Register New Admin User
     *
     * This is the main endpoint to register new ADMIN USER , ie : dashboard user
     *
     * Registered member will have Administrative role, has dashboard access and registered into User table
     *
     * The use of MongoDb for user database storage provides flexibility to add custom fields without having to redesign the schema and run migrations
     * the caveat will be to memorize any additional fields added
     *
     *
     * @name register()
     * @param string session_key
     * @method POST
     * @bodyParam name string required Full name of registering member
     * @bodyParam email string required Email address, must be unique
     * @bodyParam password string required Password chosen initially, should be validated in front end
     * @bodyParam roleName string required Role name intended for the new user, must be exact string match to one of the set Roles in backend. ie: "Case Manager"
     *
     * @bodyParam push string Push notification token, obtained from FCM, used to correlate member with push notification token, enabling direct push to single member
     * @bodyParam app string required App package id / bundle id , to identify which app is sending the request, used platform with multiple mobile app type, and for multi device signin
     *
     */
    public function postRegister(Request $request){

        $member = $request->input();

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        $em = $this->usermodel->where('email','=', $member['email'] )->count();

        if($em > 0){
            $retVal = ["result" => "ERR", "message" => "Email sudah terdaftar", 'data'=>false];
            return response()->json($retVal);
        }

        $user = clone $this->usermodel;

        $idPicId = null;

        foreach ($member as $k=>$v){
            $user->{$k} = $v;
        }

        if(isset($user->app)){
            unset($user->app);
        }

        if(isset($user->password)){
            $user->password = bcrypt($user->password);
        }

        $avatarId = '';
        if(isset($user->avatar)){
            $avatarId = $user->avatar;
            if( preg_match('/^http/', $user->avatar ) ){

            }else{
                $user->avatar = $this->getAvatar($user->avatar);
            }
        }

        $idPicId = '';
        if(isset($user->idPic)){
            $idPicId = $user->idPic;
            if( preg_match('/^http/', $user->idPic ) ){

            }else{
                $user->idPic = $this->getPicture($user->idPic);
            }
        }


        if(isset($user->handle) && $user->handle != ''){

        }else{
            $user->handle = Str::random(12);
        }

        if(isset($user->push) && $user->push != ''){
            $user->pushId = $user->push;
            unset($user->push);
        }else{
            $user->pushId = '';
        }

        $user->cartSession = Str::random(16);

        $user->lastUpdate = Carbon::createFromTimestamp(time());
        $user->createdDate = Carbon::createFromTimestamp(time());

        $role_array = config('registerrole.appname');

        if( isset($role_array[ $appname ])  ){
            $user->roleId = AuthUtil::getRoleId($role_array[ $appname ]);
        }else{
            $user->roleId = AuthUtil::getRoleId("Administrator");
        }

        try{
            $user->save();
            $retVal = array("result" => "OK", "message" => "Member berhasil didaftarkan", 'data'=>$user->toArray() );
        }catch (\Exception $exception){
            $retVal = array("result" => "ERR", "message" => $exception->getMessage(), 'data'=>false);
        }

        $data['to'] = $member['email'];
        $data['subject'] = 'Register Member';

        ////Event::fire(new SendMail('sendMail', $data, 'emails.registermember' ));

        return response()->json($retVal);

    }

    /**
     * Register New Member User
     *
     * This is the main endpoint to register new USER , ie : regular user without access to dashboard
     *
     * Registered member will have non Admin role, and registered into Member table instead of User table
     *
     * @name registermember()
     * @param string session_key
     * @method POST
     * @bodyParam name string required Full name of registering member
     * @bodyParam email string required Email address, must be unique
     * @bodyParam countryCode string required Phone number country code ie: Indonesia = 62
     * @bodyParam mobile string required Mobile number without countryCode or "0" ie: 8120987654
     * @bodyParam password string required Password chosen initially, should be validated in front end
     * @bodyParam gender string required Registering member gender possible value "L" or "P"
     *
     * @bodyParam nik string required NIK / Id Number
     * @bodyParam bpjs string required BPJS number
     *
     * @bodyParam address string required Full Address
     * @bodyParam lat string required Address latitude, decimal transmitted as string
     * @bodyParam lng string required Address longitude, decimal transmitted as string
     * @bodyParam city string required City name
     * @bodyParam province string required Province name
     * @bodyParam zip string required ZIP code
     *
     * @bodyParam push string Push notification token, obtained from FCM, used to correlate member with push notification token, enabling direct push to single member
     * @bodyParam app string required App package id / bundle id , to identify which app is sending the request, used platform with multiple mobile app type, and for multi device signin
     *
     */
    public function postRegisterMember(Request $request){

        $member = $request->input();

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        $this->usermodel = new Member();

        $em = $this->usermodel->where('email','=', $member['email'] )->count();

        if($em > 0){
            $retVal = ["result" => "ERR", "message" => "Email sudah terdaftar"];
            return response()->json($retVal);
        }

        $user = clone $this->usermodel;

        $idPicId = null;

        foreach ($member as $k=>$v){
            $user->{$k} = $v;
        }

        if(isset($user->app)){
            unset($user->app);
        }

        if(isset($user->password)){
            $user->password = bcrypt($user->password);
        }

        $avatarId = '';
        if(isset($user->avatar)){
            $avatarId = $user->avatar;
            if( preg_match('/^http/', $user->avatar ) ){

            }else{
                $user->avatar = $this->getAvatar($user->avatar);
            }
        }

        $idPicId = '';
        if(isset($user->idPic)){
            $idPicId = $user->idPic;
            if( preg_match('/^http/', $user->idPic ) ){

            }else{
                $user->idPic = $this->getPicture($user->idPic);
            }
        }


        if(isset($user->handle) && $user->handle != ''){

        }else{
            $user->handle = Str::random(12);
        }

        if(isset($user->push) && $user->push != ''){
            $user->pushId = $user->push;
            unset($user->push);
        }else{
            $user->pushId = '';
        }

        $user->lastUpdate = Carbon::createFromTimestamp(time());
        $user->createdDate = Carbon::createFromTimestamp(time());

        $role_array = config('registerrole.appname');

        if( isset($role_array[ $appname ])  ){
            $user->roleId = AuthUtil::getRoleId($role_array[ $appname ]);
        }else{
            $user->roleId = AuthUtil::getRoleId("Member");
        }

        try{
            $user->save();
            $retVal = array("result" => "OK", "message" => "Registration success");
        }catch (\Exception $exception){
            $retVal = array("result" => "ERR", "message" => $exception->getMessage());
        }

        //$this->updateParentId($user->_id,$avatarId,$idPicId);


        $data['to'] = $member['email'];
        $data['subject'] = 'Register Member';

        ////Event::fire(new SendMail('sendMail', $data, 'emails.registermember' ));

        return response()->json($retVal);

    }



    /**
     * JWT Authentication
     *
     * Obtaining JWT token for subsequent requests that require bearer authentication.
     *
     * DEBUG MODE : Will return user object in plain JSON , otherwise only request result and JWT token
     *
     * @unauthenticated
     * @queryParam login string Field containing identification credential, typically containing email or username, or other ID string that can uniquely identify a user.
     * @queryParam pwd string Field containing password in plain text
     */
    public function postLoginToken(Request $request){

        $login = trim( $request->get('login'));
        $pwd = trim($request->get('pwd'));

        $mobilelogin = preg_replace('/^0|^620|^62/i', '', $login);

        //First attemp to login as member
        $user = Member::where( function ($q) use ($login, $mobilelogin){
            $q->where('nik', '=', $login)
                ->orWhere('email', '=', $login)
                ->orWhere('username', '=', $login)
                ->orWhere('mobile', 'like', '%'.$mobilelogin)
                ->orWhere('mobile', '=', $mobilelogin)
                ->orWhere('mobile', '=', $login);
        })->first();

        if($user){
            return $this->processAuth($user, $pwd);
        }else{

            $user = User::where( function ($q) use ($login, $mobilelogin){
                $q->where('nik', '=', $login)
                    ->orWhere('email', '=', $login)
                    ->orWhere('username', '=', $login)
                    ->orWhere('mobile', 'like', '%'.$mobilelogin)
                    ->orWhere('mobile', '=', $mobilelogin)
                    ->orWhere('mobile', '=', $login);
            })->first();

            return $this->processAuth($user, $pwd);

        }


    }

    private function processAuth($user, $pwd){
        if( $user ){
            unset($user->raw_json);
            $user->extId = $user->_id;

            if(Hash::check($pwd, $user->password) ){

                $user->needUpdate = $user->needUpdate ?? false;

                $user->createdAt = $user->created_at;
                $user->updatedAt = $user->updated_at;

                $user->dateOfBirth =  trim($user->dateOfBirth) == '' || is_null($user->dateOfBirth ) || !isset($user->dateOfBirth)  ? null: $user->dateOfBirth;
                $user->tanggalLahir = trim($user->tanggalLahir) == '' || is_null($user->tanggalLahir ) || !isset($user->tanggalLahir)  ? null: $user->tanggalLahir;

                $cartSession = $user->cartSession ?? null;
                if(is_null($cartSession)){
                    $cartSession = Str::random(16);
                    $user->cartSession = $cartSession;
                    $user->save();
                }

                unset($user->keywords);
                unset($user->kabupatenObject);
                unset($user->relativeKabupatenObject);


                $token = $this->createToken($user);

                return \response()->json(
                    [
                        'result'=>'OK',
                        'message'=>'Authentication success',
                        'data'=>[
                            'user'=>$user,
                            'token'=>$token
                        ]
                    ], 200
                );

            }else{
                return \response()->json(
                    [
                        'result'=>'ERR',
                        'data'=>false,
                        'message'=>'Wrong Password'
                    ], 401
                );
            }

        }else{
            return \response()->json(
                [
                    'result'=>'ERR',
                    'data'=>false,
                    'message'=>'Account not found'
                ], 401
            );
        }

    }

    private function createToken($user)
    {
        return AuthUtil::createToken($user);
    }


    /**
     * Username / email and password authentication
     *
     * @unauthenticated
	 * @name login()
	 * @param string login
	 * @param sring pwd
	 * @method POST
     * @queryParam login string required Username or Email that identifies the user
     * @queryParam pwd string Password in plain text
	 */

    public function postLogin(Request $request){

        $secretKey = file_get_contents( base_path('k/mkey.pem') );

        $passwordfield = config('util.api_password_field');
        $loginfield = config('util.api_login_field');

        $dbpasswordfield = config('util.password_field');

        $login = request()->input($loginfield);

        $password = request()->input($passwordfield);

        if(is_null($login)){

            $body =  $request->all();
            $login = $body[$loginfield];
            $password = $body[$passwordfield];

        }


        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        $logindata = [
            $fieldType => $login,
            $dbpasswordfield => $password
        ];

        if( Auth::guard('web-api')->attempt( $logindata )){
            $user = Auth::guard('web-api')->user();

            $usr = [
                '_id'=> $user->_id,
                'username'=> $user->username,
                'email'=> $user->email,
                'avatar'=> $user->avatar,
                'salutation'=> $user->salutation,
                'state'=> $user->state,
                'street'=> $user->street,
                'updated_at'=> $user->updated_at,
                'name'=> $user->name,
                'handle'=> $user->handle,
                'roleName'=> $user->roleName,
                'roleId'=> $user->roleId,
                'created_at'=> $user->created_at
            ];

            $usrArray = [];

            foreach ($user as $k=>$v){
                $usrArray[$k] = $v;
            }

            $payload = [
                'iss' => env('JWT_ISS', 'auth.mejik.dev'), // Issuer of the token, Organization / Product
                'sub' => $user->_id, // Subject of the token
                'iat' => time(), // Time when JWT was issued.
                'exp' => time() + 60*60, // Expiration time
                'usr' => $usr
            ];

            $token = JWT::encode($payload, $secretKey);

            return \response()->json(
                [
                    'result'=>'OK',
                    'message'=>'Authentication success',
                    'data'=>[
                        'user'=>( env('APP_DEBUG') )? $user: [],
                        'token'=>$token,
                    ]
                ], 200
            );
        }else{
            return \response()->json(
                [
                    'result'=>'ERR',
                    'data'=>false,
                    'message'=>'Authentication failed'
                ], 401
            );
        }

    }

    public function postLoginPlain(Request $request){

        $userfield = config('util.api_login_field');
        $passwordfield = config('util.api_password_field');

        $dbpasswordfield = config('util.password_field');

        if($request->has($userfield) && $request->has($passwordfield))
    	{
    		$retVal = array("result" => "ERR", "message" => "Invalid username or password.");
    		try {

    		    if($this->userenv == 'MONGO'){
                    $qs = '/'.$request->get('user').'/i';
                    $user = $this->usermodel->where($userfield, 'regexp', $qs )->firstorFail();
                }else{
                    $user = $this->usermodel->where($userfield, '=', $request->get('user'))->firstorFail();
                }

    			if($user)
    			{
    				if(Hash::check($request->get($passwordfield), $user->{$dbpasswordfield} ))
    				{
    					$sessionKey = md5(time() . $user->email . $user->_id . "mobauth<-Salt?");

    					$user->sessionKey = $sessionKey;

                        if($request->has('push')){
                            $user->pushId = $request->get('push');
                        }

    					$user->save();

                        $userarray = $user->toArray();

                        if($this->userenv == 'MONGO'){
                            $userarray['mongoid'] = $userarray['_id'];
                        }else{
                            $userarray['mongoid'] = strval($userarray['id']) ;
                        }
                        unset($userarray['password']);
                        unset($userarray['_id']);
                        unset($userarray['id']);
                        unset($userarray['_token']);
                        unset($userarray['session_key']);

                        $userinfo = [];



                        $userinfo['email'] = $userarray['email'];
                        $userinfo['name']  = $userarray['name'];
                        $userinfo['mobile']  = isset($userarray['mobile'])?$userarray['mobile']:'';
                        $userinfo['address']  = isset($userarray['address'])?$userarray['address']:'';
                        $userinfo['firstname']  = isset($userarray['firstname'])?$userarray['firstname']:'';
                        $userinfo['fullname']  = isset($userarray['fullname'])?$userarray['fullname']:'';
                        //$userinfo['avatar']  = $this->getAvatarPic($userarray);
                        $userinfo['avatar']  = isset($userarray['avatar']) && isset($userarray['avatar']['url']) ?$userarray['avatar']['base'].$userarray['avatar']['url']:'';
                        $userinfo['idPic']  = isset($userarray['idPic']) && isset($userarray['idPic']['url']) ?$userarray['idPic']['base'].$userarray['idPic']['url']:'';
                        $userinfo['gender']  = isset($userarray['gender'])?$userarray['gender']:'';
                        //$userinfo['lastUpdate']  = $userarray['lastUpdate'];
                        $userinfo['lastname']  = isset($userarray['lastname'])?$userarray['lastname']:'';
                        $userinfo['sessionKey']  = $userarray['sessionKey'];
                        $userinfo['updatedAt']  = isset($userarray['updatedAt'])?$userarray['updatedAt']:'';

                        $userinfo['mongoid']  = $userarray['mongoid'];
                        $userinfo['branches']  = isset($userarray['branches'])?$userarray['branches']:'';

                        $userinfo['kelurahan']  = isset($userarray['kelurahan'])?$userarray['kelurahan']:'';
                        $userinfo['kecamatan']  = isset($userarray['kecamatan'])?$userarray['kecamatan']:'';
                        $userinfo['city']  = isset($userarray['city'])?$userarray['city']:'';
                        $userinfo['province']  = isset($userarray['province'])?$userarray['province']:'';
                        $userinfo['handle']  = isset($userarray['handle'])?$userarray['handle']:'';

                        $retVal = [
                            'result' => 'OK',
                            'message' => 'Login Success',
                            'user'=> $userinfo ,
                            'token' => $sessionKey
                        ] ;

                        $actor = $user->email;
                        //Event::fire('log.api',array($this->controller_name, 'login' ,$actor,'logged in'));

    				}
    			}else{
                        $actor = $request->get('user');
                        //\Event::fire('log.api',array($this->controller_name, 'login' ,$actor,'user not found'));
                }

    		}catch (ModelNotFoundException $e){
                $retVal = ['result'=>'ERR', 'message'=>$e->getMessage()];
    		}

    		return response()->json($retVal, 200);
    	}

    }

    /**
     * Logout using POST method
     *
     * Logout using POST method, invalidates session token or JWT token.
     *
     * This function should be synchronized with in app session management to provide correct UX
     *
     * @name logout()
     * @param string session_key
     * @method POST
     * @bodyParam token string required Session token or JWT token to invalidate.
     */

    public function postLogout(Request $request){

        $secretKey = file_get_contents( base_path('k/mkey.pem') );

        $token = $request->bearerToken();

        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'result'=>'ERR',
                'data'=>false,
                'message' => 'Token not provided.'
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, $secretKey, ['HS256']);

            $cred = [];
            $cred['iss'] = $credentials->iss;
            $cred['sub'] = $credentials->sub;
            $cred['iat'] = $credentials->iat;
            $cred['exp'] = $credentials->exp;

            $blacklist = new TokenBlacklist();

            $blacklist->token = $token;
            $blacklist->expiry = $credentials->exp;
            $blacklist->cred = $cred;
            $blacklist->save();

            //remove from whitelist
            AuthUtil::removeWhitelist($token);

            return response()->json([
                'result'=>'OK',
                'data'=>null,
                'message' => 'Logout success, now you are unauthorized'
            ], 401);

        } catch(ExpiredException $e) {

            return response()->json([
                'result'=>'ERR',
                'data'=>null,
                'message' => 'Provided token is expired.'
            ], 401);
        } catch(Exception $e) {
            return response()->json([
                'result'=>'ERR',
                'data'=>null,
                'message' => 'Error while decoding token.'
            ], 401);
        }

    }

    /**
     * Logout using GET method
     *
     * Logout using GET method, invalidates session token or JWT token.
     *
     * This function should be synchronized with in app session management to provide correct UX
     *
     * @name logout()
     * @param string session_key
     * @method GET
     * @queryParam token string required Session token or JWT token
     */

    public function getLogout(Request $request){

        $secretKey = file_get_contents( base_path('k/mkey.pem') );

        $token = $request->bearerToken();

        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'result'=>'OK',
                'data'=>false,
                'message' => 'Token not provided.'
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, $secretKey, ['HS256']);

            $cred = [];
            $cred['iss'] = $credentials->iss;
            $cred['sub'] = $credentials->sub;
            $cred['iat'] = $credentials->iat;
            $cred['exp'] = $credentials->exp;

            $blacklist = new TokenBlacklist();

            $blacklist->token = $token;
            $blacklist->expiry = $credentials->exp;
            $blacklist->cred = $cred;
            $blacklist->save();

            return response()->json([
                'result'=>'ERR',
                'data'=>false,
                'message' => 'Logout success, now you are unauthorized'
            ], 401);

        } catch(ExpiredException $e) {

            return response()->json([
                'result'=>'ERR',
                'data'=>false,
                'message' => 'Provided token is expired.'
            ], 401);
        } catch(Exception $e) {
            return response()->json([
                'result'=>'ERR',
                'data'=>false,
                'message' => 'Error while decoding token.'
            ], 401);
        }

    }



    public function putProfile(Request $request){

        $member = $request->getContent();

        $sessionkey = $request->input('key');

        $member = json_decode( $member, true );

        $userenv = env('USER_API_MODEL', 'MONGO');
        if( $userenv == 'SQL'){
            $usermodel = new \App\Models\Core\MySql\User();
        }else{
            $usermodel = new \App\Models\Core\Mongo\User();
        }


        if($em == 0){
            $retVal = array("result" => "ERR", "message" => "User Not Authenticated");
            return response()->json($retVal);
        }

        $user = $this->usermodel->where('email', '=', $member['email'])->first();

        if($user){
            unset($member['id']);
            unset($member['mongoid']);
            unset($member['key']);
            unset($member['msg']);
            unset($member['status']);

            $member['updated_at'] = ( $member['updatedAt'] != '' )?$member['updatedAt']: date('Y-m-d H:i:s', time());
            unset($member['updatedAt']);

            $member['Mobile'] = $member['mobile'];

            foreach ($member as $k=>$v){
                if($v != ''){
                    $user->{$k} = $v;
                }
            }

            $user->lastUpdate = Carbon::createFromTimestamp(time());

            $user->save();

            $retVal = array("result" => "OK", "message" => "Member berhasil diupdate");
        }else{
            $retVal = array("result" => "ERR", "message" => "Member tidak ditemukan");
        }

        return response()->json($retVal, 200);

    }

    /**
     * Reset password request
     *
     * @unauthenticated
     * @name reset()
     * @param string email
     * @method POST
     * @queryParam  email string required Registered email address that identifies the user account
     *
     */
    public function postReset(Request $request){

        $member = $request->input();

        $this->usermodel = new User();

        $to_mobile = false;
        $to_email = false;

        $user = null;

        if( isset($member['email']) && $member['email'] != ''){
            $em = $this->usermodel->where('email','=', $member['email'] )->count();

            $to_email = $member['email'];


            if($em == 0){
                $retVal = array("result" => "ERR", "message" => "Email tidak ditemukan, silakan register terlebih dahulu.", 'data'=>null);
                return response()->json($retVal);
            }else{
                $user = $this->usermodel->where('email','=', $member['email'] )->first();
                $user = $user->toArray();
            }

        }

        if( isset($member['mobile']) && $member['mobile'] != ''){
            $em = $this->usermodel->where('mobile','=', $member['mobile'] )->count();

            $to_mobile = '62'.$member['mobile'];

            if($em == 0){
                $retVal = array("result" => "ERR", "message" => "Nomor WA tidak ditemukan, silakan register terlebih dahulu.", 'data'=>null);
                return response()->json($retVal);
            }else{
                $user = $this->usermodel->where('mobile','=', $member['mobile'] )->first();
                $user = $user->toArray();
            }
        }

        $key = Util::randomstring(12, 'alpha');
        $session = new ResetPassSession();

        $session->key = $key;
        $session->email = trim($member['email']);
        $session->mobile = $to_mobile;
        $session->user = $user;
        $session->expire = time() + 60*15;
        $session->status = 'unaccessed';
        $session->save();

        if($to_email){
            /* Kirim email berisi link ke form reset
             * */
            $data['to'] = $to_email;
            $data['subject'] = env('APP_NAME').' Reset Password';
            $data['name'] = $user['name'] ?? 'no name';
            $data['key'] = $key;

            $rec = [
                'to'=>$to_email,
                'name'=> $data['name'],
                'cc'=> [],
                'bcc'=> [],
            ];

            MmsUtil::sendEmail($rec, $data['subject'], $data, 'password-reset' );
            //Event::fire(new SendMail('sendMail', $data, 'emails.resetpassword' ));
        }

        if($to_mobile){
            /* Kirim WA berisi link ke form reset
             * */
            $data['to'] = $to_mobile;
            $data['name'] = $to_mobile;
            $data['subject'] = env('APP_NAME').' Reset Password';
            $data['key'] = $key;
            $body_params = [
                'name'=>$user['name'] ?? 'no name',
                'key'=> $key
            ];
            MmsUtil::sendWhatsApp([ $to_mobile ], $data, 'password-reset', $body_params );
        }

        $retVal = [
            "result" => "OK",
            "message" => "Pesan berisi URL untuk reset password telah dikirim",
            'data'=>$member['email']
        ];

        return response()->json($retVal, 200);

    }

    /**
     * OTP request
     *
     * @unauthenticated
     * @name reset()
     * @param string email
     * @method POST
     * @queryParam  email string required Registered email address that identifies the user account
     *
     */
    public function postOtp(Request $request){

        $req = $request->input();

        $this->usermodel = new User();

        $to_mobile = false;
        $to_email = false;

        $recipient = '';

        $user = null;

        if( $req['via'] == 'email' ){

            $em = $this->usermodel->where('email','=', $req['recipient'] )->first();

            if($em){
                $to_email = $req['recipient'];
                $recipient = $to_email;
                $user = $em->toArray();
            }else{
                $retVal = array("result" => "ERR", "message" => "Email tidak ditemukan, silakan register terlebih dahulu.", 'data'=>null);
                return response()->json($retVal);
            }

        }

        if( $req['via'] == 'mobile'){

            $em = $this->usermodel->where('mobile','=', $req['recipient'] )->first();

            if($em){
                $to_mobile = '62'.$req['recipient'];
                $recipient = $to_mobile;
                $user = $em->toArray();
            }else{
                $retVal = array("result" => "ERR", "message" => "Nomor WA tidak ditemukan, silakan register terlebih dahulu.", 'data'=>null);
                return response()->json($retVal);
            }
        }

        $key = Util::randomstring(4, 'numeric');

        $session = new ResetPassSession();

        $session->key = $key;
        $session->ns = $req['ns'] ?? 'register';
        $session->email = $to_email;
        $session->mobile = $to_mobile;
        $session->user = $user;
        $session->expire = time() + 60*15;
        $session->status = 'unaccessed';
        $session->save();

        $transport = 'email';

        if($to_email){
            /* Kirim email berisi link ke form reset
             * */
            $data['to'] = $to_email;
            $data['subject'] = env('APP_NAME').' Kode Verifikasi';
            $data['name'] = $user['name'] ?? 'no name';
            $data['expire'] = date( 'd-m-Y H:i:s' ,$session->expire) ;
            $data['code'] = $key;

            $rec = [
                'to'=>$to_email,
                'name'=> $data['name'],
                'cc'=> [],
                'bcc'=> [],
            ];

            MmsUtil::sendEmail($rec, $data['subject'], $data, 'email-otp' );
        }

        if($to_mobile){
            /* Kirim WA berisi link ke form reset
             * */
            $data['to'] = $to_mobile;
            $data['name'] = $to_mobile;
            $data['subject'] = env('APP_NAME').' Kode Verifikasi';
            $data['key'] = $key;
            $body_params = [
                'name'=>$user['name'] ?? 'no name',
                'expire'=>date( 'd-m-Y H:i:s' ,$session->expire),
                'code'=> $key
            ];
            MmsUtil::sendWhatsApp([ $to_mobile ], $data, 'mobile-otp', $body_params );
            $transport = env('MMS_GW', ) == 'TWILIO_SMS' ? 'SMS' : 'WA';
        }


        $retVal = [
            "result" => "OK",
            "message" => "Pesan berisi Kode Verifikasi telah dikirim ke $transport ".$recipient,
            'data'=>$req['recipient']
        ];

        return response()->json($retVal, 200);

    }

    /**
     * OTP verification
     *
     * @unauthenticated
     * @name reset()
     * @param string email
     * @method POST
     * @queryParam  email string required Registered email address that identifies the user account
     *
     */
    public function postOtpVerify(Request $request){

        $req = $request->input();

        $this->usermodel = new User();

        $to_mobile = false;
        $to_email = false;

        $recipient = '';

        $user = null;

        if( $req['via'] == 'email' ){

            $sess = ResetPassSession::where('email','=',$req['recipient'])
                ->where('key','=',$req['code'])
                ->where('ns','=',$req['ns'])
                ->first();

            $user = $this->usermodel->where('email','=', $req['recipient'] )
                ->orderBy('createdAt', 'desc')
                ->first();


            if($sess){

                if($req['ns'] == 'register'){

                    if($user){
                        $user->emailVerification = true;
                        $user->emailVerified = true;
                        $user->emailVerifiedBy = $user->_id ?? 'Selfsign';
                        $user->emailVerifiedByName = $user->name ?? 'Username';
                        $user->emailVerifiedAt = Carbon::now( env('DEFAULT_TIME_ZONE', 'Asia/Jakarta'));
                        $user->save();
                    }

                    $sess->verifiedUser = $user->toArray();

                }
                $to_email = $req['recipient'];
                $sess->status = 'VERIFIED';
                $sess->save();

            }else{
                $retVal = array("result" => "ERR", "message" => "Kode konfirmasi email tidak ditemukan.", 'data'=>null);
                return response()->json($retVal);
            }

        }

        if( $req['via'] == 'mobile'){

            $sess = ResetPassSession::where('mobile','like', '%'.$req['recipient'] )
                ->where('key','=',$req['code'])
                ->where('ns','=',$req['ns'])
                ->first();

            $user = $this->usermodel->where('mobile','=', $req['recipient'] )
                ->orderBy('createdAt', 'desc')
                ->first();

            if($sess){

                if($req['ns'] == 'register'){

                    if($user){
                        $user->mobileVerification = true;
                        $user->mobileVerified = true;
                        $user->mobileVerifiedBy = $user->_id ?? 'Selfsign';
                        $user->mobileVerifiedByName = $user->name ?? 'Username';
                        $user->mobileVerifiedAt = Carbon::now( env('DEFAULT_TIME_ZONE', 'Asia/Jakarta'));
                        $user->save();

                        $user = $user->toArray();
                        $sess->verifiedUser = $user;

                    }


                }
                $to_mobile = '62'.$req['recipient'];
                $sess->status = 'VERIFIED';
                $sess->save();

            }else{
                $retVal = array("result" => "ERR", "message" => "Kode konfirmasi mobile tidak ditemukan.", 'data'=>null);
                return response()->json($retVal);
            }
        }



        if($to_email){
            /* Kirim email berisi link ke form reset
             * */
            $data['to'] = $to_email;
            $data['subject'] = env('APP_NAME').' Email Verified';
            $data['name'] = $user['name'] ?? 'no name';
            $data['expire'] = '' ;
            $data['code'] = '';

            $rec = [
                'to'=>$to_email,
                'name'=> $data['name'],
                'cc'=> [],
                'bcc'=> [],
            ];

            MmsUtil::sendEmail($rec, $data['subject'], $data, 'email-otp-confirm' );
        }

        if($to_mobile){
            /* Kirim WA berisi link ke form reset
             * */
            $data['to'] = $to_mobile;
            $data['name'] = $to_mobile;
            $body_params = [
                'name'=>$user['name'] ?? 'no name',
                'expire'=>'',
                'code'=> ''
            ];
            MmsUtil::sendWhatsApp([ $to_mobile ], $data, 'mobile-otp-confirm', $body_params );
        }

        $retVal = [
            "result" => "OK",
            "message" => 'Verifikasi '.ucfirst( $req['via'] ).' sukses' ,
            'data'=>$req['recipient']
        ];

        return response()->json($retVal, 200);

    }


    public function updateParentId($parentId, $avatarId, $idPicId)
    {
        $avatar = Uploaded::find($avatarId);
        if($avatar){
            $avatar->parent_id = $parentId;
            $avatar->save();
        }


        if(isset($idPicId) && !is_null($idPicId)){
            $idPic = Uploaded::find($idPicId);
            if($idPic){
                $idPic->parent_id = $parentId;
                $idPic->save();
            }
        }

    }

    public function getPicture($dbid){
        $image = Uploaded::find($dbid);
        if($image){
            return (isset($image->large_url))? $image->large_url:'';
        }else{
            return '';
        }
    }

    public function getAvatarPic($data){

        if(isset($data['avatar']) && $data['avatar'] != ''){

            try{
                $avatar = json_decode($data['avatar']);

                if(isset($avatar->thumbnail_url) ){
                    //return $data['avatar'];
                    return $avatar->thumbnail_url;
                }else{
                    return $data['avatar'];
                }

            }catch (\Exception $e){
                if(is_array($data['avatar'])){
                    return '';
                }else{
                    return $data['avatar'];
                }
            }

        }else{
            return "";
        }

    }

    public function getAvatar($dbid){
        $image = Uploaded::find($dbid);
        if($image){
            return (isset($image->square_url))? $image->square_url:'';
        }else{
            return '';
        }
    }

    /**
     * Echo test endpoint
     *
     * This endpoint is only for JWT middleware testing purpose. Guarded by JWT middleware and returns whatever sent to it.
     * @bodyParam data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function postTest(Request $request)
    {
        //print_r($request->auth->toArray());
        return response()->json( [
            'result'=>'OK',
            'message'=>'Echo success',
            'data'=>[
                'request'=>$request->all(),
                'auth'=>$request->auth->toArray()
            ]
        ] );
    }

    public function missingMethod($parameters = array())
    {
        //
    }

}
