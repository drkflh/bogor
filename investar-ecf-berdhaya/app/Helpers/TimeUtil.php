<?php


namespace App\Helpers;


use Carbon\Carbon;

class TimeUtil
{
    public static function spreadTime($objectmodel, $fieldname, $local_tz)
    {
        if(is_array($objectmodel)){
            $input = $objectmodel[$fieldname];
        }else{
            $input = $objectmodel->{$fieldname};
        }

        $display = Carbon::make($input)->shiftTimezone('UTC');
        $local = Carbon::make($input)->setTimezone($local_tz)->toDateTimeString();
        $local_utc = Carbon::make($input)->setTimezone($local_tz)->toDateTimeString();

        if(is_array($objectmodel)){
            $objectmodel[$fieldname] = $display;
            $objectmodel[$fieldname.'_local'] = [ 'datetime'=>$local, 'tz'=>$local_tz ];
            $objectmodel[$fieldname.'_utc'] = $local_utc;
        }else{
            $objectmodel->{$fieldname} = $display;
            $objectmodel->{$fieldname.'_local'} = [ 'datetime'=>$local, 'tz'=>$local_tz ];
            $objectmodel->{$fieldname.'_utc'} = $local_utc;
        }

        return $objectmodel;

    }

    public static function createTime($objectmodel, $local_tz)
    {
        $now = Carbon::now(env('DEFAULT_TIME_ZONE','UTC'));
        $local_now = Carbon::now($local_tz)->toDateTimeString();
        $local_utc = Carbon::now($local_tz)->setTimezone('UTC')->toDateTimeString();

        $objectmodel->createdAt = $now;
        $objectmodel->updatedAt = $now;
        $objectmodel->createdDate = $now;
        $objectmodel->lastUpdate = $now;
        $objectmodel->created_at = $now;
        $objectmodel->updated_at = $now;

        $objectmodel->createdAt_local = [ 'datetime'=>$local_now, 'tz'=>$local_tz ];
        $objectmodel->updatedAt_local = [ 'datetime'=>$local_now, 'tz'=>$local_tz ];
        $objectmodel->createdDate_local = [ 'datetime'=>$local_now, 'tz'=>$local_tz ];
        $objectmodel->lastUpdate_local = [ 'datetime'=>$local_now, 'tz'=>$local_tz ];
        $objectmodel->created_at_local = [ 'datetime'=>$local_now, 'tz'=>$local_tz ];
        $objectmodel->updated_at_local = [ 'datetime'=>$local_now, 'tz'=>$local_tz ];

        $objectmodel->createdAt_utc = $local_utc;
        $objectmodel->updatedAt_utc = $local_utc;
        $objectmodel->createdDate_utc = $local_utc;
        $objectmodel->lastUpdate_utc = $local_utc;
        $objectmodel->created_at_utc = $local_utc;
        $objectmodel->updated_at_utc = $local_utc;

        return $objectmodel;

    }

    public static function updateTime($objectmodel, $local_tz)
    {
        $now = Carbon::now(env('DEFAULT_TIME_ZONE','UTC'));
        $local_now = Carbon::now($local_tz)->toDateTimeString();
        $local_utc = Carbon::now($local_tz)->setTimezone('UTC')->toDateTimeString();

        $objectmodel->updatedAt = $now;
        $objectmodel->lastUpdate = $now;
        $objectmodel->updated_at = $now;

        $objectmodel->updatedAt_local = [ 'datetime'=>$local_now, 'tz'=>$local_tz ];
        $objectmodel->lastUpdate_local = [ 'datetime'=>$local_now, 'tz'=>$local_tz ];
        $objectmodel->updated_at_local = [ 'datetime'=>$local_now, 'tz'=>$local_tz ];

        $objectmodel->updatedAt_utc = $local_utc;
        $objectmodel->lastUpdate_utc = $local_utc;
        $objectmodel->updated_at_utc = $local_utc;

        return $objectmodel;

    }

    public static function qt($date, $entity, $field)
    {
        $timeconf = config('timeshift');

        if( isset($timeconf['query'][ $entity ][ $field] ) ){
            $conf = $timeconf['query'][ $entity ][ $field];
            $offset = intval($conf['offset']);

            if($offset == 0 || is_null($offset) || !isset($offset) ){
                return $date;
            }

            if($offset > 0){
                return $date->addHours( abs($offset) );
            }

            if($offset < 0){
                return $date->subHours( abs( $offset));
            }
        }

        return $date;

    }

    public static function in($date, $entity, $field)
    {
        $timeconf = config('timeshift');

        if( isset($timeconf['input'][ $entity ][ $field] ) ){
            $conf = $timeconf['input'][ $entity ][ $field];
            $offset = intval($conf['offset']);

            if($offset == 0 || is_null($offset) || !isset($offset) ){
                return $date;
            }

            if($offset > 0){
                return $date->addHours( abs($offset) );
            }

            if($offset < 0){
                return $date->subHours( abs( $offset));
            }
        }

        return $date;

    }

    public static function out($date, $entity, $field)
    {
        $timeconf = config('timeshift');

        if( isset($timeconf['output'][ $entity ][ $field] ) ){
            $conf = $timeconf['output'][ $entity ][ $field];
            $offset = intval($conf['offset']);

            if($offset == 0 || is_null($offset) || !isset($offset) ){
                return $date;
            }

            if($offset > 0){
                return $date->addHours( abs($offset) );
            }

            if($offset < 0){
                return $date->subHours( abs( $offset));
            }
        }

        return $date;

    }

    public static function formatDate($date = null, $format = null)
    {
        if(is_null($date)){
            return '';
        }else{
            $format = $format ?? env('DATE_API_FORMAT', 'd-m-Y');
            return Carbon::make($date)->format($format);
        }
    }



}
