<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Obj;

use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Obj\FormTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormTemplateController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'views/obj/formtemplate';
        $this->yml_file = 'fields';

        $this->entity = 'Form Template';

        $this->model = new FormTemplate();
    }

    public function getIndex()
    {
        $this->title = 'Form Template';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'assets';


        /* YML for custom form layout */
        //$this->yml_layout_file = 'layout';

        /* YML for custom page navigation */
        //$this->nav_file = 'nav';
        //$this->nav_path = 'views/clinic/patient';

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->data_url = 'obj/form-template';

        $this->add_url = 'obj/form-template/add';

        $this->update_url = 'obj/form-template/edit';

        $this->del_url = 'obj/form-template/del';

        $this->item_data_url = 'obj/form-template/data';

        $this->param_url = 'obj/form-template/param';

        $this->download_url = 'obj/form-template/dlxl';

        $this->del_url = 'obj/form-template/del';

        $this->clone_url = 'obj/form-template/clone';

        $this->can_add = true;

        $this->can_upload = true;

        $this->can_download_xls = true;

        $this->can_download_csv = true;

        $this->can_multi_select = true;

        $this->import_preview_cols = [
            'key',
            'name',
            'formContent'
        ];

        $this->import_preview_heads = [
            'Key',
            'Name',
            'Content'
        ];

        $this->import_commit_url = 'obj/form-template/commit';

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'obj.formtemplate.viewlayout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'obj.formtemplate.formlayout';
        $this->form_dialog_size = 'fs';

        $this->table_slot_view = 'obj.formtemplate.table_slot';
        $this->table_head_slot_view = 'obj.formtemplate.table_head_slot';
        $this->table_action_view = 'obj.formtemplate.table_action';
        $this->table_additional_view = 'obj.formtemplate.table_additional';
        $this->table_modal_view = 'obj.formtemplate.table_modal';

        $this->table_methods_view = 'obj.formtemplate.table_methods';
        $this->table_computed_view = 'obj.formtemplate.table_computed';
        $this->table_watch_view = 'obj.formtemplate.table_watch';


        $this->add_methods_view = 'obj.formtemplate.add_methods';
        $this->add_computed_view = 'obj.formtemplate.add_computed';
        $this->add_watch_view = 'obj.formtemplate.add_watch';

        $this->edit_methods_view = 'obj.formtemplate.edit_methods';
        $this->edit_computed_view = 'obj.formtemplate.edit_computed';
        $this->edit_watch_view = 'obj.formtemplate.edit_watch';


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        return parent::getIndex();
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
        return parent::rowPostProcess($row);
    }

    public function beforeUpdateForm($population)
    {

        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }


    public function beforeUpdate($id, $data)
    {

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

}
