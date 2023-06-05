<?php

namespace App\Http\Controllers\Api\Sfm\Product;

use App\Http\Controllers\Api\Core\ApiAdminController;
use App\Models\Sfm\Product\Cogs;

class CogsController extends ApiAdminController
{

    public function __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->model = new Cogs();

        $this->res_path = 'models/sfm/product'; // under resources ,ie: resources/models
        $this->yml_file = 'cogs'; // name of yml ,ie: member.yml
        $this->entity = 'cogs';

    }

    public function beforeOutput($data)
    {
        //$data['addOut'] = "ADD BEFORE OUTPUT";
        return parent::beforeOutput($data); // TODO: Change the autogenerated stub
    }


    public function beforeSave($data)
    {
        //$data['beforeSave'] = 'BEFORE';
        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function afterSave($data)
    {
        //$data['afterSave'] = 'AFTER';
        return parent::afterSave($data); // TODO: Change the autogenerated stub
    }


}