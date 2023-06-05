<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dms\Admin;

use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Http\Controllers\Core\UserController;
use App\Models\Dms\Doc;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new Doc();
    }

    public function getIndex()
    {
        $this->title = 'Dashboard';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'users';
        $this->yml_file = 'fields';
        $this->res_path = 'views/dms/admin/dashboard';

        $this->template_var = [ 'hasSideNav'=>false ];

        $this->can_add = true;

        $this->data_url = 'admin/fieldreport';

        $this->table_view = env('ADMIN_DASHBOARD_VIEW', 'trips.dashboard');

        return parent::getIndex();
    }

    public function getDashboard($id = null){

//        $this->yml_file = 'fields';
//        $this->res_path = 'views/dms/admin/dashboard';

        $this->res_path = 'models/controllers/dms/admin';
        $this->yml_file = 'dashboard_controller';

        $this->nav_file = 'nav';
        $this->nav_path = 'views/partials/app/dms';
        $this->yml_layout_file = 'tracking_layout';
        $this->logo = env('APP_LOGO');

        $this->title = 'Dashboard';

        $this->show_title = false;

        $this->item_data_url = 'dms/dashboard/data';

        $this->item_id = 1;

        $this->has_tab = false;

        $this->form_mode = 'edit';

        $this->form_view = 'form.htmlpage';

        $this->form_type = 'html';

        $this->form_layout = 'dms.admin.dashboard.dashboard';

        $this->can_autosave = false;

        $this->can_lock = true;

        $this->can_add = false;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        return parent::formGenerator();
    }


    public function postIndex(Request $request)
    {
        $this->defOrderField = 'createdDate';
        $this->defOrderDir = 'desc';

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        return $model;
    }

    public function beforeSave($data)
    {
        $data['roleId'] = AuthUtil::getRoleId('Employee');
        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

}