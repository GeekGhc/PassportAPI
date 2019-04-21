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
//自定义passport oauth/token 登录令牌
Route::post('authorizations','AuthController@store');
//自定义passport oauth/token 刷新令牌
Route::put('authorizations/current','AuthController@store');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signip');

    //需认证api
    Route::group(['middleware'=>'auth:api'],function(){
        Route::get('logout','AuthController@logout');
        Route::get('user','AuthController@user');
    });
});

Route::group(['namespace'=>'Api'],function(){
    Route::get('/test','IndexController@index');

    // 用户资源
    Route::get('/user','UserController@user');
    Route::get('/users','UserController@users');
});