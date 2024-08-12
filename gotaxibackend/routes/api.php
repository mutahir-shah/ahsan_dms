<?php

use App\BlockUserProvider;
use App\Country;
use App\Http\Controllers\SendPushNotification;
use App\Settings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

use App\ServiceType;
use App\Helpers\Helper;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\TwilioController;
use App\Http\Controllers\SOAPController;
use App\Http\Controllers\FavoriteProviderController;
use App\Http\Controllers\GeoFencingController;
use App\Provider;
use App\ProviderService;
use App\PushNotificationLog;
use App\UserRequests;
use App\Zones;
use App\Http\Controllers\ServiceTypeController;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

// Route::get('/test-url', function() {
//     $url = url('/');
//     if(!str_contains($url, 'paxiapp.us')) {
//         echo $url;
//     }
// }); 

// Route::get('/test-seconds', function() {

//     $userRequest = UserRequests::find(140);

//     $start_time = Carbon::parse($userRequest->started_at);
//     $end_time = Carbon::parse($userRequest->finished_at);
//     $seconds = $end_time->diffInSeconds($start_time);
//     $minutes = $seconds / 60;
//     $hours = $minutes / 60;

//     return $hours;
// });

Route::get('test-distance/{request_id}', function($request_id) {

    $serviceTypeController = new ServiceTypeController();
    $calculatedDistance = $serviceTypeController->calculateDistance($request_id);
    $meter = $calculatedDistance['totalDistance'];
    $seconds = $calculatedDistance['totalDuration'];
    $kilometer = Helper::applyDistanceSystem($meter);
    $distance_system = Setting::get('distance_system', 'metric');
    $distance_system_calculation = Setting::get('distance_system_calculation', 'local');

    $responseData['distance_system_calculation'] = $distance_system_calculation;
    $responseData['meter'] = $meter;
    $responseData['seconds'] = $seconds;
    $responseData['distance_system'] = $distance_system;
    $responseData['kilometer'] = $kilometer;

    return response()->json($responseData);
});

Route::get('test-polyline/{request_id}', function($request_id) {
    $serviceTypeController = new ServiceTypeController();
    $polylinePoints = $serviceTypeController->getUserRequestPolylinePoints($request_id);
    
    $polylineData = Helper::getPolylineGoogleForRequest($polylinePoints['origin'], $polylinePoints['destination'], $polylinePoints['waypoints']);
    $route_key = $polylineData['points'];

    return response()->json($route_key);
});

// Route::get('test-distance-local/{request_id}', function($request_id) {

//     $serviceTypeController = new ServiceTypeController();
//     $coordinates = $serviceTypeController->getUserRequestTrackingCoordinates($request_id);

//     // Initialize variables
//     $totalDistance = 0;
//     $totalDuration = 0;

//     // Iterate over coordinates to calculate distance and duration
//     for ($i = 0; $i < count($coordinates) - 1; $i++) {
//         $origin = $coordinates[$i]["latitude"] . "," . $coordinates[$i]["longitude"];
//         $destination = $coordinates[$i + 1]["latitude"] . "," . $coordinates[$i + 1]["longitude"];
        
//         // Make API request to get distance and duration
//         // Here you would use your own implementation to make HTTP requests to the Google Maps Distance Matrix API
        
//         // For simplicity, I'm using Haversine formula to calculate distance between coordinates
//         $distance = Helper::calculateDistanceAndDurationLocal($coordinates[$i]["latitude"], $coordinates[$i]["longitude"], $coordinates[$i + 1]["latitude"], $coordinates[$i + 1]["longitude"]);
        
//         // Example: You would parse API response to get duration
//         $duration = 3600; // Example duration in seconds
        
//         // Accumulate total distance and duration
//         $totalDistance += $distance;
//         $totalDuration += $duration;
//     }

//     echo "Total distance: " . $totalDistance . " km<br>";
//     echo "Total duration: " . $totalDuration . " seconds";
// });

