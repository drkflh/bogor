<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dms\Admin;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Dms\CallCode;
use App\Models\Dms\Doc;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CallCodeController extends AdminController

{
    public function __construct()
    {
        parent::__construct();


        $this->res_path = 'models/controllers/dms/admin';
        $this->yml_file = 'callcode_controller';

        $this->entity = 'Call Code';

        // this must be set to use ACL
        $this->auth_entity = 'dms-call-code';

        // set controller path
        $this->controller_base = 'dms/admin/callcode';

        // set view base to include standard slot
        $this->view_base = 'dms.admin.callcode';

        $this->model = new CallCode();
    }

    public function getIndex()
    {
        $this->title = '<img src="'.url('images/icons/yellow-file.png').'" /> Call Code';

        $cname = substr(strrchr(get_class($this), '\\'), 1);

        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;
        $this->viewer_layout = 'dms.admin.callcode.formlayout';
        $this->viewer_dialog_size = 'lg';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dms.admin.callcode.formlayout';
        $this->form_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_filler = true;


        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {
//        $this->defOrderField = 'IODate';
//        $this->defOrderDir = 'desc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {
        $this->def_param['Status'] = 'Active';
        return parent::getParam(); // TODO: Change the autogenerated stub
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
//        $data['IODate'] = ImportUtil::excelDateToNormal($data['IODate']);
//        $data['DocDate'] = ImportUtil::excelDateToNormal($data['DocDate']);
//        $data['RetDate'] = ImportUtil::excelDateToNormal($data['RetDate']);
//        $data['DispDate'] = ImportUtil::excelDateToNormal($data['DispDate']);

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


}
