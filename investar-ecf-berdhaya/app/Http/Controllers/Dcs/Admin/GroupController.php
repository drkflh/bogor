<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dcs\Admin;

use App\Helpers\App\DcsUtil;
use App\Helpers\CmsUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Dcs\Admin\Group;
use Illuminate\Http\Request;

class GroupController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/dcs/admin';
        $this->yml_file = 'group_controller';

        $this->entity = 'Group';
        $this->view_base = 'dcs.admin.group';
        $this->auth_entity = 'cms-group';
        $this->controller_base = 'dcs/admin/group';

        $this->model = new Group();
    }

    /**
     * @hideFromAPIDocumentation
     * @return mixed
     */
    public function getIndex()
    {
        $this->title = 'DCS Group';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->template_var = [ 'hasSideNav'=>true ];


        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->import_commit_url = 'dcs/admin/group/commit';

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'dcs.admin.group.formlayout';

        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dcs.admin.group.formlayout';
        $this->form_dialog_size = 'md';
        $this->viewer_dialog_size = 'md';

        $this->can_approve = false;
        $this->can_request_approval = false;
        $this->can_revise = false;

        $this->add_title_fields = '"<h4> Tambah Group</h4>"';
        $this->view_title_fields = '"Lihat"  + " " + this.groupName';
        $this->update_title_fields = '"Update" +  " " + this.groupName';

        return parent::getIndex();
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions['sectionCodeOptions'] = DcsUtil::toOptions(DcsUtil::getSection(), 'sectionName', 'sectionCode');
        $formOptions['categoryCodeOptions'] = DcsUtil::toOptions(DcsUtil::getCategory(), 'categoryName', 'categoryCode');
        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }


    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        $data['version'] = config('dbversions.product_categories');
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
        $data['version'] = config('dbversions.product_categories');
        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


    public function beforeUpdate($id, $data)
    {
        $data['version'] = config('dbversions.product_categories');
        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }
}