// Route::get('test-distance-google/{request_id}', function($request_id) {

//     $serviceTypeController = new ServiceTypeController();
//     $coordinates = $serviceTypeController->getUserRequestTrackingCoordinates($request_id);

//     // Initialize variables
//     $totalDistance = 0;
//     $totalDuration = 0;

//     // Iterate over coordinates to calculate distance and duration
//     for ($i = 0; $i < count($coordinates) - 1; $i++) {
//         $origin = $coordinates[$i]["latitude"] . "," . $coordinates[$i]["longitude"];
//         $destination = $coordinates[$i + 1]["latitude"] . "," . $coordinates[$i + 1]["longitude"];
        
//         // Make API request to get distance and duration
//         $result = Helper::calculateDistanceAndDurationGoogle($origin, $destination);
        
//         if ($result) {
//             $distance = $result['distance'] / 1000; // Convert distance to kilometers
//             $duration = $result['duration'];
            
//             // Accumulate total distance and duration
//             $totalDistance += $distance;
//             $totalDuration += $duration;
//         } else {
//             echo "Error occurred while fetching distance and duration.";
//             break; // Exit loop if API request fails
//         }
//     }

//     echo "Total distance: " . $totalDistance . " km<br>";
//     echo "Total duration: " . $totalDuration . " seconds";
// });


// Route::get('/test-wallet', function() {

//     $provider = Provider::find(3484);

//     if($provider->wallet < 0) {
//         $provider->wallet -= 10; 
//     } else {
//         $provider->wallet -= 10;
//     }

//     // $provider->save();

//     return $provider->wallet;
// });


// Route::get('/get-providers-in-radius/{latitude}/{longitude}', function($latitude, $longitude) {

//     // $latitude = '33.5241994';
//     // $longitude = '73.1503911';
//     $service_type_id = 2;
//     $vweight = 10;
//     $userGenderPref = 'male';
//     $userGender = 'male';
//     $zone_id = 0;

//     if (Setting::get('zone_module', "0") == "1") {
//         $geoFencingController = new GeoFencingController();
//         $currentZone = $geoFencingController->getZone($latitude, $longitude);
//         $zone_id = $currentZone != null ? $currentZone->id : 0;
//     }

//     //New
//     // $userGenderPref = Auth::user()->gender_pref;
//     $distance = Setting::get('provider_search_radius', '10');
//     $code_base_job_req = Setting::get('code_base_job_req', 0);
//     $vehicle_weightage = Setting::get('vehicle_weightage', 0);
//     $gender_pref_enabled = Setting::get('gender_pref_enabled', 0);
//     $zone_restrict_module = Setting::get('zone_restrict_module', 0);
//     $block_user = Setting::get('block_user', 0);
//     $block_driver = Setting::get('block_driver', 0);
//     $favourite_driver = Setting::get('favourite_driver', 0);
//     $providerFavouriteIds = [];
//     $userBlockedProviderIds = [];
//     $providerBlockedUserIds = [];

