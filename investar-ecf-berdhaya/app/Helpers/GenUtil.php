<?php


namespace App\Helpers;


class GenUtil
{
    public static function compileForm($yml, $currentForm = ''){
        $elements = [];
        foreach( $yml['form'] as $el){
            if($el['name'] != '_id' ){
                if(strpos($currentForm, $el['name']) === false){
                    $elements[] = sprintf( "{!! $%s ?? '' !!}", $el['name'] );
                }
            }
        }

        $elString = implode("\r\n", $elements);
        return $currentForm."\r\n".$elString;
    }

    public static function compileViewForm($yml, $currentForm = ''){
        $elements = [];
        foreach( $yml['view'] as $el){
            if($el['name'] != '_id' ){
                if(strpos($currentForm, $el['name']) === false){
                    $elements[] = sprintf( "{!! $%s ?? '' !!}", $el['name'] );
                }
            }
        }

        $elString = implode("\r\n", $elements);
        return $currentForm."\r\n".$elString;
    }
}
