<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 14/12/19
 * Time: 00.24
 */
function sa($str){
    $current = \Illuminate\Support\Facades\Route::currentRouteAction();
    if(strpos($str, $current ) > 0){
        return 'active';
    }else{
        return '';
    }
}