//     $providers = Provider::with('service')
//                     ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"), 'id', 'providers.*')
//                     ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
//                     ->where('status', 'approved')
//                     ->whereHas('service', function ($q) use ($service_type_id, $vehicle_weightage, $vweight) {
//                         $q->where('status', 'active');
//                         $q->where('is_selected', 1);
//                         $q->where('service_type_id', $service_type_id);
//                         //Handled case of vehicle_weightage
//                         $q->when(($vehicle_weightage == 1 && ($vweight != null || $vweight != "")), function ($q) use ($vweight) {
//                             $q->where('service_weight_allowed_kg', '>=', $vweight);
//                         });
//                     })
//                     //Handled case of gender_pref_enabled && preference: male
//                     ->when(($gender_pref_enabled == 1 && $userGenderPref == 'male' && $userGender != null), function ($q) use ($userGender) {
//                         $q->where('gender', 'male');
//                         $q->where(function ($query) use ($userGender) {
//                             $query->where('gender_pref', $userGender)
//                                 ->orWhere('gender_pref', 'both');
//                         });
//                     })
//                     //Handled case of gender_pref_enabled && preference: female
//                     ->when(($gender_pref_enabled == 1 && $userGenderPref == 'female' && $userGender != null), function ($q) use ($userGender) {
//                         $q->where('gender', 'female');
//                         $q->where(function ($query) use ($userGender) {
//                             $query->where('gender_pref', $userGender)
//                                 ->orWhere('gender_pref', 'both');
//                         });
//                     })
//                     //Handled case of zone_restrict_module
//                     ->when(($zone_restrict_module == 1 && ($zone_id != 0)), function ($q) use ($zone_id) {
//                         $q->where('zone_id', $zone_id);
//                     })
//                     //Handled case of block_user
//                     ->when(($block_user == 1 && (count($userBlockedProviderIds) > 0)), function ($q) use ($userBlockedProviderIds) {
//                         $q->whereNotIn('id', $userBlockedProviderIds);
//                     })
//                     //Handled case of favourite_driver
//                     ->when(($favourite_driver == 1 && $is_favourite_driver == 1 && (count($providerFavouriteIds) > 0)), function ($q) use ($providerFavouriteIds) {
//                         $q->whereIn('id', $providerFavouriteIds);
//                     })
//                     ->orderBy('distance')
//                     ->get();

//                 if ($code_base_job_req == 1 && $providers->count() == 0) {
//                     $providerServiceRiding = ProviderService::where('provider_id', $request->driver_job_code)->where('service_type_id', $service_type)->where('status', 'riding')->count();
//                     $providerServiceOffline = ProviderService::where('provider_id', $request->driver_job_code)->where('service_type_id', $service_type)->where('status', 'offline')->count();
//                     if ($providerServiceRiding > 0) {
//                         $message = 'Driver is on another ride!';
//                     } else if ($providerServiceOffline > 0) {
//                         $message = 'Driver is offline!';
//                     } else {
//                         $message = 'Driver not available!';
//                     }
//                     return response()->json(['message' => $message]);
//                 }

//     return $providers;
// });


// Route::get('/test-kilometers', function() {

//     $service_type = ServiceType::find(2);

//     return Helper::kilometer_tiers(3.86, $service_type);
// });

// Route::get('/test-distance', function() {

//     $s_latitude = 33.5241994;
//     $s_longitude = 73.1503911;
//     $d_latitude = 33.5557505;
//     $d_longitude = 73.0946375;

//     $response = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
    
//     return dd($response);
// });

// Route::get('/test', function() {

//     $logs = PushNotificationLog::where('receiver_id', 1)->where('app_type', 'Driver')->orderBy('id', 'DESC')->distinct()->get(['id', 'title', 'message', 'created_at']);
    
//     dd($logs);
//     //round function check
//     // return Helper::customRoundtoMultiple(72.26);

//     //request with rider & driver models
//     // $UserRequests = UserRequests::with([
//     //     'userReportImages',
//     //     'driverReportImages'
//     // ])->get();
//     // return response()->json($UserRequests);


//     //block/unblock function check
//     // $userBlockedProviderIds = BlockUserProvider::where('user_id', 785)->where('blocked_by', 'USER')->pluck('provider_id')->toArray();

//     // //Sample providers
//     // $providers = Provider::skip(0)->take(10)->get();

//     // foreach ($providers as $key => $provider) {

//     //     if(in_array($provider->id, $userBlockedProviderIds)) {
//     //         continue;
//     //     }

//     //     // if(Setting::get('block_driver', 0) == 1) {
//     //         $providerBlockedUserCount = BlockUserProvider::where('user_id', 785)->where('provider_id', $provider->id)->where('blocked_by', 'PROVIDER')->count();
//     //         if($providerBlockedUserCount > 0) {
//     //             // dd($providerBlockedUserCount);
//     //             continue;
//     //         }
//     //     // }

