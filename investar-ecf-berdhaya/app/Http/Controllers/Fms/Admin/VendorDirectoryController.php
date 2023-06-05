<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Fms\Admin;

use App\Helpers\App\CentralUtil;
use App\Helpers\App\DwfUtil;
use App\Helpers\App\FmsUtil;
use App\Helpers\App\SfmUtil;
use App\Helpers\Injector;
use App\Helpers\Util;
use App\Helpers\RefUtil;
use App\Helpers\WorkflowUtil;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\Role;
use App\Models\Directory\VendorDirectory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class VendorDirectoryController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/fms/admin';
        $this->yml_file = 'vendor_directory_controller';


        $this->entity = 'Vendor';

        $this->auth_entity = 'fms-vendor-directory';

        $this->controller_base = 'fms/vendor';

        $this->view_base = 'fms.admin.vendordirectory';

        $this->model = new VendorDirectory();
    }

    public function getIndex()
    {
        $this->title = 'Vendor Directory';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'fms.admin.vendordirectory.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'fms.admin.vendordirectory.form_layout';
        $this->form_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();
        $formOptions['provinceNameOptions'] = RefUtil::toOptions(RefUtil::getProvince(),'provinceName','provinceName', false);
        $formOptions['cityNameOptions'] = [];

        $formOptions['companyTypeOptions'] = RefUtil::toOptions(RefUtil::getCompanyType(),'companyType','companyType', false);

        $uiOptions = [];
        //start $picContacts
      // use injector to provide parameter for simpletablemodaltemplate / simpletable
      $uiOptions = Injector::setObject('picContacts') // name variable / field yang akan diinject
      ->setObjFields( // mwnambahkan setting field untuk table
        [
          [ 'label'=>'Name', 'key'=>'contactName', 'class'=>'text-100'],
          [ 'label'=>'Phone', 'key'=>'contactPhone', 'class'=>'text-120'],
          [ 'label'=>'Mobile', 'key'=>'contactMobile', 'class'=>'text-140'],
          [ 'label'=>'Email', 'key'=>'contactEmail'],
          [ 'label'=>'Default', 'key'=>'contactDefault', 'class'=>'text-75']
        ]
      )->setObjDef( // set object default
        [
          'contactName'=>'',
          'contactPhone'=>'',
          'contactMobile'=>'',
          'contactEmail'=>'',
          'contactDefault'=>false
        ]
      )
        ->setObjTemplate(view('fms.admin.vendordirectory.contact')->render() ) // set template
        ->injectObject($uiOptions); // inject into uiOption array
        //end $picContacts

        $this->with_advanced_search = true;

        $this->extra_query = [
            'coyName'=>'',
            'services'=>'',
            'products'=>'',
            'brands'=>'',
            'picContacts'=>''
        ];

        $formOptions['vendorClassOptions'] = config('app.fms.vendorClass');

        $formOptions['companyProfileUrlTemplate'] = "`<span>Company Profile</span>`";
        $formOptions['mediaUrlCatalogTemplate'] = "`<span>Catalogue</span>`";
        $formOptions['taxIdNpwpTemplate'] = "`<span>Tax ID(NPWP)</span>`";

        $this->aux_data = array_merge( $uiOptions ,$formOptions);
        $this->add_title_fields = '"<h4><img src=\"'.url('images/icons/vendor-icon.png').'\" style=\"width:42px;height:auto;margin-top:-15px;\"/> Add : Vendor Directory</h4>"';
        $this->view_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\"><h4 style=\"margin-bottom: 40px;\">" + this.coyName+ "-" + this.vendorCode+ "</h4></div>"',  '<img src=\"'.url('images/icons/vendor-icon.png').'\" style=\"width:42px;height:auto;\"/>' );
        $this->update_title_fields = sprintf('"<h4>%s Update Vendor: "  + this.coyName+ "-" + this.vendorCode+"</h4>"',  '<img src=\"'.url('images/icons/vendor-icon.png').'\" style=\"width:42px;height:auto;margin-top:-15px;\"/>' );

        $this->print_template = 'vendor-print-template';
        $this->print_modal_size = 'lg';
        $this->non_closing_save = false;

        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {
//        $this->defOrderField = 'IODate';
//        $this->defOrderDir = 'desc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {

        $cname = substr(strrchr(get_class($this), '\\'), 1);

        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'fms.admin.vendordirectory.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $form_layout = 'form_layout';
        $this->form_dialog_size = 'lg';

        $template_name = strtolower($keyword0);

        if($keyword0 != ''){
            $layout = str_replace('-', '_', $keyword0);
            if( View::exists('fms.admin.vendordirectory.'.$layout) ){
                $form_layout = $layout;
                if($keyword0 == 'field-officer' || $keyword0 == 'farm-admin' || $keyword0 == 'ib-officer'){
                    $this->form_dialog_size = 'lg';
                }
            }
        }
        $this->form_layout = 'fms.admin.vendordirectory.'.$form_layout;

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

        $this->edit_as_page = false;
        $this->add_as_page = false;

        $this->aux_data = $formOptions;
        $this->print_template = 'data-card';
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

        $this->add_filler = true;

        return parent::getList($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }


    public function additionalQuery($model, Request $request)
    {
        $adv = $request->get('advancedSearch') ?? false;
        $ext = $request->get('extraData') ?? false;
        if( $adv && $ext &&  (isset($adv['enable']) && $adv['enable']) && $adv['isOpen']){

//            'coyName'=>'',
//            'services'=>'',
//            'products'=>'',
//            'picContacts'=>''

            if( isset($ext['coyName']) && $ext['coyName'] != '' ){
                $model = $model->where('coyName','like', '%'.$ext['coyName'].'%');
            }

            if( isset($ext['services']) && $ext['services'] != '' ){
                $services = explode(',', $ext['services'] );

                $model = $model->where(function($q) use ( $services) {
                    for($i = 0; $i < count($services); $i++){
                        if($i == 0){
                            $q = $q->where('services','like','%'.$services[$i].'%');
                        }else{
                            $q = $q->orWhere('services','like','%'.$services[$i].'%');
                        }
                    }
                });
            }

            if( isset($ext['products']) && $ext['products'] != '' ){
                $products = explode(',', $ext['products'] );

                $model = $model->where(function($q) use ( $products) {
                    for($i = 0; $i < count($products); $i++){
                        if($i == 0){
                            $q = $q->where('products','like','%'.$products[$i].'%');
                        }else{
                            $q = $q->orWhere('products','like','%'.$products[$i].'%');
                        }
                    }
                });
            }

            if( isset($ext['brands']) && $ext['brands'] != '' ){
                $brands = explode(',', $ext['brands'] );

                $model = $model->where(function($q) use ( $brands) {
                    for($i = 0; $i < count($brands); $i++){
                        if($i == 0){
                            $q = $q->where('brands','like','%'.$brands[$i].'%');
                        }else{
                            $q = $q->orWhere('brands','like','%'.$brands[$i].'%');
                        }
                    }
                });
            }

        }

        if($request->has('keywords')){
            $k = $request->get('keywords');
            if($k['keyword0'] != ''){
                $model = $model->where('vendorClass','=', $k['keyword0'] );
            }
        }

        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        $data['vendorSeq'] = intval($data['vendorSeq']);
        return parent::beforeSave($data);
    }

    public function getParam()
    {
        $request = Request::capture();

        $roleSlug = $request->get('keyword0');
        $this->def_param['vendorClass'] = $roleSlug;
        $this->def_param['companyType'] = 'PT';

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {
        /* modify or add new fields */
        //$row['linkConsult'] = url('clinic/patient/km/'.$row['_id']);
        //$row['linkOp'] = url('clinic/patient/op/'.$row['_id']);

        return parent::rowPostProcess($row);
    }

    public function beforeImportCommit($data)
    {
        // $data['IODate'] = ImportUtil::excelDateToNormal($data['IODate']);
        // $data['DocDate'] = ImportUtil::excelDateToNormal($data['DocDate']);
        // $data['RetDate'] = ImportUtil::excelDateToNormal($data['RetDate']);
        // $data['DispDate'] = ImportUtil::excelDateToNormal($data['DispDate']);

        if($data['picContacts'] != ''){
            $data['picContacts'] = json_decode($data['picContacts']);
        }

        $name = explode(' ', $data['coyName'] );

        if(count($name) > 1){
            $s1 = substr($name[0], 0, 1);
            $s2 = substr($name[1], 0, 1);
            $prefix = strtoupper($s1.$s2);
        } else {
            $s1 = substr($name[0], 0, 1);
            $s2 = $s1;
            $prefix = strtoupper($s1.$s2);
        }

        $prefix = 'V'.$prefix;



        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }

    public function postGetSeq(Request $request)
    {
        $entity = $request->get('entity');
        $company = $request->get('company');

        // validasi untuk mencegah 2 company dengan nama yang sama
        if( is_null($company) && $company != ''){

        }else{
            $rec = $this->model->where('coyName', '=', $company)
                ->where('vendorCode', 'exists' , true)
                ->whereNotNull('vendorCode')
                ->where('vendorCode', '!=' , '')
                ->first();
            if ($rec){
                return response()->json([
                    'result'=>'ERR',
                    'msg'=>'Vendor already exist'
                ]);
            }
        }

        if( $request->has('padding') ){
            $padding = $request->get('padding')??env('NUM_PAD', 5);
        }else{
            $padding = env('NUM_PAD', 5);
        }

        if( is_null($entity) && $entity != ''){
            $seq = false;
        }else{
            $rec = $this->model->where('vendorPrefix', '=', $entity)->max('vendorSeq');
            $seq = $rec + 1;
        }

        //$seq = CedarUtil::getSequence($entity);

        if($seq){
            return response()->json([
                'result'=>'OK',
                'entity'=>$entity,
                'seq'=>$seq,
                'padded'=> str_pad($seq, $padding , '0', STR_PAD_LEFT )
            ]);

        }else{
            return response()->json([
                'result'=>'ERR',
                'msg'=>'NOENTITY'
            ]);
        }
    }
}