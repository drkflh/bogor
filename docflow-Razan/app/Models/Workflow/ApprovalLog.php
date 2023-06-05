<?php
namespace App\Models\Workflow;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class ApprovalLog extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'approval_log';
    protected $guarded = ['id','_id'];

    // protected $dates = ['created_at', 'updated_at', 'datetime', 'createdAt', 'updatedAt', 'activeFrom', 'inactiveDate', 'createdDate', 'lastUpdate'];
    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class
    ];
}

