<?php
namespace App\Models\Directory\Knowledge;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class DocCatalogue extends Eloquent {

    protected $connection = 'mongodir';
    protected $collection = 'doc_catalogue';
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
        'DocDate'=> MongoUTC::class,
    ];
}

