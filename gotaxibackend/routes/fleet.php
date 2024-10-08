<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Fleet Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'FleetProtectOTP'], function(){
    Route::get('/otp', 'FleetController@opt')->name('otp');
    Route::post('/verify-otp', 'FleetController@verifyOpt')->name('verify-otp');
});
Route::group(['middleware' => 'FleetVerifiedOTP'], function(){
    Route::get('/', 'FleetController@dashboard')->name('index');
Route::get('/dashboard', 'FleetController@dashboard')->name('dashboard');

Route::resource('provider', 'Resource\ProviderFleetResource');

Route::group(['as' => 'provider.'], function () {
    Route::get('review/provider', 'FleetController@provider_review')->name('review');
    Route::get('provider/{vehicle_id}/approve-vehicle', 'Resource\ProviderFleetResource@approveVehicle')->name('approveVehicle');
    Route::get('provider/{vehicle_id}/disapprove-vehicle', 'Resource\ProviderFleetResource@disapproveVehicle')->name('disapproveVehicle');
    Route::get('provider/{id}/approve', 'Resource\ProviderFleetResource@approve')->name('approve');
    Route::get('provider/{id}/disapprove', 'Resource\ProviderFleetResource@disapprove')->name('disapprove');
    Route::get('provider/{vehicle_id}/approve-vehicle', 'Resource\ProviderFleetDocumentResource@approveVehicle')->name('approveVehicle');
    Route::get('provider/{vehicle_id}/disapprove-vehicle', 'Resource\ProviderFleetDocumentResource@disapproveVehicle')->name('disapproveVehicle');
    Route::get('provider/{vehicle_id}/{provider_id}/select-vehicle', 'Resource\ProviderFleetDocumentResource@selectVehicle')->name('selectVehicle');
    Route::get('provider/{id}/request', 'Resource\ProviderFleetResource@request')->name('request');
    Route::resource('provider/{provider}/document', 'Resource\ProviderFleetDocumentResource');
    Route::delete('provider/{provider}/service/{document}', 'Resource\ProviderFleetDocumentResource@service_destroy')->name('document.service');
});

Route::get('user/{id}/request', 'Resource\UserResource@request')->name('user.request');

Route::get('map', 'FleetController@map_index')->name('map.index');
Route::get('map/ajax', 'FleetController@map_ajax')->name('map.ajax');

Route::get('profile', 'FleetController@profile')->name('profile');
Route::post('profile', 'FleetController@profile_update')->name('profile.update');

Route::get('password', 'FleetController@password')->name('password');
Route::post('password', 'FleetController@password_update')->name('password.update');

// Static Pages - Post updates to pages.update when adding new static pages.

Route::get('requests', 'Resource\TripResource@Fleetindex')->name('requests.index');
Route::delete('requests/{id}', 'Resource\TripResource@Fleetdestroy')->name('requests.destroy');
Route::get('requests/{id}', 'Resource\TripResource@Fleetshow')->name('requests.show');
Route::get('scheduled', 'Resource\TripResource@Fleetscheduled')->name('requests.scheduled');

});

