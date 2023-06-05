<?php

namespace App\Http\Controllers\Api\Sfm;

use App\Http\Controllers\Api\Core\ApiAdminController;
use App\Models\Sfm\Invoice;

class InvoiceController extends ApiAdminController
{

    public function __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->model = new Invoice();

        $this->res_path = 'models/sfm'; // under resources ,ie: resources/models
        $this->yml_file = 'invoice'; // name of yml ,ie: member.yml
        $this->entity = 'invoice';

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