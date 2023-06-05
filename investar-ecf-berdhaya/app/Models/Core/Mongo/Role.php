<?php
namespace App\Models\Core\Mongo;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Role extends Eloquent {

    protected $connection = 'mongousr';
    protected $collection = 'roles';
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
