<?php
namespace App\Models\Reflow;
use App\Casts\MongoBoolean;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class DecisionRule extends Eloquent {
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'decision_rules';
    protected $guarded = ['id','_id'];
    protected $dates = ['deleted_at','created_at', 'updated_at', 'datetime' ];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=>MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=>MongoUTC::class,
        'qontakTplLast'=>MongoUTC::class,
        'isActive'=>MongoBoolean::class
    ];
}
