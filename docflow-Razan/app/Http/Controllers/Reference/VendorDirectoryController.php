<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Reference;

use App\Helpers\App\CedarUtil;
use App\Helpers\App\LoyaltyUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Injector;
use App\Helpers\Util;
use App\Helpers\RefUtil;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Reference\Area;
use App\Models\Reference\City;
use App\Models\Reference\VendorDirectory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorDirectoryController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'views/reference/vendordirectory';
        $this->yml_file = 'fields';

        $this->entity = 'Vendor Directory';
        $this->auth_entity = 'vendor-directory';

        $this->controller_base = 'reference/vendor-directory';

        $this->view_base = 'reference.vendordirectory';
        $this->model = new VendorDirectory();
    }

    public function getIndex()
    {
        $this->title = '<img src="'.url('images/icons/yellow-file.png').'" /> Vendor Directory';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'reference.vendordirectory.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'reference/vendordirectory/formlayout';
        $this->form_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

      $uiOptions = [];
      //start $bankAccountDetails
      // use injector to provide parameter for simpletablemodaltemplate / simpletable
      $uiOptions = Injector::setObject('bankAccountDetails') // name variable / field yang akan diinject
      ->setObjFields( // mwnambahkan setting field untuk table
        [
          [ 'label'=>'Nama Pemilik Rekening', 'key'=>'ownerName', 'class'=>'text-150'],
          [ 'label'=>'Nama Bank', 'key'=>'bankName', 'class'=>'text-75'],
          [ 'label'=>'Nomor Rekening', 'key'=>'accountNumber', 'class'=>'text-150']
        ]
      )->setObjDef( // set object default
        [
          'ownerName'=>'',
          'bankName'=>'',
          'accountNumber'=>''
        ]
      )
        ->setObjTemplate(file_get_contents( resource_path('views/reference/vendordirectory/bank_account.html') )) // set template
        ->injectObject($uiOptions); // inject into uiOption array
        //end $bankAccountDetails

        $this->aux_data = array_merge( $uiOptions ,$formOptions);
        $this->view_title_fields = '"View "  + " " +this.vendorName';
        $this->update_title_fields = '"Update " +  " " +this.vendorName';

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
        /* sample query modifier */
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        return parent::beforeSave($data);
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

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


}
