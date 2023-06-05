<?php
namespace App\Models\Core;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class ConsoleLog extends Eloquent {
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'consolelogs';
    protected $guarded = ['id','_id'];
    protected $dates = ['deleted_at','created_at', 'updated_at', 'datetime' ];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'bdate'=> MongoUTC::class,
        'fdate'=> MongoUTC::class,
        'currentCycleStart'=> MongoUTC::class,
        'lastProcess'=> MongoUTC::class,
        'isEstrusDate'=> MongoUTC::class,
        'isUSGDate'=> MongoUTC::class,
        'isPregnantDate'=> MongoUTC::class,
        'isEstrus'=> MongoBoolean::class,
        'isUSG'=> MongoBoolean::class,
        'isPregnant'=> MongoBoolean::class,
        'isLactation'=> MongoBoolean::class,
    ];
}
