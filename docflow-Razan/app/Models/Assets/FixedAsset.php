<?php
namespace App\Models\Assets;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class FixedAsset extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'fixedassets';
    protected $guarded = ['id','_id'];

    protected $dates = ['created_at', 'updated_at', 'datetime' ];
    protected $casts = [
        //'lat'=>'double',
        //'lon'=>'double',
    ];
}

