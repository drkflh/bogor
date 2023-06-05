<?php

namespace App\Http\Controllers\Api\Halal;

use App\Http\Controllers\Api\Core\ApiAdminController;
use App\Models\Halal\SponsorDeposit;

class SponsorDepositController extends ApiAdminController
{

    public function __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->model = new SponsorDeposit();

        $this->res_path = 'models/db/halal'; // under resources ,ie: resources/models
        $this->yml_file = 'sponsor_deposit'; // name of yml ,ie: member.yml
        $this->entity = 'sponsordeposit';

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