<?php
namespace App\Models\Directory;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class CustomerDirectory extends Eloquent {

    protected $connection = 'mongodir';
    protected $collection = 'customer_directory';
    protected $guarded = ['id','_id'];

    //protected $dates = ['created_at', 'updated_at', 'datetime' ];
    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'activeFrom'=>MongoUTC::class,
        'inactiveDate'=> MongoUTC::class,
    ];
}

