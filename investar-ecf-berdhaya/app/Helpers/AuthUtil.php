<?php
namespace App\Helpers;
use App\Models\Core\Mongo\Role;
use App\Models\Core\Mongo\TokenBlacklist;
use App\Models\Core\Mongo\TokenWhitelist;
use App\Models\Core\Mongo\User;
use App\Models\Obj\AclObject;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 09/12/19
 * Time: 23.55
 */

class AuthUtil{
    public static $roleObjectEntity = null;


    public static function createToken($user, $timeout = false)
    {
        $secretKey = file_get_contents( base_path('k/mkey.pem') );

        if($timeout){
            $expire = doubleval($timeout);
        }else{
            $expire = doubleval(env('JWT_TOKEN_AGE', 60*60*24)) ;
        }

        $payload = [
            'iss' => env('JWT_ISS', 'silani.go.id'), // Issuer of the token, Organization / Product
            'sub' => $user->_id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + $expire , // Expiration time
            'usr' => $user
        ];

        $token = JWT::encode($payload, $secretKey);

        if(env('ALLOW_MULTIPLE_AUTH', true)){

        }else{
            $whites = TokenWhitelist::where('sub','=',$user->_id)
                ->where('role','=',$user->roleId)
                ->get();
            if($whites){
                foreach($whites as $wt){
                    $blacklist = new TokenBlacklist();

                    $blacklist->token = $wt->token;
                    $blacklist->expiry = $wt->expiry;
                    $blacklist->cred = $wt->cred;
                    $blacklist->save();

                    $wt->delete();
                }
            }

        }


        $whitelist = new TokenWhitelist();

        $whitelist->token = $token;
        $whitelist->sub = $payload['sub'];
        $whitelist->role = $payload['usr']->roleId;
        $whitelist->expiry = $payload['exp'];
        $whitelist->cred = $payload;
        $whitelist->save();

        return $token;

    }

    public static function removeWhitelist($token)
    {
        try{
            TokenWhitelist::where('token', '=', $token)->delete();
        }catch(\Exception $exception){
            return false;
        }
        return true;
    }

    public static function getRoleId($rolename)
    {
        $role = Role::where('rolename','=',$rolename)->orWhere('slug','=', strtolower( $rolename ))->first();
        if($role){
            return $role->_id;
        }else{
            return false;
        }
    }

    public static function getRoleName($roleid)
    {
        $role = Role::find($roleid);
        if($role){
            return $role->rolename;
        }else{
            return false;
        }
    }

    public static function getRoleSlug($roleid)
    {
        $role = Role::find($roleid);
        if($role){
            if( !isset($role->slug) || is_null($role->slug) || $role->slug ==''  ){
                $slug = Util::makeSlug( $role->rolename );
            }else{
                $slug = $role->slug;
            }

            return $slug;
        }else{
            return false;
        }
    }

