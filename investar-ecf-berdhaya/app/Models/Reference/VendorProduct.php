<?php
namespace App\Models\Reference;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class VendorProduct extends Eloquent {

    protected $connection = 'mongoref';
    protected $collection = 'vendor_products';
    protected $guarded = ['id','_id'];

    //protected $dates = ['created_at', 'createdDate', 'lastUpdate', 'updated_at', 'datetime', 'createdAt', 'updatedAt', 'activeFrom', 'inactiveDate'  ];
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

