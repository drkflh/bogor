<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/11/19
 * Time: 21.43
 */
namespace App\Http\Controllers\Core;

use App\Helpers\AuthUtil;
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\Member;
use App\Models\Core\Mongo\Role;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

//        $this->res_path = 'views/core/member';
//        $this->yml_file = 'fields';

        $this->res_path = 'models/controllers/core';
        $this->yml_file = 'member_model_controller';

        $this->entity = 'Member';

        // this must be set to use ACL
        $this->auth_entity = 'all-members';

        // set controller path
        $this->controller_base = 'member';

        // set view base to include standard slot
        $this->view_base = 'core.member';

        $this->model = new Member();
    }

    public function getIndex()
    {
        $this->title = 'Members';

        $cname = substr(strrchr(get_class($this), '\\'), 1);

        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'core.member.viewlayout';
        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'core.member.formlayout';
        $this->form_dialog_size = 'xl';

        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $this->can_approve = false;
        $this->can_request_approval = false;
        $this->can_revise = false;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['roleIdOptions'] = Util::toSelectOptions(new Role(), true, 'rolename', '_id');

        $formOptions['provinceOptions'] = RefUtil::toOptions(RefUtil::getProvince(),'provinceName','_object', false);

        $formOptions['kecamatanOptions'] = [];

        $formOptions['kelurahanOptions'] = [];

        $formOptions['cityOptions'] = [];

        $this->print_template = [
            [
                'template'=>'user-detail',
                'modal'=>'xl',
                'label'=>'Print Detail'
            ],
            [
                'template'=>'user-card',
                'modal'=>'xl',
                'label'=>'Print Card'
            ]
        ];

        $this->aux_data = $formOptions;
        $this->view_title_fields='this.name';
        $this->update_title_fields='this.name';
        $this->add_title_fields = '"<h4>Create New '.$this->entity.'</h4>"';

        return parent::getIndex();
    }

    public function beforeUpdateForm($population)
    {
        $population['password'] = '';
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {
        if(isset($data['password']) && $data['password'] != ''){
            unset($data['confirm_password']);
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
            unset($data['confirm_password']);
        }

        if(isset($data['pin']) && $data['pin'] != ''){
            unset($data['confirm_pin']);
            $data['pin'] = Hash::make($data['pin']);
        }else{
            unset($data['pin']);
            unset($data['confirm_pin']);
        }

        $roleName = 'member';
        $data['roleId'] = AuthUtil::getRoleId($roleName);
        $data['roleSlug'] = $roleName;
        $data['roleName'] = AuthUtil::getRoleName($data['roleId']);

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }


    public function postEdit($_id, $data = null, Request $request)
    {
        if( isset($data['password']) && $data['password'] == ''){
            unset($data['password']);
            unset($data['confirm_password']);
        }

        if( isset($data['pin']) && $data['pin'] == ''){
            unset($data['pin']);
            unset($data['confirm_pin']);
        }

        return parent::postEdit($_id, $data, $request); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {
        unset($data['confirm_password']);
        unset($data['confirm_pin']);

        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        if(isset($data['pin'])){
            $data['pin'] = Hash::make($data['pin']);
        }

        $roleName = 'Member';
        $data['roleId'] = AuthUtil::getRoleId($roleName);
        $data['roleName'] = AuthUtil::getRoleName($data['roleId']);
        $data['roleSlug'] = $roleName;

        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        $roleId = AuthUtil::getRoleId('Member');
        $model = $model->where('roleId','=',$roleId);
        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
    }


    public function getParam()
    {
        $allRoles = Util::toSelectOptions(new Role(), true , 'rolename');
        $this->sel_options['roles'] = $allRoles;

        $this->def_param['avatar'] = url( env('DEFAULT_AVATAR') );
        $this->def_param['idPic'] = url( env('DEFAULT_CARD_IMAGE') );

        $this->def_param['pin'] = '';
        $this->def_param['confirm_pin'] = '';

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    public function getData($id, $additional_data = null)
    {
        return parent::getData($id, $additional_data); // TODO: Change the autogenerated stub
    }

    public function postDlxl(Request $request)
    {
        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        return parent::postDlxl($request); // TODO: Change the autogenerated stub
    }

    public function rowPostProcess($row)
    {
//        $row['roleName'] = ( $rolename = AuthUtil::getRoleName( $row['roleId'] ) )? $rolename : 'No Role';
        return $row;
    }

    public function postGenerateToken(Request $request)
    {
        $id = $request->get('apiId');

        $user = Member::find($id);

        if($user){

            debug($user->toArray());

            unset($user->token);
            unset($user->raw_json);
            // set token for 50 years
            $token = AuthUtil::createToken( $user, env('JWT_TOKEN_AGE'));

            $user->token = $token;
            $user->save();

            return response([
                'result'=>'OK',
                'message'=>'New Token',
                'data'=> [
                    'token'=>$token
                ]
            ],200);

        }else{
            return response([
                'result'=>'ERR',
                'message'=>'API User not found',
                'data'=> [
                    'token'=>null
                ]
            ],404);
        }

    }


}
