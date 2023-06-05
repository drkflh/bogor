<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/**
 * @hideFromAPIDocumentation
 */
Route::get('/', function () {
    if(\Illuminate\Support\Facades\Auth::check()){
        return redirect( env('AUTH_REDIRECT_TO','login'));
    }else{
        return redirect( env('OPEN_REDIRECT_TO','/'));
    }
});

Auth::routes();
