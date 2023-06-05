<?php
namespace App\Models\Workflow\Time;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class TimeReport extends Eloquent {

    protected $connection = 'mongousr';
    protected $collection = 'time_report';
    protected $guarded = ['id','_id'];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'clockInTime'=> MongoUTC::class,
        'clockOutTime'=> MongoUTC::class,
        'from'=> MongoUTC::class,
        'to'=> MongoUTC::class,
        'timerStart'=> MongoUTC::class,
        'timerStop'=> MongoUTC::class,
    ];
}