//     //     //test
//     //     echo 'Count:' . $providerBlockedUserCount;
//     // }

//     // return response()->json($userBlockedProviderIds);

//     $userRequest = UserRequests::get()->first();

//     $cancellationTimeout = Setting::get('cancellation_time', 5);
//     $arrivedDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $userRequest->arrived_at);
//     $dateNow = Carbon::now();
//     $userRequest->cancellation_enabled = $dateNow->diffInMinutes($arrivedDateTime) >= $cancellationTimeout ? true : false;
//     $minutes = $dateNow->diffInMinutes($arrivedDateTime);
//     $seconds = ($dateNow->diffInSeconds($arrivedDateTime) % 60);
//     $userRequest->job_arrived_duration = CarbonInterval::minutes($minutes)->seconds($seconds)->forHumans();

//     // dd($userRequest->schedule_at->toDateTimeString());
//     $schedule_at = $userRequest->schedule_at != null ? $userRequest->schedule_at->toDateTimeString() : null;
//     dd($schedule_at);
//     return response()->json($userRequest);

// });

// Route::get('/get-countries-json', function() {
//     $countries = Country::with('states')->get();
    
//     return response()->json($countries);
// });


// Route::get('test-soap', 'SOAPController@test');

// Route::get('/time', function() {
//     $timeArray = [];

//     $rider_trial_period = Setting::get('rider_trial_period' , 0);
//     $trial_end_time_rider = 0;
//     if($rider_trial_period > 0) {
//         $trial_end_time_rider = Carbon::now()->addDays($rider_trial_period);
//     }

//     $driver_trial_period = Setting::get('driver_trial_period' , 0);
//     $trial_end_time_driver = 0;
//     if($driver_trial_period > 0) {
//         $trial_end_time_driver = Carbon::now()->addDays($driver_trial_period);
//     }
    
//     $timeArray['rider_trial_period'] =  $rider_trial_period;
//     $timeArray['trial_end_time_rider'] =  $trial_end_time_rider;
//     $timeArray['driver_trial_period'] =  $driver_trial_period;
//     $timeArray['trial_end_time_driver'] =  $trial_end_time_driver;
//     $timeArray['date_time'] =  Carbon::now()->toDateTimeString();
//     $timeArray['day'] = Carbon::now()->format('l');
//     $timeArray['time'] =  Carbon::now()->format('H:i:s');

//     return response()->json($timeArray, 200);
// });

//For Zoning development
// Route::get('fetch-countries', 'CountryController@fetchCountries');
// Route::get('fetch-states', 'CountryController@fetchStates');
// Route::get('fetch-states-detail', 'CountryController@fetchStatesDetail');
// Route::get('fetch-cities', 'CountryController@fetchCities');
// Route::get('remove-cities-duplicates', 'CountryController@removeDuplicateCities');


Route::get('test', function(){
    return 'Api WOrking Fine';
});

//For zoning implemetation
Route::get('get-countries', 'CountryController@getCountries')->name('api.countries');
Route::get('get-states/{country_id?}', 'CountryController@getStates')->name('api.states');
Route::get('get-cities/{state_id?}', 'CountryController@getCities')->name('api.cities');

Route::get('get-zone-inbound/{lat?}/{long?}/{zones?}', 'GeoFencingController@getZoneInbound');
Route::get('get-zone/{lat?}/{long?}', 'GeoFencingController@getZone');

//For switching demo-mode for admin panel
Route::post('/demo-mode', function(Request $request) {
    if($request->access_key != "ERmq9En3Un844AHfWFJhYgahkaPm3KVb") {
        return response()->json(['error' => 'You are not authorised to change application mode!'], 403);
    }

    $demo_mode = $request->demo_mode;
    Settings::where('key', 'demo_mode')->update(['value' => $demo_mode]);
    
    return response()->json(['success' => 'Application mode changed successfully!'], 200);
});

