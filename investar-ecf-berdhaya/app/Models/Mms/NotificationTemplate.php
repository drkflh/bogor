<?php
namespace App\Models\Mms;
use App\Casts\MongoBoolean;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class NotificationTemplate extends Eloquent {
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'notificationtemplates';
    protected $guarded = ['id','_id'];
    protected $dates = ['deleted_at','created_at', 'updated_at', 'datetime' ];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=>MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=>MongoUTC::class,
        'qontakTplLast'=>MongoUTC::class,
        'isActive'=>MongoBoolean::class
    ];
}
