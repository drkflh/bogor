<?php
namespace App\Models\Dcs\Scoring;
use App\Casts\MongoUTC;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;



class Question extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'dcs_questions';
    protected $guarded = ['id','_id'];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'score1'=>'double',
        'score2'=>'double',
        'score3'=>'double',
        'score4'=>'double',
        'score5'=>'double',
        'defaultScore'=>'double',
    ];
}
