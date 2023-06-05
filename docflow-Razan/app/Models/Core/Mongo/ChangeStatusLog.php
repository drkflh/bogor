<?php
namespace App\Models\Core\Mongo;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class ChangeStatusLog extends Eloquent {

    protected $connection = 'mongolog';
    protected $collection = 'change_status_log';
    protected $guarded = ['id','_id'];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'changeDate'=>MongoUTC::class,
        'upTs'=>'double'
    ];
}

