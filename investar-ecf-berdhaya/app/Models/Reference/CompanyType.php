<?php
namespace App\Models\Reference;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class CompanyType extends Eloquent {

    protected $connection = 'mongoref';
    protected $collection = 'company_types';
    protected $guarded = ['id','_id'];

    protected $dates = ['created_at', 'updated_at', 'datetime' ];
    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
    ];
}

