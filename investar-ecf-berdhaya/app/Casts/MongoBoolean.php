<?php
namespace App\Casts;


use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use MongoDB\BSON\UTCDateTime;

class MongoBoolean implements CastsAttributes
{
    /**
     * MongoBoolean constructor.
     */
    public function __construct()
    {

    }

    public function get($model, string $key, $value, array $attributes)
    {
        try {

            if(strtolower($value) == 'y' || strtolower($value) == 'yes' || $value == 1 || $value == true){
                return true;
            }else{
                return false;
            }

        }catch (\Exception $exception){
            //debug($exception->getMessage());
            return false;
        }
    }

    public function set($model, string $key, $value, array $attributes)
    {
        //debug('Mongo set UTC');
        //debug( date_default_timezone_get());
        //debug($value);

        $timezone = date_default_timezone_get();

        try {

            if(strtolower($value) == 'y' || strtolower($value) == 'yes' || $value == 1 || $value == true){
                return true;
            }else{
                return false;
            }

        }catch (\Exception $exception){
            //debug($exception->getMessage());
            return false;
        }

    }

}
