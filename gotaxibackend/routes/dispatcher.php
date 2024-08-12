<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'DispatcherProtectOTP'], function(){
    Route::get('/otp', 'DispatcherController@opt')->name('otp');
    Route::post('/verify-otp', 'DispatcherController@verifyOpt')->name('verify-otp');
});

Route::group(['middleware' => 'DispatcherVerifiedOTP'], function(){
    Route::get('/', 'DispatcherController@dispatcher_index')->name('index');
Route::get('booking-requests', 'DispatcherController@booking_requests')->name('booking-requests');
Route::get('map/ajax', 'DispatcherController@map_ajax')->name('map.ajax');

Route::group(['as' => 'dispatcher.', 'prefix' => 'dispatcher'], function () {
    Route::get('/', 'DispatcherController@dispatcher_index')->name('index');
    Route::post('/', 'DispatcherController@store')->name('store');
    Route::get('/trips', 'DispatcherController@trips')->name('trips');
    Route::get('/{id}/update-schedule', 'DispatcherController@editSchedule')->name('edit-schedule');
    Route::put('/{user_request}/update-schedule', 'DispatcherController@updateSchedule')->name('update-schedule');
    Route::get('/cancel', 'DispatcherController@cancel')->name('cancel');
    Route::get('/trips/{trip}/{provider}', 'DispatcherController@assign')->name('assign');
    Route::get('/users', 'DispatcherController@users')->name('users');
    Route::get('/providers', 'DispatcherController@providers')->name('providers');
});

Route::get('/trips/{trip}/{provider}', 'DispatcherController@assign')->name('assign');
Route::resource('service', 'Resource\ServiceResource');

Route::get('password', 'DispatcherController@password')->name('password');
Route::post('password', 'DispatcherController@password_update')->name('password.update');

Route::get('profile', 'DispatcherController@profile')->name('profile');
Route::post('profile', 'DispatcherController@profile_update')->name('profile.update');

Route::post('/fetch-user', 'UserApiController@fetchUser')->name('dispatcher.fetchUser');
});

