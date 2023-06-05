<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/11/19
 * Time: 21.43
 */
namespace App\Http\Controllers\Core;

use App\Helpers\App\DwfUtil;
use App\Helpers\AuthUtil;
use App\Helpers\RefUtil;
use App\Helpers\App\CentralUtil;
use App\Helpers\WorkflowUtil;
use App\Helpers\Util;
use App\Models\Core\Mongo\Role;
use App\Models\Core\Mongo\User;
use App\Models\Dwf\Admin\GroupAlias;
use App\Models\Dwf\Admin\JobGroup;
use App\Models\Reference\JobTitle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class UserController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

//        $this->res_path = 'views/core/user';
//        $this->yml_file = 'fields';

        $this->res_path = 'models/controllers/core';
        $this->yml_file = 'user_model_controller';

        $this->entity = 'User';

        // this must be set to use ACL
        $this->auth_entity = 'all-users';

        // set controller path
        $this->controller_base = 'user';

        // set view base to include standard slot
        $this->view_base = 'core.user';

        $this->model = new User();
    }

    public function getIndex()
    {
        $this->title = 'Users';

        $cname = substr(strrchr(get_class($this), '\\'), 1);

        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'core.user.viewlayout';
        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'core.user.formlayout';
        $this->form_dialog_size = 'xl';

        $this->runViewSet();
        $this->runAcl();
        $this->runUrlSet();
        $this->runMoreMenu();

        $this->can_print = false;
        $this->can_clone = false;
        $this->can_multi_clone = false;
        $this->can_delete = true;

        $this->viewer_dialog_size = 'xl';

        $this->with_advanced_search = true;

        $this->extra_query = [
            'dobFrom'=>'',
            'dobUntil'=>'',
            'roleName'=>'',
            'statusEmployee'=>'',
            'companyName'=>'',
        ];

        $this->can_approve = false;
        $this->can_request_approval = false;
        $this->can_revise = false;


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['roleIdOptions'] = Util::toSelectOptions(new Role(), true, 'rolename', '_id');
        $formOptions['provinceOptions'] = RefUtil::toOptions(RefUtil::getProvince(),'provinceName','provinceName', false);
        $formOptions['companyNameOptions'] = CentralUtil::toOptions(WorkflowUtil::getClient(),'companyName','companyName', false);
        $formOptions['statusEmployeeOptions'] = config('util.employee_status');

        $formOptions['jobObjectOptions'] = DwfUtil::toOptions( DwfUtil::getTitleCode(), ['jobCode','jobTitle'], '_object', false ) ;

        $formOptions['bizUnitOptions'] = DwfUtil::toOptions( RefUtil::getBizUnit(), ['bizUnitCode','bizUnitName'], 'bizUnitCode', true ) ;


        $formOptions['idTypeOptions'] = [[ 'value'=> 'KTP', 'text'=> 'KTP' ],[ 'value'=> 'SIM', 'text'=> 'SIM'],[ 'value'=> 'KITAS', 'text'=> 'KITAS'],[ 'value'=> 'PASSPORT', 'text'=> 'PASSPORT']];

        $formOptions['genderOptions'] = [[ 'value'=> 'L', 'text'=> 'L' ],[ 'value'=> 'P', 'text'=> 'P']];

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

        $formOptions['new_password'] = '""';
        $formOptions['new_confirm_password'] = '""';
        $formOptions['new_pin'] = '""';
        $formOptions['new_confirm_pin'] = '""';

        $formOptions['mobileCountryOptions'] = config('util.mobile_countries');


        $this->aux_data = $formOptions;
        $this->view_title_fields='this.name';
        $this->update_title_fields = '"<h4>'.__('Edit').' " + this.name + "</h4>"' ;
        $this->add_title_fields = '"<h4>'.__('Create').' '.$this->entity.'</h4>"';

        $this->add_filler = true;

        return parent::getIndex();
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {

        $cname = substr(strrchr(get_class($this), '\\'), 1);

        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'core.user.viewlayout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $form_layout = 'form_layout';
        $this->form_dialog_size = 'xl';

        $template_name = strtolower($keyword0);

        if($keyword0 != ''){
            $layout = str_replace('-', '_', $keyword0);
            if( View::exists('core.user.'.$layout) ){
                $form_layout = $layout;
                if($keyword0 == 'field-officer' || $keyword0 == 'farm-admin' || $keyword0 == 'ib-officer'){
                    $this->form_dialog_size = 'lg';
                }
            }
        }

        $this->form_layout = 'core.user.'.$form_layout;

        $this->form_view = 'form.html'; // use plain html

        $this->auth_entity = 'fms-'.trim($keyword0);

        $this->can_update = true;
        $this->can_view = true;

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $this->can_print = true;
        $this->can_clone = false;
        $this->can_multi_clone = false;
        $this->can_multi_print = false;

        $s1 = (isset($keyword1) && !is_null($keyword1) && !$keyword1 == '') ? '/'.$keyword1 :'';
        $s2 = (isset($keyword2) && !is_null($keyword2) && !$keyword2 == '') ? '/'.$keyword2 :'';
        $this->data_url = $this->controller_base.'/list/'.$keyword0.$s1.$s2;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['roleIdOptions'] = Util::toSelectOptions(new Role(), true, 'rolename', '_id');
        $formOptions['provinceOptions'] = RefUtil::toOptions(RefUtil::getProvince(),'provinceName','provinceName', false);
        $formOptions['companyNameOptions'] = CentralUtil::toOptions(WorkflowUtil::getClient(),'companyName','companyName', false);
        $formOptions['statusEmployeeOptions'] = config('util.employee_status');
        $formOptions['genderOptions'] = [[ 'value'=> 'L', 'text'=> 'L' ],[ 'value'=> 'P', 'text'=> 'P']];

        $formOptions['jobObjectOptions'] = DwfUtil::toOptions( DwfUtil::getTitleCode(), ['jobCode','jobTitle'], '_object', false ) ;

        $formOptions['bizUnitOptions'] = FmsUtil::toOptions( FmsUtil::getFarms( Auth::user()->_id ), 'farmName', '_object', true ) ;


        $formOptions['idTypeOptions'] = [[ 'value'=> 'KTP', 'text'=> 'KTP' ],[ 'value'=> 'SIM', 'text'=> 'SIM'],[ 'value'=> 'KITAS', 'text'=> 'KITAS'],[ 'value'=> 'PASSPORT', 'text'=> 'PASSPORT']];

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

        $formOptions['new_password'] = '""';
        $formOptions['new_confirm_password'] = '""';
        $formOptions['new_pin'] = '""';
        $formOptions['new_confirm_pin'] = '""';

        $formOptions['mobileCountryOptions'] = config('util.mobile_countries');

        $this->edit_as_page = false;
        $this->add_as_page = false;

        $this->aux_data = $formOptions;

        $this->add_filler = true;

        $this->viewer_as_document = true;

        $this->print_template = $template_name;

        $exclude = null;

        $this->title = str_replace('-', ' ', Str::title($keyword0) );

        if(strpos($this->yml_file, '_controller') === false){
            $this->table_column = Util::loadResYaml( $this->yml_file,$this->res_path )->toColFields(false, $this->show_actions, $this->add_filler);
        }else{
            $this->table_column = Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFields(false, $this->show_actions, $this->add_filler, $exclude);
        }

        $this->entity = $this->title;

        return parent::getList($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        $adv = $request->get('advancedSearch');
        $ext = $request->get('extraData');
        if((isset($adv['enable']) && $adv['enable']) && $adv['isOpen']){ // query hanya dilakukan jika advanced search aktif dan panel terbuka
            if( $ext['dobFrom'] != '' && $ext['dobUntil'] != '' ){

                $dobFrom = Carbon::parse($ext['dobFrom']);
                $dobUntil = Carbon::parse($ext['dobUntil']);

                $model = $model->whereBetween('dateOfBirth', [ $dobFrom , $dobUntil ] );
            }

            if( $ext['roleName'] != '' ){
                $role = $ext['roleName'];
                $model = $model->where('roleId', $role);
            }

            if( $ext['statusEmployee'] != '' ){
                $statEmployee = $ext['statusEmployee'];
                $model = $model->where('statusEmployee', $statEmployee);
            }

            if( $ext['companyName'] != '' ){
                $company = $ext['companyName'];
                $model = $model->where('companyName', $company);
            }
        }

        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
    }

    public function beforeUpdateForm($population)
    {
        $population['password'] = '';

        if(isset($population['jobTitleCode']) && $population['jobTitleCode'] != '' ){
            $jobObject = JobTitle::where( 'jobCode','=', $population['jobTitleCode'] )->first([
                'description','jobCode', 'jobTitle','subGroup'
            ]);
            if($jobObject){
                $jo =  $jobObject->toArray();
                $jo['_id'] = ['jobCode'=>$jo['jobCode'] ];
                $population['jobObject'] = $jo;
            }else{
                $population['jobObject'] = null;
            }
        }else{
            $population['jobObject'] = null;
        }
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

        $data['roleSlug'] = AuthUtil::getRoleSlug($data['roleId']);
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

        $data['roleName'] = AuthUtil::getRoleName($data['roleId']);
        $data['roleSlug'] = AuthUtil::getRoleSlug($data['roleId']);

        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function changePassword(Request $request)
    {
        $id = $request->get('id') ?? Auth::user()->_id;
        $user = $this->model->find($id);
        $password = Hash::make($request->get('password'));

        $user->password = $password;

        if( $user->save() )
        {
            return response()->json([
                'result'=>'OK',
                'msg'=>'Password changed successfuly',
            ]);
        }else{
            return response()->json([
                'result'=>'NOK',
                'msg'=>'Failed to change Password'
            ]);
        }
    }

    public function changePin(Request $request)
    {
        $id = $request->get('id') ?? Auth::user()->_id;

        //$id = $id ?? Auth::user()->id;
        $user = $this->model->find($id);

        $pin = Hash::make($request->get('pin'));

        $user->pin = $pin;

        if( $user->save() )
        {
            return response()->json([
                'result'=>'OK',
                'msg'=>'Pin changed successfuly',
            ]);
        }else{
            return response()->json([
                'result'=>'NOK',
                'msg'=>'Pin failed to change'
            ]);
        }
    }

    public function getCity(Request $request)
    {
        $getCity = RefUtil::toOptions(RefUtil::getCity($request->get('province')),'cityName','cityName', false);
        return $getCity;
    }

    public function getParam()
    {
        $request = Request::capture();

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
        $allRoles = Util::toSelectOptions(new Role(), true , 'rolename');
        $this->sel_options['roles'] = $allRoles;
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

    public function beforeImportCommit($data)
    {

        $uniqUser = $this->model->where( 'username', '=', $data['username'] )
            ->orWhere( 'email', '=', $data['email'] )
            ->orWhere( 'employeeId', '=', ($data['employeeId'] ?? null) )
            ->count();

        if($uniqUser > 0){
            return false;
        }else{

            unset($data['id']);

            if(isset($data['password']) && $data['password'] != '' ){
                $data['password'] = Hash::make($data['password']);
            }else{
                $data['password'] = Hash::make( env('DEFAULT_NEW_PASS', '87654321') );
            }
            if(isset($data['pin']) && $data['pin'] != '' ){
                $data['pin'] = Hash::make($data['pin']);
            }else{
                $data['pin'] = Hash::make( env('DEFAULT_NEW_PIN', '876543') );
            }

            if(isset($data['roleName']) && $data['roleName'] != '' ){
                $data['roleId'] = AuthUtil::getRoleId( $data['roleName'] );
            }else{
                $data['roleId'] = AuthUtil::getRoleId( 'Employee' );
            }

            if(isset($data['jobTitleCode']) && $data['jobTitleCode'] != '' ){
                $jobObject = JobTitle::where( 'jobCode','=', $data['jobTitleCode'] )->first();
                if($jobObject){
                    $data['jobObject'] = $jobObject->toArray() ;
                }else{
                    $data['jobObject'] = null;
                }
            }else{
                $data['jobObject'] = null;
            }

            if(isset($data['jobTitleCode']) && $data['jobTitleCode'] != '' ){
                $jobObject = JobTitle::where( 'jobCode','=', $data['jobTitleCode'] )->first([
                    'description','jobCode', 'jobTitle','subGroup'
                ]);
                if($jobObject){
                    $jo =  $jobObject->toArray();
                    $jo['_id'] = ['jobCode'=>$jo['jobCode'] ];
                    $data['jobObject'] = $jo;
                }else{
                    $data['jobObject'] = null;
                }
            }else{
                $data['jobObject'] = null;
            }


        }

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }

    public function setDispoKey($group){
        $eid = [];
        $kgroup = [];
        foreach ($group as $g){
            $e = $g['employeeId'] ?? 'noid';
            if($e != 'noid'){
                $eid[] =
                $kgroup[$e] = $g;
            }
        }

        $users = User::whereIn('employeeId', $eid)->get();
        if($users){
            foreach ($users->toArray() as $usr){
                if(isset( $kgroup[$usr['employeeId']] )){
                    $kgroup[$usr['employeeId']]['_id'] = $usr['_id'];
                }
            }
        }

        $grp = [];
        foreach ($kgroup as $k=>$v){
            $grp[] = $v;
        }

        return $grp;
    }

    public function getAutoUser(Request $request)
    {
        $q = $request->get('q');

        $ext = $request->get('extraData');

        $res = [];

        if( isset($ext['keyword0']) && ( $ext['keyword0'] == 'lembar-disposisi' ) ){

            $tc = $ext['titleCode']['jobCode'] ?? '';

            $groups = JobGroup::where( 'jobTitleCode', '=', strtoupper( trim($tc) ) )
                ->where(function($qx) use($q) {
                    $qx->where( 'group', 'like', '%'.$q.'%' )
                        ->orWhere( 'jobTitle', 'like', '%'.$q.'%' )
                        ->orWhere( 'personnelName', 'like', '%'.$q.'%' );
                })

                ->get([
                    '_id',
                    'group',
                    'personnelName',
                    'jobTitle',
                    'jobTitleCode',
                    'employeeId',
                    'email',
                    'seq'
                ]);

            $groups = $groups->toArray();

            foreach ($groups as $g){
                $res[] = [
                    '_id'=>$g['_id'],
                    'email'=>( $g['email'] ?? '' ),
                    'name'=> ($g['personnelName'] ?? $g['jobTitleCode'].' '.$g['jobTitle']),
                    'username'=>$g['jobTitle'],
                    'jobTitle'=>$g['jobTitle'],
                    'jobTitleCode'=>$g['jobTitleCode'],
                    'avatar'=>'',
                    'seq'=>( $g['seq'] ?? '000' ),
                    'datatype'=>'disposisi'
                ];
            }

        }

        if( ( isset($ext['keyword0']) && ($ext['keyword0'] == 'surat-dinas' || $ext['keyword0'] == 'nota-dinas'))
            && ( isset($ext['model']) && ( $ext['model'] == 'recipient' || $ext['model'] == 'copy' ) ) ){
            $groups = GroupAlias::where( 'groupName', 'like', '%'.$q.'%' )
                ->orWhere( 'groupMember', 'like', '%'.$q.'%' )
                ->orWhere( 'jobTitleCode', 'like', '%'.$q.'%' )
                ->groupBy('groupName')
                ->get([
                    'groupName',
                    'groupMember',
                    'jobTitleCode',
                    'seq'
                ]);
            $groups = $groups->toArray();

            foreach ($groups as $g){
                $res[] = [
                    '_id'=>Util::randomstring(10),
                    'email'=>'',
                    'name'=>$g['groupName'],
                    'username'=>$g['groupName'],
                    'jobTitle'=>( strpos( $g['jobTitleCode'] , '@') > -1 ? $g['groupMember'] : '' ) ,
                    'jobTitleCode'=>$g['jobTitleCode'],
                    'avatar'=>'',
                    'seq'=>$g['seq'],
                    'datatype'=>'alias'
                ];
            }
        }

        $key0 = $ext['keyword0'] ?? '';
        $mdl = $ext['model'] ?? '';

        if( !($key0 == 'lembar-disposisi' && $mdl == 'recipient') ){

            $users = User::where( 'name', 'like', '%'.$q.'%' )
                ->orWhere( 'username', 'like', '%'.$q.'%' )
                ->orWhere( 'email', 'like', '%'.$q.'%' )
                ->orWhere( 'jobTitle', 'like', '%'.$q.'%' )
                ->orWhere( 'jobTitleCode', 'like', '%'.$q.'%' )
                ->orWhere( 'employeeId', 'like', '%'.$q.'%' )
                ->orderBy('jobGroupSeq', 'asc')
                ->orderBy('jobTitleSeq', 'asc')
                ->get();

            $users = $users->toArray();

            foreach ($users as $g){
                $res[] = [
                    '_id'=>$g['_id'],
                    'email'=>$g['email'],
                    'name'=>$g['name'],
                    'username'=>$g['username'],
                    'jobTitle'=>($g['jobTitle'] ?? ''),
                    'jobTitleCode'=>($g['jobTitleCode'] ?? ''),
                    'avatar'=>$g['avatar'],
                    'seq'=>( $g['jobTitleSeq'] ?? '000' ) ,
                    'datatype'=>'person'
                ];
            }

        }


        return response()->json([
            'result' => 'OK',
            'data' =>$res,
        ], 200);


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSetting($id = null)
    {
        if(is_null($id)){
            if(Auth::check()){
                $id = Auth::user()->id;
            }else{
                return redirect('login');
            }
        }

        $user = $this->model->find($id);

        if($user){
            $this->title = $user->name;
        }else{
            return redirect('login');
        }

        $this->table_view = 'core.user.setting';

        return $this->pageGenerator();

    }

    public function editProfile(Request $request, $id = null)
    {
        $this->res_path = 'models/controllers/core';
        $this->yml_file = 'user_model_controller';

        $this->view_base = 'core.user';


        $this->model = new User();

        $id = $id ?? Auth::user()->_id;

        $user = $this->model->find($id);

        if($user){
            $this->title = "Edit ".$user->name;
        }else{
            return redirect('login');
        }

        $this->runPageViewSet();

        $this->has_tab = false;

        $this->show_title = false;

        $this->add_url = 'user/add';

        $this->update_url = 'user/edit';

        $this->item_id = $id;

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_layout = 'core.user.formlayout_profile';

        $this->form_mode = 'edit';

        $this->can_lock = false;

        $this->can_save = true;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['companyNameOptions'] = CentralUtil::toOptions(RefUtil::getCompany(),'companyName','companyName', false);
        // $formOptions['companyNameOptions'] = CentralUtil::toOptions(WorkflowUtil::getClient(),'companyName','companyName', false);

        $formOptions['provinceOptions'] = RefUtil::toOptions(RefUtil::getProvince(),'provinceName','provinceName', false);

        $formOptions['roleIdOptions'] = Util::toSelectOptions(new Role(), true, 'rolename', '_id');

        $formOptions['statusEmployeeOptions'] = config('util.employee_status');

        $formOptions['idTypeOptions'] = [[ 'value'=> 'KTP', 'text'=> 'KTP' ],[ 'value'=> 'SIM', 'text'=> 'SIM'],[ 'value'=> 'KITAS', 'text'=> 'KITAS'],[ 'value'=> 'PASSPORT', 'text'=> 'PASSPORT']];

        $formOptions['kecamatanOptions'] = [];

        $formOptions['kelurahanOptions'] = [];

        $formOptions['cityOptions'] = [];

        $formOptions['new_pin'] = '""';

        $formOptions['new_confirm_pin'] = '""';

        $formOptions['new_password'] = '""';

        $formOptions['new_confirm_password'] = '""';

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

        $this->page_redirect_after_save = true;
        $this->page_save_redirect = 'profile';
        $this->page_cancel_redirect = 'profile';

        return parent::formGenerator();
    }

    public function getProfile($id = null)
    {
        $this->res_path = 'models/controllers/core';
        $this->yml_file = 'user_profile_controller';

        $this->view_base = 'core.user';


        $this->model = new User();

        $id = $id ?? Auth::user()->_id;

        $user = $this->model->find($id);

        if($user){
            $this->title = $user->name;
        }else{
            return redirect('login');
        }

        $this->runPageViewSet();

        $this->has_tab = false;

        $this->show_title = false;

        $this->add_url = 'user/add';

        $this->update_url = 'user/edit';

        $this->item_id = $id;

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_layout = 'core.user.page_viewlayout';

        $this->form_mode = 'view';

        $this->can_lock = false;

        $this->can_save = false;

        $this->page_additional_view = 'core.user.profile_page_additional';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['roleIdOptions'] = Util::toSelectOptions(new Role(), true, 'rolename', '_id');

        $formOptions['provinceOptions'] = RefUtil::toOptions(RefUtil::getProvince(),'provinceName','_object', false);

        $formOptions['idTypeOptions'] = [[ 'value'=> 'KTP', 'text'=> 'KTP' ],[ 'value'=> 'SIM', 'text'=> 'SIM'],[ 'value'=> 'KITAS', 'text'=> 'KITAS'],[ 'value'=> 'PASSPORT', 'text'=> 'PASSPORT']];

        $formOptions['new_pin'] = '""';

        $formOptions['new_confirm_pin'] = '""';

        $formOptions['new_password'] = '""';

        $formOptions['new_confirm_password'] = '""';


        $this->aux_data = $formOptions;

        return parent::formGenerator();
    }

}
