<?php
namespace App\Models\Qontak;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Category extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'qontak_categories';
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
