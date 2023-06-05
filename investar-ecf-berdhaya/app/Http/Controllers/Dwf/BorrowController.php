<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dwf;

use App\Helpers\App\DwfUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Dwf\Doc;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BorrowController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'views/dwf/borrow';
        $this->yml_file = 'fields';

        $this->entity = 'Document';

        $this->model = new Doc();
    }

    public function getIndex()
    {
        $this->title = '<img src="'.url('images/icons/yellow-file.png').'" /> Document Borrow';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'assets';

        /* YML for custom form layout */
        //$this->yml_layout_file = 'layout';

        /* YML for custom page navigation */
        //$this->nav_file = 'nav';
        //$this->nav_path = 'views/clinic/patient';

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->data_url = 'dwf/borrow';

        $this->add_url = 'dwf/borrow/add';

        $this->update_url = 'dwf/borrow/edit';

        $this->item_data_url = 'dwf/borrow/data';

        $this->param_url = 'dwf/borrow/param';

        $this->del_url = 'dwf/borrow/del';

        $this->clone_url = 'dwf/borrow/clone';

        $this->download_url = 'dwf/borrow/dlxl';

        $this->can_add = true;

        $this->can_upload = true;

        $this->can_download_xls = true;

        $this->can_download_csv = true;

        $this->import_commit_url = 'dwf/borrow/commit';

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'form.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dwf.borrow.formlayout';
        $this->form_dialog_size = 'xl';

        $this->table_slot_view = 'dwf.borrow.table_slot';
        $this->table_head_slot_view = 'dwf.borrow.table_head_slot';
        $this->table_action_view = 'dwf.borrow.table_action';
        $this->table_additional_view = 'dwf.borrow.table_additional';
        $this->table_modal_view = 'dwf.borrow.table_modal';

        $this->table_methods_view = 'dwf.borrow.table_methods';
        $this->table_computed_view = 'dwf.borrow.table_computed';
        $this->table_watch_view = 'dwf.borrow.table_watch';


        $this->add_methods_view = 'dwf.borrow.add_methods';
        $this->add_computed_view = 'dwf.borrow.add_computed';
        $this->add_watch_view = 'dwf.borrow.add_watch';

        $this->edit_methods_view = 'dwf.borrow.edit_methods';
        $this->edit_computed_view = 'dwf.borrow.edit_computed';
        $this->edit_watch_view = 'dwf.borrow.edit_watch';


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['TipeOptions'] = DwfUtil::toOptions( DwfUtil::getDocType(), 'DocType', 'DocType', false );
        $formOptions['CoyOptions'] = DwfUtil::toOptions( DwfUtil::getCompany(), 'CoyName', 'CoyCode', false );
        $formOptions['RetPerOptions'] = DwfUtil::toOptions( DwfUtil::getYearOptions(), 'Desc', 'DisYr', false );
        $formOptions['DispPerOptions'] = DwfUtil::toOptions( DwfUtil::getYearOptions(), 'Desc', 'DisYr', false );

        $formOptions['TopicObjectOptions'] = DwfUtil::toOptions( DwfUtil::getTopics(), 'Topic', '_object', false );

        $formOptions['selectedSheets'] = 0;
        $formOptions['boxIdInput'] = "``";



        $formOptions['labelTemplate'] = '`'.file_get_contents( resource_path('views/dwf/borrow/labeltemplate.html') ).'`';
        $formOptions['printTemplate'] = '`'.file_get_contents( resource_path('views/dwf/borrow/printtemplate.html') ).'`';
        $formOptions['printLabelData'] = "``";

        $this->aux_data = $formOptions;

        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {
        $this->defOrderField = 'IODate';
        $this->defOrderDir = 'desc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {
        $today = date('Y-m-d H:i:s', time());

        return response()->json(
            [
                'IO'=>'Incoming',
                'Status'=>'Active',
                'RetPer'=>2,
                'DispPer'=>5,
                'IODate'=>$today
            ]

        );

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
        $data['IODate'] = ImportUtil::excelDateToNormal($data['IODate']);
        $data['DocDate'] = ImportUtil::excelDateToNormal($data['DocDate']);
        $data['RetDate'] = ImportUtil::excelDateToNormal($data['RetDate']);
        $data['DispDate'] = ImportUtil::excelDateToNormal($data['DispDate']);

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


}