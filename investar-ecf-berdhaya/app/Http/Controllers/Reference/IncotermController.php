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
use App\Models\Sms\Reference\Incoterm;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncotermController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/reference';
        $this->yml_file = 'incoterm_controller';

        $this->entity = 'Incoterm';

        $this->auth_entity = 'incoterm';

        $this->controller_base = 'reference/incoterm';

        $this->view_base = 'reference.incoterm';

        $this->model = new Incoterm();
    }

    public function getIndex()
    {
        $this->title = 'Incoterm';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'reference.incoterm.form_layout';
        $this->form_dialog_size = 'md';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'reference.incoterm.view_layout';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_filler = true;

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
