<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\User;

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

// Test
Route::get('/invoice/{request_id}', 'ProviderResources\TripController@invoice');

// Authentication
Route::post('/v2/register', 'ProviderAuth\TokenController@signup');
// Route::post('/register', 'ProviderAuth\TokenController@register');
Route::post('/oauth/token', 'ProviderAuth\TokenController@authenticate');
Route::post('/v2/oauth/token', 'ProviderAuth\TokenController@authenticatev2');
Route::post('/logout', 'ProviderAuth\TokenController@logout');
Route::post('/verify', 'ProviderAuth\TokenController@verify');

Route::post('/auth/facebook', 'ProviderAuth\TokenController@facebookViaAPI');
Route::post('/auth/google', 'ProviderAuth\TokenController@googleViaAPI');

Route::post('/forgot/password', 'ProviderAuth\TokenController@forgot_password');
Route::post('/reset/password', 'ProviderAuth\TokenController@reset_password');

Route::get('/location/{provider_id}', 'ProviderResources\TripController@current_location')->name('provider.location');
//delete vehicle
Route::post('/delete-vehicle', 'UserApiController@deleteVehicle');

Route::post('/refresh/token', 'ProviderAuth\TokenController@refresh_token');

Route::post('/sendOTP', 'TwilioController@sendOTP');
// Route::post('/resendOTP', 'TwilioController@resendOTP');
Route::post('/verifyOTP', 'TwilioController@verifyOTP');

Route::group(['middleware' => ['provider.api', 'provider.language']], function () {

    Route::get('locale', function() {
        return dd(App::getLocale());
    });

    Route::get('/get-user', function() {
        return User::get()->first();
    });

    Route::get('/block', 'BlockUserController@index');
    Route::get('/block/{user_id}', 'BlockUserController@toggleBlock');

    //Refresh FCM Token
    Route::post('/refresh/fcm-token', 'UserApiController@refreshProviderFCMToken');

    //Paymob Api
    Route::post('/paymob-payment', 'PaymobController@paymentKeyRequest');

    //Mlajan Api
    Route::post('/mlajan-payment', 'MlajanController@payNow');

    //Pre payment capture
    Route::post('/capture-payment', 'ProviderResources\TripController@capture_payment');

    //Negotiation Apis
    Route::post('/send-offer', 'ProviderResources\TripController@send_offer');
    Route::post('/skip-request', 'ProviderResources\TripController@skip_request');


    Route::get('/get-notifications', 'UserApiController@getDriverNotifications');
    Route::post('/delete-notifications/{id?}', 'UserApiController@deleteDriverNotifications');

    // faqs
    Route::get('/faqs', 'UserApiController@getDriverFaqs');

    //get services & documents
    Route::get('/services-documents', 'UserApiController@getServicesDocuments');
    //create vehicle
    Route::post('/create-vehicle', 'UserApiController@createVehicle');
    //get vehicles
    Route::get('/get-vehicles', 'UserApiController@getVehicles');
    //select vehicle
    Route::post('/select-vehicle', 'UserApiController@selectVehicle');
    //delete vehicle
    Route::post('/delete-vehicle', 'UserApiController@deleteVehicle');

    //Akara Payment
    Route::post('/payment/akara', 'AkaraController@payNow');

    //MTN payment
    Route::post('/payment/mtn', 'MTNController@payNow');

    Route::post('/share-wallet', 'UserApiController@share_wallet_provider');

    //get subscriptions
    Route::get('/subscriptions', 'UserApiController@getSubscriptions');

    //set subscription
    Route::post('/subscription', 'UserApiController@setSubscription');
    //cancel subscription
    Route::post('/cancel-subscription', 'UserApiController@cancelSubscription');

    // card payment
    Route::resource('card', 'ProviderResources\CardResource');
    Route::post('/card/set-default', 'ProviderResources\CardResource@set_default_card');
    Route::post('/add/money', 'PaymentController@add_money_provider');
    Route::post('/donate', 'PaymentController@donate_money_provider');

    Route::post('/update/request-payment', 'UserApiController@request_payment');

    Route::group(['prefix' => 'profile'], function () {

        Route::get('/', 'ProviderResources\ProfileController@index');
        Route::post('/', 'ProviderResources\ProfileController@update');
        Route::post('/password', 'ProviderResources\ProfileController@password');
        Route::post('/location', 'ProviderResources\ProfileController@location');
        Route::post('/available', 'ProviderResources\ProfileController@available');

    });

    Route::get('/target', 'ProviderResources\ProfileController@target');
    Route::get('/target2', 'ProviderResources\ProfileController@target7');

    Route::resource('trip', 'ProviderResources\TripController');
    Route::post('cancel', 'ProviderResources\TripController@cancel');
    Route::post('nextpro', 'ProviderResources\TripController@nextpro');
    Route::post('summary', 'ProviderResources\TripController@summary');
    Route::get('help', 'ProviderResources\TripController@help_details');

    //Delete Provider
    Route::post('/delete', 'UserApiController@deleteProvider')->name('deleteProvider');

    Route::group(['prefix' => 'trip'], function () {
        Route::post('{id}', 'ProviderResources\TripController@accept');
        Route::post('{id}/rate', 'ProviderResources\TripController@rate');
        Route::post('{id}/message', 'ProviderResources\TripController@message');
        Route::post('{id}/calculate', 'ProviderResources\TripController@calculate_distance');

    });

    Route::group(['prefix' => 'requests'], function () {

        Route::get('/upcoming', 'ProviderResources\TripController@scheduled');
        Route::get('/history', 'ProviderResources\TripController@history');
        Route::get('/history/details', 'ProviderResources\TripController@history_details');
        Route::get('/upcoming/details', 'ProviderResources\TripController@upcoming_details');

    });

});