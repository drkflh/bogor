<?php

namespace App\Models\Core\Mongo;

use App\Casts\MongoUTC;
use App\Models\Mms\Notification;
use App\Overrides\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    //use SoftDeletes;
    protected $connection = 'mongousr';

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
        'dateOfBirth'=> MongoUTC::class,
        'email_verified_at'=> MongoUTC::class,
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'mobileString',
        'roleId',
        'roleName',
        'email_verification',
        'mobile_verification',
        'cartSession',
        'referralByCode',
        'memberReferralCode',
        'roleSlug',
        'password',
        'isComplete',
        'approvalStatus'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];

    protected $dates = [
        'deleted_at',
        //'created_at',
        // 'lastUpdate'
    ];
}
