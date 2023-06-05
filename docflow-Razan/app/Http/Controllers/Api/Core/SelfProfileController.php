<?php
namespace App\Http\Controllers\Api\Core;

use App\Helpers\AuthUtil;
use App\Http\Controllers\Api\Core\ApiAdminController;
use App\Models\Core\Mongo\Member;
use App\Models\Core\Mongo\TokenBlacklist;
use App\Models\Core\Mongo\User;
use DebugBar\DebugBar;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SelfProfileController extends ApiAdminController
{

    public function __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->model = new User();

        $this->res_path = 'models'; // under resources ,ie: resources/models
        $this->yml_file = 'user'; // name of yml ,ie: member.yml
        $this->entity = 'User';

    }

    public function getIndex(Request $request)
    {
        if($request->auth){
            $subject = $request->auth;

            $id = $subject->_id;

            if($subject->roleName == 'Member'){
                $this->model = new Member();
            }else{
                $this->model = new User();
            }

            return parent::show($id, $request); // TODO: Change the autogenerated stub\
        }

    }

    public function putUpdatePass(Request $request){

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

            if($request->has('pass') && $request->has('confirmPass')){
                $pass = $request->get('pass');
                $confirmPass = $request->get('confirmPass');

                if($pass != $confirmPass ){
                    return response()->json([
                        'result'=>'ERR',
                        'data'=>false,
                        'message' => 'Confirmation pair not match'
                    ], 400);
                }

            }else{
                return response()->json([
                    'result'=>'ERR',
                    'data'=>false,
                    'message' => 'Incomplete parameters'
                ], 400);

            }

            if($request->auth){

                $subject = $request->auth;

                if($subject->roleName == 'Member'){
                    $this->model = new Member();
                    $this->res_path = 'models'; // under resources ,ie: resources/models
                    $this->yml_file = 'member'; // name of yml ,ie: member.yml
                }else{
                    $this->model = new User();
                    $this->res_path = 'models'; // under resources ,ie: resources/models
                    $this->yml_file = 'user'; // name of yml ,ie: member.yml
                }

            }else{
                return response()->json([
                    'result'=>'ERR',
                    'data'=>false,
                    'message' => 'Account information not found'
                ], 400);
            }

            $user = $this->model->find($credentials->sub);

            if($user && ( $pass == $confirmPass ) ){
                $user->password = Hash::make($pass);

                if($user->save()){

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
                        'result'=>'OK',
                        'data'=>false,
                        'message' => 'Password update success, please re-authorize'
                    ], 401);
                }else{
                    return response()->json([
                        'result'=>'ERR',
                        'data'=>false,
                        'message' => 'Password update failed'
                    ], 400);
                }

            }else{
                return response()->json([
                    'result'=>'ERR',
                    'data'=>false,
                    'message' => 'Account not found'
                ], 400);
            }

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


    public function putUpdateProfile(Request $request)
    {
        if($request->auth){
            $subject = $request->auth;

            $id = $subject->_id;

            if($subject->roleName == 'Member'){
                $this->model = new Member();
                $this->yml_file = 'member'; // name of yml ,ie: member.yml
                $this->entity = 'Member';

            }else{
                $this->model = new User();
            }

            return parent::putUpdate($id, $request); // TODO: Change the autogenerated stub
        }
    }

    public function showProfile(Request $request)
    {
        \Debugbar::disable();

        if($request->auth){
            $subject = $request->auth;

            $id = $subject->_id;

            if($subject->roleName == 'Member'){
                $this->model = new Member();
            }else{
                $this->model = new User();
            }

            return parent::show($id, $request); // TODO: Change the autogenerated stub
        }
    }


    public function beforeOutput($data)
    {
        unset($data['password']);
        $data['roleId'] = AuthUtil::getRoleId(env('DEFAULT_USER_ROLE', 'Member' ));
        $data['roleSlug'] = AuthUtil::getRoleSlug( $data['roleId'] );
        return parent::beforeOutput($data); // TODO: Change the autogenerated stub
    }


    public function beforeSave($data)
    {
        $roleName = $data['roleName'] ?? env('DEFAULT_USER_ROLE', 'Member' );
        $data['roleName'] = $roleName;
        $data['roleId'] = AuthUtil::getRoleId($roleName);
        $data['roleSlug'] = AuthUtil::getRoleSlug( $data['roleId'] );
        $data['roleName'] = AuthUtil::getRoleName($data['roleId']);
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        $data['regStatus'] = env('DEFAULT_REG_STATUS', 'UNASSIGNED');
        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function afterSave($data)
    {
        //$data->afterSave = 'AFTER';
        return parent::afterSave($data); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($data)
    {
        $roleName = $this->auth->roleName ?? env('DEFAULT_USER_ROLE', 'Member' );
        $data['roleName'] = $roleName;
        $data['roleId'] = AuthUtil::getRoleId($roleName);
        $data['roleSlug'] = AuthUtil::getRoleSlug( $data['roleId'] );
        // $data['roleName'] = AuthUtil::getRoleName($data['roleId']);
        if(isset($data['password']) && $data['password'] != ''){
            $data['password'] = Hash::make($data['password']);
        }
        return parent::beforeUpdate($data); // TODO: Change the autogenerated stub
    }

}