Route::post('/push-test', function(Request $request) {
    $fcm_token = $request->fcm_token;
    $payload = $request->payload;
    $type = $request->type;
    $device_type = $request->device_type;

    if($type == 'Rider') {
        $pushNotificationObject = new SendPushNotification;
        $pushNotificationObject->sendToUser($fcm_token, null, $device_type, null, $payload);
    } else if($type == 'Driver') {
        $pushNotificationObject = new SendPushNotification;
        $pushNotificationObject->sendToProvider($fcm_token, null, $device_type, null, $payload);
    }

    return response()->json(['success' => 'Push sent successfully!'], 200);
});

Route::get('/test-sms/{number?}/{message?}', function(Request $request, $number = null, $message = null) {

    if(!$number) $number = '+923335806128';
    if(!$message) $message = 'This is a test message!';

    $sendSMS = new TwilioController;
    $responseData = $sendSMS->sendTestSMS($number, $message);

    return response()->json(['success' => 'SMS sent successfully!', 'data' => $responseData], 200);
});

Route::get('/json-zone-parsing', function(Request $request) {

    // Taxidrive Spain
    // $fileNames = ['1-Badalona', '2-Badia del Valles', '3-Barbera del Valles', '4-Barcelona', '5-Begues', '6-Castellbisbal', '7-Castelldefels', '8-Cerdanyola del Valles', '9-Cervello', '10-Corbera de Llobregat', '11-Cornella de Llobregat', '12- El Papiol', '13 - El Prat de Llobregat', '14 - Esplugues de Llobregat', '15 - Gavà', '16-LHospitalet de Llobregat', '17 - La Palma de Cervelló', '18-Molins de Rei', '19-Montcada i Reixac', '20-Montgat', '21-Palleja', '22-Ripollet', '23-Sant Adria de Besos', '24-Sant Andreu de la Barca', '25-Sant Boi de Llobregat', '26-Sant Climent de Llobregat', '27-Sant Cugat del Valles', '28-Sant Feliu de Llobregat', '29-Sant Joan Despi', '30-Sant Just Desvern', '31-Sant Vicenc dels Horts', '32-Santa Coloma de Cervello', '34-Tiana', '35-Torrelles de Llobregat', '36 - Viladecans'];
    // Gooji
    // $fileNames = ['Virginia', 'DC', 'Merlin'];
    // Droadz
    $fileNames = ['Kashmir', 'Balochistan', 'Islamabad', 'KPK', 'Punjab', 'Sindh'];

    foreach($fileNames as $fileName) {
        try{
            $jsonString = file_get_contents('zones/' . $fileName . '.json');
            $jsonArray = json_decode($jsonString, true);
    
            //$jsonArray['geometries'][0]['coordinates'][0][0]; //For single polygon in region
            $coordinatesArrays = $jsonArray['geometries'][0]['coordinates'];
            // $coordinatesArrays = $jsonArray['coordinates'];
            foreach($coordinatesArrays as $index => $coordinateArray) {
                $zoneArray = [];
                // $coordinatesCount = count($coordinates);
                foreach($coordinateArray[0] as $coordinate) {
                    $coordinateString = $coordinate[1] . ', ' . $coordinate[0];
                    array_push($zoneArray, $coordinateString); 
                }
        
                $serializedZoneString = serialize($zoneArray);
        
                $zone = Zones::firstOrCreate([
                    'name' => $fileName,
                    'country' => 'Pakistan', 
                    'state' => 'Federal', 
                    'city' => 'Islamabad', 
                    'status' => 'active', 
                    'currency' => 'PKR', 
                    'coordinate' => $serializedZoneString
                ]);
            }
            
        } catch(\Exception $e) {
            dd($fileName);
            return dd($e->getMessage());
        }
    }

    return response()->json(['success' => 'Zone synced successfully!'], 200);
});


