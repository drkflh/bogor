<?php
namespace App\Models\Core\Mongo;
use App\Casts\MongoUTC;
use danielme85\LaravelLogToDB\Models\LogToDbCreateObject;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class LaravelLog extends Eloquent {
    use LogToDbCreateObject;

    protected $connection = 'mongodb';
    protected $collection = 'laravel_log';
    protected $guarded = ['id','_id'];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'startDate'=>MongoUTC::class,
        'endDate'=> MongoUTC::class,
        'upTs'=>'double'
    ];
}

