<?php
namespace App\Models\Dcs\Scoring;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoInt32;


class CollectedResult extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'dcs_collected';
    protected $guarded = ['id','_id'];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
    ];
}