Route::get('/json-zone-preview', function(Request $request) {

    $zone = Zones::where('id', '=', 9)->get(['coordinate'])->first();

    $zonePreview = unserialize($zone->coordinate);

    return response()->json(['success' => 'Zone preview successfully!', 'data' => $zonePreview], 200);
});

Route::get('/test-invoice/{request_id}', 'ProviderResources\TripController@invoice');

Route::get('/createToken', 'Resource\CardResource@createToken');

Route::post('/sendOTP', 'TwilioController@sendOTP');
// Route::post('/resendOTP', 'TwilioController@resendOTP');
Route::post('/verifyOTP', 'TwilioController@verifyOTP');

// Route::post('/signup', 'UserApiController@signup');
Route::post('/v2/signup', 'UserApiController@register');
Route::post('/logout', 'UserApiController@logout');
Route::post('/verify', 'UserApiController@verify');

Route::post('/oauth/token', 'UserApiController@authenticate');
Route::post('/refresh/token', 'UserApiController@refreshToken');

Route::post('/auth/facebook', 'Auth\SocialLoginController@facebookViaAPI');
Route::post('/auth/google', 'Auth\SocialLoginController@googleViaAPI');
Route::post('/forgot/password', 'UserApiController@forgot_password');
Route::post('/reset/password', 'UserApiController@reset_password');


