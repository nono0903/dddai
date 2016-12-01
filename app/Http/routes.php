<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Indexcontroller@index');

Route::get('home',function(){
	return "走错门了";
});
/**
 * 注册路由
 */
Route::get('auth/reg','Auth\AuthController@getRegister');
Route::post('auth/reg',['middleware'=>'App\Http\Middleware\EmailMiddleware','uses'=>'Auth\AuthController@postRegister']);
/**
 * 登录登出路由
 */
Route::get('auth/login','Auth\AuthController@getLogin');
Route::post('auth/login','Auth\AuthController@postLogin');
Route::get('auth/logout','Auth\AuthController@getLogout');
/**
 * 借款
 */
Route::get('jie','ProjectController@jie');
Route::post('jie','ProjectController@jiepost');
Route::get('pro/{pid}','ProjectController@pro');
Route::post('pro/{pid}','ProjectController@postpro');

Route::get('prolist','CheckController@prolist');

Route::get('shenhe/{id}','checkController@shenhe');
Route::post('shenhe/{id}','checkController@postshenhe');


Route::get('run','GrowController@run');

Route::get('myzd','ProjectController@myzd');

Route::get('mytz','ProjectController@mytz');

Route::get('mysy','ProjectController@mysy');

Route::get('mydk','ProjectController@mydk');

//测试路游
//


Route::post('pay','ProjectController@pay');

Route::post('payback','ProjectController@payback');
Event::listen('illuminate.query',function($query){
 
var_dump($query);
 
});