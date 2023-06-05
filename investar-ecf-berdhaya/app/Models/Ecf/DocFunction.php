<?php
namespace App\Models\Ecf;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class DocFunction extends Eloquent {

    protected $connection = 'mongodms';
    protected $collection = 'dwf_doc_function';
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
    ];
}
