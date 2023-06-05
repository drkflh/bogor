<?php
/**
 * Created by VSCode.
 * User: mfaiza
 * Date: 16/03/21
 * Time: 12.30
 */

namespace App\Http\Controllers\Reference;

use App\Helpers\App\DmsUtil;
use App\Helpers\Injector;
use App\Helpers\App\SalesopUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Reference\CompanyType;
use App\Models\Reference\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyTypeController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'views/reference/companytype';

        $this->yml_file = 'fields';

        $this->entity = 'Company Type';

        $this->auth_entity = 'company-type';

        $this->controller_base = 'sms/reference/company-type';

        $this->view_base = 'reference.companytype';

        $this->model = new CompanyType();

        $this->defOrderField = 'seq';
        $this->defOrderDir = 'asc';

    }

    public function getIndex()
    {
        $this->title = 'Company Type';

        $cname = substr(strrchr(get_class($this), '\\'), 1);

        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'reference.companytype.formlayout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'reference/companytype/formlayout';
        $this->form_dialog_size = 'md';
        $this->viewer_dialog_size = 'md';



        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $uiOptions = [];


        $this->aux_data = array_merge( $uiOptions ,$formOptions);
        $this->add_title_fields = '"Add Company Type"';
        $this->view_title_fields = 'this.companyType';
        $this->update_title_fields = '"Update " + this.companyType';

        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        return $model;
    }

    public function beforeSave($data)
    {

        return parent::beforeSave($data);
    }

    public function getParam()
    {

        return parent::getParam(); // TODO: Change the autogenerated stub
    }


    protected function rowPostProcess($row)
    {


        return parent::rowPostProcess($row);
    }

    public function beforeImportCommit($data)
    {


        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


}
