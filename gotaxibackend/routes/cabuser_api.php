<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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

//getUserByPhone
// Route::get('getuserbyphone', 'CabUser\UserApiController@getUserByPhone');
//isStaffIdExist
// Route::get('isstaffidexist', 'CabUser\UserApiController@isStaffIdExist');
Route::get('getconstdata', 'CabUser\UserApiController@getconstdata');
//deletefav
Route::post('deletefav', 'CabUser\UserApiController@deletefav');
//sendpushtouser
Route::post('sendpushtouser', 'CabUser\UserApiController@sendpushtouser');
Route::get('getchat/{booking_id}', 'CabUser\UserApiController@getchat');
// Route::get('checkservicelist/{service_id}/{provider_id}', 'CabUser\UserApiController@checkservicelist');
Route::post('staffloginbyphone', 'CabUser\UserApiController@staffloginbyphone');
Route::post('/addtaximeterride', 'CabUser\UserApiController@addtaximeterride');
Route::post('addchat', 'CabUser\UserApiController@addchat'); 
Route::post('paymentdone', 'CabUser\UserApiController@paymentdone');
Route::get('/getservices/{type}', 'CabUser\UserApiController@getservices');
