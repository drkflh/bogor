<?php
namespace App\Models\Mms;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Notification extends Eloquent {
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'notifications';
    protected $guarded = ['id','_id'];
    protected $dates = ['deleted_at','created_at', 'updated_at', 'datetime' ];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'read_at'=> MongoUTC::class,
    ];
}
