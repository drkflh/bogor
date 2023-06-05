<?php
namespace App\Casts;


use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use MongoDB\BSON\UTCDateTime;

class MongoUTC implements CastsAttributes
{
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * MongoUTC constructor.
     * @param string $dateFormat
     */
    public function __construct(string $dateFormat = 'Y-m-d H:i:s')
    {
        $this->dateFormat = $dateFormat;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        //debug('Mongo get UTC');
        //debug($value);
        try {
            if(is_string($value)  || is_null($value)){
                //debug('Is String');
                $value = $value ?? '';
                if($value != ''){
                    $value = Carbon::parse($value)->format($this->dateFormat);
                }
                return $value;
            }else{
                if ($value instanceof \DateTime) {
                    $dt = $value->toDateTime();
                    $dt->setTimeZone( new \DateTimeZone( date_default_timezone_get() ) );
                    return $dt->format($this->dateFormat);
                }
                if ($value instanceof UTCDateTime) {
                    $dt = $value->toDateTime();
                    //$dt->setTimeZone( new \DateTimeZone( date_default_timezone_get() ) );
                    return $dt->format($this->dateFormat);
                }
            }
        }catch (\Exception $exception){
            //debug($exception->getMessage());
            return '';
        }
    }

    public function set($model, string $key, $value, array $attributes)
    {
        //debug('Mongo set UTC');
        //debug( date_default_timezone_get());
        //debug($value);

        $timezone = date_default_timezone_get();

        try {

            if(is_string($value) ){
                $tms = Carbon::parse($value, $timezone);
                $tms->shiftTimezone('UTC');
                $tms = $tms->getPreciseTimestamp(3);
                return new \MongoDB\BSON\UTCDateTime($tms);
            }
            if ($value instanceof \DateTime) {
                $tz = $value->getTimezone()->getName();
                //debug('is DateTime');
                //debug($tz);
                if($tz != 'UTC'){
                    $value->shiftTimezone('UTC');
                }
                $tms = $value->getPreciseTimestamp(3);
                return new \MongoDB\BSON\UTCDateTime($tms);
            }

            if ($value instanceof UTCDateTime) {
                $tms = $value->toDateTime();
                $tz = $tms->getTimezone()->getName();
                //debug('is UTC DT');
                //debug($tz);
                if($tz != '+00:00'){
                    $tms->shiftTimezone('UTC');
                    $tms = $tms->getPreciseTimestamp(3);
                    return new \MongoDB\BSON\UTCDateTime($tms);
                }else{
                    return $value;
                }
            }

        }catch (\Exception $exception){
            //debug($exception->getMessage());
            return '';
        }

    }

}
