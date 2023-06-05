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

class DeleteduserController extends UserController
{
    public function getIndex()
    {
        $this->title = 'Deleted';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'users';
        $this->yml_file = 'fields';
        $this->res_path = 'views/core/employee';

        $this->template_var = [ 'hasSideNav'=>true ];
        return AdminController::getIndex();
    }

    public function additionalQuery($model, Request $request)
    {
        $model = $model->whereNotNull('deleted_at');
        return $model;
    }

}
