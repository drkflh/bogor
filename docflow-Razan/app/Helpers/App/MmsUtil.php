<?php

namespace App\Helpers\App;

class MmsUtil
{
    public static function sendNotification($users, $notificationType, $data, $req){
        foreach($users as $user){
            $user->notify( new $notificationType($data, $req));
        }
    }

}
