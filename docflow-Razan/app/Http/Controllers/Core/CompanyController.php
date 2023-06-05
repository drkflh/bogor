<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Core;

use App\Helpers\AuthUtil;
use Illuminate\Http\Request;

class CompanyController extends UserController
{
    public function getIndex()
    {
        $this->title = 'Company Member';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'users';
        $this->yml_file = 'fields';
        $this->res_path = 'views/core/company';

        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'core.company.formlayout';
        // setUp grid
        $this->grid = [
            ['col'=>[4, 4, 4]],
        ];

        $this->template_var = [ 'hasSideNav'=>true ];
        return AdminController::getIndex();
    }

    public function additionalQuery($model, Request $request)
    {
        $model = $model->where('roleId','=', AuthUtil::getRoleId('Company') );
        return $model;
    }

    public function beforeSave($data)
    {
        $data['roleId'] = AuthUtil::getRoleId('Company');
        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

}
