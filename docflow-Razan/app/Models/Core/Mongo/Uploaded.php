<?php
namespace App\Models\Core\Mongo;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Uploaded extends Eloquent {

    protected $connection = 'mongolog';
    protected $collection = 'uploaded_files';
    protected $guarded = ['id','_id'];
    protected $fillable = ['dump'];

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