    public static function getRoleRedirect($roleid)
    {
        $role = Role::find($roleid);
        if($role){

            if( env('WITH_KYC', false) ){
                // create callback with signature fn(role) return uri string to redirect to
                $kyc_guard = env('KYC_GUARD');
                return $kyc_guard($role);
            }else{
                if(isset($role->roleredirect)){
                    return $role->roleredirect;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }

    public static function getRoleLayout($roleid)
    {
        $role = Role::find($roleid);
        if($role){
            if(isset($role->rolelayout)){
                return $role->rolelayout;
            }else{
                if(self::isAdmin()){
                    return env('ADMIN_LAYOUT');
                }else{
                    return env('DEFAULT_LAYOUT');
                }
            }
        }else{
            return env('DEFAULT_LAYOUT');
        }
    }

    public static function getAvatar($avatar, $default)
    {
        if(is_array($avatar) && isset($avatar['url']) ){
            return $avatar['url'];
        }elseif(is_string($avatar)){
            return $avatar;
        }else{
            return $default;
        }
    }

    public static function getAclEntityForm()
    {
        $aclList = AclObject::where('isActive','=', true)->get();
        $form = [];
        foreach ($aclList as $fr){

            $fo = [
                'label'=>$fr->objectName,
                'form'=>[
                    'model'=>'value.'.$fr->objectKey,
                    'options'=>config('acl.crud')
                ]
            ];

            $fr->formType = $fr->formType??'checkbox';
            $fr->formType = 'checkbox';
            $field = view('form.component.'.strtolower($fr->formType) , $fo )->render();

            $form[] = $field;

        }

        return '<div>'.implode('',$form).'</div>';
   }

    public static function getAclEntityModel()
    {
        $aclList = AclObject::where('isActive','=', true)->get();
        $model = [];
        foreach ($aclList as $fr){
            $type = '';
            switch ($fr->formType){
                case 'checkbox':
                    $type = ['create','update'];
                    break;
                case 'radio':
                    $type = '';
                    break;
                case 'Object':
                    $type = new \ArrayObject();
                    break;
                default:
                    $type = '';
                    break;
            }

            $permArray = [];

            if( isset($fr->standardCrud) && ( $fr->standardCrud == 'yes' || $fr->standardCrud == true) ){

                foreach ( config('acl.crud') as $item ){
                    $key = strtolower( trim( str_replace(' ', '', $item['key'] ) ) );
                    $permArray[] = ['label'=>$item['text'], 'key'=>$key, 'value'=>$item['default']  ];
                }

            }

            if( isset($fr->valueArray) && is_string($fr->valueArray) ){
                $customObj = explode(',', $fr->valueArray);
                if($customObj){
                    foreach ( $customObj as $obj){
                        $label = ucfirst($obj);
                        $permArray[] = ['label'=>$label, 'key'=>$obj, 'value'=>false  ];
                    }
                }
            }

            $model[$fr->objectKey] = [ 'label'=>$fr->objectName, 'descr'=>$fr->objectDescription , 'enabled'=>true ,'acl'=>$permArray ] ;

        }

        return $model;

    }

    public static function loadRoleEntity($role){
        if(is_null($role)){
            return new self;
        }
        $roleSet = Role::select(
            [
                '_id',
                'ajax',
                'handle',
                'createdAt',
                'updatedAt',
                'ownerId',
                'ownerName',
                'deleted',
                'rolename',
                'slug',
                'roleredirect',
                'roleDescription',
                'roleACL',
                'rev',
                'updated_at',
                'created_at',
            ]
        )->find($role);
        if($roleSet){
            self::$roleObjectEntity = $roleSet->toArray();
        }
        return new self;
    }

    public static function registerAclObject($key, $name , $group){

        $acl = AclObject::where('objectKey', '=', trim($key))->first();

        if($acl){
            return false;
        }else{
            $acl = new AclObject();

            $acl->isActive = true ;
            $acl->objectName = $name ;
            $acl->objectKey = $key ;
            $acl->group = $group ;
            $acl->checkMethod = 'BooleanCheck' ;
            $acl->objectType = 'Boolean' ;
            $acl->formType = 'Checkbox' ;
            $acl->standardCrud = true ;
            $acl->valueArray = null ;
            $acl->lookupTo = 'Config' ;
            $acl->lookupParam = 'acl.crud' ;
            $acl->objectDescription = null ;
            $acl->handle = 'mKRqPE' ;
            $acl->domainNs = env('APP_NAMESPACE', '') ;

            $acl = TimeUtil::createTime($acl, env('DEFAULT_TIME_ZONE'));

            $acl->save();
        }

        return true;
    }

    public static function can($action, $entity, $role = null){
        debug('ROLE_ENTITY');
        debug(self::$roleObjectEntity);

        if(env('SKIP_ROLE', true)){
            return true;
        }
        if(is_null($role)){
            return false;
        }else{
            $roleName = strtolower(self::getRoleName($role));
            if ($roleName=="superuser" || $roleName=="superadmin" || $roleName=="root" || $roleName=="super"){
                return true;
            }

            if(self::$roleObjectEntity == null){
                //$roleObject = Role::find($role);
            }else{
                $roleObject = self::$roleObjectEntity;
            }

            debug('ROLE_ENTITY');
            debug($roleObject);

            if($roleObject){

                $roa = is_array($roleObject) ? $roleObject : $roleObject->toArray();

                if(isset($roa['roleACL'])){
                    $permissions = $roa['roleACL'];
                    if(isset($permissions[$entity]['acl'])){
                        $permissions = $permissions[$entity]['acl'];
                        $can = false;
                        foreach ($permissions as $p){
                            if(isset($p['key']) && $p['key'] == $action){
                                $can = $p['value']??false;
                            }
                        }
                        return $can;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }


        }
    }

    public static function is($rolename)
    {
        if(Auth::check()){
            $user = Auth::user()->toArray();
            if( $user['roleId'] == self::getRoleId($rolename)){
                return true ;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function isAdmin()
    {
        if(Auth::check()){
            if($ownRoleId = Auth::user()->roleId){
                return $ownRoleId == self::getRoleId('root') ||  $ownRoleId == self::getRoleId('superuser') ||  $ownRoleId == self::getRoleId('administrator');
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function isRoot()
    {
        if(Auth::check()){
            if($ownRoleId = Auth::user()->roleId){
                return $ownRoleId == self::getRoleId('root') || $ownRoleId == self::getRoleId('superuser') || $ownRoleId == self::getRoleId('Superuser');
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function updateField(array $kv){
        if (Auth::check()){
            $user = User::find( Auth::user()->_id );
            if($user){
                foreach ($kv as $k=>$v){
                    $user->{$k} = $v;
                }
                $user->save();
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function isFilled($fields)
    {
        $usr = User::find(Auth::user()->_id);
        if($usr){
            $usr = $usr->toArray();
            $filled = true;
            foreach($fields as $f){
                if(isset($usr[$f])){
                    if(is_null($usr[$f]) || $usr[$f] == '' || empty($usr[$f])){
                        $filled = false;
                    }
                }else{
                    $filled = false;
                }
            }
            return $filled;
        }else{
            return false;
        }
    }

    public static function isObjectFilled($fields, $obj)
    {
        $usr = $obj ?? false;
        if($usr){
            $usr = $usr->toArray();
            $filled = true;
            foreach($fields as $f){
                if(isset($usr[$f])){
                    if(is_null($usr[$f]) || $usr[$f] == '' || empty($usr[$f])){
                        $filled = false;
                    }
                }else{
                    $filled = false;
                }
            }
            return $filled;
        }else{
            return false;
        }
    }

}
