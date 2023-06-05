<?php
namespace App\Models\Pmc;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class TimeReportLog extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'log_time_report';
    protected $guarded = ['id','_id'];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'approvedAt'=> MongoUTC::class,
    ];
}
