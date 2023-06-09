<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dwf\Admin;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Dwf\Admin\ArchiveGroup;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveGroupController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/dwf/admin';

        $this->yml_file = 'archivegroup_controller';

        $this->entity = 'Archive Group';

        $this->auth_entity = 'archive-group';

        $this->controller_base = 'dwf/admin/archive-group';

        $this->view_base = 'dwf.admin.archivegroup';

        $this->model = new ArchiveGroup();
    }

    public function getIndex()
    {
        $this->title = 'Archive Group';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dwf.admin.archivegroup.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'dwf.admin.archivegroup.view_layout';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        $this->add_title_fields = '"<h4> Add Archive Group</h4>"';
        $this->view_title_fields = '"Lihat"  + " " + this.namaLansia';
        $this->update_title_fields = '"Update" +  " " + this.namaLansia';

        return parent::getIndex();
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {

        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }


    public function getParam()
    {

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    public function postIndex(Request $request)
    {

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {

        return parent::rowPostProcess($row);
    }

}
