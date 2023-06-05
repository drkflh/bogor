<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Reference;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Reference\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CountryController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/reference';
        $this->yml_file = 'country_controller';

        $this->entity = 'Country';

        $this->model = new Country();
    }

    public function getIndex()
    {
        $this->title = 'Country';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        //$this->nav_section = 'assets';

        /* YML for custom form layout */
        //$this->yml_layout_file = 'layout';

        /* YML for custom page navigation */
        //$this->nav_file = 'nav';
        //$this->nav_path = 'views/clinic/patient';

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->data_url = 'reference/country';

        $this->add_url = 'reference/country/add';

        $this->update_url = 'reference/country/edit';

        $this->item_data_url = 'reference/country/data';

        $this->param_url = 'reference/country/param';

        $this->del_url = 'reference/country/del';

        $this->clone_url = 'reference/country/clone';

        $this->download_url = 'reference/country/dlxl';

        $this->can_add = false;

        $this->can_delete = false;

        $this->can_upload = true;

        $this->can_download_xls = true;

        $this->can_download_csv = true;

        $this->import_commit_url = 'reference/country/commit';

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'reference.country.formlayout';

        /* Use custom form layout
        *  default to form.flatgrid
        *  change form_view & view_layout
        */
        // use custom form
        //$this->form_view = 'form.custom';
        // or use html template for mote detailed control without having to fiddle with YML
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'reference.country.formlayout';
        $this->form_dialog_size = '';

        $this->table_slot_view = 'reference.country.table_slot';
        $this->table_head_slot_view = 'reference.country.table_head_slot';
        $this->table_action_view = 'reference.country.table_action';
        $this->table_additional_view = 'reference.country.table_additional';
        $this->table_modal_view = 'reference.country.table_modal';

        $this->table_methods_view = 'reference.country.table_methods';
        $this->table_computed_view = 'reference.country.table_computed';
        $this->table_watch_view = 'reference.country.table_watch';


        $this->add_methods_view = 'reference.country.add_methods';
        $this->add_computed_view = 'reference.country.add_computed';
        $this->add_watch_view = 'reference.country.add_watch';

        $this->edit_methods_view = 'reference.country.edit_methods';
        $this->edit_computed_view = 'reference.country.edit_computed';
        $this->edit_watch_view = 'reference.country.edit_watch';

        $this->table_grouped = false;

        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {
        //$this->defOrderField = 'IODate';
        //$this->defOrderDir = 'desc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {

        return parent::getParam(); // TODO: Change the autogenerated stub
    }


    public function additionalQuery($model, Request $request)
    {

        /* sample query modifier */
//        $model = $model->orderBy('provinceCode', 'asc' );
        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
//        $data['version'] = config('dbversions.zipcodes');
        return parent::beforeSave($data);
    }


    protected function rowPostProcess($row)
    {
        /* modify or add new fields */
        //$row['linkConsult'] = url('clinic/patient/km/'.$row['_id']);
        //$row['linkOp'] = url('clinic/patient/op/'.$row['_id']);

        return parent::rowPostProcess($row);
    }

    // Transform fields before commited into the database collection ( xls import )
    public function beforeImportCommit($data)
    {
        //example : transform imported data to datetime field
        // $data['IODate'] = ImportUtil::excelDateToNormal($data['IODate']);
        // $data['DocDate'] = ImportUtil::excelDateToNormal($data['DocDate']);
        // $data['RetDate'] = ImportUtil::excelDateToNormal($data['RetDate']);
        // $data['DispDate'] = ImportUtil::excelDateToNormal($data['DispDate']);
//        $data['version'] = config('dbversions.zipcodes');
        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


    public function beforeUpdate($id, $data)
    {
//        $data['version'] = config('dbversions.zipcodes');
        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }
}
