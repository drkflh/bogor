<?php

namespace App\Http\Controllers\Api\Mms;

use App\Http\Controllers\Api\Core\ApiAdminController;
use App\Models\Mms\NotificationChannel;

class NotificationChannelController extends ApiAdminController
{

    public function __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->model = new NotificationChannel();

        $this->res_path = 'models'; // under resources ,ie: resources/models
        $this->yml_file = 'notification_channel'; // name of yml ,ie: member.yml
        $this->entity = 'notificationchannel';

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
