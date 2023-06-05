<?php
namespace App\Models\Dms;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Doc extends Eloquent {

    protected $connection = 'mongodms';
    protected $collection = 'documents';
    protected $guarded = ['id','_id'];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'IODate'=>MongoUTC::class,
        'DocDate'=> MongoUTC::class,
        'RetDate'=> MongoUTC::class,
        'DispPer'=> MongoUTC::class,
        'ExpDate'=> MongoUTC::class,
    ];
}
