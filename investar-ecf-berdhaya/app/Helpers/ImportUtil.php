<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 22/04/20
 * Time: 12.34
 */

namespace App\Helpers;


use Carbon\Carbon;

class ImportUtil
{

    public static function fromExcelDate($value){
        return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    }

    public static function excelDateToNormal($value){
        debug($value);

        if(is_null($value)){
            return '';
        }
        $value = intval($value);
        return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->toDateTimeString();
    }

}
