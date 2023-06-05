<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Api\Core\ApiAdminController;
use App\Models\Central\Project\Client;

class ClientController extends ApiAdminController
{

    public function __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->model = new Client();

        $this->res_path = 'models'; // under resources ,ie: resources/models
        $this->yml_file = 'client'; // name of yml ,ie: member.yml
        $this->entity = 'client';

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
