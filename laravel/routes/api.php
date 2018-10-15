<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => ['cors'],
],function (){
    Route::get('parenter','Admin\ParenterController@api');
    Route::get('news/{lang}','Admin\NewsController@api');
    Route::get('news/detail/{id}','Admin\NewsController@detail');
});