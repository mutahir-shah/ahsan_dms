<?php
use Illuminate\Support\Facades\Route;
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

Route::get('getallservices', 'CabUser\ProviderApiController@getAllservices');
Route::post('driverloginbyphone', 'CabUser\ProviderApiController@driverloginbyphone');
Route::post('addtaximeterride', 'CabUser\ProviderApiController@addtaximeterride');
Route::post('startorder', 'CabUser\ProviderApiController@startorder');
Route::get('getconstdata', 'CabUser\ProviderApiController@getconstdata');
Route::post('deleteservice', 'CabUser\ProviderApiController@deleteservice');
Route::get('getcity', 'CabUser\ProviderApiController@getcity');
Route::post('addchat', 'CabUser\ProviderApiController@addchat'); 
Route::get('getchat/{booking_id}', 'CabUser\ProviderApiController@getchat');
Route::post('addwithdraw', 'CabUser\ProviderApiController@addwithdraw');
Route::post('updateservice', 'CabUser\ProviderApiController@updateservice');
Route::get('getbankaccount/{id}', 'CabUser\ProviderApiController@getbankaccount');
Route::post('/addbankaccount', 'CabUser\ProviderApiController@addbankaccount');
Route::get('getservices/{type}', 'CabUser\ProviderApiController@getservices');
Route::post('adddriverwallet', 'CabUser\ProviderApiController@adddriverwallet');
Route::post('uploaddoc', 'CabUser\ProviderApiController@uploaddoc');

Route::group(['middleware' => ['provider.api']], function () {
    Route::get('getalldocs', 'CabUser\ProviderApiController@getAllDocuments');
    Route::get('fetchdocs', 'CabUser\ProviderApiController@fetchDocuments');
});