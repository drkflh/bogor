<?php

namespace App\Http\Controllers\Api\Halal\Admin;

use App\Http\Controllers\Api\Core\ApiAdminController;
use App\Models\Halal\Admin\OwnerPenyeliaProfile;

class OwnerPenyeliaProfileController extends ApiAdminController
{

    public function __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->model = new OwnerPenyeliaProfile();

        $this->res_path = 'models/db/halal/admin'; // under resources ,ie: resources/models
        $this->yml_file = 'ownerpenyeliaProfile'; // name of yml ,ie: member.yml
        $this->entity = 'ownerpenyeliaprofile';

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