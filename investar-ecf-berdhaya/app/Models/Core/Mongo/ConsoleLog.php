<?php
namespace App\Models\Core\Mongo;
use App\Casts\MongoBoolean;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class ConsoleLog extends Eloquent {

    protected $connection = 'mongolog';
    protected $collection = 'console_log';
    protected $guarded = ['id','_id'];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'ts'=> MongoUTC::class,
        'checkDate'=> MongoUTC::class,
        'bdate'=> MongoUTC::class,
        'fdate'=> MongoUTC::class,
        'currentCycleStart'=> MongoUTC::class,
        'lastProcess'=> MongoUTC::class,
        'isEstrusDate'=> MongoUTC::class,
        'isInseminatedDate'=> MongoUTC::class,
        'isUSGDate'=> MongoUTC::class,
        'isPregnantDate'=> MongoUTC::class,
        'isEstrus'=> MongoBoolean::class,
        'isInseminated'=> MongoBoolean::class,
        'isUSG'=> MongoBoolean::class,
        'isPregnant'=> MongoBoolean::class,
        'isLactation'=> MongoBoolean::class,
    ];
}
