<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dcs\Admin;

use App\Helpers\App\DcsUtil;
use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Dcs\Admin\Category;
use Illuminate\Http\Request;

class CategoryController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/dcs/admin';
        $this->yml_file = 'category_controller';

        $this->entity = 'Category';
        $this->view_base = 'dcs.admin.category';
        $this->auth_entity = 'dcs-category';
        $this->controller_base = 'dcs/admin/category';

        $this->clone_name_field = 'categoryName';

        $this->model = new Category();
    }

    /**
     * @hideFromAPIDocumentation
     * @return mixed
     */
    public function getIndex()
    {
        $this->title = 'DCS Category';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->template_var = [ 'hasSideNav'=>true ];


        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->import_commit_url = 'dcs/admin/category/commit';

        $this->show_title = true;

        $this->viewer_layout = 'dcs.admin.category.formlayout';

        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dcs.admin.category.formlayout';
        $this->form_dialog_size = 'lg';
        $this->viewer_dialog_size = 'lg';

        $this->can_approve = false;
        $this->can_request_approval = false;
        $this->can_revise = false;

        $this->table_grouped = true;

        return parent::getIndex();
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions['sectionObjectOptions'] = DcsUtil::toOptions(DcsUtil::getSection(), 'sectionName', '_object');
        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postIndex(Request $request)
    {
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
        $model = $model->orderBy('sectionCode','asc')
            ->orderBy('menuSeq','asc');
        return $model;
    }

    public function beforeSave($data)
    {
        return parent::beforeSave($data);
    }

    public function afterSave($data)
    {
        AuthUtil::registerAclObject($data['menuAuth'], $data['menuTitle'], 'DCS');
        return parent::afterSave($data); // TODO: Change the autogenerated stub
    }

    public function afterUpdate($id, $data = null)
    {
        AuthUtil::registerAclObject($data['menuAuth'], $data['menuTitle'], 'DCS');
        return parent::afterUpdate($id, $data); // TODO: Change the autogenerated stub
    }


    public function externalData($data, $request)
    {
        $temp = [];

        for($i = 0; $i < count($data); $i++ ){
            $label = $data[$i]['sectionObject']['sectionName'] ?? $data[$i]['sectionCode'];
            $temp[ $label ][] = $data[$i];
        }

        $out = [];
        foreach($temp as $k=>$v){
            $out[] = [
                'label'=>$k,
                'mode'=>'span',
                'children'=>$v
            ];
        }

        return $out;

    }

    protected function rowPostProcess($row)
    {
        return parent::rowPostProcess($row);
    }

    // Transform fields before commited into the database collection ( xls import )
    public function beforeImportCommit($data)
    {
        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


    public function beforeUpdate($id, $data)
    {
        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }
}
