<?php
namespace App\Models\Sms\SalesOperation;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class JobRegister extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'job_register';
    protected $guarded = ['id','_id'];
    // protected $hidden = ['id','_id'];


    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'datetime'=> MongoUTC::class,
        'dated' => MongoUTC::class,
        'requestDelivery' => MongoUTC::class,
        'actualDelivery' => MongoUTC::class,
        'bidOpeningDate' => MongoUTC::class,
        'bidSubmission' => MongoUTC::class,
        'prebidMeetingDate' => MongoUTC::class,
        'inquiryDate' => MongoUTC::class
    ];
}

/**,  */
