<?php
namespace App\Models\Obj;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Menu extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'menus';
    protected $guarded = ['id','_id'];

    protected $dates = ['created_at', 'updated_at', 'datetime' ];
    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'datetime'=> MongoUTC::class,
    ];
}

