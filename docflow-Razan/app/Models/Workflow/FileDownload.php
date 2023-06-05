<?php
namespace App\Models\Workflow;
use App\Casts\MongoBoolean;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class FileDownload extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'filedownloads';
    protected $guarded = ['id','_id'];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'isActive'=>MongoBoolean::class,
    ];
}
