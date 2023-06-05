<?php
namespace App\Models\Cms;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Group extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'groups';
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
