<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Sfm\Directory;

use App\Helpers\App\SfmUtil;
use App\Helpers\Injector;
use App\Helpers\Util;
use App\Helpers\RefUtil;
use App\Http\Controllers\Core\AdminController;
use App\Models\Directory\CustomerDirectory;
use Illuminate\Http\Request;

class CustomerDirectoryController extends AdminController

{
    public function __construct()
    {
        parent::__construct();


        $this->res_path = 'models/controllers/sfm/directory';
        $this->yml_file = 'customer_directory_controller';

        $this->entity = 'Customer';

        $this->auth_entity = 'sfm-directory-customer-directory';

        $this->controller_base = 'sfm/directory/customer-directory';

        $this->view_base = 'sfm.directory.customerdirectory';

        $this->model = new CustomerDirectory();
    }

    public function getIndex()
    {
        $this->title = '<img style="width:38px;height:auto;margin-top:-10px;margin-right:3px" src="'.url('images/icons/vendor-icon.png').'" /> Customer Directory';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'sfm.directory.customerdirectory.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sfm/directory/customerdirectory/formlayout';
        $this->form_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();

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
          [ 'label'=>'Phone', 'key'=>'contactPhone', 'class'=>'text-100'],
          [ 'label'=>'Mobile', 'key'=>'contactMobile', 'class'=>'text-100'],
          [ 'label'=>'Email', 'key'=>'contactEmail', 'class'=>'text-100'],
          [ 'label'=>'Default', 'key'=>'contactDefault', 'class'=>'text-100']
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
        ->setObjTemplate(view('sfm.directory.customerdirectory.contact')->render() ) // set template
        ->injectObject($uiOptions); // inject into uiOption array
        //end $picContacts

        $this->with_advanced_search = false;

        $this->extra_query = [
            'customerName'=>'',
            'services'=>'',
            'products'=>'',
            'brands'=>'',
            'picContacts'=>''
        ];

        $formOptions['customerClassOptions'] = config('app.sfm.customerClass');

        $formOptions['companyProfileUrlTemplate'] = "`<span>Company Profile</span>`";
        $formOptions['mediaUrlCatalogTemplate'] = "`<span>Catalogue</span>`";
        $formOptions['taxIdNpwpTemplate'] = "`<span>Tax ID(NPWP)</span>`";

        $this->aux_data = array_merge( $uiOptions ,$formOptions);
        $this->add_title_fields = '"<h4><img src=\"'.url('images/icons/vendor-icon.png').'\" style=\"width:42px;height:auto;margin-top:-15px;\"/> Add : Customer Directory</h4>"';
        $this->view_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\"><h4 style=\"margin-bottom: 40px;\">" + this.customerName+ "-" + this.customerCode+ "</h4></div>"',  '<img src=\"'.url('images/icons/vendor-icon.png').'\" style=\"width:42px;height:auto;\"/>' );
        $this->update_title_fields = sprintf('"<h4>%s Update Customer: "  + this.customerName+ "-" + this.customerCode+"</h4>"',  '<img src=\"'.url('images/icons/vendor-icon.png').'\" style=\"width:42px;height:auto;margin-top:-15px;\"/>' );

        $this->print_template = 'customer-print-template';
        $this->print_modal_size = 'xl';
        $this->non_closing_save = false;

        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {
//        $this->defOrderField = 'IODate';
//        $this->defOrderDir = 'desc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
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

            if( isset($ext['customerName']) && $ext['customerName'] != '' ){
                $model = $model->where('customerName','like', '%'.$ext['customerName'].'%');
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

        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
//         $data['customerSeq'] = intval($data['customerSeq']);
        return parent::beforeSave($data);
    }

    public function getParam()
    {
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

        $name = explode(' ', $data['customerName'] );

        if(count($name) > 1){
            $s1 = substr($name[0], 0, 1);
            $s2 = substr($name[1], 0, 1);
            $prefix = strtoupper($s1.$s2);
        } else {
            $s1 = substr($name[0], 0, 1);
            $s2 = $s1;
            $prefix = strtoupper($s1.$s2);
        }

        $prefix = 'C'.$prefix;



        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }

    public function postGetSeq(Request $request)
    {
        $entity = $request->get('entity');
        $customer = $request->get('customer');

        // validasi untuk mencegah 2 company dengan nama yang sama
        if( is_null($customer) && $customer != ''){

        }else{
            $rec = $this->model->where('customerName', '=', $customer)
                ->where('customerCode', 'exists' , true)
                ->whereNotNull('customerCode')
                ->where('customerCode', '!=' , '')
                ->first();
            if ($rec){
                return response()->json([
                    'result'=>'ERR',
                    'msg'=>'Customer already exist'
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
            $rec = $this->model->where('customerPrefix', '=', $entity)->max('customerSeq');
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