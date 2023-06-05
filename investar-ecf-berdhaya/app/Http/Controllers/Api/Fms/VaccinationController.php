<?php

namespace App\Http\Controllers\Api\Fms;

use App\Http\Controllers\Api\Core\ApiAdminController;
use App\Models\Fms\Vaccination;

class VaccinationController extends ApiAdminController
{

    public function __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->model = new Vaccination();

        $this->res_path = 'models'; // under resources ,ie: resources/models
        $this->yml_file = 'fms_vaccination'; // name of yml ,ie: member.yml
        $this->entity = 'vaccination';

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
