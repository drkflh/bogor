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
use App\Models\Dms\CoyCode;
use App\Models\Dms\Doc;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoyCodeController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

//        $this->res_path = 'views/dms/admin/coycode';
//        $this->yml_file = 'fields';

        $this->res_path = 'models/controllers/dms/admin';
        $this->yml_file = 'coycode_controller';

        $this->entity = 'Company Code';

        $this->model = new CoyCode();
    }

    public function getIndex()
    {
        $this->title = '<img src="'.url('images/icons/yellow-file.png').'" /> Company Code';

        $cname = substr(strrchr(get_class($this), '\\'), 1);

        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'assets';

        /* YML for custom form layout */
        //$this->yml_layout_file = 'layout';

        /* YML for custom page navigation */
        //$this->nav_file = 'nav';
        //$this->nav_path = 'views/clinic/patient';

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->data_url = 'dms/admin/coycode';

        $this->add_url = 'dms/admin/coycode/add';

        $this->update_url = 'dms/admin/coycode/edit';

        $this->item_data_url = 'dms/admin/coycode/data';

        $this->param_url = 'dms/admin/coycode/param';

        $this->del_url = 'dms/admin/coycode/del';

        $this->clone_url = 'dms/admin/coycode/clone';

        $this->download_url = 'dms/admin/coycode/dlxl';

        $this->can_add = true;

        $this->can_upload = true;

        $this->can_download_xls = true;

        $this->can_download_csv = true;

        $this->import_commit_url = 'dms/admin/coycode/commit';

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'dms.admin.coycode.formlayout';
        $this->viewer_dialog_size = 'md';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dms.admin.coycode.formlayout';
        $this->form_dialog_size = 'md';

        $this->table_slot_view = 'dms.admin.coycode.table_slot';
        $this->table_head_slot_view = 'dms.admin.coycode.table_head_slot';
        $this->table_action_view = 'dms.admin.coycode.table_action';
        $this->table_modal_view = 'dms.admin.coycode.table_modal';

        $this->table_methods_view = 'dms.admin.coycode.table_methods';
        $this->table_computed_view = 'dms.admin.coycode.table_computed';
        $this->table_watch_view = 'dms.admin.coycode.table_watch';


        $this->add_methods_view = 'dms.admin.coycode.add_methods';
        $this->add_computed_view = 'dms.admin.coycode.add_computed';
        $this->add_watch_view = 'dms.admin.coycode.add_watch';

        $this->edit_methods_view = 'dms.admin.coycode.edit_methods';
        $this->edit_computed_view = 'dms.admin.coycode.edit_computed';
        $this->edit_watch_view = 'dms.admin.coycode.edit_watch';


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['labelTemplate'] = '`'.file_get_contents( resource_path('views/dms/admin/coycode/labeltemplate.html') ).'`';
        $formOptions['printTemplate'] = '`'.file_get_contents( resource_path('views/dms/admin/coycode/printtemplate.html') ).'`';
        $formOptions['printLabelData'] = "``";

        $this->aux_data = $formOptions;


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
