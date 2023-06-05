<?php
namespace App\Models\Core\Mongo;

use App\Casts\MongoUTC;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Member extends Authenticatable {
    use Notifiable;
    use SoftDeletes;
    protected $connection = 'mongousr';
    protected $collection = 'members';
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
        'upTs'=>'double'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
        'createdDate',
        'lastUpdate',
    ];
}