Route::group(['middleware' => ['auth:api', 'user.language']], function () {

    Route::get('/get-provider', function() {
        return Provider::get()->first();
    });

    Route::get('getalldocs', 'CabUser\UserApiController@getAllDocuments');
    Route::get('fetchdocs', 'CabUser\UserApiController@fetchDocuments');
    Route::post('uploaddoc', 'CabUser\UserApiController@uploaddoc');

    //get subscriptions
    Route::get('/subscriptions', 'UserApiController@getSubscriptionsForUser');
    //set subscription
    Route::post('/subscription', 'UserApiController@setSubscriptionForUser');
    //cancel subscription
    Route::post('/cancel-subscription', 'UserApiController@cancelSubscriptionForUser');

    Route::get('/favorite', 'FavoriteProviderController@index');
    // Route::post('/favorite/{provider_id}', 'FavoriteProviderController@toggleFavorite');
    Route::get('/favorite/{provider_id}', 'FavoriteProviderController@toggleFavorite');

    Route::get('/block', 'BlockProviderController@index');
    // Route::post('/block/{provider_id}', 'BlockProviderController@toggleBlock');
    Route::get('/block/{provider_id}', 'BlockProviderController@toggleBlock');

    Route::get('locale', function() {
        return dd(App::getLocale());
    });

    //Refresh FCM Token
    Route::post('/refresh/fcm-token', 'UserApiController@refreshUserFCMToken');

    //Paymob Api
    Route::post('/paymob-payment', 'PaymobController@paymentKeyRequest');

    //Mlajan Api
    Route::post('/mlajan-payment', 'MlajanController@payNow');

    //Negotiation Apis
    Route::post('/accept-offer', 'UserApiController@accept_offer');
    Route::post('/decline-offer', 'UserApiController@decline_offer');

    Route::get('/get-notifications', 'UserApiController@getUserNotifications');
    Route::post('/delete-notifications/{id?}', 'UserApiController@deleteUserNotifications');

    // user profile
    Route::post('/change/password', 'UserApiController@change_password');
    Route::post('/update/location', 'UserApiController@update_location');
    Route::get('/details', 'UserApiController@details');
    Route::post('/update/profile', 'UserApiController@update_profile');
    Route::post('/share-wallet', 'UserApiController@share_wallet');
    Route::post('/redeem-points', 'UserApiController@redeem_points');

    // faqs
    Route::get('/faqs', 'UserApiController@getUserFaqs');

    // services
    Route::get('/services', 'UserApiController@services'); //TODO: disable old api
    Route::get('/servicesWithEstimate', 'UserApiController@servicesWithEstimate');

    // provider
    Route::post('/rate/provider', 'UserApiController@rate_provider');

    // bank
    Route::get('/bank/get', 'UserApiController@getBank');
    Route::post('/bank/add', 'UserApiController@addBank');

    // request
    Route::post('/send/request', 'UserApiController@send_request');
    Route::post('/update-offer', 'UserApiController@update_offer');
    Route::post('/cancel/request', 'UserApiController@cancel_request');
    Route::get('/request/check', 'UserApiController@request_status_check');
    Route::get('/show/providers', 'UserApiController@show_providers');
    Route::post('/update/request', 'UserApiController@modifiy_request');

    // history
    Route::get('/trips', 'UserApiController@trips');
    Route::get('upcoming/trips', 'UserApiController@upcoming_trips');
    Route::get('/trip/details', 'UserApiController@trip_details');
    Route::get('upcoming/trip/details', 'UserApiController@upcoming_trip_details');
    // payment
    Route::post('/payment', 'PaymentController@payment');
    Route::post('/add/money', 'PaymentController@add_money');
    Route::post('/donate', 'PaymentController@donate_money_user');

    Route::post('/tip-charge', 'PaymentController@tip_charge');
    Route::post('/add/money_new', 'PaymentController@add_money_new');
    // estimated
    Route::get('/estimated/fare', 'UserApiController@estimated_fare');
    // help
    Route::get('/help', 'UserApiController@help_details');
    // promocode
    Route::get('/promocodes', 'UserApiController@promocodes');
    Route::post('/promocode/add', 'UserApiController@add_promocode');
    // card payment
    Route::resource('card', 'Resource\CardResource');
    Route::post('/card/set-default', 'Resource\CardResource@set_default_card');
    // card payment
    Route::resource('location', 'Resource\FavouriteLocationResource');
    // passbook
    Route::get('/wallet/passbook', 'UserApiController@wallet_passbook');
    Route::get('/promo/passbook', 'UserApiController@promo_passbook');

    //MTN payment
    Route::post('/payment/mtn', 'MTNController@payNow');
    //For MTN Development
    // Route::post('/payment/apiUserCollection', 'MTNController@apiUserCollection');
    // Route::post('/payment/apiUserCollectionReference', 'MTNController@apiUserCollectionReference');
    // Route::post('/payment/apiUserCollectionReferenceKey', 'MTNController@apiUserCollectionReferenceKey');
    // Route::post('/payment/token', 'MTNController@token');
    // Route::post('/payment/requestToPay', 'MTNController@requestToPay');
    // Route::get('/payment/requestToPayState', 'MTNController@requestToPayState');

    //Akara Payment
    Route::post('/payment/akara', 'AkaraController@payNow');
    //For Akara Development
    Route::post('/payment/token', 'AkaraController@token');
    Route::post('/payment/requestToPay', 'AkaraController@requestToPay');

    //Delete User
    Route::post('/delete', 'UserApiController@deleteUser')->name('deleteUser');
});



// Artisan Commands
Route::get('/serve', function () {
    $exitCode = Artisan::call('serve');
    return '<h1>served</h1>';
});
//Clear Cache facade value:
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

//Migration
Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return '<h1>Migration Done</h1>';
});

//Seed
Route::get('/seed', function () {
    $exitCode = Artisan::call('db:seed');
    return '<h1>Seeding Done</h1>';
});

//Syslink
Route::get('/syslink', function () {
    $exitCode = Artisan::call('storage:link');
    return '<h1>Syslink Done</h1>';
});

//Key generate
Route::get('/key-generate', function () {
    $exitCode = Artisan::call('key:generate');
    return '<h1>Key Generate</h1>';
});

//JWT Key Secret
Route::get('/jwt-secret', function () {
    $exitCode = Artisan::call('jwt:secret');
    return '<h1>JWT Key Secret</h1>';
});