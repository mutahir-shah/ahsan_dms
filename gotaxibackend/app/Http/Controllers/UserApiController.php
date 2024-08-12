<?php

namespace App\Http\Controllers;

use anlutro\LaravelSettings\Facade as Setting;
use App\BankAccount;

use App\BlockUserProvider;

use App\Card;
use App\Language;
use App\Document;
use App\Faqs;

use App\FavoriteProvider;

use App\FavouriteLocation;

use App\Helpers\Helper;

use App\Http\Controllers\ProviderResources\TripController;
use App\Http\Controllers\SendPushNotification;
use App\Notifications\ResetPasswordOTP;

use App\Notifications\Welcome;

use App\Promocode;

use App\PromocodePassbook;

use App\PromocodeUsage;

use App\Provider;

use App\ProviderDevice;

use App\ProviderDocument;
use App\ProviderProfile;
use App\ProviderReferral;

use App\ProviderService;
use App\PushNotificationLog;
use App\RequestFilter;
use App\RequestFilterLog;

use App\RequestOffer;
use App\RequestReportImages;
use App\ServiceType;

use App\Settings;

use App\Subscription;

use App\User;

use App\UserDocument;

use App\UserReferral;

use App\UserRequestPayment;

use App\UserRequestRating;

use App\UserRequests;

use App\WalletPassbook;
use App\WithdrawalMoney;

use App\Zones;
use App\ZoneService;
use Carbon\Carbon;
use Config;
use DB;
use Exception;
use GuzzleHttp;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JWTAuth;
use Log;
use Notification;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Exception\CardException;

use Stripe\Exception\InvalidRequestException;
use Stripe\Stripe;
use Stripe\StripeInvalidRequestError;
use Illuminate\Support\Collection;
class UserApiController extends Controller

{

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'device_id' => 'required',
            'device_type' => 'required|in:android,ios',
            // TODO: handle this properly with app devs
            // 'device_token' => 'required',
            'username' => 'required',
            'password' => 'required|min:6',
            'type' => 'required|in:phone,email',
            'language' => 'nullable'
        ]);

        

        if (Setting::get('email_field', "0") == 1) {
            if ($request->type == 'email') {
                $user = User::where('email', $request->username)->first();
                if (!$user) {
                    return response()->json(['error' => 'invalid_credentials', 'message' => "The user credentials were incorrect."], 400);
                }
                $username = $request->username;
            } else if ($request->type == 'phone') {
                $user = User::where('mobile', $request->username)->first();
                if (!$user) {
                    return response()->json(['error' => 'invalid_credentials', 'message' => "The user credentials were incorrect."], 400);
                }
                $username = $user->email;
            }
        } else {
            $user = User::where('mobile', $request->username)->first();
            if (!$user) {
                return response()->json(['error' => 'invalid_credentials', 'message' => "The user credentials were incorrect."], 400);
            }
            $username = $request->username;
        }

        $user = User::find($user->id);
        $user->device_id = $request->device_id;
        $user->device_type = $request->device_type;
        $user->device_token = $request->device_token ? $request->device_token : null ;
        $user->language = $request->has('language') ? $request->language : 'en';
        if ($user->referral_code == null) {
            $user->referral_code = strtoupper(substr(md5(uniqid(rand(1,6))), 0, 6));
            $user->save();
        }
         // Delete User Token 
        if (Setting::get('multi_device_login_passenger') == 0){
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
        }
        $user->save();

        if (Setting::get('email_field', "0") == 1) {
            $http = new GuzzleHttp\Client(['exceptions' => false, 'CURLOPT_SSL_VERIFYPEER' => false, 'verify' => false]);
            $client = DB::table('oauth_clients')->latest('id')->first();
            $response = $http->post(config('app.url', url('/')) . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'username' => $username,
                    'password' => ($request->password),
                    'scope' => '',
                ],
            ]);
            
            $token = json_decode($response->getBody()->getContents());
            if ($response->getStatusCode() == 401) {
                return response()->json(['error' => 'invalid_credentials', 'message' => "The user credentials were incorrect."], 400);
            } if ($response->getStatusCode() == 400) { 
                 // Delete User Token 
                // if (Setting::get('multi_device_login_passenger') == 0){
                //     DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
                // }
                $token = $user->createToken('accessToken')->accessToken; //Alternative way to generate token
                $user->access_token = $token;
            }
            else {
                 // Delete User Token 
                //  if (Setting::get('multi_device_login_passenger') == 0){
                //     DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
                // }
                $user->access_token = $token->access_token;
                $user->refresh_token = $token->refresh_token;
                $user->expires_in = $token->expires_in;
                $user->token_type = $token->token_type;
            }
        } else {
            //Alternative way to login & generate token
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'code' => 400,
                    'status' => false,
                    'message' => 'The provided credentials are incorrect',
                ], 400);
            }

           

            $token = $user->createToken('accessToken')->accessToken; //Alternative way to generate token
            $user->access_token = $token;
        }

        $user->currency = trans('currency.' . Setting::get('currency'));
        $user->sos = Setting::get('sos_number', '911');
        $user->token_type = "Bearer";

        $slider_images = [];
        $slider_image1 = Setting::get('slider_image1', '');
        $slider_image2 = Setting::get('slider_image2', '');
        $slider_image3 = Setting::get('slider_image3', '');
        $slider_image4 = Setting::get('slider_image4', '');
        $slider_image5 = Setting::get('slider_image5', '');

        array_push($slider_images, $slider_image1, $slider_image2, $slider_image3, $slider_image4, $slider_image5);

        $user->slider_images = $slider_images;

        $user->tip_collect = Setting::get('tip_collect', '0');
        $tip_suggestions = [];
        $tip_suggestion1 = Setting::get('tip_suggestion1', '0');
        $tip_suggestion2 = Setting::get('tip_suggestion2', '0');
        $tip_suggestion3 = Setting::get('tip_suggestion3', '0');

        array_push($tip_suggestions, $tip_suggestion1, $tip_suggestion2, $tip_suggestion3);

        $user->tip_suggestions = $tip_suggestions;

        $user->subscription_module = Setting::get('subscription_module', '0');

        $user->home = FavouriteLocation::where(['type' => 'home', 'user_id' => $user->id])->get();
        $user->work = FavouriteLocation::where(['type' => 'work', 'user_id' => $user->id])->get();
        $user->others = FavouriteLocation::where(['type' => 'others', 'user_id' => $user->id])->get();

        $user->zone_name = $user->zone ? $user->zone->name : 'N/A';

        $user->reward_points = (string) $user->reward_points;

        return response()->json($user);
    }

    public function refreshToken(Request $request)
    {
        try {
            $http = new GuzzleHttp\Client(['exceptions' => false, 'CURLOPT_SSL_VERIFYPEER' => false, 'verify' => false]);
            $client = DB::table('oauth_clients')->latest('id')->first();
            $response = $http->post(config('app.url', url('/')) . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'refresh_token' => $request->refresh_token,
                    'scope' => '',
                ],
            ]);

            $token = json_decode($response->getBody()->getContents());

            if ($response->getStatusCode() == 401) {
                return response()->json(['error' => 'invalid_credentials', 'message' => "The user credentials were incorrect."], 401);
            } else if ($token->error == 'invalid_request') {
                return response()->json(['error' => 'invalid_request', 'message' => 'Token cannot be refreshed, please Login again'], 403);
            }

            return response()->json($token);
        } catch (Exception $e) {
            return response()->json([
                'code' => 403,
                'message' => 'Token cannot be refreshed, please Login again'
            ], 403);
        }
    }


    public function fetchUser(Request $request)
    {
        $user = User::where('mobile', '=', $request->mobile)->get(['first_name', 'last_name', 'email'])->first();
        if ($user) {
            return $user;
        } else {
            return "false";
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function fareEstimate()

    {

        $userAPI = new UserApiController;

        $this->UserAPI = $userAPI;

        $services = $this->UserAPI->services();

        return view('ride', compact('services'));

    }

    public function signup(Request $request)

    {

        $this->validate($request, [

            'social_unique_id' => ['required_if:login_by,facebook,google', 'unique:users'],

            'device_type' => 'required|in:android,ios',

            // TODO: handle this properly with app devs
            // 'device_token' => 'required',

            'device_id' => 'required',

            'login_by' => 'required|in:manual,facebook,google',

            'first_name' => 'required|max:255',

            'last_name' => 'required|max:255',

            'email' => Setting::get('email_field', "0") == 1 ? 'required|email|max:255|unique:users' : 'nullable',

            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|unique:users,mobile',

            'password' => 'required|min:6',
            'language' => 'nullable'

        ]);

        try {

            $user = $request->all();

            $user['payment_mode'] = 'CASH';

            $user['password'] = bcrypt($request->password);

            if ($request->hasFile('picture')) {
                $user['picture'] = $request->picture->store('user/profile');
            }

            $user['email'] = Setting::get('email_field', "0") == 1 && $request->has('email') ? $request->email : null;
            $user['language'] = $request->has('language') ? $request->language : 'en';

            $user = User::create($user);

            $user->reward_points = (string) $user->reward_points;
            return $user;

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    public function register(Request $request)

    {

        $this->validate($request, [

            'social_unique_id' => ['required_if:login_by,facebook,google', 'unique:users'],

            'device_type' => 'required|in:android,ios',

            // TODO: handle this properly with app devs
            // 'device_token' => 'required',

            'device_id' => 'required',

            'login_by' => 'required|in:manual,facebook,google',

            'first_name' => 'required|max:255',

            'last_name' => 'required|max:255',

            'email' => Setting::get('email_field', "0") == 1 ? 'required|email|max:255|unique:users,email' : 'nullable',

            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|unique:users,mobile',

            'password' => 'required|min:6',
            'language' => 'nullable'

        ]);

        try {

            $user = $request->all();

            if (Setting::get('driver_code_signup') == 1) {
                $driver_job_code = $request->driver_job_code;
                if($driver_job_code != '') {
                    $provider = Provider::where('id', $driver_job_code);
                    $providerCount = $provider->count();
                    if($providerCount == 0) {
                        return response()->json(['error' => 'invalid_data', 'message' => "Invalid driver code"], 400);
                    } else {
                        $providerData = $provider->get()->first();
                        $user['driver_job_code'] = $driver_job_code;
                        $user['driver_name'] = $providerData->first_name . ' ' . $providerData->last_name;
                    }
                }
            } else {
                $user['driver_job_code'] = null;
            }

            if (Setting::get('user_referral') == 1) {
                $referral_code = strtoupper($request->referral_code);
                if($referral_code != '') {
                    $providerReferralCount = Provider::where('referral_code', $referral_code)->get(['id'])->count(); 
                    $userReferralCount = User::where('referral_code', $referral_code)->get(['id'])->count();

                    if(($providerReferralCount == 0 && $userReferralCount == 0))
                        return response()->json(['error' => 'invalid_data', 'message' => "Invalid referral code"], 400);
                }
            }

            $user['payment_mode'] = 'CASH';

            $user['password'] = bcrypt($request->password);

            if ($request->hasFile('picture')) {
                $user['picture'] = $request->picture->store('user/profile');
            }

            if (Setting::get('user_verification', 0) == 1) {
                $user['status'] = 'doc_required';
            } else {
                if (Setting::get('subscription_module', 0) == 1 && Setting::get('rider_subscription_module', 0) == 1) {
                    $user['status'] = 'subscription_expired';
                } else {
                    $user['status'] = 'approved';
                }
            }

            if(Setting::get('subscription_module_stripe_trial', 0) == 0) {
                $trial_period = Setting::get('rider_trial_period', 0);
                if($trial_period > 0) {
                    if (Setting::get('user_verification', 0) == 1) {
                        $user['status'] = 'doc_required';
                    } else {
                        $user['trial_availed'] = 1;
                        $user['trial_end_time'] = Carbon::now()->addDays($trial_period);
                        $user['subscription_status'] = 'trialing';
                        $user['status'] = 'approved';
                    }
                }
            }

            if (Setting::get('customer_vehicle_info', 0) == 1) {
                $user['vehicle_make'] = $request->vehicle_make != '' ? $request->vehicle_make : null;
                $user['vehicle_number'] = $request->vehicle_number != '' ? $request->vehicle_number : null;
            } else {
                $user['vehicle_make'] = null;
                $user['vehicle_number'] = null;
                // $request->remove('vehicle_make');
                // $request->remove('vehicle_number');
            }

            if (Setting::get('gender', 0) == 1) {
                $user['gender'] = $request->gender != '' ? $request->gender : null;
            } else {
                $user['gender'] = null;
                // $request->remove('gender');
            }

            if (Setting::get('gender_pref_enabled', 0) == 1) {
                $user['gender_pref'] = $request->gender_pref != '' ? $request->gender_pref : null;
            } else {
                $user['gender_pref'] = null;
                // $request->remove('gender_pref');
            }

            if (Setting::get('email_field', "0") == 1 && $request->has('email')) {
                $user['email'] =  $request->email != '' ? $request->email : null;
            } else {
                $user['email'] = null;
                // $request->remove('email');
            }
            
            $user['language'] = $request->has('language') ? $request->language : 'en';
            $user['referral_code'] = strtoupper(substr(md5(uniqid(rand(1,6))), 0, 6));

            $user['dob'] = ($request->has('dob') && $request->dob != '') ? $request->dob : null;
            $user['address'] = ($request->has('address') && $request->address != '') ? $request->address : null;

            $user = User::create($user);
            $newCreatedUserId = $user->id;

            if (Setting::get('email_field', "0") == 1) {
                $http = new GuzzleHttp\Client(['exceptions' => false, 'CURLOPT_SSL_VERIFYPEER' => false, 'verify' => false]);
                $client = DB::table('oauth_clients')->latest('id')->first();
                $response = $http->post(config('app.url', url('/')) . '/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => $client->id,
                        'client_secret' => $client->secret,
                        'username' => $request->email,
                        'password' => ($request->password),
                        'scope' => '',
                    ],
                ]);

                $token = json_decode($response->getBody()->getContents());
                if ($response->getStatusCode() == 401) {
                    return response()->json(['error' => 'invalid_credentials', 'message' => "The user credentials were incorrect."], 400);
                } else {
                    $user = User::where('email', $request->email)->first();
                    $user->access_token = $token->access_token;
                    $user->refresh_token = $token->refresh_token;
                    $user->expires_in = $token->expires_in;
                    $user->token_type = $token->token_type;
                }
            } else {
                // Alterantive way to get token
                $token = $user->createToken('accessToken')->accessToken;
                $user->access_token = $token;
                $user->token_type = 'Bearer';
            }

            $user->currency = trans('currency.' . Setting::get('currency'));
            
            $user->sos = Setting::get('sos_number', '911');

            $slider_images = [];
            $slider_image1 = Setting::get('slider_image1', '');
            $slider_image2 = Setting::get('slider_image2', '');
            $slider_image3 = Setting::get('slider_image3', '');
            $slider_image4 = Setting::get('slider_image4', '');
            $slider_image5 = Setting::get('slider_image5', '');

            array_push($slider_images, $slider_image1, $slider_image2, $slider_image3, $slider_image4, $slider_image5);

            $user->slider_images = $slider_images;

            $user->tip_collect = Setting::get('tip_collect', '0');
            $tip_suggestions = [];
            $tip_suggestion1 = Setting::get('tip_suggestion1', '0');
            $tip_suggestion2 = Setting::get('tip_suggestion2', '0');
            $tip_suggestion3 = Setting::get('tip_suggestion3', '0');

            array_push($tip_suggestions, $tip_suggestion1, $tip_suggestion2, $tip_suggestion3);

            $user->tip_suggestions = $tip_suggestions;

            $user->subscription_module = Setting::get('subscription_module', '0');

            if (Setting::get('user_referral') == 1) {
                $referral_code = strtoupper($request->referral_code);
                if ($referral_code != $user->referral_code) {
                    $providerReferral = Provider::where('referral_code', $referral_code)->get(['id'])->first(); 
                    $userReferral = User::where('referral_code', $referral_code)->get(['id'])->first();
                    
                    if ($providerReferral) {
                        $provider = Provider::find($providerReferral->id);
                        $provider->user_referral_count = $provider->user_referral_count + 1;
                        $provider->save();

                        ProviderReferral::create([
                            'provider_id' => $provider->id,
                            'reffered_id' => $newCreatedUserId, // new created user
                            'type' => 'User',
                        ]);
                    }
                    if ($userReferral) {
                        if ($userReferral->id != $newCreatedUserId) {
                            $userUpdate = User::find($userReferral->id);
                            $userUpdate->user_referral_count = $userUpdate->user_referral_count + 1;
                            $userUpdate->save();

                            UserReferral::create([
                                'user_id' => $userReferral->id,
                                'reffered_id' => $newCreatedUserId, // new created user
                                'type' => 'User',
                            ]);
                        }
                    }
                }
            }

            $user->zone_name = $user->zone ? $user->zone->name : 'N/A';

            // return $user;
            // $user = User::find($newCreatedUserId);
            $user->reward_points = (string) $user->reward_points;
            return response()->json($user, 201);

        } catch (Exception $e) {
            // return $e->getMessage();

            return response()->json(['error' => trans('api.something_went_wrong'), 'data' => $e->getMessage()], 500);

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function logout(Request $request)

    {

        try {

            User::where('id', $request->id)->update(['device_id' => '', 'device_token' => '']);

            return response()->json(['message' => trans('api.logout_success')]);

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function change_password(Request $request)
    {

        $this->validate($request, [

            'password' => 'required|confirmed|min:6',

            'old_password' => 'required',

        ]);

        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {

            $user->password = bcrypt($request->password);

            $user->save();

            if ($request->ajax()) {

                return response()->json(['message' => trans('api.user.password_updated')]);

            } else {

                return back()->with('flash_success', 'Password Updated');

            }

        } else {

            if ($request->ajax()) {

                return response()->json(['error' => trans('api.user.change_password')], 500);

            } else {

                return back()->with('flash_error', trans('api.user.change_password'));

            }

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function update_location(Request $request)
    {

        $this->validate($request, [

            'latitude' => 'required|numeric',

            'longitude' => 'required|numeric',

        ]);

        if ($user = User::find(Auth::user()->id)) {

            $user->latitude = 0.00;

            $user->longitude = 0.00;

            $user->save();

            return response()->json(['message' => trans('api.user.location_updated')]);

        } else {

            return response()->json(['error' => trans('api.user.user_not_found')], 500);

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function details(Request $request)
    {

        $this->validate($request, [

            'device_type' => 'in:android,ios',

        ]);

        try {

            if ($user = User::find(Auth::user()->id)) {

                if ($request->has('device_token')) {

                    $user->device_token = $request->device_token ? $request->device_token : null ;

                }

                if ($request->has('device_type')) {

                    $user->device_type = $request->device_type;

                }

                if ($request->has('device_id')) {

                    $user->device_id = $request->device_id;

                }

                $user->save();

                $user->currency = trans('currency.' . Setting::get('currency'));

                $user->sos = Setting::get('sos_number', '911');

                $slider_images = [];
                $slider_image1 = Setting::get('slider_image1', '');
                $slider_image2 = Setting::get('slider_image2', '');
                $slider_image3 = Setting::get('slider_image3', '');
                $slider_image4 = Setting::get('slider_image4', '');
                $slider_image5 = Setting::get('slider_image5', '');

                array_push($slider_images, $slider_image1, $slider_image2, $slider_image3, $slider_image4, $slider_image5);

                $user->slider_images = $slider_images;

                $user->tip_collect = Setting::get('tip_collect', '0');
                $tip_suggestions = [];
                $tip_suggestion1 = Setting::get('tip_suggestion1', '0');
                $tip_suggestion2 = Setting::get('tip_suggestion2', '0');
                $tip_suggestion3 = Setting::get('tip_suggestion3', '0');

                array_push($tip_suggestions, $tip_suggestion1, $tip_suggestion2, $tip_suggestion3);

                $user->tip_suggestions = $tip_suggestions;

                $user->subscription_module = Setting::get('subscription_module', '0');

                $user->home = FavouriteLocation::where(['type' => 'home', 'user_id' => Auth::user()->id])->get();
                $user->work = FavouriteLocation::where(['type' => 'work', 'user_id' => Auth::user()->id])->get();
                $user->others = FavouriteLocation::where(['type' => 'others', 'user_id' => Auth::user()->id])->get();

                $user->zone_name = $user->zone ? $user->zone->name : 'N/A';
                $user->reward_points = strval($user->reward_points);
                return $user;

            } else {

                return response()->json(['error' => trans('api.user.user_not_found')], 500);

            }

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function update_profile(Request $request)

    {

        $this->validate($request, [

            'first_name' => 'required|max:255',

            'last_name' => 'max:255',

            'email' => Setting::get('email_field', "0") == 1 ? 'sometimes|email|max:255|unique:users,email,' . Auth::user()->id : 'nullable',

            'mobile' => 'regex:/[+][0-9 ]{10,15}/|min:10|unique:users,mobile,' . Auth::user()->id,

            'picture' => 'nullable|mimes:jpeg,bmp,png',

        ]);

        try {

            $user = User::findOrFail(Auth::user()->id);

            if ($request->has('first_name')) {

                $user->first_name = $request->first_name;

            }

            if ($request->has('last_name')) {

                $user->last_name = $request->last_name;

            }

            if ($request->has('gender')) {

                $user->gender = $request->gender;

            }

            if ($request->has('gender_pref')) {

                $user->gender_pref = $request->gender_pref;

            }

            if ($request->has('email')) {

                $user->email = $request->email;

            }

            if ($request->has('mobile')) {

                $user->mobile = str_replace(' ', '', $request->mobile);

            }

            if ($request->picture != "") {

                Storage::delete($user->picture);

                $user->picture = $request->picture->store('user/profile');

            }

            if (Setting::get('customer_vehicle_info', 0) == 1) {

                if ($request->has('vehicle_make')) {
                    $user->vehicle_make = $request->vehicle_make;
                }

                if ($request->has('vehicle_number')) {
                    $user->vehicle_number = $request->vehicle_number;
                }
            }

            $user->save();
            $user = User::findOrFail(Auth::user()->id);

            $user->reward_points = strval($user->reward_points);
            if ($request->ajax()) {

                return response()->json($user);

            } else {

                return back()->with('flash_success', trans('api.user.profile_updated'));

            }

        } catch (ModelNotFoundException $e) {

            return response()->json(['error' => trans('api.user.user_not_found')], 500);

        }

    }

    public function share_wallet(Request $request)

    {

        $this->validate($request, [

            'amount' => 'required|max:255',

            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5',

        ]);

        try {

            $user = User::findOrFail(Auth::user()->id);

            if ($request->amount > $user->wallet_balance) {
                return response()->json(['error' => 'Invalid amount'], 400);
            }

            $receiverUserData = User::where('mobile', $request->mobile)->get()->first();

            if (!$receiverUserData) {
                return response()->json(['error' => 'Invalid mobile number'], 400);
            }

            $user->wallet_balance = $user->wallet_balance - $request->amount;

            $user->save();

            WalletPassbook::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'status' => 'DEBITED',
                'via' => $user->first_name . ' ' . $user->last_name,
                'type' => 'User'
            ]);

            $receiverUser = User::findOrFail($receiverUserData->id);

            $receiverUser->wallet_balance = $receiverUser->wallet_balance + $request->amount;

            $receiverUser->save();

            //sending push on adding wallet money
            (new SendPushNotification)->WalletMoneyReceived($receiverUser->id, ($request->amount));


            WalletPassbook::create([
                'user_id' => $receiverUser->id,
                'amount' => $request->amount,
                'status' => 'CREDITED',
                'via' => $user->first_name . ' ' . $user->last_name,
                'type' => 'User'
            ]);

            if ($request->ajax()) {

                return response()->json($user);

            } else {

                return back()->with('flash_success', trans('api.user.profile_updated'));

            }

        } catch (ModelNotFoundException $e) {

            return response()->json(['error' => trans('api.user.user_not_found')], 500);

        }

    }

    public function redeem_points(Request $request)
    {

        try {

            $user_id = Auth::user()->id;

            $user = User::find($user_id);

            $user->wallet_balance = $user->wallet_balance + $user->reward_points;
            $user->reward_points = 0;

            $user->save();


            return response()->json(['message' => 'Points redeemed successfully!', 'wallet_balance' => $user->wallet_balance]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }


    }

    public function share_wallet_provider(Request $request)

    {

        $this->validate($request, [

            'amount' => 'required|max:255',

            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5',

        ]);

        try {

            $provider = Provider::findOrFail(Auth::user()->id);

            if ($request->amount > $provider->wallet) {
                return response()->json(['error' => 'Invalid amount'], 400);
            }

            $receiverProviderData = Provider::where('mobile', $request->mobile)->get()->first();

            if (!$receiverProviderData) {
                return response()->json(['error' => 'Invalid mobile number'], 400);
            }

            $provider->wallet = $provider->wallet - $request->amount;

            $provider->save();

            WalletPassbook::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'status' => 'DEBITED',
                'via' => $provider->first_name . ' ' . $provider->last_name,
                'type' => 'Provider'
            ]);

            $receiverProvider = Provider::findOrFail($receiverProviderData->id);

            $receiverProvider->wallet = $receiverProvider->wallet + $request->amount;

            $receiverProvider->save();

            //sending push on adding wallet money
            (new SendPushNotification)->WalletMoneyReceived($receiverProvider->id, ($request->amount));

            WalletPassbook::create([
                'user_id' => $receiverProvider->id,
                'amount' => $request->amount,
                'status' => 'CREDITED',
                'via' => $provider->first_name . ' ' . $provider->last_name,
                'type' => 'Provider'
            ]);

            if ($request->ajax()) {

                return response()->json($provider);

            } else {

                return back()->with('flash_success', trans('api.user.profile_updated'));

            }

        } catch (ModelNotFoundException $e) {

            return response()->json(['error' => trans('api.user.user_not_found')], 500);

        }

    }

    public function request_payment(Request $request)
    {

        $this->validate($request, [
            'request_id' => 'required|numeric|exists:user_requests,id',
            'amount' => 'required'
        ]);

        try {

            $amount = $request->amount;
            $request_id = $request->request_id;

            // Update Reuqest Values
            $userRequest = UserRequests::findOrFail($request_id);
            $userRequest->amount = $amount;
            $userRequest->ride_amount = $amount;
            $userRequest->driver_amount = $amount;
           
          // Ensure the invoice attribute is an array before updating it
            $invoice = is_array($userRequest->invoice) ? $userRequest->invoice : [];

            // Update invoice array
            $invoice['fixed'] = $amount;
            $invoice['provider_commission'] = $amount;
            $invoice['t_price'] = $amount;
            $invoice['total'] = $amount;
            $invoice['provider_pay'] = $amount;
            $invoice['payable'] = $amount;

            // Assign updated invoice array back to the model
            $userRequest->invoice = $invoice;

            // Save changes to the database
            $userRequest->update();

            // //Todo: Start Invoice Calculation in function
            // $service_type_id = $userRequest->service_type_id;
            // $s_latitude = $userRequest->s_latitude;
            // $s_longitude = $userRequest->s_longitude;
            // $vweight = $userRequest->vweight;
            // $origin_address = $userRequest->s_address;
            // $destination_address = $userRequest->destination_address;
            $distance = $userRequest->distance;
            // $schedule_time = $userRequest->schedule_time ? $userRequest->schedule_time : null;
            // $schedule_date = $userRequest->schedule_date ? $userRequest->schedule_date : null;
            // $schedule_web = $userRequest->schedule_web ? $userRequest->schedule_web : null;
            
            // $start_time = Carbon::parse($userRequest->started_at);
            // $end_time = Carbon::parse($userRequest->finished_at);
            // $seconds = $end_time->diffInSeconds($start_time);
            // $minutes = $seconds / 60;
            // $hours = $minutes / 60;

            // $serviceTypeController = new ServiceTypeController();
            // $userApiController = new UserApiController();

            // $service_type = $serviceTypeController->getServiceType($service_type_id, $s_latitude, $s_longitude);

            // $base_price = $service_type->fixed;
            // $base_distance = $service_type->distance;
            // $locked_pricing = $service_type->locked_pricing;

            // $calculationData = $userApiController->calculatePricingWithServiceType($service_type, $schedule_date, $schedule_time, $schedule_web, $kilometer, $seconds, $origin_address, $destination_address, $s_latitude, $s_longitude, $vweight);
            // // $peakActive = $calculationData['peakActive'];
            // // $isextraprice = $calculationData['isextraprice'];
            // $price = $calculationData['price'];

            // //TODO: calculate this nego in main function
            // if ($locked_pricing == 0) {
            //     if (Setting::get('negotiation_module', 0) == 1) {
            //         $price = $userRequest->amount;
            //     }
            // } else {
            //     if (Setting::get('negotiation_module', 0) == 1) {
            //         $price = $userRequest->client_offer;
            //     }
            // }

            // $surgeDetail = $serviceTypeController->getSurge($service_type, $price, $s_latitude, $s_longitude);
            // // $surgeActive = $surgeDetail['is_active'];
            // $surgePrice = $surgeDetail['surgePrice'];
            // $price += $surgePrice;

            // $bookingFeeDetail = $serviceTypeController->getBookingPrice($service_type);
            // $bookingFeeAmount = $bookingFeeDetail['bookingFeeAmount'];
            // $price += $bookingFeeAmount;
            
            // //TODO: we'll discuss this later to apply commission on which price
            // $commissionDetail = $serviceTypeController->getCommissionPrice($service_type, $price);
            // $commission_price = $commissionDetail['commission_price'];
            // $commission_type = $commissionDetail['commission_type'];
            // $price += $commission_price;

            // $taxDetail = $serviceTypeController->getTaxPrice($service_type, $price);
            // $tax_price = $taxDetail['tax_price'];
            // $total = $price + $tax_price;

            // // dd($service_type);
            // // $extra_amount_percentage = Setting::get('extra_amount_percentage', '100');

            // $discount = 0; // Promo Code discounts should be added here.
            // $wallet = 0;
            // $providerCommission = 0;
            // $companyCommission = 0;
            // $providerPay = 0;
            
            // // Company Commission: Booking Fee + Company Commission + Tax
            // $companyCommission =  $commission_price + $bookingFeeAmount + $tax_price; //Company Comission
            // // Provider Commission: Total - (Booking Fee + Company Commission + Tax
            // $providerCommission = $total - $companyCommission;
            // $providerPay = $providerCommission;

            // if ($promocodeUsage = PromocodeUsage::where('user_id', $userRequest->user_id)->where('status', 'ADDED')->first()) {
            //     if ($Promocode = Promocode::find($promocodeUsage->promocode_id)) {
            //         $discount = $Promocode->discount;
            //         $promocodeUsage->status = 'USED';
            //         $promocodeUsage->save();

            //         PromocodePassbook::create([
            //             'user_id' => Auth::user()->id,
            //             'status' => 'USED',
            //             'promocode_id' => $promocodeUsage->promocode_id
            //         ]);
            //     }

            //     if ($promocodeUsage->promocode->discount_type == 'amount') {
            //         $total -= $discount;
            //     } else {
            //         $total = ($total) - (($total) * ($discount / 100));
            //         $discount = (($total) * ($discount / 100));
            //     }
            // }
            //Todo: End Invoice Calculation in function

            //tax, commission, discount and other values should also be updated!
            UserRequestPayment::firstOrCreate([
                'request_id' => $request_id,
                // 'fixed' => $base_price,
                'fixed' => $amount,
                'distance' => $distance,
                // 'tax' => $tax_price,
                'tax' => 0,
                // 'discount' => $discount,
                'discount' => 0,
                'wallet' => 0,
                // 'surge' => $surgePrice,
                'surge' => 0,
                // 'commision' => $companyCommission,
                'commision' => 0,
                // 'provider_commission' => $providerCommission,
                'provider_commission' => 0,
                // 'provider_pay' => $providerPay,
                'provider_pay' => $amount,
                // 'total' => $total,
                'total' => $amount ,
                // 't_price' => $price,
                't_price' => $amount ,
                // 'payable' => $total,
                'payable' => $amount,
                'request_category' => 'Metered'
            ]);

            return response()->json(['message' => 'Ride pricing updated!']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Get the services listing.
     *
     * @return Response
     */

    public function servicesWithEstimate(Request $request)
    {
        $loopIndex = 0;
        try {

            $servicesArray = [];
            $servicesArrayResponse = [];
            $servicesArrayNormal = [];
            $servicesArrayMetered = [];
            
            $s_latitude = $request->s_latitude;
            $s_longitude = $request->s_longitude;
            $d_latitude = $request->d_latitude;
            $d_longitude = $request->d_longitude;

            $serviceTypeController = new ServiceTypeController();
            $types = $serviceTypeController->getActiveServicesTypes($request);
            $zoneList = $serviceTypeController->isZoneListExists($s_latitude, $s_longitude);
            $geoFencingController = new GeoFencingController();
            $currentZone = null;
            if (Setting::get('zone_module', "0") == "1" || Setting::get('zone_inbound_force', "0") == "1") {
                $currentZone = $geoFencingController->getZone($s_latitude, $s_longitude);
            }

            /**
             * Checking the services region
             */
            $inbound = false;
            if (Setting::get('zone_module', "0") == "1") {
                $servicesList = [];
                if (Setting::get('zone_inbound_force', "0") == "1") {
                    $inbound = $serviceTypeController->getServiceZoneInbound($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                    if (!$inbound) {
                        return [];
                    }
                    //Todo: handle this case of else
                } else {
                    $servicesList = $serviceTypeController->getAllServiceTypes($s_latitude, $s_longitude, $request);
                }
            } else {
                $servicesList = $serviceTypeController->getAllServiceTypes($s_latitude, $s_longitude, $request);
            }
            // return $servicesList;

            if ($servicesList) {
                foreach ($servicesList as $index => $serviceList) {
                    $loopIndex = $index;
                    // if ($loopIndex == 8) {
                    //     dd($serviceList);
                    // }
                    if ($s_latitude != null && $s_longitude != null && $d_latitude != null && $d_longitude != null) {
            
                        $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                        
                        $meter = $googleDistanceAndTime['distanceValue'];
                        $seconds = $googleDistanceAndTime['durationValue'];
                        $time = $googleDistanceAndTime['durationText'];
                        $origin_address = $googleDistanceAndTime['originAddress'];
                        $destination_address = $googleDistanceAndTime['destinationAddress'];
                        $kilometer = Helper::applyDistanceSystem($meter);
                        $minutes = $seconds / 60;
                        $hours = $seconds / 3600;
                        
                        if (Setting::get('zone_module', "0") == "1") {
                            if ($currentZone != null) {
                                $serviceList->id = $serviceList->service_id;
                                $serviceList->zone_id = $currentZone->id;
                            }
                        }

                        $service_type_id = $serviceList->id;
                        $service_type = $serviceTypeController->getServiceType($service_type_id, $s_latitude, $s_longitude);
                        
                        $extra_amount_percentage = Setting::get('extra_amount_percentage', '100');
                        $price = $service_type->fixed;
                        $phourfrom = $service_type->phourfrom;
                        $phourto = $service_type->phourto;
                        $pextra = $service_type->pextra == null ? 0 : $service_type->pextra;
                        $base_distance = $service_type->distance;
                        $kilometer0 = $base_distance;
                        // $base_price = $base_distance > 0 ? $price : 0; //TODO: for handling base price with distance
                        $base_price = $price;
                        $finalprice = 0;
                        $isextraprice = 0;
                        $extraprice = 0;
                        $vweight = $request->vweight ? $request->vweight : 0;

                        $schedule_date = null;
                        $schedule_time = null;
                        $schedule_web = null;
                        if ($request->has('schedule_web')  && $request->schedule_web == 'yes') {
                            $schedule_web = $request->schedule_web;
                        }

                        if ($request->has('schedule_date') && $request->has('schedule_time')) {
                            $schedule_date = $request->schedule_date;
                            $schedule_time = $request->schedule_time;
                        }

                        $calculationData = $this->calculatePricingWithServiceType($service_type, $schedule_date, $schedule_time, $schedule_web, $kilometer, $seconds, $origin_address, $destination_address, $s_latitude, $s_longitude, $vweight);
                        
                        $ridePrice = $calculationData['ridePrice'];
                        $price = $calculationData['price'];
                        $peakActive = $calculationData['peakActive'];
                        $peakValue = $calculationData['peakValue'];
                        $peakPrice = $calculationData['peakPrice'];
                        $peakType = $calculationData['peakType'];
                        $surgeActive = $calculationData['surgeActive'];
                        $surgePrice = $calculationData['surgePrice'];
                        $surgePercentage = $calculationData['surge_percentage'];
                        $bookingFeeActive = $calculationData['bookingFeeActive'];
                        $bookingFeeAmount = $calculationData['bookingFeeAmount'];
                        $commission_tax_apply = $calculationData['commission_tax_apply'];
                        $commission_type = $calculationData['commission_type'];
                        $commission_percentage = $calculationData['commission_percentage'];
                        $commission_deduction = $calculationData['commission_deduction'];
                        $commission_price = $calculationData['commission_price'];
                        $commission_source = $calculationData['commission_source'];
                        $tax_active = $calculationData['tax_active'];
                        $tax_price = $calculationData['tax_price'];
                        $return_tax_price = $calculationData['return_tax_price'];
                        $government_charges_active = $calculationData['government_charges_active'];
                        $government_charges = $calculationData['government_charges'];
                        $toll_fee_active = $calculationData['toll_fee_active'];
                        $toll_fee = $calculationData['toll_fee'];
                        $airport_charges_active = $calculationData['airport_charges_active'];
                        $airport_charges = $calculationData['airport_charges'];
                        $total = $calculationData['total'];
                        $return_total = $calculationData['return_total'];
                        $grand_total = $calculationData['grand_total'];
                        $grand_return_total = $calculationData['grand_return_total'];
                        $isextraprice = $calculationData['isextraprice'];
                        $additionalCharges = $calculationData['additionalCharges'];

                        $serviceList->booking_fee_amount = $bookingFeeAmount;
                        $serviceList->isextraprice = $isextraprice;
                        
                        // $estimated_fare = $price + $additionalCharges;
                        $serviceList->peak_active = (int) $peakActive;
                        $serviceList->estimated_fare = Helper::customRoundtoMultiple($total, 2);
                        $serviceList->return_estimated_fare = Helper::customRoundtoMultiple($return_total, 2);
                        $serviceList->tax_price = Helper::customRoundtoMultiple($tax_price, 2);
                        $serviceList->return_tax_price = Helper::customRoundtoMultiple($return_tax_price, 2);
                        $serviceList->eta_total = Helper::customRoundtoMultiple($grand_total, 2);
                        $serviceList->eta_return_total = Helper::customRoundtoMultiple($grand_return_total, 2);
                        $serviceList->eta_total_cash = Helper::customRoundtoMultiple($total, 2);
                        $serviceList->eta_return_total_cash = Helper::customRoundtoMultiple($return_total, 2);
                        $serviceList->total = Helper::customRoundtoMultiple($grand_total, 2);
                        $serviceList->return_total = Helper::customRoundtoMultiple($grand_return_total, 2);

                        // $serviceList->finalprice = Helper::customRoundtoMultiple($finalprice, 2);
                        // $serviceList->tier = Helper::customRoundtoMultiple($tier, 2);
                        // $serviceList->peak = Helper::customRoundtoMultiple($total, 2);
                    }   
                    /**
                     * Start getting inbound
                     */
                    if (Setting::get('zone_module', "0") == "1") {
                        if ($zoneList == true) {
                            $seviceZones = ServiceType::where('id', $serviceList->service_id)->get(['zones'])->first();
                            if (isset($serviceList->zones)) {
                                $serviceList->zones = $seviceZones->zones;
                            }
                        }
    
                        if (isset($serviceList->zones) && ($serviceList->zones != 'all' || $serviceList->zones != '')) {
                            $serviceZones = unserialize($serviceList->zones);
                        }

                        if (Setting::get('zone_inbound_force', "0") == "1") {
                            $serviceList->inbound = $inbound;
                        }
                    }
                    /** End getting inbound */

                    if (Setting::get('negotiation_module', '0') == 1) {

                        $negotiation_type = Setting::get('negotiation_type', 0);
                        $negotiation_min_threshold = Setting::get('negotiation_min_threshold', 0);
                        $negotiation_max_threshold = Setting::get('negotiation_max_threshold', 0);

                        if ($negotiation_type == 'percentage') {
                            $serviceList->estimated_max_value = $serviceList->eta_total + ($serviceList->eta_total * ($negotiation_max_threshold / 100));
                            $minValue = ($serviceList->eta_total * ($negotiation_min_threshold / 100));
                            // if ($minValue <= 0) {
                            //     $minValue = $serviceList->eta_total;
                            // }
                            $serviceList->estimated_min_value = $serviceList->eta_total - ($minValue);

                            $difference = $serviceList->eta_total * ($negotiation_max_threshold / 100);
                            $difference_part = $difference / 3;
                            $counter_offer_one = $serviceList->eta_total + $difference_part;
                            $counter_offer_two = $counter_offer_one + $difference_part;
                            $counter_offer_three = $counter_offer_two + $difference_part;

                            $serviceList->counter_offer_one = $counter_offer_one;
                            $serviceList->counter_offer_two = $counter_offer_two;
                            $serviceList->counter_offer_three = $counter_offer_three;
                        } else {
                            $serviceList->estimated_max_value = $serviceList->eta_total + ($negotiation_max_threshold);
                            $minValue = ($negotiation_min_threshold);
                            if ($minValue <= 0 || $minValue >= $serviceList->eta_total) {
                                $minValue = $serviceList->eta_total;
                            } else {
                                $minValue = $serviceList->eta_total - ($minValue);
                            }
                            $serviceList->estimated_min_value = ($minValue);

                            $difference = $negotiation_max_threshold;
                            $difference_part = $difference / 3;
                            $counter_offer_one = $serviceList->eta_total + $difference_part;
                            $counter_offer_two = $counter_offer_one + $difference_part;
                            $counter_offer_three = $counter_offer_two + $difference_part;

                            $serviceList->counter_offer_one = $counter_offer_one;
                            $serviceList->counter_offer_two = $counter_offer_two;
                            $serviceList->counter_offer_three = $counter_offer_three;
                        }

                        if ($serviceList->is_free == 1) {
                            $serviceCloneMetered = clone $serviceList;
                            $serviceCloneMetered->request_category = 'Free';
                            array_push($servicesArrayMetered, $serviceCloneMetered);
                            $serviceList->request_category = 'Normal';
                            array_push($servicesArrayNormal, $serviceList);
                        } else {
                            $serviceList->request_category = 'Normal';
                            array_push($servicesArrayNormal, $serviceList);
                        }
                    } else if (Setting::get('zone_metering', '0') == 1) {
                        if ($inbound == false) {
                            $serviceCloneMetered = clone $serviceList;
                            $serviceCloneMetered->request_category = 'Metered';
                            array_push($servicesArrayMetered, $serviceCloneMetered);
                        } else {
                            $serviceCloneMetered = clone $serviceList;
                            $serviceCloneMetered->request_category = 'Metered';
                            array_push($servicesArrayMetered, $serviceCloneMetered);
                            // $serviceCloneNormal = clone $serviceList;
                            $serviceList->request_category = 'Normal';
                            array_push($servicesArrayNormal, $serviceList);
                        }
                    } else if (Setting::get('service_metering', '0') == 1) {
                        $serviceCloneMetered = clone $serviceList;
                        $serviceCloneMetered->request_category = 'Metered';
                        array_push($servicesArrayMetered, $serviceCloneMetered);
                        $serviceList->request_category = 'Normal';
                        array_push($servicesArrayNormal, $serviceList);
                    } else {
                        if ($service_type->calculator == 'METERING') {
                            $serviceList->request_category = 'Metered';
                            array_push($servicesArrayNormal, $serviceList);
                        } else {
                            if ($serviceList->is_free == 1) {
                                $serviceCloneMetered = clone $serviceList;
                                $serviceCloneMetered->request_category = 'Free';
                                array_push($servicesArrayMetered, $serviceCloneMetered);
                                $serviceList->request_category = 'Normal';
                                array_push($servicesArrayNormal, $serviceList);
                            } else {
                                $serviceList->request_category = 'Normal';
                                array_push($servicesArrayNormal, $serviceList);
                            }
                            
                        }
                    }
                }

                // $kilometerArray['1'] = $kilometer1;
                // $kilometerArray['2'] = $kilometer2;
                // $kilometerArray['3'] = $kilometer3;
                // $kilometerArray['4'] = $kilometer4;
                // return $kilometerArray;

                $servicesArrayResponse = array_merge($servicesArrayNormal, $servicesArrayMetered);

                // foreach($servicesArrayResponse as $serviceResponse) {
                //     $serviceResponse->id = $serviceResponse->service_id;
                // }

                return $servicesArrayResponse;

            } else {
                return [];
                // return response()->json(['error' => trans('api.services_not_found')], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong') . ' | ' . $loopIndex , 'stack' => $e->getMessage()], 500);
        }
    }

    /**
     * Get the services listing.
     *
     * @return Response
     */

    public function servicesWithEstimateOld(Request $request)
    {
        $loopIndex = 0;
        try {

            $servicesArray = [];
            $servicesArrayResponse = [];
            $servicesArrayNormal = [];
            $servicesArrayMetered = [];
            
            $s_latitude = $request->s_latitude;
            $s_longitude = $request->s_longitude;
            $d_latitude = $request->d_latitude;
            $d_longitude = $request->d_longitude;

            $serviceTypeController = new ServiceTypeController();
            $types = $serviceTypeController->getActiveServicesTypes();
            $zoneList = $serviceTypeController->isZoneListExists($s_latitude, $s_longitude);
            $geoFencingController = new GeoFencingController();
            $currentZone = null;
            if (Setting::get('zone_module', "0") == "1" || Setting::get('zone_inbound_force', "0") == "1") {
                $currentZone = $geoFencingController->getZone($s_latitude, $s_longitude);
            }

            /**
             * Checking the services region
             */
            $inbound = false;
            if (Setting::get('zone_module', "0") == "1") {
                $servicesList = [];
                if (Setting::get('zone_inbound_force', "0") == "1") {
                    $inbound = $serviceTypeController->getServiceZoneInbound($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                    if (!$inbound) {
                        return [];
                    }
                    //Todo: handle this case of else
                } else {
                    $servicesList = $serviceTypeController->getAllServiceTypes($s_latitude, $s_longitude, $request);
                }
            } else {
                $servicesList = $serviceTypeController->getAllServiceTypes($s_latitude, $s_longitude, $request);
            }

            if ($servicesList) {
                foreach ($servicesList as $index => $serviceList) {
                    $loopIndex = $index;
                    // if ($loopIndex == 8) {
                    //     dd($serviceList);
                    // }
                    if ($s_latitude != null && $s_longitude != null && $d_latitude != null && $d_longitude != null) {
            
                        $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                        
                        $meter = $googleDistanceAndTime['distanceValue'];
                        $seconds = $googleDistanceAndTime['durationValue'];
                        $time = $googleDistanceAndTime['durationText'];
                        $origin_address = $googleDistanceAndTime['originAddress'];
                        $destination_address = $googleDistanceAndTime['destinationAddress'];
                        $kilometer = Helper::applyDistanceSystem($meter);
                        $minutes = $seconds / 60;
                        $hours = $seconds / 3600;
                        
                        if (Setting::get('zone_module', "0") == "1") {
                            if ($currentZone != null) {
                                $serviceList->id = $serviceList->service_id;
                                $serviceList->zone_id = $currentZone->id;
                            }
                        }

                        $service_type_id = $serviceList->id;
                        $service_type = $serviceTypeController->getServiceType($service_type_id, $s_latitude, $s_longitude);
                        
                        $extra_amount_percentage = Setting::get('extra_amount_percentage', '100');
                        $price = $service_type->fixed;
                        $phourfrom = $service_type->phourfrom;
                        $phourto = $service_type->phourto;
                        $pextra = $service_type->pextra == null ? 0 : $service_type->pextra;
                        $base_distance = $service_type->distance;
                        $kilometer0 = $base_distance;
                        // $base_price = $base_distance > 0 ? $price : 0; //TODO: for handling base price with distance
                        $base_price = $price;
                        $finalprice = 0;
                        $isextraprice = 0;
                        $extraprice = 0;
                        $vweight = $request->vweight ? $request->vweight : 0;

                        $schedule_date = null;
                        $schedule_time = null;
                        $schedule_web = null;
                        if ($request->has('schedule_web')  && $request->schedule_web == 'yes') {
                            $schedule_web = $request->schedule_web;
                        }

                        if ($request->has('schedule_date') && $request->has('schedule_time')) {
                            $schedule_date = $request->schedule_date;
                            $schedule_time = $request->schedule_time;
                        }

                        $calculationData = $this->calculatePricingWithServiceType($service_type, $schedule_date, $schedule_time, $schedule_web, $kilometer, $seconds, $origin_address, $destination_address, $s_latitude, $s_longitude, $vweight);

                        $ridePrice = $calculationData['ridePrice'];
                        $price = $calculationData['price'];
                        $peakActive = $calculationData['peakActive'];
                        $peakValue = $calculationData['peakValue'];
                        $peakPrice = $calculationData['peakPrice'];
                        $peakType = $calculationData['peakType'];
                        $surgeActive = $calculationData['surgeActive'];
                        $surgePrice = $calculationData['surgePrice'];
                        $surgePercentage = $calculationData['surge_percentage'];
                        $bookingFeeActive = $calculationData['bookingFeeActive'];
                        $bookingFeeAmount = $calculationData['bookingFeeAmount'];
                        $commission_tax_apply = $calculationData['commission_tax_apply'];
                        $commission_type = $calculationData['commission_type'];
                        $commission_percentage = $calculationData['commission_percentage'];
                        $commission_deduction = $calculationData['commission_deduction'];
                        $commission_price = $calculationData['commission_price'];
                        $commission_source = $calculationData['commission_source'];
                        $tax_active = $calculationData['tax_active'];
                        $tax_price = $calculationData['tax_price'];
                        $government_charges_active = $calculationData['government_charges_active'];
                        $government_charges = $calculationData['government_charges'];
                        $toll_fee_active = $calculationData['toll_fee_active'];
                        $toll_fee = $calculationData['toll_fee'];
                        $airport_charges_active = $calculationData['airport_charges_active'];
                        $airport_charges = $calculationData['airport_charges'];
                        $total = $calculationData['total'];
                        $grand_total = $calculationData['grand_total'];
                        $isextraprice = $calculationData['isextraprice'];
                        $additionalCharges = $calculationData['additionalCharges'];

                        $serviceList->booking_fee_amount = $bookingFeeAmount;
                        $serviceList->isextraprice = $isextraprice;
                        
                        // $estimated_fare = $price + $additionalCharges;
                        $serviceList->peak_active = (int) $peakActive;
                        $serviceList->estimated_fare = Helper::customRoundtoMultiple($total, 2);
                        $serviceList->tax_price = Helper::customRoundtoMultiple($tax_price, 2);
                        $serviceList->eta_total = Helper::customRoundtoMultiple($grand_total, 2);
                        $serviceList->eta_total_cash = Helper::customRoundtoMultiple($total, 2);
                        $serviceList->total = Helper::customRoundtoMultiple($grand_total, 2);

                        // $serviceList->finalprice = Helper::customRoundtoMultiple($finalprice, 2);
                        // $serviceList->tier = Helper::customRoundtoMultiple($tier, 2);
                        // $serviceList->peak = Helper::customRoundtoMultiple($total, 2);
                    }

                    /**
                     * Start getting inbound
                     */
                    if (Setting::get('zone_module', "0") == "1") {
                        if ($zoneList == true) {
                            $seviceZones = ServiceType::where('id', $serviceList->service_id)->get(['zones'])->first();
                            if (isset($serviceList->zones)) {
                                $serviceList->zones = $seviceZones->zones;
                            }
                        }
    
                        if (isset($serviceList->zones) && ($serviceList->zones != 'all' || $serviceList->zones != '')) {
                            $serviceZones = unserialize($serviceList->zones);
                        }

                        if (Setting::get('zone_inbound_force', "0") == "1") {
                            $serviceList->inbound = $inbound;
                        }
                    }
                    /** End getting inbound */

                    if (Setting::get('negotiation_module', '0') == 1) {

                        $negotiation_type = Setting::get('negotiation_type', 0);
                        $negotiation_min_threshold = Setting::get('negotiation_min_threshold', 0);
                        $negotiation_max_threshold = Setting::get('negotiation_max_threshold', 0);

                        if ($negotiation_type == 'percentage') {
                            $serviceList->estimated_max_value = $serviceList->eta_total + ($serviceList->eta_total * ($negotiation_max_threshold / 100));
                            $minValue = ($serviceList->eta_total * ($negotiation_min_threshold / 100));
                            // if ($minValue <= 0) {
                            //     $minValue = $serviceList->eta_total;
                            // }
                            $serviceList->estimated_min_value = $serviceList->eta_total - ($minValue);

                            $difference = $serviceList->eta_total * ($negotiation_max_threshold / 100);
                            $difference_part = $difference / 3;
                            $counter_offer_one = $serviceList->eta_total + $difference_part;
                            $counter_offer_two = $counter_offer_one + $difference_part;
                            $counter_offer_three = $counter_offer_two + $difference_part;

                            $serviceList->counter_offer_one = $counter_offer_one;
                            $serviceList->counter_offer_two = $counter_offer_two;
                            $serviceList->counter_offer_three = $counter_offer_three;
                        } else {
                            $serviceList->estimated_max_value = $serviceList->eta_total + ($negotiation_max_threshold);
                            $minValue = ($negotiation_min_threshold);
                            if ($minValue <= 0 || $minValue >= $serviceList->eta_total) {
                                $minValue = $serviceList->eta_total;
                            } else {
                                $minValue = $serviceList->eta_total - ($minValue);
                            }
                            $serviceList->estimated_min_value = ($minValue);

                            $difference = $negotiation_max_threshold;
                            $difference_part = $difference / 3;
                            $counter_offer_one = $serviceList->eta_total + $difference_part;
                            $counter_offer_two = $counter_offer_one + $difference_part;
                            $counter_offer_three = $counter_offer_two + $difference_part;

                            $serviceList->counter_offer_one = $counter_offer_one;
                            $serviceList->counter_offer_two = $counter_offer_two;
                            $serviceList->counter_offer_three = $counter_offer_three;
                        }

                        if ($serviceList->is_free == 1) {
                            $serviceCloneMetered = clone $serviceList;
                            $serviceCloneMetered->request_category = 'Free';
                            array_push($servicesArrayMetered, $serviceCloneMetered);
                            $serviceList->request_category = 'Normal';
                            array_push($servicesArrayNormal, $serviceList);
                        } else {
                            $serviceList->request_category = 'Normal';
                            array_push($servicesArrayNormal, $serviceList);
                        }
                    } else if (Setting::get('zone_metering', '0') == 1) {
                        if ($inbound == false) {
                            $serviceCloneMetered = clone $serviceList;
                            $serviceCloneMetered->request_category = 'Metered';
                            array_push($servicesArrayMetered, $serviceCloneMetered);
                        } else {
                            $serviceCloneMetered = clone $serviceList;
                            $serviceCloneMetered->request_category = 'Metered';
                            array_push($servicesArrayMetered, $serviceCloneMetered);
                            // $serviceCloneNormal = clone $serviceList;
                            $serviceList->request_category = 'Normal';
                            array_push($servicesArrayNormal, $serviceList);
                        }
                    } else if (Setting::get('service_metering', '0') == 1) {
                        $serviceCloneMetered = clone $serviceList;
                        $serviceCloneMetered->request_category = 'Metered';
                        array_push($servicesArrayMetered, $serviceCloneMetered);
                        $serviceList->request_category = 'Normal';
                        array_push($servicesArrayNormal, $serviceList);
                    } else {
                        if ($service_type->calculator == 'METERING') {
                            $serviceList->request_category = 'Metered';
                            array_push($servicesArrayNormal, $serviceList);
                        } else {
                            if ($serviceList->is_free == 1) {
                                $serviceCloneMetered = clone $serviceList;
                                $serviceCloneMetered->request_category = 'Free';
                                array_push($servicesArrayMetered, $serviceCloneMetered);
                                $serviceList->request_category = 'Normal';
                                array_push($servicesArrayNormal, $serviceList);
                            } else {
                                $serviceList->request_category = 'Normal';
                                array_push($servicesArrayNormal, $serviceList);
                            }
                            
                        }
                    }
                }

                // $kilometerArray['1'] = $kilometer1;
                // $kilometerArray['2'] = $kilometer2;
                // $kilometerArray['3'] = $kilometer3;
                // $kilometerArray['4'] = $kilometer4;
                // return $kilometerArray;

                $servicesArrayResponse = array_merge($servicesArrayNormal, $servicesArrayMetered);

                // foreach($servicesArrayResponse as $serviceResponse) {
                //     $serviceResponse->id = $serviceResponse->service_id;
                // }

                return $servicesArrayResponse;

            } else {
                return [];
                // return response()->json(['error' => trans('api.services_not_found')], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong') . ' | ' . $loopIndex , 'stack' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function services(Request $request)
    {
        $types = [];
        $serviceTypeController = new ServiceTypeController();
        $types = $serviceTypeController->getActiveServicesTypes($request);

        $servicesList = $this->getServicesWithMultiLanguage($types, $request);

        $filteredServicesList = $servicesList->map(function($service) {
            $service->name = $service->translations[0]->name;
            $service->description = $service->translations[0]->description;
            unset($service->translations);
            return $service;
        });
        
        return $filteredServicesList;
     
    }

    public function getServicesWithMultiLanguage($type, $request){
        $language_id = getLanguageIdFromApis($request);
        $default_language_id = getDefautlLanguage();

        $servicesList = ServiceType::whereHas('translations', function($query) use($language_id) {
            $query->where('language_id', $language_id);
        })
        ->with(['translations' => function($query) use($language_id) {
            $query->where('language_id', $language_id);
        }])
        ->whereIn('type', $type)
                ->get();

        if ($servicesList->isEmpty()) {
            $servicesList = ServiceType::whereHas('translations', function($query) use($default_language_id) {
                        $query->where('language_id', $default_language_id);
                    })
                    ->with(['translations' => function($query) use($default_language_id) {
                        $query->where('language_id', $default_language_id);
                    }])
                    ->whereIn('type', $type)
                    ->get();
        }

        // Get only the first translation if it exists
        $servicesList->each(function ($service) {
            if ($service->translations->isNotEmpty()) {
                $service->setRelation('translations', $service->translations->take(1));
            }
        });

        return $servicesList;
    }

    public function getServicesWithMultiLanguageAndByServiceTypeId($service_type_id, $request)
    {
        $language_id = getLanguageIdFromApis($request);
        $default_language_id = getDefautlLanguage();

        $service = ServiceType::whereHas('translations', function ($query) use ($language_id) {
            $query->where('language_id', $language_id);
        })
        ->with(['translations' => function ($query) use ($language_id) {
            $query->where('language_id', $language_id);
        }])
        ->find($service_type_id);

        if (is_null($service)) {
            $service = ServiceType::whereHas('translations', function ($query) use ($default_language_id) {
                $query->where('language_id', $default_language_id);
            })
            ->with(['translations' => function ($query) use ($default_language_id) {
                $query->where('language_id', $default_language_id);
            }])
            ->find($service_type_id);
        }
        
        if(!is_null($service)){
            $service->name = $service->translations[0]->name;
            $service->description = $service->translations[0]->description;
            unset($service->translations);
        }
        return $service;
    }

    
     public function calculatePricingWithServiceType($service_type, $schedule_date, $schedule_time, $schedule_web, $kilometer, $seconds, $origin_address, $destination_address, $s_latitude, $s_longitude, $vweight) {
        try {
            $dataArray = [];

            $serviceTypeController = new ServiceTypeController();
            $peakActive = false;
            $isextraprice = 0;
            $isInPeakDays = $serviceTypeController->isInPeakDays($service_type, $schedule_date, $schedule_time, $schedule_web);
            $isInPeakTime = $serviceTypeController->isInPeakTime($service_type, $schedule_date, $schedule_time, $schedule_web);
            if (($isInPeakDays) || ($isInPeakTime)) {
                // return response()->json(['status' => true, 'message' => 'Service Type is Peak']);
                if ($service_type->peak_percentage == 1 || $service_type->peak_percentage == "1" || $service_type->peak_fixed_pricing == 1 || $service_type->peak_fixed_pricing == "1") {
                    $peakActive = true;
                    $isextraprice = 1;
                }

                $price = $serviceTypeController->getCalculatedPrice($service_type, $kilometer, $seconds, $vweight, $peakActive);
                $return_price = $serviceTypeController->getCalculatedReturnPrice($service_type, $kilometer, $seconds, $vweight, $peakActive);
            } else {
                // return response()->json(['status' => true, 'message' => 'Service Type is Normal']);
            $price = $serviceTypeController->getCalculatedPrice($service_type, $kilometer, $seconds, $vweight, $peakActive);
            $return_price = $serviceTypeController->getCalculatedReturnPrice($service_type, $kilometer, $seconds, $vweight, $peakActive);
            }

            $ridePrice = $price;
            $rideReturnPrice = $return_price;

            $peakDetail = $serviceTypeController->getPeakPrice($service_type, $price, $peakActive);
           
            $peakValue = $peakDetail['peakValue'];
            $peakActive = $peakDetail['peakActive'];
            $peakPrice = $peakDetail['peakPrice'];
            $peakType = $peakDetail['peakType'];
            $price += $peakPrice;

            $peakReturnDetail = $serviceTypeController->getPeakPrice($service_type, $return_price, $peakActive);
            $peakReturnValue = $peakReturnDetail['peakValue'];
            $peakReturnActive = $peakReturnDetail['peakActive'];
            $peakReturnPrice = $peakReturnDetail['peakPrice'];
            $peakReturnType = $peakReturnDetail['peakType'];
            $return_price += $peakReturnPrice;

            $price = $serviceTypeController->applyLocationPrice($price, $origin_address, $destination_address);
            $return_price = $serviceTypeController->applyLocationPrice($return_price, $origin_address, $destination_address);

            $surgeDetail = $serviceTypeController->getSurge($service_type, $price, $s_latitude, $s_longitude);
            $surgeActive = $surgeDetail['surgeActive'];
            $surgePrice = $surgeDetail['surgePrice'];
            $surgePercentage = $surgeDetail['surge_percentage'];
            $price += $surgePrice;

            $surgeReturnDetail = $serviceTypeController->getSurge($service_type, $return_price, $s_latitude, $s_longitude);
            $surgeReturnActive = $surgeReturnDetail['surgeActive'];
            $surgeReturnPrice = $surgeReturnDetail['surgePrice'];
            $surgeReturnPercentage = $surgeReturnDetail['surge_percentage'];
            $return_price += $surgeReturnPrice;

            $bookingFeeDetail = $serviceTypeController->getBookingPrice($service_type);
            $bookingFeeActive = $bookingFeeDetail['bookingFeeActive'];
            $bookingFeeAmount = $bookingFeeDetail['bookingFeeAmount'];
            $price += $bookingFeeAmount;
            $return_price += $bookingFeeAmount;
            
            //TODO: we'll discuss this later to apply commission on which price
            $commissionDetail = $serviceTypeController->getCommissionPrice($service_type, $price);
            $commission_tax_apply = $commissionDetail['commission_tax_apply'];
            $commission_type = $commissionDetail['commission_type'];
            $commission_percentage = $commissionDetail['commission_percentage'];
            $commission_deduction = $commissionDetail['commission_deduction'];
            $commission_price = $commissionDetail['commission_price'];
            $commission_source = $commissionDetail['commission_source'];
            $price += $commission_price;

            $commissionReturnDetail = $serviceTypeController->getCommissionPrice($service_type, $return_price);
            $commission_return_tax_apply = $commissionReturnDetail['commission_tax_apply'];
            $commission_return_type = $commissionReturnDetail['commission_type'];
            $commission_return_percentage = $commissionReturnDetail['commission_percentage'];
            $commission_return_deduction = $commissionReturnDetail['commission_deduction'];
            $commission_return_price = $commissionReturnDetail['commission_price'];
            $commission_return_source = $commissionReturnDetail['commission_source'];
            $return_price += $commission_return_price;

            $taxDetail = $serviceTypeController->getTaxPrice($service_type, $price);
            $tax_active = $taxDetail['tax_active'];
            $tax_percentage = $taxDetail['tax_percentage'];
            $tax_price = $taxDetail['tax_price'];

            $taxDetailReturn = $serviceTypeController->getTaxPrice($service_type, $return_price);
            $tax_return_active = $taxDetailReturn['tax_active'];
            $tax_return_percentage = $taxDetailReturn['tax_percentage'];
            $return_tax_price = $taxDetailReturn['tax_price'];

            $governmentChargesDetail = $serviceTypeController->getGovernmentCharges($service_type, $price);
            $government_charges_active = $governmentChargesDetail['government_charges_active'];
            $government_charges = $governmentChargesDetail['government_charges'];

            $tollFeeDetail = $serviceTypeController->getTollFee();
            $toll_fee_active = $tollFeeDetail['toll_fee_active'];
            $toll_fee = $tollFeeDetail['toll_fee'];

            $airportChargesDetail = $serviceTypeController->getAirportCharges();
            $airport_charges_active = $airportChargesDetail['airport_charges_active'];
            $airport_charges = $airportChargesDetail['airport_charges'];

            $additionalCharges = $government_charges + $toll_fee + $airport_charges;
            $price += $additionalCharges;
            $return_price += $additionalCharges;

            $total = $price + $tax_price;
            $return_total = $return_price + $return_tax_price;

            $bankChargesDetail = $serviceTypeController->getBankCharges($service_type, $price);
            $bank_charges_active = $bankChargesDetail['bank_charges_active'];
            $bank_charges_type = $bankChargesDetail['bank_charges_type'];
            $bank_charges_value = $bankChargesDetail['bank_charges_value'];
            $bank_charges_amount = $bankChargesDetail['bank_charges_amount'];
            $grand_total = $total + $bank_charges_amount;

            $bankChargesReturnDetail = $serviceTypeController->getBankCharges($service_type, $return_price);
            $bank_charges_return_active = $bankChargesReturnDetail['bank_charges_active'];
            $bank_charges_return_type = $bankChargesReturnDetail['bank_charges_type'];
            $bank_charges_return_value = $bankChargesReturnDetail['bank_charges_value'];
            $bank_charges_return_amount = $bankChargesReturnDetail['bank_charges_amount'];
            $grand_return_total = $return_total + $bank_charges_return_amount;

            $dataArray['ridePrice'] = $ridePrice;
            $dataArray['rideReturnPrice'] = $rideReturnPrice;
            $dataArray['price'] = $price;
            $dataArray['return_price'] = $return_price;

            $dataArray['peakActive'] = $peakActive;
            $dataArray['peakValue'] = $peakValue;
            $dataArray['peakPrice'] = $peakPrice;
            $dataArray['peakType'] = $peakType;

            $dataArray['peakReturnActive'] = $peakReturnActive;
            $dataArray['peakReturnValue'] = $peakReturnValue;
            $dataArray['peakReturnPrice'] = $peakReturnPrice;
            $dataArray['peakReturnType'] = $peakReturnType;

            $dataArray['surgeActive'] = $surgeActive;
            $dataArray['surgePrice'] = $surgePrice;
            $dataArray['surge_percentage'] = $surgePercentage;

            $dataArray['surgeReturnActive'] = $surgeReturnActive;
            $dataArray['surgeReturnPrice'] = $surgeReturnPrice;
            $dataArray['surge_return_percentage'] = $surgeReturnPercentage;

            $dataArray['bookingFeeActive'] = $bookingFeeActive;
            $dataArray['bookingFeeAmount'] = $bookingFeeAmount;

            $dataArray['commission_tax_apply'] = $commission_tax_apply;
            $dataArray['commission_type'] = $commission_type;
            $dataArray['commission_percentage'] = $commission_percentage;
            $dataArray['commission_deduction'] = $commission_deduction;
            $dataArray['commission_price'] = $commission_price;
            $dataArray['commission_source'] = $commission_source;

            $dataArray['commission_return_tax_apply'] = $commission_return_tax_apply;
            $dataArray['commission_return_type'] = $commission_return_type;
            $dataArray['commission_return_percentage'] = $commission_return_percentage;
            $dataArray['commission_return_deduction'] = $commission_return_deduction;
            $dataArray['commission_return_price'] = $commission_return_price;
            $dataArray['commission_return_source'] = $commission_return_source;

            $dataArray['tax_active'] = $tax_active;
            $dataArray['tax_percentage'] = $tax_percentage;
            $dataArray['tax_price'] = $tax_price;

            $dataArray['tax_return_active'] = $tax_return_active;
            $dataArray['tax_return_percentage'] = $tax_return_percentage;
            $dataArray['return_tax_price'] = $return_tax_price;

            $dataArray['airport_charges_active'] = $airport_charges_active;
            $dataArray['airport_charges'] = $airport_charges;

            $dataArray['toll_fee_active'] = $toll_fee_active;
            $dataArray['toll_fee'] = $toll_fee;

            $dataArray['government_charges_active'] = $government_charges_active;
            $dataArray['government_charges'] = $government_charges;

            $dataArray['total'] = $total;
            $dataArray['return_total'] = $return_total;
            $dataArray['grand_total'] = $grand_total;
            $dataArray['grand_return_total'] = $grand_return_total;

            $dataArray['bank_charges_active'] = $bank_charges_active;
            $dataArray['bank_charges_type'] = $bank_charges_type;
            $dataArray['bank_charges_value'] = $bank_charges_value;
            $dataArray['bank_charges_amount'] = $bank_charges_amount;
            
            $dataArray['bank_charges_return_active'] = $bank_charges_return_active;
            $dataArray['bank_charges_return_type'] = $bank_charges_return_type;
            $dataArray['bank_charges_return_value'] = $bank_charges_return_value;
            $dataArray['bank_charges_return_amount'] = $bank_charges_return_amount;

            $dataArray['isextraprice'] = $isextraprice;
            $dataArray['additionalCharges'] = $additionalCharges;

            return $dataArray;
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong'), 'detail' => $e->getMessage()], 500);
        }
    }

    public function calculatePricingWithServiceTypeOld($service_type, $schedule_date, $schedule_time, $schedule_web, $kilometer, $seconds, $origin_address, $destination_address, $s_latitude, $s_longitude, $vweight) {
        try {
            $dataArray = [];

            $serviceTypeController = new ServiceTypeController();
            $peakActive = false;
            $isextraprice = 0;
            $isInPeakDays = $serviceTypeController->isInPeakDays($service_type, $schedule_date, $schedule_time, $schedule_web);
            $isInPeakTime = $serviceTypeController->isInPeakTime($service_type, $schedule_date, $schedule_time, $schedule_web);
            if (($isInPeakDays) || ($isInPeakTime)) {
                // return response()->json(['status' => true, 'message' => 'Service Type is Peak']);
                if ($service_type->peak_percentage == 1 || $service_type->peak_percentage == "1" || $service_type->peak_fixed_pricing == 1 || $service_type->peak_fixed_pricing == "1") {
                    $peakActive = true;
                    $isextraprice = 1;
                }

                $price = $serviceTypeController->getCalculatedPrice($service_type, $kilometer, $seconds, $vweight, $peakActive);
            } else {
                // return response()->json(['status' => true, 'message' => 'Service Type is Normal']);
            $price = $serviceTypeController->getCalculatedPrice($service_type, $kilometer, $seconds, $vweight, $peakActive);
            }

            $ridePrice = $price;

            $peakDetail = $serviceTypeController->getPeakPrice($service_type, $price, $peakActive);
            $peakValue = $peakDetail['peakValue'];
            $peakActive = $peakDetail['peakActive'];
            $peakPrice = $peakDetail['peakPrice'];
            $peakType = $peakDetail['peakType'];
            $price += $peakPrice;

            $price = $serviceTypeController->applyLocationPrice($price, $origin_address, $destination_address);

            $surgeDetail = $serviceTypeController->getSurge($service_type, $price, $s_latitude, $s_longitude);
            $surgeActive = $surgeDetail['surgeActive'];
            $surgePrice = $surgeDetail['surgePrice'];
            $surgePercentage = $surgeDetail['surge_percentage'];
            $price += $surgePrice;

            $bookingFeeDetail = $serviceTypeController->getBookingPrice($service_type);
            $bookingFeeActive = $bookingFeeDetail['bookingFeeActive'];
            $bookingFeeAmount = $bookingFeeDetail['bookingFeeAmount'];
            $price += $bookingFeeAmount;
            
            //TODO: we'll discuss this later to apply commission on which price
            $commissionDetail = $serviceTypeController->getCommissionPrice($service_type, $price);
            $commission_tax_apply = $commissionDetail['commission_tax_apply'];
            $commission_type = $commissionDetail['commission_type'];
            $commission_percentage = $commissionDetail['commission_percentage'];
            $commission_deduction = $commissionDetail['commission_deduction'];
            $commission_price = $commissionDetail['commission_price'];
            $commission_source = $commissionDetail['commission_source'];
            $price += $commission_price;

            $taxDetail = $serviceTypeController->getTaxPrice($service_type, $price);
            $tax_active = $taxDetail['tax_active'];
            $tax_percentage = $taxDetail['tax_percentage'];
            $tax_price = $taxDetail['tax_price'];

            $governmentChargesDetail = $serviceTypeController->getGovernmentCharges($service_type, $price);
            $government_charges_active = $governmentChargesDetail['government_charges_active'];
            $government_charges = $governmentChargesDetail['government_charges'];

            $tollFeeDetail = $serviceTypeController->getTollFee();
            $toll_fee_active = $tollFeeDetail['toll_fee_active'];
            $toll_fee = $tollFeeDetail['toll_fee'];

            $airportChargesDetail = $serviceTypeController->getAirportCharges();
            $airport_charges_active = $airportChargesDetail['airport_charges_active'];
            $airport_charges = $airportChargesDetail['airport_charges'];

            $additionalCharges = $government_charges + $toll_fee + $airport_charges;
            $price += $additionalCharges;

            $total = $price + $tax_price;

            $bankChargesDetail = $serviceTypeController->getBankCharges($service_type, $price);
            $bank_charges_active = $bankChargesDetail['bank_charges_active'];
            $bank_charges_type = $bankChargesDetail['bank_charges_type'];
            $bank_charges_value = $bankChargesDetail['bank_charges_value'];
            $bank_charges_amount = $bankChargesDetail['bank_charges_amount'];

            $grand_total = $total + $bank_charges_amount;

            $dataArray['ridePrice'] = $ridePrice;
            $dataArray['price'] = $price;

            $dataArray['peakActive'] = $peakActive;
            $dataArray['peakValue'] = $peakValue;
            $dataArray['peakPrice'] = $peakPrice;
            $dataArray['peakType'] = $peakType;

            $dataArray['surgeActive'] = $surgeActive;
            $dataArray['surgePrice'] = $surgePrice;
            $dataArray['surge_percentage'] = $surgePercentage;

            $dataArray['bookingFeeActive'] = $bookingFeeActive;
            $dataArray['bookingFeeAmount'] = $bookingFeeAmount;

            $dataArray['commission_tax_apply'] = $commission_tax_apply;
            $dataArray['commission_type'] = $commission_type;
            $dataArray['commission_percentage'] = $commission_percentage;
            $dataArray['commission_deduction'] = $commission_deduction;
            $dataArray['commission_price'] = $commission_price;
            $dataArray['commission_source'] = $commission_source;

            $dataArray['tax_active'] = $tax_active;
            $dataArray['tax_percentage'] = $tax_percentage;
            $dataArray['tax_price'] = $tax_price;

            $dataArray['airport_charges_active'] = $airport_charges_active;
            $dataArray['airport_charges'] = $airport_charges;

            $dataArray['toll_fee_active'] = $toll_fee_active;
            $dataArray['toll_fee'] = $toll_fee;

            $dataArray['government_charges_active'] = $government_charges_active;
            $dataArray['government_charges'] = $government_charges;

            $dataArray['total'] = $total;
            $dataArray['grand_total'] = $grand_total;

            $dataArray['bank_charges_active'] = $bank_charges_active;
            $dataArray['bank_charges_type'] = $bank_charges_type;
            $dataArray['bank_charges_value'] = $bank_charges_value;
            $dataArray['bank_charges_amount'] = $bank_charges_amount;

            $dataArray['isextraprice'] = $isextraprice;
            $dataArray['additionalCharges'] = $additionalCharges;

            return $dataArray;
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong'), 'detail' => $e->getMessage()], 500);
        }
    }

    public function estimated_fare_calculation($s_latitude, $s_longitude, $d_latitude, $d_longitude, $service_type_id, $schedule_date = null, $schedule_time = null, $schedule_web = null, $vweight = null)
    {
        try {

            $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
            
            $meter = $googleDistanceAndTime['distanceValue'];
            $seconds = $googleDistanceAndTime['durationValue'];
            $time = $googleDistanceAndTime['durationText'];
            $origin_address = $googleDistanceAndTime['originAddress'];
            $destination_address = $googleDistanceAndTime['destinationAddress'];
            $kilometer = Helper::applyDistanceSystem($meter);
            $minutes = $seconds / 60;
            $hours = $seconds / 3600;
            $serviceTypeController = new ServiceTypeController();
            $geoFencingController = new GeoFencingController();

            $service_type = $serviceTypeController->getServiceType($service_type_id, $s_latitude, $s_longitude);

            $extra_amount_percentage = Setting::get('extra_amount_percentage', '100');
            $price = $service_type->fixed;
            $phourfrom = $service_type->phourfrom;
            $phourto = $service_type->phourto;
            $pextra = $service_type->pextra == null ? 0 : $service_type->pextra;
            $base_distance = $service_type->distance;
            $kilometer0 = $base_distance;
            // $base_price = $base_distance > 0 ? $price : 0; //TODO: for handling base price with distance
            $base_price = $price;
            $finalprice = 0;
            $isextraprice = 0;
            $extraprice = 0;

            $calculationData = $this->calculatePricingWithServiceType($service_type, $schedule_date, $schedule_time, $schedule_web, $kilometer, $seconds, $origin_address, $destination_address, $s_latitude, $s_longitude, $vweight);
            






            $ridePrice = $calculationData['ridePrice'];
            $rideReturnPrice = $calculationData['rideReturnPrice'];
            $price = $calculationData['price'];
            $return_price = $calculationData['return_price'];
            $peakActive = $calculationData['peakActive'];
            $peakValue = $calculationData['peakValue'];
            $peakPrice = $calculationData['peakPrice'];
            $peakReturnPrice = $calculationData['peakReturnPrice'];
            $peakType = $calculationData['peakType'];
            $surgeActive = $calculationData['surgeActive'];
            $surgeReturnActive = $calculationData['surgeReturnActive'];
            $surgePrice = $calculationData['surgePrice'];
            $surgeReturnPrice = $calculationData['surgeReturnPrice'];
            $surgePercentage = $calculationData['surge_percentage'];
            $bookingFeeActive = $calculationData['bookingFeeActive'];
            $bookingFeeAmount = $calculationData['bookingFeeAmount'];
            $commission_tax_apply = $calculationData['commission_tax_apply'];
            $commission_type = $calculationData['commission_type'];
            $commission_percentage = $calculationData['commission_percentage'];
            $commission_deduction = $calculationData['commission_deduction'];
            $commission_price = $calculationData['commission_price'];
            $commission_return_price = $calculationData['commission_return_price'];
            $commission_source = $calculationData['commission_source'];
            $tax_active = $calculationData['tax_active'];
            $tax_price = $calculationData['tax_price'];
            $return_tax_price = $calculationData['return_tax_price'];
            $government_charges_active = $calculationData['government_charges_active'];
            $government_charges = $calculationData['government_charges'];
            $toll_fee_active = $calculationData['toll_fee_active'];
            $toll_fee = $calculationData['toll_fee'];
            $airport_charges_active = $calculationData['airport_charges_active'];
            $airport_charges = $calculationData['airport_charges'];
            $total = $calculationData['total'];
            $return_total = $calculationData['return_total'];
            $grand_total = $calculationData['grand_total'];
            $grand_return_total = $calculationData['grand_return_total'];
            $isextraprice = $calculationData['isextraprice'];
            $additionalCharges = $calculationData['additionalCharges'];
            $bank_charges_active = $calculationData['bank_charges_active'];
            $bank_charges_type = $calculationData['bank_charges_type'];
            $bank_charges_value = $calculationData['bank_charges_value'];
            $bank_charges_amount = $calculationData['bank_charges_amount'];
            $bank_charges_return_amount = $calculationData['bank_charges_return_amount'];

            $driver_amount = $ridePrice + $peakPrice + $surgePrice;
            $return_driver_amount = $rideReturnPrice + $peakReturnPrice + $surgeReturnPrice;

            if ($service_type && $service_type->calculator == 'HOUR') {
                $estimated_amount_per_hour = $base_price + $service_type->minute * 1; //1 is number of hour
            } else {
                $estimated_amount_per_hour = $total;
            }

            return [
                'surge' => $surgeActive,
                'peakActive' => $peakActive,
                'distance' => Helper::customRoundtoMultiple($kilometer, 2),
                'eta_per_hour' => Helper::customRoundtoMultiple($estimated_amount_per_hour, 2),
                'eta_total' => Helper::customRoundtoMultiple($grand_total, 2),
                'eta_return_total' => Helper::customRoundtoMultiple($grand_return_total, 2),
                'eta_total_cash' => Helper::customRoundtoMultiple($total, 2),
                'eta_return_total_cash' => Helper::customRoundtoMultiple($return_total, 2),
                'driver_amount' => Helper::customRoundtoMultiple($driver_amount, 2),
                'return_driver_amount' => Helper::customRoundtoMultiple($return_driver_amount, 2),
                'ridePrice' => Helper::customRoundtoMultiple($ridePrice, 2),
                'rideReturnPrice' => Helper::customRoundtoMultiple($rideReturnPrice, 2),
            ];
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong'), 'detail' => $e->getMessage()], 500);
        }
    }


    public function update_offer(Request $request)
    {

        try {
            $this->validate($request, [
                'request_id' => 'required|numeric|exists:user_requests,id',
                'client_offer' => 'required|numeric'
            ]);

            $userRequestData = UserRequests::find($request->request_id);
            if ($userRequestData) {
                $userRequestData->amount = $request->client_offer;
                $userRequestData->driver_amount = $request->client_offer;
                $userRequestData->ride_amount = $request->client_offer;
                $userRequestData->client_offer = $request->client_offer;
                $userRequestData->updated_at = Carbon::now();
                $userRequestData->save();

                $deleteOldOffers = RequestOffer::where('request_id', $request->request_id)->delete();

                //Logic 1
                // $offerProviders = RequestOffer::where('request_id', $request->request_id)->pluck('provider_id')->toArray();
                // $deleteOldOffers = RequestOffer::where('request_id', $request->request_id)->delete();
                // if (count($offerProviders) > 0) {
                //     foreach($offerProviders as $provider_id) {
                //         RequestOffer::create([
                //             'request_id' => $request->request_id, 
                //             'provider_id' => $provider_id,
                //             'offer_price' => $request->client_offer,
                //             'is_declined' => 1
                //         ]);
                //     }
                // } else {
                //     RequestOffer::create([
                //         'request_id' => $request->request_id, 
                //         'provider_id' => 0,
                //         'offer_price' => 0,
                //         'is_declined' => 1
                //     ]);
                // }

                //Logic 2
                // $offers = RequestOffer::where('request_id', $request->request_id)->get();
                // foreach($offerProviders as $provider_id) {
                //     $offer->offer_price = $request->client_offer;
                //     $offer->is_declined = 0;
                //     $offer->save();
                // }

                return response()->json(['message' => 'Offer updated successfully!']);
            } else {
                return response()->json(['message' => 'Request not found!'], 400);
            }

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }
    }


    public function send_request(Request $request)
    {
            // dd($request->all());
            $this->validate($request, [
                's_latitude' => 'required|numeric',
                'd_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_longitude' => 'required|numeric',
                'service_type' => 'required|numeric|exists:service_types,id',
                'promo_code' => 'exists:promocodes,promo_code',
                'dont_disturb_user' => 'nullable|boolean',
                'gender_pref_run_time' => 'nullable',
                // 'distance' => 'required|numeric',
                'use_wallet' => 'numeric',
                'payment_mode' => 'required|in:CASH,CARD,PAYPAL',
                // 'gender_pref' => 'required_if:|in:'. Auth::user()->gender_pref,
                // 'card_id' => ['required_if:payment_mode,CARD', 'exists:cards,card_id,user_id,' . Auth::user()->id],
            ]);

         try {
            
            if (Setting::get('instant_booking', 0) == 1) {
                if (UserRequests::where('user_id', Auth::user()->id)->where('status', 'REQUESTED')->count() > 0) {
                    if (Setting::get('multi_job_website', 0) == 0) {
                        if ($request->ajax()) {
                            return response()->json([
                                'message' => 'Job Already Requested',
                                'request_id' => 0,
                                'job_already_requested' => true,
                            ]);
                        } else {
                            return back()->with('flash_error', 'Job Already Requested');
                        }
                    }
                }
            } else {
                $status = ['SEARCHING','ACCEPTED','STARTED','ARRIVED','PICKEDUP'];
                //TODO: Handle schedule job with time
                if (UserRequests::where('user_id', Auth::user()->id)->whereIn('status', $status)->count() > 0) {
                    if (Setting::get('multi_job_website', 0) == 0) {
                        if ($request->ajax()) {
                            return response()->json([
                                'message' => 'Job Already Requested',
                                'request_id' => 0,
                                'job_already_requested' => true,
                            ]);
                        } else {
                            return back()->with('flash_error', 'Job Already Requested');
                        }
                    }
                }
            }

            // Log::info('New Request from User: ' . Auth::user()->id);
            // Log::info('Request Details:', $request->all());

            // $data_array =  array(
            //     "distance"  => url('/')
            // );

            // $make_call = $this->getDistance('POST', 'distance', json_encode($data_array));
            // if (!$make_call) {
            //     if ($request->ajax()) {

            //         return response()->json(['error' => trans('Distance not found.')], 500);

            //     } else {

            //         return redirect('dashboard')->with('flash_error', 'Distance not found.');

            //     }
            // }
            // $response = json_decode($make_call, true);
            // $distance = $response['distance'];
            // if ($distance == 0){
            //     return response()->json(['error' => 'Already request is in progress. Try again later '.  $distance], 500);
            // }

            // $ActiveRequests = UserRequests::PendingRequest(Auth::user()->id)->count();

            // if ($ActiveRequests > 0) {

            //     if ($request->ajax()) {

            //         return response()->json(['error' => trans('api.ride.request_inprogress')], 500);

            //     } else {

            //         return redirect('dashboard')->with('flash_error', 'Already request is in progress. Try again later');

            //     }

            // }

            if ($request->has('schedule_date') && $request->has('schedule_time')) {

                $beforeschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->subHour(1);
                $afterschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->addHour(1);

                $CheckScheduling = UserRequests::where('status', 'SCHEDULED')
                    ->where('user_id', Auth::user()->id)
                    ->whereBetween('schedule_at', [$beforeschedule_time, $afterschedule_time])
                    ->count();
                if (Setting::get('multi_job_website', 0) == 0) {
                    if ($CheckScheduling > 0) {
                        if ($request->ajax()) {
                            return response()->json(['error' => trans('api.ride.request_scheduled')], 500);
                        } else {
                            return redirect('dashboard')->with('flash_error', 'Already request is scheduled on this time.');
                        }
                    }

                }

                $schedule_date = null;
                $schedule_time = null;
                $schedule_web = null;
                if ($request->has('schedule_web')  && $request->schedule_web == 'yes') {
                    $schedule_web = $request->schedule_web;
                }

                if ($request->has('schedule_date') && $request->has('schedule_time')) {
                    $schedule_date = $request->schedule_date;
                    $schedule_time = $request->schedule_time;
                }

                $vweight = 0;
                if (Setting::get('vehicle_weightage', 0) == 1) {
                    $vweight = $request->vweight ? $request->vweight : 0;
                }

                $calculationResult = $this->estimated_fare_calculation($request->s_latitude, $request->s_longitude, $request->d_latitude, $request->d_longitude, $request->service_type, $schedule_date, $schedule_time, $schedule_web, $vweight);
                // return dd($calculationResult);
            } else {
                $vweight = 0;
                if (Setting::get('vehicle_weightage', 0) == 1) {
                    $vweight = $request->vweight ? $request->vweight : 0;
                }
                $calculationResult = $this->estimated_fare_calculation($request->s_latitude, $request->s_longitude, $request->d_latitude, $request->d_longitude, $request->service_type, null, null, null, $vweight);
                // return dd($calculationResult);
            }
            
            // dd($calculationResult);

            $userRequest = new UserRequests;

            if ($calculationResult['surge'] == 1) {
                $userRequest->surge = 1;
            }

            if ($calculationResult['peakActive'] == 1) {
                $userRequest->is_peak = 1;
            }

            $service_type = $request->service_type;
            $service_type_id = $service_type;
            $distance = Setting::get('provider_search_radius', '10');
            $check_lux = DB::table('service_types')->where('id', $service_type_id)->first();
            if (!is_null($check_lux)) {
                if ($check_lux->type == 'luxury') {
                    $distance = Setting::get('provider_search_radius_delivery', '10');
                }
            }

            $latitude = $request->s_latitude;
            $longitude = $request->s_longitude;
            $vweight = $request->vweight ? $request->vweight : 0;
            $driver_job_code = $request->driver_job_code ? $request->driver_job_code : 0;
            $is_favourite_driver = $request->has('favourite_driver') ? $request->favourite_driver : 0;

            $code_base_job_req = Setting::get('code_base_job_req', 0);
            $vehicle_weightage = Setting::get('vehicle_weightage', 0);
            $gender_pref_enabled = Setting::get('gender_pref_enabled', 0);
            $zone_restrict_module = Setting::get('zone_restrict_module', 0);
            $block_user = Setting::get('block_user', 0);
            $block_driver = Setting::get('block_driver', 0);
            $favourite_driver = Setting::get('favourite_driver', 0);
            $userGender = null;
            $userGenderPref = null;

            if($gender_pref_enabled = 1) {
                $userGender = User::where('id', Auth::user()->id)->get(['gender'])->first();
                if (Setting::get('gender_pref_run_time') == 1) {
                    $userGenderPref = $userRequest->gender_pref_run_time = $request->has('gender_pref_run_time') ? $request->gender_pref_run_time : null;
                } else {
                    $userGenderPref = (Auth::user()->gender_pref != null || Auth::user()->gender_pref != '') ? Auth::user()->gender_pref : null;
                }
            }
            
            $userBlockedProviderIds = [];
            $providerBlockedUserIds = [];
            $providerFavouriteIds = [];
            $zone_id = 0;

            if($favourite_driver == 1 && $is_favourite_driver == 1) {
                $providerFavouriteIds = FavoriteProvider::where('user_id', Auth::user()->id)->pluck('provider_id')->toArray();
            }

            if ($block_user == 1) {
                $userBlockedProviderIds = BlockUserProvider::where('user_id', Auth::user()->id)->where('blocked_by', 'USER')->pluck('provider_id')->toArray();
            }

            // $blockedProviderIds = array_unique(array_merge($userBlockedProviderIds, $providerBlockedUserIds), SORT_REGULAR);

            if (Setting::get('zone_module', "0") == "1") {
                $geoFencingController = new GeoFencingController();
                $currentZone = $geoFencingController->getZone($latitude, $longitude);
                $zone_id = $currentZone != null ? $currentZone->id : 0;
            }

            //&& ($driver_job_code != null || $driver_job_code != "")
            if ($code_base_job_req == 1 && ($driver_job_code != null || $driver_job_code != "")) {

                // $providerExist = Provider::find($driver_job_code)->count();
                // if($providerExist) {
                // }
 
                if ($block_driver == 1) {
                    $providerBlockedUserCount = BlockUserProvider::where('user_id', Auth::user()->id)->where('provider_id', $driver_job_code)->where('blocked_by', 'PROVIDER')->count();
                    if($providerBlockedUserCount > 0) {
                        return response()->json(['error' => "Driver has blocked your account"], 400);
                    }
                }

                if ($block_user == 1) {
                    $userBlockedProviderCount = BlockUserProvider::where('user_id', Auth::user()->id)->where('provider_id', $driver_job_code)->where('blocked_by', 'USER')->count();
                    if($userBlockedProviderCount > 0) {
                        return response()->json(['error' => "You have blocked this provider"], 400);
                    }
                }

                $providers = Provider::with('service')
                    ->where('status', 'approved')
                    ->where('id', $driver_job_code)
                    ->whereHas('service', function ($q) use ($service_type_id) {
                        $q->where('status', 'active');
                        $q->where('is_selected', 1);
                        $q->where('is_approved', 1);
                        $q->where('service_type_id', $service_type_id);
                    })
                    ->get();
                
                if($providers->count() == 0) {
                    $providerServiceRiding = ProviderService::where('provider_id', $driver_job_code)->where('service_type_id', $service_type_id)->where('status', 'riding')->count();
                    $providerServiceOffline = ProviderService::where('provider_id', $driver_job_code)->where('service_type_id', $service_type_id)->where('status', 'offline')->count();
                    
                    if ($providerServiceRiding > 0) {
                        $message = 'This driver is on another ride!';
                    } else if ($providerServiceOffline > 0) {
                        $message = 'This driver is offline!';
                    } else {
                        $message = 'This driver is not available!';
                    }

                    return response()->json(['message' => $message]);
                }
            } else {
                $providers = Provider::with('service')
                    ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"), 'id', 'providers.*')
                    ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->where('status', 'approved')
                    ->whereHas('service', function ($q) use ($service_type_id, $vehicle_weightage, $vweight) {
                        $q->where('status', 'active');
                        $q->where('is_selected', 1);
                        $q->where('is_approved', 1);
                        $q->where('service_type_id', $service_type_id);
                        //Handled case of vehicle_weightage
                        $q->when(($vehicle_weightage == 1 && ($vweight != null || $vweight != "")), function ($q) use ($vweight) {
                            $q->where('service_weight_allowed_kg', '>=', $vweight);
                        });
                    })
                    //Handled case of gender_pref_enabled && preference: male
                    ->when(($gender_pref_enabled == 1 && $userGenderPref == 'male' && $userGender != null), function ($q) use ($userGender) {
                        $q->where('gender', 'male');
                        $q->where(function ($query) use ($userGender) {
                            $query->where('gender_pref', $userGender)
                                ->orWhere('gender_pref', 'both');
                        });
                    })
                    //Handled case of gender_pref_enabled && preference: female
                    ->when(($gender_pref_enabled == 1 && $userGenderPref == 'female' && $userGender != null), function ($q) use ($userGender) {
                        $q->where('gender', 'female');
                        $q->where(function ($query) use ($userGender) {
                            $query->where('gender_pref', $userGender)
                                ->orWhere('gender_pref', 'both');
                        });
                    })
                    //Handled case of zone_restrict_module
                    ->when(($zone_restrict_module == 1 && ($zone_id != 0)), function ($q) use ($zone_id) {
                        $q->where('zone_id', $zone_id);
                    })
                    //Handled case of block_user
                    ->when(($block_user == 1 && (count($userBlockedProviderIds) > 0)), function ($q) use ($userBlockedProviderIds) {
                        $q->whereNotIn('id', $userBlockedProviderIds);
                    })
                    //Handled case of favourite_driver
                    ->when(($favourite_driver == 1 && $is_favourite_driver == 1 && (count($providerFavouriteIds) > 0)), function ($q) use ($providerFavouriteIds) {
                        $q->whereIn('id', $providerFavouriteIds);
                    })
                    ->orderBy('distance')
                    ->get();
            }

            if ($request->has('schedule_date') && $request->has('schedule_time')) {
                if (Setting::get('force_schedule_job', 0) == 0) {
                    // List Providers who are currently busy and add them to the filter list.
                    if (count($providers) == 0) {
                        if ($request->ajax()) {
                            // Push Notification to User
                            return response()->json(['message' => trans('api.ride.no_providers_found')]);
                        } else {
                            return back()->with('flash_error', 'No Providers Found! Please try again.');
                        }

                    }
                }
            } else {
                if (Setting::get('instant_booking', 0) == 0) {
                    // List Providers who are currently busy and add them to the filter list.
                    if (count($providers) == 0) {
                        if ($request->ajax()) {
                            // Push Notification to User
                            return response()->json(['message' => trans('api.ride.no_providers_found')]);
                        } else {
                            return back()->with('flash_error', 'No Providers Found! Please try again.');
                        }

                    }
                }
            }

            $charge_id = null;
            if ($request->payment_mode == 'CARD') {
                if (Setting::get('booking_pre_payment', 0) == 1 && Setting::get('CARD', 0) == 1) {
                    $Card = Card::where('user_id', Auth::user()->id)->where('is_default', 1)->first();

                    $cardCount = Card::where('user_id', Auth::user()->id)->where('is_default', 1)->count();
                    if ($cardCount == 0) {
                        $message = 'No card added or set as default!';
                        return response()->json(['error' => $message], 500);
                    }

                    Stripe::setApiKey(Setting::get('stripe_secret_key'));

                    if (Setting::get('pre_booking_hourly_hold', 0) == 1) {
                        $first_time_hold = Setting::get('first_hold_time', 1);
                        $estimatedAmountCalculated = $calculationResult['eta_per_hour'] * $first_time_hold;
                        $estimatedAmount = intval(($calculationResult['eta_per_hour'] * $first_time_hold) * 100);
                    } else {
                        if($userRequest->returntrip == 1 && $userRequest->is_return_trip == 1){
                            $estimatedAmountCalculated = $calculationResult['eta_return_total'] * 1.20;
                            $estimatedAmount = intval(($calculationResult['eta_return_total'] * 1.20) * 100); //extra 20% hold
                        }else{
                            $estimatedAmountCalculated = $calculationResult['eta_total'] * 1.20;
                            $estimatedAmount = intval(($calculationResult['eta_total'] * 1.20) * 100); //extra 20% hold
                        }
                    }

                    $userRequest->prebooking_amount = $estimatedAmountCalculated;

                    // eloquent get only 
                    $userRequest->prebooking_card_details = json_encode($Card->only([
                        'last_four',
                        'brand',
                        'gateway_type'
                    ]));

                    try {

                        $Charge = Charge::create(array(
                            "amount" => intval($estimatedAmount),
                            "currency" => Setting::get('currency'),
                            "customer" => Auth::user()->stripe_cust_id,
                            "card" => $Card->card_id,
                            "description" => "Ride Payment",
                            'capture' => false,
                        ));
                    } catch (CardException $e) {
                        error_log("A payment error occurred: {$e->getError()->message}");
                        return response()->json(['error' => 'The card has been declined'], 500);
                    } catch (InvalidRequestException $e) {
                        error_log("An invalid request occurred.");
                        return response()->json(['error' => 'The request is invalid'], 500);
                    } catch (Exception $e) {
                        $error_code = isset($e->jsonBody['error']['code']) ? $e->jsonBody['error']['code'] : 'null';
                        $decline_code = isset($e->jsonBody['error']['decline_code']) ? $e->jsonBody['error']['decline_code'] : 'null';
                        if ($error_code == 'card_declined') {
                            if ($decline_code == 'generic_decline') {
                                $message = 'Your card is declined';
                            } else if ($decline_code == 'insufficient_funds') {
                                $message = 'Your card is declined due to insufficent funds';
                            } else if ($decline_code == 'lost_card') {
                                $message = 'Your card is declined as it is marked as lost';
                            } else if ($decline_code == 'stolen_card') {
                                $message = 'Your card is declined as it is marked as stolen';
                            }
                        } else if ($error_code == 'expired_card') {
                            $message = 'Your card is declined as it is expired';
                        } else if ($error_code == 'incorrect_cvc') {
                            $message = 'Your card is declined as it has invalid cvc';
                        } else if ($error_code == 'processing_error') {
                            $message = 'Your card is declined due to processing error';
                        } else if ($error_code == 'incorrect_number') {
                            $message = 'Your card is declined due to incorrect number';
                        } else {
                            $message = 'Your card is declined';
                        }
                        return response()->json(['error' => $message], 500);
                    }

                    $charge_id = $Charge->id;
                }
            }
            
            $details = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $request->s_latitude . "," . $request->s_longitude . "&destination=" . $request->d_latitude . "," . $request->d_longitude . "&mode=driving&key=" . Setting::get('map_key') . "&units=" . Setting::get('distance_system', 'metric');
            $json = curl($details);
            $details = json_decode($json, TRUE);
            $route_key = $details['routes'][0]['overview_polyline']['points'];

            if ($request->ajax()) {
                // dd($calculationResult);
                $requestDistance = isset($calculationResult['distance']) ? $calculationResult['distance'] : null;
            } else {
                $s_latitude = $request->s_latitude;
                $s_longitude = $request->s_longitude;
                $d_latitude = $request->d_latitude;
                $d_longitude = $request->d_longitude;

                $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                $meter = $googleDistanceAndTime['distanceValue'];

                $kilometer = Helper::applyDistanceSystem($meter);
                $requestDistance = $kilometer;
            }

            $userRequest->booking_id = Helper::generate_booking_id();
            $userRequest->dont_disturb_user = $request->dont_disturb_user;
            $userRequest->user_id = Auth::user()->id;

            if ($request->has('schedule_date') && $request->has('schedule_time')) {
                if (Setting::get('force_schedule_job', 0) == 0) {
                    $userRequest->current_provider_id = $providers[0]->id;
                } else {
                    $userRequest->current_provider_id = 0;
                }
            } else {
                if (Setting::get('instant_booking', 0) == 0) {
                    $userRequest->current_provider_id = $providers[0]->id;
                } else {
                    $userRequest->current_provider_id = 0;
                }
            }

            $userRequest->service_type_id = $request->service_type;
            $userRequest->payment_mode = $request->payment_mode;
            $userRequest->client_offer = $request->has('client_offer') ? $request->client_offer : null;
            $userRequest->vweight = $request->has('vweight') ? $request->vweight : null;
            $userRequest->is_free = $request->has('is_free') ? $request->is_free : 0;
            $userRequest->currency = Setting::get('currency', 'USD');
            $userRequest->distance_system = Setting::get('distance_system', 'metric');

            if ($request->has('schedule_date') && $request->has('schedule_time')) {
                if (Setting::get('force_schedule_job', 0) == 0) {
                    $userRequest->status = 'SEARCHING';
                } else {
                    $userRequest->status = 'SCHEDULED';
                }
            } else {
                if (Setting::get('instant_booking', 0) == 0) {
                    $userRequest->status = 'SEARCHING';
                } else {
                    $userRequest->status = 'REQUESTED';
                }
            }

            if (Setting::get('code_base_job_req', 0) == 1 && ($request->driver_job_code != null || $request->driver_job_code != "")) {
                $userRequest->driver_job_code = $request->driver_job_code;
            }

            $userRequest->s_address = $request->s_address ?: "";
            $userRequest->d_address = $request->d_address ?: "";
            $userRequest->otp = rand(1000, 9999);

            if ($request->ajax()) {
                $userRequest->amount = $calculationResult['eta_total'];
                $userRequest->return_amount = $calculationResult['eta_return_total'];
            } else {
                $userRequest->amount = $request->amount_total_web; // Lock: Not Understand
            }

            $userRequest->ride_amount = $calculationResult['ridePrice'];
            $userRequest->return_ride_amount = $calculationResult['rideReturnPrice'];

            $userRequest->driver_amount = $calculationResult['driver_amount'];
            $userRequest->return_driver_amount = $calculationResult['return_driver_amount'];

            $userRequest->s_latitude = $request->s_latitude;
            if ($request->has('return_trip')) {
                $userRequest->returntrip = $request->return_trip;
            }

            if ($request->has('set_dest_later')) {
                $userRequest->set_dest_later = $request->set_dest_later;
            }

            if ($request->has('specialNote')) {
                $userRequest->specialNote = $request->specialNote;
            }

            $userRequest->s_longitude = $request->s_longitude;
            $userRequest->d_latitude = $request->d_latitude;
            $userRequest->d_longitude = $request->d_longitude;
            $userRequest->distance = $requestDistance;

            if (Auth::user()->wallet_balance > 0) {
                $userRequest->use_wallet = $request->use_wallet ?: 0;
            }

            if ($request->has('return_t')) {
                $userRequest->returntrip = $request->return;
            }

            if ($request->has('eta_total')) {
                $userRequest->amount = $calculationResult['eta_total'];
            }

            $userRequest->assigned_at = Carbon::now();
            $userRequest->route_key = $route_key;

            if ($request->has('schedule_date') && $request->has('schedule_time')) {
                $userRequest->schedule_at = date("Y-m-d H:i:s", strtotime("$request->schedule_date $request->schedule_time"));
            }

            if ($request->has('request_category')) {
                $userRequest->request_category = $request->request_category;
            }

            if (Setting::get('customer_vehicle_info', 0) == 1) {
                $userRequest->vehicle_make = $request->vehicle_make;
                $userRequest->vehicle_number = $request->vehicle_number;
            }

            $userRequest->charge_id = $charge_id;
            $userRequest->save();

            // Log::info('New Request id : ' . $userRequest->id . ' Assigned to provider : ' . $userRequest->current_provider_id);

            // update payment mode 

            User::where('id', Auth::user()->id)->update(['payment_mode' => $request->payment_mode]);

            if ($request->has('card_id')) {
                Card::where('user_id', Auth::user()->id)->update(['is_default' => 0]);
                Card::where('card_id', $request->card_id)->update(['is_default' => 1]);
            }

            $timeOut = Setting::get('provider_select_timeout', 180);
            $userRequestData = UserRequests::with(['user', 'provider', 'service_type'])->find($userRequest->id);

            $userRequestData->time_left_to_respond = $timeOut - (time() - strtotime($userRequestData->assigned_at));
           
            $userRequest->is_return_trip = $userRequestData->service_type->is_return_trip;
            $userRequestData->is_return_trip = $userRequestData->service_type->is_return_trip;
            if (Setting::get('zone_module', "0") == "1") {
                $service_type = ZoneService::where('service_id', $userRequest->service_type_id)->get()->first();
            } else {
                $service_type = ServiceType::findOrFail($userRequest->service_type_id)->first();
            }

            $commission_tax_apply = Setting::get('commission_tax_apply', 'global');

            if ($commission_tax_apply == 'global') {
                $tax_percentage = Setting::get('tax_percentage', 10);
                $commission_type = Setting::get('commission_type', 'percentage');
                $provider_commission_percentage = Setting::get('commission_percentage', 10);
                $commission_percentage = Setting::get('commission_percentage', 10);
            } else if ($commission_tax_apply == 'service') {
                if (Setting::get('zone_module', "0") == "1") {
                    $tax_percentage = $service_type->tax_percentage == null ? 0 : $service_type->tax_percentage;
                    $commission_type = $service_type->commission_type == null ? 'percentage' : $service_type->commission_type;
                    $provider_commission_percentage = $service_type->commission_percentage == null ? 0 : $service_type->commission_percentage;
                    $commission_percentage = $provider_commission_percentage;
                } else {
                    $tax_percentage = $service_type->tax_percentage == null ? 0 : $service_type->tax_percentage;
                    $commission_type = $service_type->commission_type == null ? 'percentage' : $service_type->commission_type;
                    $provider_commission_percentage = $service_type->commission_percentage == null ? 0 : $service_type->commission_percentage;
                    $commission_percentage = $provider_commission_percentage;
                }
            } else {
                $tax_percentage = Setting::get('tax_percentage', 10);
                $commission_type = Setting::get('commission_type', 'percentage');
                $provider_commission_percentage = Setting::get('commission_percentage', 10);
                $commission_percentage = Setting::get('commission_percentage', 10);
            }

            $serviceTypeController = new ServiceTypeController();
            $bookingFeeDetail = $serviceTypeController->getBookingPrice($service_type);
            $bookingFeeAmount = $bookingFeeDetail['bookingFeeAmount'];

            $userRequestData->driver_amount = (string)Helper::customRoundtoMultiple($userRequestData->driver_amount, 2);
            $userRequestData->return_driver_amount = (string)Helper::customRoundtoMultiple($userRequestData->return_driver_amount, 2);

            if ($request->has('schedule_date') && $request->has('schedule_time')) {
                if (Setting::get('force_schedule_job', 0) == 0) {
                    if (Setting::get('negotiation_module', 0) == 0) {
                        if (Setting::get('pickup_time_switch', 0) == 1 && Setting::get('instant_booking', 0) == 0) {
                            $providerLoc = Provider::where('id', $providers[0]->id)->get(['latitude', 'longitude'])->first();
                            
                            $s_latitude = $providerLoc->latitude;
                            $s_longitude = $providerLoc->longitude;
                            $d_latitude = $userRequestData->s_latitude;
                            $d_longitude = $userRequestData->s_longitude;

                            $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                            
                            $distance = $googleDistanceAndTime['distanceText'];
                            $duration = $googleDistanceAndTime['durationText'];

                            $userRequestData->pickup_duration = $duration;
                            $userRequestData->pickup_distance = $distance;
                        }

                        if (Setting::get('drop_time_switch', 0) == 1) {
                            $s_latitude = $userRequestData->s_latitude;
                            $s_longitude = $userRequestData->s_longitude;
                            $d_latitude = $userRequestData->d_latitude;
                            $d_longitude = $userRequestData->d_longitude;

                            $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                            
                            $distance = $googleDistanceAndTime['distanceText'];
                            $duration = $googleDistanceAndTime['durationText'];

                            $userRequestData->drop_duration = $duration;
                            $userRequestData->drop_distance = $distance;
                        }
                        // if (Setting::get('instant_booking', 0) == 0) {
                        //     (new SendPushNotification)->IncomingRequest($providers[0]->id, $userRequestData);
                        // }
                        
                    }

                    // Start OLD Logic Block Users & Drivers
                    // $userBlockedProviderIds = [];
                    // if (Setting::get('block_user', 0) == 1) {
                    //     $userBlockedProviderIds = BlockUserProvider::where('user_id', Auth::user()->id)->where('blocked_by', 'USER')->pluck('provider_id')->toArray();
                    // }
                    // End OLD Logic Block Users & Drivers

                    $index = 0;
                    foreach ($providers as $key => $provider) {

                        // Start OLD Logic Block Users & Drivers
                        // if (in_array($provider->id, $userBlockedProviderIds)) {
                        //     continue;
                        // }

                        if ($block_driver == 1) {
                            $providerBlockedUserCount = BlockUserProvider::where('user_id', Auth::user()->id)->where('provider_id', $provider->id)->where('blocked_by', 'PROVIDER')->count();
                            if ($providerBlockedUserCount > 0) {
                                continue;
                            }
                        }
                        // End OLD Logic Block Users & Drivers

                        $filter = new RequestFilter;

                        // Send push notifications to the first provider
                        if (Setting::get('negotiation_module', 0) == 1) {
                            if (Setting::get('pickup_time_switch', 0) == 1  && Setting::get('instant_booking', 0) == 0) {
                                $providerLoc = Provider::where('id', $provider->id)->get(['latitude', 'longitude'])->first();
                                
                                $s_latitude = $providerLoc->latitude;
                                $s_longitude = $providerLoc->longitude;
                                $d_latitude = $userRequestData->s_latitude;
                                $d_longitude = $userRequestData->s_longitude;

                                $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                                
                                $distance = $googleDistanceAndTime['distanceText'];
                                $duration = $googleDistanceAndTime['durationText'];

                                $userRequestData->pickup_duration = $duration;
                                $userRequestData->pickup_distance = $distance;
                            }

                            if (Setting::get('drop_time_switch', 0) == 1) {
                                $s_latitude = $userRequestData->s_latitude;
                                $s_longitude = $userRequestData->s_longitude;
                                $d_latitude = $userRequestData->d_latitude;
                                $d_longitude = $userRequestData->d_longitude;

                                $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                                
                                $distance = $googleDistanceAndTime['distanceText'];
                                $duration = $googleDistanceAndTime['durationText'];
    
                                $userRequestData->drop_duration = $duration;
                                $userRequestData->drop_distance = $distance;
                            }
                            // if (Setting::get('instant_booking', 0) == 0) {
                            //     (new SendPushNotification)->IncomingRequest($provider->id, $userRequestData);
                            // }
                            
                        }

                        $instant_booking = Setting::get('instant_booking', 0) == 1 ? true : false;
                        $force_schedule_job = Setting::get('force_schedule_job', 0) == 1 ? true : false;

                        // old code
                        // // incoming request push to provider
                        if (Setting::get('broadcast_request_all', 0) == 1) {
                            if($userRequestData->status != 'REQUESTED') {
                                if ($index == 0) {
                                    $index = 1;
                                    (new SendPushNotification)->IncomingRequest($provider->id, $userRequestData);
                                }
                            }
                            
                        } 
                        /* else if (Setting::get('code_base_job_req', 0) == 1) {
                            (new SendPushNotification)->IncomingRequest($provider[0]->id, $userRequestData);
                        }*/

                        $filter->request_id = $userRequest->id;
                        $filter->provider_id = $provider->id;
                        $filter->save();

                        $filter = new RequestFilterLog;
                        $filter->request_id = $userRequest->id;
                        $filter->provider_id = $provider->id;
                        $filter->save();

                    }
                }
            } else {
                if (Setting::get('negotiation_module', 0) == 0) {
                    if (Setting::get('pickup_time_switch', 0) == 1 && Setting::get('instant_booking', 0) == 0) {
                        $providerLoc = Provider::where('id', $providers[0]->id)->get(['latitude', 'longitude'])->first();

                        $s_latitude = $providerLoc->latitude;
                        $s_longitude = $providerLoc->longitude;
                        $d_latitude = $userRequestData->s_latitude;
                        $d_longitude = $userRequestData->s_longitude;

                        $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                        
                        $distance = $googleDistanceAndTime['distanceText'];
                        $duration = $googleDistanceAndTime['durationText'];

                        $userRequestData->pickup_duration = $duration;
                        $userRequestData->pickup_distance = $distance;
                    }

                    if (Setting::get('drop_time_switch', 0) == 1) {

                        $s_latitude = $userRequestData->s_latitude;
                        $s_longitude = $userRequestData->s_longitude;
                        $d_latitude = $userRequestData->d_latitude;
                        $d_longitude = $userRequestData->d_longitude;

                        $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                        
                        $distance = $googleDistanceAndTime['distanceText'];
                        $duration = $googleDistanceAndTime['durationText'];

                        $userRequestData->drop_duration = $duration;
                        $userRequestData->drop_distance = $distance;
                    }
                    // if (Setting::get('instant_booking', 0) == 0) {
                    //     (new SendPushNotification)->IncomingRequest($providers[0]->id, $userRequestData);
                    // }
                    
                }

                $userBlockedProviderIds = [];
                if (Setting::get('block_user', 0) == 1) {
                    $userBlockedProviderIds = BlockUserProvider::where('user_id', Auth::user()->id)->where('blocked_by', 'USER')->pluck('provider_id')->toArray();
                }

                $index = 0;
                foreach ($providers as $key => $provider) {

                    if (in_array($provider->id, $userBlockedProviderIds)) {
                        continue;
                    }

                    if (Setting::get('block_driver', 0) == 1) {
                        $providerBlockedUserCount = BlockUserProvider::where('user_id', Auth::user()->id)->where('provider_id', $provider->id)->where('blocked_by', 'PROVIDER')->count();
                        if ($providerBlockedUserCount > 0) {
                            continue;
                        }
                    }

                    $filter = new RequestFilter;

                    // Send push notifications to the first provider

                    if (Setting::get('negotiation_module', 0) == 1) {
                        if (Setting::get('pickup_time_switch', 0) == 1 && Setting::get('instant_booking', 0) == 0) {
                            $providerLoc = Provider::where('id', $provider->id)->get(['latitude', 'longitude'])->first();

                            $s_latitude = $providerLoc->latitude;
                            $s_longitude = $providerLoc->longitude;
                            $d_latitude = $userRequestData->s_latitude;
                            $d_longitude = $userRequestData->s_longitude;

                            $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                            
                            $distance = $googleDistanceAndTime['distanceText'];
                            $duration = $googleDistanceAndTime['durationText'];

                            $userRequestData->pickup_duration = $duration;
                            $userRequestData->pickup_distance = $distance;
                        }

                        if (Setting::get('drop_time_switch', 0) == 1) {

                            $s_latitude = $userRequestData->s_latitude;
                            $s_longitude = $userRequestData->s_longitude;
                            $d_latitude = $userRequestData->d_latitude;
                            $d_longitude = $userRequestData->d_longitude;

                            $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                            
                            $distance = $googleDistanceAndTime['distanceText'];
                            $duration = $googleDistanceAndTime['durationText'];

                            $userRequestData->drop_duration = $duration;
                            $userRequestData->drop_distance = $distance;
                        }
                        // if (Setting::get('instant_booking', 0) == 0) {
                        //     (new SendPushNotification)->IncomingRequest($provider->id, $userRequestData);
                        // }
                    }

                    $instant_booking = Setting::get('instant_booking', 0) == 1 ? true : false;
                    $force_schedule_job = Setting::get('force_schedule_job', 0) == 1 ? true : false;
                    // incoming request push to provider
                    if (Setting::get('broadcast_request_all', 0) == 1) {
                        if($userRequestData->status != 'REQUESTED') {
                            if ($index == 0) {
                                $index = 1;
                                (new SendPushNotification)->IncomingRequest($provider->id, $userRequestData);
                            }
                        }
                    } 
                    /* else if (Setting::get('code_base_job_req', 0) == 1) {
                        (new SendPushNotification)->IncomingRequest($provider[0]->id, $userRequestData);
                    }*/

                    $filter->request_id = $userRequest->id;
                    $filter->provider_id = $provider->id;
                    $filter->save();

                    $filter = new RequestFilterLog;
                    $filter->request_id = $userRequest->id;
                    $filter->provider_id = $provider->id;
                    $filter->save();

                }
            }

            $userRequest->save();
            if ($request->ajax()) {
                $gender_pref_run_time = Setting::get('gender_pref_run_time', 0);
                $instant_booking = Setting::get('instant_booking', 0) == 1 ? true : false;
                $force_schedule_job = Setting::get('force_schedule_job', 0) == 1 ? true : false;

                if ($instant_booking) {

                    return response()->json([
                        'message' => 'New booking request created, provider shall be assigned to you shortly.',
                        'request_id' => $userRequest->id,
                        'instant_booking' => $instant_booking,
                        'current_provider' => 0,
                        'dont_disturb_user' => $userRequest->dont_disturb_user,
                        'gender_pref_run_time' => $userRequest->gender_pref_run_time,
                        'job_already_requested' => false
                    ]);

                } else if($force_schedule_job && ($request->has('schedule_date') && $request->has('schedule_time'))) {
                    
                    return response()->json([
                        'message' => 'New booking request created, provider shall be assigned to you shortly.',
                        'request_id' => $userRequest->id,
                        'instant_booking' => $force_schedule_job,
                        'current_provider' => 0,
                        'dont_disturb_user' => $userRequest->dont_disturb_user,
                        'gender_pref_run_time' => $userRequest->gender_pref_run_time,
                        'job_already_requested' => false
                    ]);

                } else {

                    return response()->json([
                        'message' => 'New request created!',
                        'request_id' => $userRequest->id,
                        'instant_booking' => $instant_booking,
                        'current_provider' => $userRequest->current_provider_id,
                        'dont_disturb_user' => $userRequest->dont_disturb_user,
                        'gender_pref_run_time' => $userRequest->gender_pref_run_time,
                        'job_already_requested' => false
                    ]);
                }

            } else {
                return redirect('dashboard')->with('flash_success', 'New request created!');

            }

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => $e->getMessage(), 'error' => trans('api.something_went_wrong')], 500);
            } else {
                return back()->with('flash_error', 'Something went wrong while sending request. Please try again.' . ' ' . $e->getMessage());
            }
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function cancel_request(Request $request)
    {

        $this->validate($request, [
            'request_id' => 'required|numeric|exists:user_requests,id,user_id,' . Auth::user()->id,
            'cancel_reason' => 'required',
        ]);

        try {

            $userRequest = UserRequests::find($request->request_id);
            if (!$userRequest) {
                return response()->json(['error' => translateKeywordApis("no_request_found", $request)]);
            }

            $oldStatus = $userRequest->status;

            if ($userRequest->status == 'CANCELLED') {
                
                if ($request->ajax()) {

                    return response()->json(['error' => translateKeywordApis("request_is_already_cancelled", $request)], 500);

                } else {

                    return back()->with('flash_error', translateKeyword("request_is_already_cancelled"));

                }

            }

            if (in_array($userRequest->status, ['SEARCHING', 'STARTED', 'ARRIVED', 'SCHEDULED', 'REQUESTED'])) {

                // if ($userRequest->status != 'SEARCHING') {

                //     $this->validate($request, [

                //         'cancel_reason' => 'max:255',

                //     ]);

                // }

                //old logic
                // if (Setting::get('cancellation_deduction', 0) == 1) {
                //     $currentDateTime = Carbon::now()->toDateTimeString();
                //     $cancellationTimeout = Setting::get('cancellation_time', 5);
                //     $rideDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $userRequest->created_at)->addMinutes($cancellationTimeout)->toDateTimeString();
                //     if ($currentDateTime > $rideDateTime) {
                //         $user_id = Auth::user()->id;
                //         $cancellation_amount = Setting::get('cancellation_amount', 0);
                //         $user = User::find($user_id);
                //         $user->wallet_balance = $user->wallet_balance - $cancellation_amount;
                //         $user->save();
                //     }
                // }
                
                $cancellation_amount = Setting::get('cancellation_amount', 0.00);
                $price = 0;
                $cancel_amount_driver = 0;
                if ($userRequest->status != 'SEARCHING') {
                    if (Setting::get('cancellation_deduction', 0) == 1) {
                        
                        $price = $cancellation_amount;
                        $service_type_id = $userRequest->service_type_id;

                        $serviceTypeController = new ServiceTypeController();
                        $service_type = $serviceTypeController->getServiceType($service_type_id);
                        
                        $commissionDetail = $serviceTypeController->getCommissionPrice($service_type, $price);
                        $commission_deduction = $commissionDetail['commission_deduction'];
                        $commission_price = $commissionDetail['commission_price'];
                        $commission_type = $commissionDetail['commission_type'];
                        $commission_percentage = $commissionDetail['commission_percentage'];
                        $price += $commission_price;

                        $cancel_amount_driver = $cancellation_amount - $commission_price;

                        $bookingFeeDetail = $serviceTypeController->getBookingPrice($service_type);
                        $bookingFeeActive = $bookingFeeDetail['bookingFeeActive'];
                        $bookingFeeAmount = $bookingFeeDetail['bookingFeeAmount'];
                        $price += $bookingFeeAmount;

                        $taxDetail = $serviceTypeController->getTaxPrice($service_type, $price);
                        $tax_active = $taxDetail['tax_active'];
                        $tax_price = $taxDetail['tax_price'];
                        $tax_percentage = $taxDetail['tax_percentage'];
                        $price += $tax_price;

                        $governmentChargesDetail = $serviceTypeController->getGovernmentCharges($service_type, $price);
                        $government_charges_active = $governmentChargesDetail['government_charges_active'];
                        $government_charges = $governmentChargesDetail['government_charges'];
                        $price += $government_charges;

                        $cancelPaymentDetailsArray = [];
                        $cancelPaymentDetailsArray['commission_deduction'] = $commission_deduction;
                        $cancelPaymentDetailsArray['commission_price'] = $commission_price;
                        $cancelPaymentDetailsArray['commission_type'] = $commission_type;
                        $cancelPaymentDetailsArray['commission_percentage'] = $commission_percentage;

                        $cancelPaymentDetailsArray['tax_active'] = $tax_active;
                        $cancelPaymentDetailsArray['tax_percentage'] = $tax_percentage;
                        $cancelPaymentDetailsArray['tax_price'] = $tax_price;

                        $cancelPaymentDetailsArray['government_charges_active'] = $government_charges_active;
                        $cancelPaymentDetailsArray['government_charges'] = $government_charges;

                        $cancelPaymentDetailsArray['bookingFeeActive'] = $bookingFeeActive;
                        $cancelPaymentDetailsArray['bookingFeeAmount'] = $bookingFeeAmount;

                        $cancelPaymentDetailsArray['cancellation_deduction'] = 1;
                        $cancelPaymentDetailsArray['cancellation_value'] = $cancellation_amount;
                        $cancelPaymentDetailsArray['total_cancellation_deduction'] = $price;

                        if ($userRequest->user_id) {
                            $user_id = $userRequest->user_id;
                            $userUpdate = User::find($user_id);
                            $deductionAmount = $price;
                            if ($userRequest->payment_mode == 'CASH') {

                                $cancelPaymentDetailsArray['bank_charges_active'] = false;

                                $userUpdate->wallet_balance = $userUpdate->wallet_balance - ($deductionAmount);
                                $userUpdate->save();
                            } else if ($userRequest->payment_mode == 'CARD') {
                                $bankChargesDetail = $serviceTypeController->getBankCharges($service_type, $price);
                                $bank_charges_active = $bankChargesDetail['bank_charges_active'];
                                $bank_charges_amount = $bankChargesDetail['bank_charges_amount'];
                                $bank_charges_type = $bankChargesDetail['bank_charges_type'];
                                $bank_charges_value = $bankChargesDetail['bank_charges_value'];

                                $price += $bank_charges_amount;
                                $deductionAmount += number_format($bank_charges_amount, 2);

                                $cancelPaymentDetailsArray['bank_charges_active'] = $bank_charges_active;
                                $cancelPaymentDetailsArray['bank_charges_amount'] = $bank_charges_amount;
                                $cancelPaymentDetailsArray['bank_charges_type'] = $bank_charges_type;
                                $cancelPaymentDetailsArray['bank_charges_value'] = $bank_charges_value;

                                $cancelPaymentDetailsArray['total_cancellation_deduction'] = $price;

                                Stripe::setApiKey(Setting::get('stripe_secret_key'));
                                $StripeCharge = ($deductionAmount) * 100;
                                $Charge = Charge::create(array(
                                    "amount" => $StripeCharge,
                                    "currency" => Setting::get('currency'),
                                    "customer" => $userUpdate->stripe_cust_id,
                                    "card" => $request->card_id,
                                    "description" => "Cancellation Charge for " . $userUpdate->email,
                                    "receipt_email" => $userUpdate->email
                                ));
                            }

                            // $cancelPaymentDetailsJson = json_encode($cancelPaymentDetailsArray);
                            $userRequest->cancel_payment_details = $cancelPaymentDetailsArray;
                        }
        
                        if ($userRequest->provider_id) {
                            $providerController = new ProviderController();
                            $bankAccountId = $providerController->getBankAccount($userRequest->provider_id);
                            $totalCancellationAmount = $cancellation_amount - $commission_price;
                            WithdrawalMoney::create([
                                'bank_account_id' => $bankAccountId,
                                'provider_id' => $userRequest->provider_id,
                                'amount' => abs($totalCancellationAmount)
                            ]);
                        }

                        if ($deductionAmount > 0) {
                            if ($userRequest->provider_id) {
                                (new SendPushNotification)->ProviderCancelAmount($userRequest, $totalCancellationAmount);
                            }
                            if ($userRequest->payment_mode == 'CARD') {
                                (new SendPushNotification)->UserCancelAmount($userRequest, $deductionAmount, 'card');
                            } else {
                                (new SendPushNotification)->UserCancelAmount($userRequest, $deductionAmount, 'wallet');
                            }
                        }
                    }
                }

                $userRequest->status = 'CANCELLED';
                if (is_string($request->cancel_reason)) {
                    $userRequest->cancel_reason = $request->cancel_reason;
                } else {
                    $userRequest->cancellation_reason_id = $request->cancel_reason;
                }
                $userRequest->cancelled_by = 'USER';
                $userRequest->cancel_amount = $cancellation_amount != null ? $price : 0.00;
                $userRequest->cancel_amount_driver = $cancel_amount_driver;
                $userRequest->save();
                
                RequestFilter::where('request_id', $userRequest->id)->delete();

                if ($userRequest->status != 'SCHEDULED') {

                    if ($userRequest->provider_id != 0) {

                        ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'active']);

                    }

                }

                // Send Push Notification to User

                (new SendPushNotification)->UserCancellRide($userRequest);

                if ($request->ajax()) {

                    return response()->json(['message' => translateKeywordApis("ride_cancelled_successfully", $request)]);

                } else {

                    return redirect('dashboard')->with('flash_success', translateKeyword("request_cancelled_successfully"));

                }

            } else {

                if ($request->ajax()) {

                    return response()->json(['error' => translateKeywordApis("already_on_ride", $request)], 500);

                } else {

                    return back()->with('flash_error', translateKeyword("service_already_started"));

                }

            }

        } catch (ModelNotFoundException $e) {

            if ($request->ajax()) {

                return response()->json(['error' => translateKeywordApis("something_went_wrong", $request)], 500);

            } else {

                return back()->with('flash_error', translateKeyword('no_request_found'));

            }

        }

    }

    /**
     * Show the request status check.
     *
     * @return Response
     */

    public function request_status_check(Request $request)
    {

        try {

            $check_status = ['CANCELLED', 'SCHEDULED', 'REQUESTED'];

            $userRequests = UserRequests::UserRequestStatusCheck(Auth::user()->id, $check_status)
                ->get()
                ->toArray();

            $search_status = ['SEARCHING', 'SCHEDULED'];
            $user = User::find(Auth::user()->id);

            $userRequestsFilter = UserRequests::UserRequestAssignProvider(Auth::user()->id, $search_status)->get();

            if(Setting::get('subscription_module_stripe_trial', 0) == 0) {
                $trial_period = Setting::get('rider_trial_period', 0);
                if($trial_period > 0) {
                    $now = Carbon::now();
                    $userUpdate = User::find(Auth::user()->id);
                    $trial_end_time = $userUpdate->trial_end_time; 
                    if ($now > $trial_end_time) {
                        $userUpdate->subscription_status = 'inactive';
                        $userUpdate->save();
                    }
                }
            }

            if (Setting::get('subscription_module', 0) == 1 && Setting::get('rider_subscription_module', 0) == 1 && $user->status == 'approved' && $user->subscription_status != 'trialing') {
                $userUpdate = User::find(Auth::user()->id);
                $now = Carbon::now();
                // $userDocumentsPendingCount = UserDocument::where('user_id', Auth::user()->id)->where('status', 'ASSESSING')->count();
                $pendingReviewCount = UserRequests::where('user_id', Auth::user()->id)->whereIn('status', ['DROPPED','COMPLETED'])->where('user_rated', 0)->count();
                if (($userUpdate->rides_left == 0 && $pendingReviewCount == 0) || ($now > $userUpdate->subscription_end_time)) {
                    $userUpdate->is_subscribed = 0;
                    // $userUpdate->status = 'subscription_expired';
                } 
                // else if ($userUpdate->rides_left > 0 || $userDocumentsPendingCount == 0) {
                //     $userUpdate->is_subscribed = 1;
                //     $userUpdate->status = 'approved';
                // }
                $userUpdate->save();

                if ($userUpdate->is_subscribed == 0) {
                    return response()->json(['account_status' => 'subscription_expired', 'data' => [], 'pending_scheduled_jobs' => 0]);
                }
            }

            // if (Setting::get('favourite_driver') == 1) {
            //     $result->append('is_liked');
            //     //TODO: need to send 'is_fav' key in provider object
            // }
            // // Log::info($userRequestsFilter);

            $timeOut = Setting::get('provider_select_timeout', 180);
            if (Setting::get('negotiation_module', 0) == 0) {
                if (!empty($userRequestsFilter)) {

                    for ($i = 0; $i < sizeof($userRequestsFilter); $i++) {

                        $ExpiredTime = $timeOut - (time() - strtotime($userRequestsFilter[$i]->assigned_at));

                        if ($userRequestsFilter[$i]->status == 'SEARCHING' && $ExpiredTime < 0) {

                            $Providertrip = new TripController();

                            $Providertrip->assign_next_provider($userRequestsFilter[$i]->id);

                        } else if ($userRequestsFilter[$i]->status == 'SEARCHING' && $ExpiredTime > 0) {

                            break;

                        }

                    }
                }
            }

            if (Setting::get('arrival_time_switch', 0) == 1) {
                foreach ($userRequests as $key => $userRequest) {
                    $provider = Provider::where('id', $userRequest['current_provider_id'])->get(['latitude', 'longitude'])->first();
                    // return $provider;

                    $provider_latitude = isset($provider->latitude) ? $provider->latitude : null;
                    $provider_longitude = isset($provider->longitude) ? $provider->longitude : null;
                    if ($provider_latitude != null && $provider_longitude != null) {

                        $s_latitude = $provider_latitude;
                        $s_longitude = $provider_longitude;
                        $d_latitude = $userRequest['s_latitude'];
                        $d_longitude = $userRequest['s_longitude'];

                        $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                        
                        $seconds = $googleDistanceAndTime['durationValue'];

                        $userRequests[$key]['arrival_time'] = $seconds;
                    } else {
                        $userRequests[$key]['arrival_time'] = 0;
                    }


                }
            }

            if (Setting::get('negotiation_module', 0) == 1) {

                foreach ($userRequests as $key => $userRequest) {

                    $negotiation_type = Setting::get('negotiation_type', 0);
                    $negotiation_min_threshold = Setting::get('negotiation_min_threshold', 0);
                    $negotiation_max_threshold = Setting::get('negotiation_max_threshold', 0);

                    if ($negotiation_type == 'percentage') {
                        $userRequests[$key]['estimated_max_value'] = $userRequests[$key]['amount'] + ($userRequests[$key]['amount'] * ($negotiation_max_threshold / 100));
                        $minValue = ($userRequests[$key]['amount'] * ($negotiation_min_threshold / 100));
                        // if ($minValue <= 0) {
                        //     $minValue = $userRequests[$key]['amount'];
                        // }
                        $userRequests[$key]['estimated_min_value'] = $userRequests[$key]['amount'] - ($minValue);

                        $difference = $userRequests[$key]['amount'] * ($negotiation_max_threshold / 100);
                        $difference_part = $difference / 3;
                        $counter_offer_one = $userRequests[$key]['amount'] + $difference_part;
                        $counter_offer_two = $counter_offer_one + $difference_part;
                        $counter_offer_three = $counter_offer_two + $difference_part;

                        $userRequests[$key]['counter_offer_one'] = $counter_offer_one;
                        $userRequests[$key]['counter_offer_two'] = $counter_offer_two;
                        $userRequests[$key]['counter_offer_three'] = $counter_offer_three;
                    } else {
                        $userRequests[$key]['estimated_max_value'] = $userRequests[$key]['amount'] + ($negotiation_max_threshold);
                        $minValue = ($negotiation_min_threshold);
                        if ($minValue <= 0 || $minValue >= $userRequests[$key]['amount']) {
                            $minValue = $userRequests[$key]['amount'];
                        } else {
                            $minValue = $userRequests[$key]['amount'] - ($minValue);
                        }
                        $userRequests[$key]['estimated_min_value'] = $minValue;
                        $difference = $negotiation_max_threshold;
                        $difference_part = $difference / 3;
                        $counter_offer_one = $userRequests[$key]['amount'] + $difference_part;
                        $counter_offer_two = $counter_offer_one + $difference_part;
                        $counter_offer_three = $counter_offer_two + $difference_part;

                        $userRequests[$key]['counter_offer_one'] = $counter_offer_one;
                        $userRequests[$key]['counter_offer_two'] = $counter_offer_two;
                        $userRequests[$key]['counter_offer_three'] = $counter_offer_three;
                    }

                    foreach ($userRequest['offer'] as $index => $offer) {

                        $provider = Provider::where('id', $offer['provider_id'])->with(['service', 'providerRating'])->get()->first();

                        $provider_latitude = isset($provider->latitude) ? $provider->latitude : null;
                        $provider_longitude = isset($provider->longitude) ? $provider->longitude : null;
                        if (Setting::get('pickup_time_switch', 0) == 1 && $provider_latitude != null && $provider_longitude != null) {

                            $s_latitude = $provider_latitude;
                            $s_longitude = $provider_longitude;
                            $d_latitude = $userRequest['s_latitude'];
                            $d_longitude = $userRequest['s_longitude'];

                            $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                            
                            $distance = $googleDistanceAndTime['distanceText'];
                            $duration = $googleDistanceAndTime['durationText'];

                            $userRequests[$key]['offer'][$index]['pickup_duration'] = $duration;
                            $userRequests[$key]['offer'][$index]['pickup_distance'] = $distance;
                        } else {
                            $userRequests[$key]['offer'][$index]['pickup_duration'] = '';
                            $userRequests[$key]['offer'][$index]['pickup_distance'] = '';
                        }

                        if (Setting::get('drop_time_switch', 0) == 1) {

                            $s_latitude = $userRequest['s_latitude'];
                            $s_longitude = $userRequest['s_longitude'];
                            $d_latitude = $userRequest['d_latitude'];
                            $d_longitude = $userRequest['d_longitude'];

                            $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                            
                            $distance = $googleDistanceAndTime['distanceText'];
                            $duration = $googleDistanceAndTime['durationText'];

                            $userRequests[$key]['offer'][$index]['drop_duration'] = $duration;
                            $userRequests[$key]['offer'][$index]['drop_distance'] = $distance;
                        } else {
                            $userRequests[$key]['offer'][$index]['drop_duration'] = '';
                            $userRequests[$key]['offer'][$index]['drop_distance'] = '';
                        }

                        $userRequests[$key]['offer'][$index]['request_id'] = (float)$offer['provider_id'];
                        $userRequests[$key]['offer'][$index]['provider_id'] = (float)$offer['provider_id'];
                        $userRequests[$key]['offer'][$index]['offer_price'] = (float)$offer['offer_price'];
                        $userRequests[$key]['offer'][$index]['is_accepted'] = (float)$offer['is_accepted'];
                        $userRequests[$key]['offer'][$index]['is_free'] = $userRequests[$key]['is_free'];
                        $userRequests[$key]['offer'][$index]['is_skipped'] = (float)$offer['is_skipped'];
                        $userRequests[$key]['offer'][$index]['is_declined'] = (float)$offer['is_declined'];
                        $userRequests[$key]['offer'][$index]['name'] = $provider ? $provider->first_name . ' ' . $provider->last_name : '';
                        $userRequests[$key]['offer'][$index]['picture'] = $provider ? $provider->avatar : '';
                        $userRequests[$key]['offer'][$index]['vehicle_name'] = $provider && $provider->service[0] ? $provider->service[0]->service_model : '';
                        $userRequests[$key]['offer'][$index]['vehicle_number'] = $provider && $provider->service[0] ? $provider->service[0]->service_number : '';
                        $userRequests[$key]['offer'][$index]['rating'] = $provider && $provider->providerRating ? (string)Helper::customRoundtoMultiple($provider->providerRating->avg('provider_rating'), 2) : (string)Helper::customRoundtoMultiple(0.00, 2);
                        $userRequests[$key]['offer'][$index]['orders_count'] = (float)UserRequests::where('current_provider_id', $offer['provider_id'])->count();
                    }

                    $offers = RequestOffer::where('request_id', $userRequests[$key]['id'])
                        ->where('is_declined', 0)
                        // ->where('is_skipped', 0)
                        ->latest()->get();

                    $offersCount = $offers->count();
                    if ($offersCount > 0) {
                        $dateNow = Carbon::now();
                        $updated_at = $offers[0]['updated_at'];
                        $totalDuration = $dateNow->diffInSeconds($updated_at);
                        $user_id = $userRequests[$key]['user_id'];
                        $userData = User::find($user_id);
                        if (
                            $totalDuration >= 60
                        ) {
                            // $status = $userRequests[$key]['status'];
                            // if ($status == 'SEARCHING') {
                            //     $request = (object)[];
                            //     $request->title = 'Taking too long? Try increasing fare to get driver\' attention';
                            //     $request->message = 'Taking too long? Try increasing fare to get driver\' attention';
                            //     (new SendPushNotification)->user_push($request, $userData->device_token);
                            // }
                            if ($userRequests[$key]['is_free'] == true) {
                                $userRequests[$key]['increase_offer'] = false;
                                $userRequests[$key]['totalDuration'] = $totalDuration;
                            } else {
                                $userRequests[$key]['increase_offer'] = true;
                                $userRequests[$key]['totalDuration'] = $totalDuration;
                            }
                        } else {
                            $userRequests[$key]['increase_offer'] = false;
                            $userRequests[$key]['totalDuration'] = $totalDuration;
                        }
                    } else {
                        $dateNow = Carbon::now();
                        $updated_at = $userRequests[$key]['updated_at'];
                        $totalDuration = $dateNow->diffInSeconds($updated_at);
                        $user_id = $userRequests[$key]['user_id'];
                        $userData = User::find($user_id);
                        if (
                            $totalDuration >= 60
                        ) {
                            // $status = $userRequests[$key]['status'];
                            // if ($status == 'SEARCHING') {
                            //     $request = (object)[];
                            //     $request->title = 'Taking too long? Try increasing fare to get driver\' attention';
                            //     $request->message = 'Taking too long? Try increasing fare to get driver\' attention';
                            //     (new SendPushNotification)->user_push($request, $userData->device_token);
                            // }
                            if ($userRequests[$key]['is_free'] == true) {
                                $userRequests[$key]['increase_offer'] = false;
                                $userRequests[$key]['totalDuration'] = $totalDuration;
                            } else {
                                $userRequests[$key]['increase_offer'] = true;
                                $userRequests[$key]['totalDuration'] = $totalDuration;
                            }
                        } else {
                            $userRequests[$key]['increase_offer'] = false;
                            $userRequests[$key]['totalDuration'] = $totalDuration;
                        }
                    }

                    //Logic 1
                    // $offers = RequestOffer::where('request_id', $userRequests[$key]['id'])
                    //                         ->where('is_declined', 0)
                    //                         ->latest()->get();
                    // $offersCount = $offers->count();
                    // if ($offersCount > 0) {
                    //     $dateNow = Carbon::now()->addSeconds(30);
                    //     $updated_at = $offers[0]['updated_at'];
                    //     $totalDuration = $dateNow->diffInSeconds($updated_at);
                    // } else {
                    //     $totalDuration = 30;
                    // }

                    // if (
                    //     $offersCount == 0 
                    //     && 
                    //     $totalDuration >= 60
                    // ) {
                    //     $userRequests[$key]['increase_offer'] = true;
                    //     $userRequests[$key]['totalDuration'] = $totalDuration;
                    //     $userRequests[$key]['offersCount'] = $offersCount;
                    // } else {
                    //     $userRequests[$key]['increase_offer'] = false;
                    //     $userRequests[$key]['totalDuration'] = $totalDuration;
                    //     $userRequests[$key]['offersCount'] = $offersCount;
                    // }
                }

            }

            $currentTime = Carbon::now()->toDateTimeString();

            $pending_scheduled_jobs = UserRequests::where(function ($query) use ($currentTime) {
                $query->where('status', '=', 'SCHEDULED')
                    ->where('user_id', Auth::user()->id)
                    ->where('schedule_at', '>=', $currentTime);
                })
                ->orWhere([['status', 'REQUESTED'], ['user_id', Auth::user()->id]])
                ->count();

            foreach($userRequests as $userRequest){
                unset($userRequest['service_type']);
                $userRequest['service_type'] = $this->getServicesWithMultiLanguageAndByServiceTypeId($userRequest['service_type_id'], $request);
                $userRequests = $userRequest;
            }

            return response()->json([ 'account_status' => request()->user()->status, 'data' => $userRequests, 'pending_scheduled_jobs' => $pending_scheduled_jobs]);

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong'), 'data' => $e->getMessage()], 500);

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function rate_provider(Request $request)
    {

        $this->validate($request, [

            'request_id' => 'required|integer|exists:user_requests,id,user_id,' . Auth::user()->id,

            'rating' => 'required|integer|in:1,2,3,4,5',

            'comment' => 'max:255',
            'tip_amount' => 'nullable|numeric',
            'add_to_favorites' => 'nullable|boolean'

        ]);

        $userRequests = UserRequests::where('id', $request->request_id)
            ->where('status', 'COMPLETED')
            ->where('paid', 0)
            ->first();

        if ($userRequests) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.user.not_paid')], 500);
            } else {
                return back()->with('flash_error', 'Service Already Started!');
            }
        }

        try {

            $userRequest = UserRequests::findOrFail($request->request_id);
            $user = User::find($userRequest->user_id);
            
            if (Setting::get('report_images_customer', 0) == 1) {
                if ($request->hasFile('user_report_images')) {
                    foreach ($request->file('user_report_images') as $imagefile) {
                        $image = $imagefile->store('reports');
                        $image = asset('storage/' . $image);
                        $userImage = new RequestReportImages();
                        $userImage->request_id = $request->request_id;
                        $userImage->image = $image;
                        $userImage->type = 'User';
                        $userImage->save();
                    }
                }
            }

            if ($userRequest->rating == null) {

                UserRequestRating::create([

                    'provider_id' => $userRequest->provider_id,

                    'user_id' => $userRequest->user_id,

                    'request_id' => $userRequest->id,

                    'user_rating' => $request->rating,

                    'user_comment' => $request->comment,

                ]);

            } else {

                $userRequest->rating->update([

                    'user_rating' => $request->rating,

                    'user_comment' => $request->comment,

                ]);

            }

            //Adding tip to user requests
            if ($request->tip_amount != null || $request->tip_amount != 0) {
                try {
                    if ($userRequest->payment_mode == 'CARD') {
                        $Card = Card::where('user_id', Auth::user()->id)->where('is_default', 1)->first();
                        if (!$Card) {
                            return response()->json(['message' => 'Card is not available'], 501);
                        }

                        $StripeTipCharge = $request->tip_amount * 100;

                        Stripe::setApiKey(Setting::get('stripe_secret_key'));

                        $Charge = Charge::create(array(
                            "amount" => $StripeTipCharge,
                            "currency" => Setting::get('currency'),
                            "customer" => Auth::user()->stripe_cust_id,
                            "card" => $Card->card_id,
                            "description" => "Tip charge"
                        ));
                    }

                    if(Setting::get('commission_deduction_on_tip', 0) == 1) {
                        $serviceTypeController = new ServiceTypeController();
                        $service_type_id = $userRequest->service_type_id;

                        $service_type = $serviceTypeController->getServiceType($service_type_id);
                        $commissionDetail = $serviceTypeController->getCommissionPrice($service_type, $request->tip_amount);

                        $commission_tip_amount = $commissionDetail['commission_price'];
                        $tip_amount_driver = $request->tip_amount - $commission_tip_amount;
                    } else {
                        $commission_tip_amount = 0;
                        $tip_amount_driver = $request->tip_amount;
                    }
                    

                    $userRequest->update(['tip_amount' => $request->tip_amount, 'tip_amount_driver' => $tip_amount_driver, 'commission_tip_amount' => $commission_tip_amount]);

                    // $provider = Provider::find($userRequest->provider_id);
                    // $provider->wallet = $provider->wallet + $request->tip_amount;
                    // $provider->save();

                    (new SendPushNotification)->driver_tip($userRequest->provider_id, trans('currency.' . Setting::get('currency')) . $tip_amount_driver);

                    $providerController = new ProviderController();
                    $bankAccountId = $providerController->getBankAccount($userRequest->provider_id);

                    WithdrawalMoney::create([
                        'bank_account_id' => $bankAccountId,
                        'provider_id' => $userRequest->provider_id,
                        'amount' => abs($tip_amount_driver)
                    ]);

                } catch (StripeInvalidRequestError $e) {
                    if ($request->ajax()) {
                        return response()->json(['error' => $e->getMessage()], 500);
                    } else {
                        return back()->with('flash_error', $e->getMessage());
                    }
                }
            }

            $user = User::find($userRequest->user_id);
            if (Setting::get('reward_point_customer', 0) == 1) {
                $reward_percentage = Setting::get('reward_percentage', 0);
                $userRequestPayment = UserRequestPayment::where('request_id', $request->request_id)->get()->first();
                $reward_points = $userRequestPayment->total * ($reward_percentage / 100);
                $user->reward_points = $user->reward_points + $reward_points;
                // Send Push Notification to User 
                (new SendPushNotification)->points_earned($userRequest->user_id, $reward_points);
            }

            $userRequest->user_rated = 1;

            $userRequest->save();

            $average = UserRequestRating::where('provider_id', $userRequest->provider_id)->avg('user_rating');

            Provider::where('id', $userRequest->provider_id)->update(['rating' => $average]);

            if ($request->add_to_favorites) {
                FavoriteProvider::updateOrCreate(
                    ['user_id' => $userRequest->user_id, 'provider_id' => $userRequest->provider_id],
                    ['is_favorite' => 1]
                );
            }
                         
            $user->save();
            if ($request->ajax()) {

                return response()->json(['message' => trans('api.ride.provider_rated')]);

            } else {

                return redirect('dashboard')->with('flash_success', 'Driver Rated Successfully!');

            }

        } catch (Exception $e) {
            // dd($e->getMessage());
            
            if ($request->ajax()) {

                return response()->json(['error' => trans('api.something_went_wrong')], 500);

            } else {

                return back()->with('flash_error', 'Something went wrong');

            }

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function trips(Request $request)
    {
        try {
            $userRequests = UserRequests::UserTrips(Auth::user()->id)->with(['payment', 'userReportImages', 'driverReportImages'])->get();
           

            if (!empty($userRequests)) {

                $map_icon = asset('asset/img/marker-start.png');

                foreach ($userRequests as $key => $value) {

                    $userRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .

                        "autoscale=1" .

                        "&size=320x130" .

                        "&maptype=terrian" .

                        "&format=png" .

                        "&visual_refresh=true" .

                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .

                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .

                        "&path=color:0x191919|weight:3|enc:" . $value->route_key .

                        "&key=" . Setting::get('map_key');

                    
                    // $userRequests[$key]->cancel_booking_fee_amt = $userRequests[$key]->cancel_amount + $userRequests[$key]->booking_fee;

                }

            }


            $filteredUserRequests = [];
            foreach($userRequests as $userRequest){
                $userRequest['service_type'] = $this->getServicesWithMultiLanguageAndByServiceTypeId($userRequest->service_type_id,$request);
                $filteredUserRequests[] = $userRequest;

            }


            return $filteredUserRequests;

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function estimated_fare(Request $request)
    {
        // Log::info('Estimate', $request->all());
        $this->validate($request, [
            's_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
        ]);

        try {

            $s_latitude = $request->s_latitude;
            $s_longitude = $request->s_longitude;
            $d_latitude = $request->d_latitude;
            $d_longitude = $request->d_longitude;

            $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
            
            $meter = $googleDistanceAndTime['distanceValue'];
            $seconds = $googleDistanceAndTime['durationValue'];
            $time = $googleDistanceAndTime['durationText'];
            $origin_address = $googleDistanceAndTime['originAddress'];
            $destination_address = $googleDistanceAndTime['destinationAddress'];
            $kilometer = Helper::applyDistanceSystem($meter);
            $minutes = $seconds / 60;
            $hours = $seconds / 3600;

            // $service_type = ServiceType::findOrFail($request->service_type);

            $serviceTypeController = new ServiceTypeController();
            $service_type_id = $request->service_type;
            $service_type = $serviceTypeController->getServiceType($service_type_id, $s_latitude, $s_longitude);

            $extra_amount_percentage = Setting::get('extra_amount_percentage', '100');
            $price = $service_type->fixed;
            $phourfrom = $service_type->phourfrom;
            $phourto = $service_type->phourto;
            $pextra = $service_type->pextra == null ? 0 : $service_type->pextra;
            $base_distance = $service_type->distance;
            $kilometer0 = $base_distance;
            // $base_price = $base_distance > 0 ? $price : 0; //TODO: for handling base price with distance
            $base_price = $price;
            $finalprice = 0;
            $isextraprice = 0;
            $extraprice = 0;
            $vweight = $request->vweight ? $request->vweight : 0;

            $schedule_date = null;
            $schedule_time = null;
            $schedule_web = null;
            if ($request->has('schedule_web')  && $request->schedule_web == 'yes') {
                $schedule_web = $request->schedule_web;
            }

            if ($request->has('schedule_date') && $request->has('schedule_time')) {
                $schedule_date = $request->schedule_date;
                $schedule_time = $request->schedule_time;
            }

            $calculationData = $this->calculatePricingWithServiceType($service_type, $schedule_date, $schedule_time, $schedule_web, $kilometer, $seconds, $origin_address, $destination_address, $s_latitude, $s_longitude, $vweight);

            $ridePrice = $calculationData['ridePrice'];
            $rideReturnPrice = $calculationData['rideReturnPrice'];
            $price = $calculationData['price'];
            $return_price = $calculationData['return_price'];
            $peakActive = $calculationData['peakActive'];
            $peakValue = $calculationData['peakValue'];
            $peakPrice = $calculationData['peakPrice'];
            $peakReturnPrice = $calculationData['peakReturnPrice'];
            $peakType = $calculationData['peakType'];
            $surgeActive = $calculationData['surgeActive'];
            $surgeReturnActive = $calculationData['surgeReturnActive'];
            $surgePrice = $calculationData['surgePrice'];
            $surgeReturnPrice = $calculationData['surgeReturnPrice'];
            $surgePercentage = $calculationData['surge_percentage'];
            $bookingFeeActive = $calculationData['bookingFeeActive'];
            $bookingFeeAmount = $calculationData['bookingFeeAmount'];
            $commission_tax_apply = $calculationData['commission_tax_apply'];
            $commission_type = $calculationData['commission_type'];
            $commission_percentage = $calculationData['commission_percentage'];
            $commission_deduction = $calculationData['commission_deduction'];
            $commission_price = $calculationData['commission_price'];
            $commission_return_price = $calculationData['commission_return_price'];
            $commission_source = $calculationData['commission_source'];
            $tax_active = $calculationData['tax_active'];
            $tax_percentage = $calculationData['tax_percentage'];
            $tax_price = $calculationData['tax_price'];
            $return_tax_price = $calculationData['return_tax_price'];
            $government_charges_active = $calculationData['government_charges_active'];
            $government_charges = $calculationData['government_charges'];
            $toll_fee_active = $calculationData['toll_fee_active'];
            $toll_fee = $calculationData['toll_fee'];
            $airport_charges_active = $calculationData['airport_charges_active'];
            $airport_charges = $calculationData['airport_charges'];
            $total = $calculationData['total'];
            $return_total = $calculationData['return_total'];
            $grand_total = $calculationData['grand_total'];
            $grand_return_total = $calculationData['grand_return_total'];
            $isextraprice = $calculationData['isextraprice'];
            $additionalCharges = $calculationData['additionalCharges'];
            $bank_charges_active = $calculationData['bank_charges_active'];
            $bank_charges_type = $calculationData['bank_charges_type'];
            $bank_charges_value = $calculationData['bank_charges_value'];
            $bank_charges_amount = $calculationData['bank_charges_amount'];
            $bank_charges_return_amount = $calculationData['bank_charges_return_amount'];

            $kilometer_tiers = Helper::kilometer_tiers($kilometer, $service_type);
            $condition = $kilometer_tiers['condition'];
            $calcKilometers = $kilometer_tiers['calcKilometers'];
            $kilometer1 = $kilometer_tiers['kilometer1'];
            $kilometer2 = $kilometer_tiers['kilometer2'];
            $kilometer3 = $kilometer_tiers['kilometer3'];
            $kilometer4 = $kilometer_tiers['kilometer4'];
            $tier = $kilometer_tiers['tier'];

            $service_type = $this->getServicesWithMultiLanguageAndByServiceTypeId($service_type->id ,$request);

            return response()->json([
                'name' =>  $service_type->name,
                'is_return_trip' =>  $service_type->is_return_trip,
                'estimated_fare' => Helper::customRoundtoMultiple($total, 2),
                'return_estimated_fare' => Helper::customRoundtoMultiple($return_price, 2),
                'distance' => Helper::customRoundtoMultiple($kilometer, 2),
                'time' => $time,
                'ride_amount' => $ridePrice,
                'return_ride_amount' => $rideReturnPrice,
                'peak_active' => (int) $peakActive,
                'peak_value' => $peakValue,
                'peak_type' => $peakType,
                'peak_price' => Helper::customRoundtoMultiple($peakPrice, 2),
                'return_peak_price' => Helper::customRoundtoMultiple($peakReturnPrice, 2),
                'surge_active' => (int) $surgeActive,
                'return_surge_active' => (int) $surgeReturnActive,
                'surge_percentage' => $surgePercentage,
                'surge' => Helper::customRoundtoMultiple($surgePrice, 2),
                'return_surge' => Helper::customRoundtoMultiple($surgeReturnPrice, 2),
                'commission_active' => (int) $commission_deduction,
                'commision' => Helper::customRoundtoMultiple($commission_price, 2),
                'return_commision' => Helper::customRoundtoMultiple($commission_return_price, 2),
                'commission_type' => $commission_type,
                'commission_value' => $commission_percentage,
                'commission_source' => $commission_source,
                'government_charges_active' => (int) $government_charges_active,
                'government_charges' => Helper::customRoundtoMultiple($government_charges, 2),
                'toll_fee_active' => (int) $toll_fee_active,
                'toll_fee' => Helper::customRoundtoMultiple($toll_fee, 2),
                'airport_charges_active' => (int) $airport_charges_active,
                'airport_charges' => Helper::customRoundtoMultiple($airport_charges, 2),
                'bank_charges_active' => (int) $bank_charges_active,
                'bank_charges_type' => $bank_charges_type,
                'bank_charges_value' => $bank_charges_value,
                'bank_charges_amount' => Helper::customRoundtoMultiple($bank_charges_amount, 2),
                'return_bank_charges_amount' => Helper::customRoundtoMultiple($bank_charges_return_amount, 2),
                'tax_active' => (int) $tax_active,
                'tax_percentage' => $tax_percentage,
                'tax' => Helper::customRoundtoMultiple($tax_price, 2),
                'return_tax' => Helper::customRoundtoMultiple($return_tax_price, 2),
                'booking_fee_active' => (int) $bookingFeeActive,
                'booking_fee' => Helper::customRoundtoMultiple($bookingFeeAmount, 2),
                'eta_total' => Helper::customRoundtoMultiple($grand_total, 2),
                'eta_return_total' => Helper::customRoundtoMultiple($grand_return_total, 2),
                'eta_total_cash' => Helper::customRoundtoMultiple($total, 2),
                'eta_return_total_cash' => Helper::customRoundtoMultiple($return_total, 2),
                'wallet_balance' => Auth::user()->wallet_balance,
                'round_off' => Helper::customRoundtoMultiple($tax_price, 2),
                'total' => Helper::customRoundtoMultiple($grand_total, 2),
                'return_total' => Helper::customRoundtoMultiple($grand_return_total, 2),
                'total_cash' => Helper::customRoundtoMultiple($total, 2),
                'return_total_cash' => Helper::customRoundtoMultiple($return_total, 2),
                //for testing purpose
                'condition' => $condition,
                'calcKilometers' => Helper::customRoundtoMultiple($calcKilometers, 2),
                'bp' => Helper::customRoundtoMultiple($base_price, 2),
                'tier' => Helper::customRoundtoMultiple($tier, 2),
                'km1' => Helper::customRoundtoMultiple($kilometer1, 2),
                'km2' => Helper::customRoundtoMultiple($kilometer2, 2),
                'km3' => Helper::customRoundtoMultiple($kilometer3, 2),
                'km4' => Helper::customRoundtoMultiple($kilometer4, 2),
                'hours' => $hours,
                'mins' => $minutes,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong'), 'detail' => $e->getMessage()], 500);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function trip_details(Request $request)
    {

        $this->validate($request, [

            'request_id' => 'required|integer|exists:user_requests,id',

        ]);

        try {

            $userRequests = UserRequests::UserTripDetails(Auth::user()->id, $request->request_id)->with('payment')->get();

            if (!empty($userRequests)) {

                $map_icon = asset('asset/img/marker-start.png');

                foreach ($userRequests as $key => $value) {

                    $userRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .

                        "autoscale=1" .

                        "&size=320x130" .

                        "&maptype=terrian" .

                        "&format=png" .

                        "&visual_refresh=true" .

                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .

                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .

                        "&path=color:0x191919|weight:3|enc:" . $value->route_key .

                        "&key=" . Setting::get('map_key') . "&units=" . Setting::get('distance_system', 'metric');

                    if (Setting::get('invoice', 0) == 1 && $value->status == 'COMPLETED') {
                        $userRequests[$key]->invoice_url = route('app.invoice', [$value->id]);
                    }
                }

            }

            $filteredUserRequests = [];
            foreach($userRequests as $userRequest){
                unset($userRequest->service_type);
                $userRequest['service_type'] = $this->getServicesWithMultiLanguageAndByServiceTypeId($userRequest->service_type_id,$request);
                $filteredUserRequests[] = $userRequest;

            }


            return $filteredUserRequests;

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    function getDistance($method, $url, $data)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        //dd($url);
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, Setting::get('dis_code') . "fMzJxKRzPrjbBCnLxpUJRZjprEHiKaVxweYBhNRRayFYsWsQhHrMyAEQA");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        //dd($result);
        // if (!$result){die("Connection Failure");}
        curl_close($curl);
        // return $result;
        return true;
    }

    /**
     * get all promo code.
     *
     * @return Response
     */

    public function promocodes()
    {

        try {

            $this->check_expiry();

            return PromocodeUsage::Active()
                ->where('user_id', Auth::user()->id)
                ->with('promocode')
                ->get();

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    /**
     * get all subscriptions.
     *
     * @return Response
     */

    public function getSubscriptions(Request $request)
    {   
        

        try {
            $currency = trans('currency.' . Setting::get('currency'));
           
            $subscriptions = $this->getSubscriptionNames('DRIVER', $request);
            $provider = Auth::user();
            $trial_end_time = $provider->trial_end_time;

            $subscription_status = $provider->subscription_status;
            $subscriptionArray = [];
            $is_sub = false;
            
            foreach ($subscriptions as $index => $subscription) {
                $subscriptionArray[$index]['id'] = $subscription->id;
                $subscriptionArray[$index]['pkg_id'] = Str::snake('pkg_' . strtolower($subscription->title));
                $subscriptionArray[$index]['is_sub'] = ($subscription->id == $provider->subscription_id && ($provider->rides_left > 0 || $subscription->rides == 'Unlimited'))  ? true : false;
                $subscriptionArray[$index]['title'] = $subscription->translations[0]->name;
                $subscriptionArray[$index]['amount'] = $currency . $subscription->value;
                $subscriptionArray[$index]['rides_count'] = $subscription->rides;
                $is_sub = $is_sub || $subscriptionArray[$index]['is_sub'];
                if ($subscriptionArray[$index]['is_sub']) {
                    $currentDateTime = Carbon::now()->startOfDay();
                    $subscriptionEndDateTime = new Carbon($provider->subscription_end_time);
                    $diffInDays = $currentDateTime->diffInDays($subscriptionEndDateTime->endOfDay(), false);
                    $subscriptionArray[$index]['remaining_days'] =  $diffInDays;
                    $subscriptionArray[$index]['rides_left'] = $provider->rides_left == -1 ? 'Unlimited' : (string) $provider->rides_left;
                }
            }

            $stripe_customer_id = $this->customer_id();
            $this->set_stripe();
            $subscribe = reset((\Stripe\Subscription::all(['customer' => $stripe_customer_id]))->data);

            $responseArray['is_trial'] = false;
            $responseArray['trial_expires'] = "";

            if(Setting::get('subscription_module_stripe_trial' , 0) == 1 && isset($subscribe) && $subscribe) {
                if ($subscribe->status == 'trialing') {
                    $responseArray['is_trial'] = true;
                    $diffInDays = Carbon::now()->startOfDay()->diffInDays(date('Y-m-d H:i:s', $subscribe->trial_end), false);
                    $responseArray['trial_expires'] = $diffInDays > 0 ? "Trial expires in  $diffInDays day(s)" : "";
                }
            } else {
                if ($subscription_status == 'trialing') {
                    $responseArray['is_trial'] = true;
                    $diffInDays = Carbon::now()->startOfDay()->diffInDays($trial_end_time, false);
                    $responseArray['trial_expires'] = $diffInDays > 0 ? "Trial expires in  $diffInDays day(s)" : "";
                }
            }

            $responseArray['status'] = 200;
            $responseArray['message'] = translateKeywordApis("subscriptions_fetched_successfully", $request);
            $responseArray['packages'] = $subscriptionArray;
            $responseArray['is_sub'] = $is_sub;

            return $responseArray;

        } catch (Exception $e) {
            throw $e;
            return response()->json(['error' => translateKeywordApis("something_went_wrong", $request), 'data' => $e->getMessage()], 500);
        }
    }

    private function getSubscriptionNames($type, $request){
        $language_id = getLanguageIdFromApis($request);
        $default_language_id = getDefautlLanguage();

        $subscriptions = Subscription::whereHas('translations', function($query) use($language_id) {
            $query->where('language_id', $language_id);
        })
        ->with(['translations' => function($query) use($language_id) {
            $query->where('language_id', $language_id);
        }])
        ->where('type', $type)
                ->get(['id', 'title', 'value', 'rides']);

        if ($subscriptions->isEmpty()) {
            $subscriptions = Subscription::whereHas('translations', function($query) use($default_language_id) {
                        $query->where('language_id', $default_language_id);
                    })
                    ->with(['translations' => function($query) use($default_language_id) {
                        $query->where('language_id', $default_language_id);
                    }])
                    ->where('type', $type)
                    ->get(['id', 'title', 'value', 'rides']);
        }

        // Get only the first translation if it exists
        $subscriptions->each(function ($subscription) {
            if ($subscription->translations->isNotEmpty()) {
                $subscription->setRelation('translations', $subscription->translations->take(1));
            }
        });

        return $subscriptions;


    }


    public function getSubscriptionsForUser(Request $request)
    {

        try {
            $currency = trans('currency.' . Setting::get('currency'));

            
            $subscriptions = $this->getSubscriptionNames('USER', $request);
            $user = Auth::user();
            $trial_end_time = $user->trial_end_time;
            $subscription_status = $user->subscription_status;
            $subscriptionArray = [];
            $is_sub = false;

            foreach ($subscriptions as $index => $subscription) {
                $subscriptionArray[$index]['id'] = $subscription->id;
                $subscriptionArray[$index]['pkg_id'] = Str::snake('pkg_' . strtolower($subscription->title));
                $subscriptionArray[$index]['is_sub'] = ($subscription->id == $user->subscription_id && ($user->rides_left > 0 || $subscription->rides == 'Unlimited')) ? true : false;
                $subscriptionArray[$index]['title'] = $subscription->translations[0]->name;
                $subscriptionArray[$index]['amount'] = $currency . $subscription->value;
                $subscriptionArray[$index]['rides_count'] = $subscription->rides;
                $is_sub = $is_sub || $subscriptionArray[$index]['is_sub'];
                if ($subscriptionArray[$index]['is_sub']) {
                    $currentDateTime = Carbon::now()->startOfDay();
                    $subscriptionEndDateTime = new Carbon($user->subscription_end_time);
                    $diffInDays = $currentDateTime->diffInDays($subscriptionEndDateTime->endOfDay(), false);
                    $subscriptionArray[$index]['remaining_days'] =  $diffInDays;
                    $subscriptionArray[$index]['rides_left'] = $user->rides_left == -1 ? 'Unlimited' : (string) $user->rides_left;
                }
            }

            $stripe_customer_id = $this->customer_id();
            $this->set_stripe();
            $subscribe = reset((\Stripe\Subscription::all(['customer' => $stripe_customer_id]))->data);

            $responseArray['is_trial'] = false;
            $responseArray['trial_expires'] = "";

            if(Setting::get('subscription_module_stripe_trial' , 0) == 1 && isset($subscribe) && $subscribe) {
                if ($subscribe->status == 'trialing') {
                    $responseArray['is_trial'] = true;
                    $diffInDays = Carbon::now()->startOfDay()->diffInDays(date('Y-m-d H:i:s', $subscribe->trial_end), false);
                    $responseArray['trial_expires'] = $diffInDays > 0 ? "Trial expires in  $diffInDays day(s)" : "";
                }
            } else {
                if ($subscription_status == 'trialing') {
                    $responseArray['is_trial'] = true;
                    $diffInDays = Carbon::now()->startOfDay()->diffInDays($trial_end_time, false);
                    $responseArray['trial_expires'] = $diffInDays > 0 ? "Trial expires in  $diffInDays day(s)" : "";
                }
            }

            $responseArray['status'] = 200;
            $responseArray['message'] = 'Subscriptions fetched successfully!';
            $responseArray['packages'] = $subscriptionArray;
            $responseArray['is_sub'] = $is_sub;

            return $responseArray;

        } catch (Exception $e) {
            throw $e;
            return response()->json(['error' => trans('api.something_went_wrong'), 'data' => $e->getMessage()], 500);
        }

    }

    /**
     * setting stripe.
     *
     * @return Response
     */
    public function set_stripe()
    {
        return Stripe::setApiKey(Setting::get('stripe_secret_key'));
    }

    /**
     * Get a stripe customer id.
     *
     * @return Response
     */
    public function customer_id()
    {
        if (Auth::user()->stripe_cust_id != null) {

            return Auth::user()->stripe_cust_id;

        } else {

            try {

                $stripe = $this->set_stripe();

                $customer = Customer::create([
                    'email' => Auth::user()->email,
                ]);

                User::where('id', Auth::user()->id)->update(['stripe_cust_id' => $customer['id']]);
                return $customer['id'];

            } catch (Exception $e) {
                return $e;
            }
        }
    }

    /**
     * Get a stripe customer id.
     *
     * @return Response
     */
    public function driver_id()
    {
        if (Auth::user()->stripe_cust_id != null) {

            return Auth::user()->stripe_cust_id;

        } else {

            try {

                $stripe = $this->set_stripe();

                $customer = Customer::create([
                    'email' => Auth::user()->email,
                ]);

                Provider::where('id', Auth::user()->id)->update(['stripe_cust_id' => $customer['id']]);
                return $customer['id'];

            } catch (Exception $e) {
                return $e;
            }
        }
    }

    /**
     * set subscription.
     *
     * @return Response
     */

    public function setSubscription(Request $request)
    {

        try {
            $subscription_id = $request->subscription_id;
            $provider = Auth::user();
            $provider_id = $provider->id;
            $current_subscription_id = $provider->subscription_id;
            $provider = Provider::find($provider_id);

            $cardCount = Card::where('user_id', Auth::user()->id)->where('type', 'Provider')->count();
            if ($cardCount == 0) {
                $responseArray['status'] = 450;
                $responseArray['message'] = translateKeywordApis("no_card_found_please_add_card", $request);
                return $responseArray;
            }

            $subscription = Subscription::where('type', 'DRIVER')->where('id', $subscription_id)->get(['trial_period', 'stripe_price_id', 'title', 'rides'])->first();
            if (!$subscription)
                return response()->json(['error' => translateKeywordApis("Subscription not found", $request)]);

            if (($current_subscription_id != null || $current_subscription_id == $subscription_id) && ($subscription->rides != 'Unlimited' && ($provider->rides_left > 0 || $provider->rides_left != null))) {
                $responseArray['status'] = 500;
                $responseArray['message'] = translateKeywordApis('subscription_already_taken', $request);
            } else {

                $stripe_customer_id = $this->driver_id();
                $this->set_stripe();

                $subscriptions = \Stripe\Subscription::all(['customer' => $stripe_customer_id]);
                foreach ($subscriptions->data as $subscriptionData) {
                    $subscriptionToCancel = \Stripe\Subscription::retrieve($subscriptionData->id);
                    $subscriptionToCancel->cancel();
                }

                $existing_rides_left = 0;
                // If already subscribed and subscription is not expired
                if (
                    $current_subscription_id && // subscription exists
                    is_numeric($subscription->rides) && // subscription is not unlimited
                    $provider->rides_left != -1 && // existing subscription is not unlimited
                    strtotime($provider->subscription_end_time) >= time()
                ) 
                    $existing_rides_left = $provider->rides_left;
                

                $subscription_obj = ['customer' => $stripe_customer_id,
                    'items' => [
                        ['price' => $subscription->stripe_price_id],
                        // "receipt_email" => Auth::user()->email
                    ],
                    'collection_method' => 'charge_automatically',
                    'payment_behavior' => 'error_if_incomplete',
                ];

                $trial_end_time = null;
                $subscription_status = null;
                if (!$provider->trial_availed) {
                    if(Setting::get('subscription_module_stripe_trial' , 0) == 1 && isset($subscribe) && $subscribe) {
                        $subscription_obj['trial_period_days'] = $subscription->trial_period > 0 ? $subscription->trial_period : 0;
                        $subscription_status = 'trialing';
                    } else {
                        $subscription_obj['trial_period_days'] = 0;
                        $subscription_status = 'active';
                    }

                    $driver_trial_period = Setting::get('driver_trial_period' , 0);
                    if($driver_trial_period > 0) {
                        $trial_end_time = Carbon::now()->addDays($driver_trial_period);
                        $subscription_status = 'trialing';
                    } else {
                        $subscription_status = 'active';
                    }
                }
                
                $subscribe = \Stripe\Subscription::create($subscription_obj);

                $subscription_end_time = date('Y-m-d H:i:s', $subscribe->current_period_end);
                Provider::where('id', $provider_id)->update([
                    'subscription_id' => $subscription_id,
                    'stripe_subscription_id' => $subscribe->id,
                    'subscription_start_time' => date('Y-m-d H:i:s', $subscribe->current_period_start),
                    'subscription_end_time' => $subscription_end_time,
                    'rides_left' => is_numeric($subscription->rides) ? $subscription->rides: -1,
                    'trial_end_time' => $trial_end_time != null ? $trial_end_time : null,
                    'trial_availed' => 1,
                    'is_subscribed' => 1
                ]);

                $currency = trans('currency.' . Setting::get('currency'));

                $subscriptions = Subscription::where('type', 'DRIVER')->get(['id', 'title', 'value', 'rides']);
                $subscriptionArray = [];
                $is_sub = false;
                
                foreach ($subscriptions as $index => $subscription) {
                    $subscriptionArray[$index]['id'] = $subscription->id;
                    $subscriptionArray[$index]['pkg_id'] = Str::snake('pkg_' . strtolower($subscription->title));
                    $subscriptionArray[$index]['is_sub'] = $subscription->id == $subscription_id ? true : false;
                    $subscriptionArray[$index]['title'] = $subscription->title;
                    $subscriptionArray[$index]['amount'] = $currency . $subscription->value;
                    $subscriptionArray[$index]['rides_count'] = $subscription->rides;
                    $is_sub = $is_sub || $subscriptionArray[$index]['is_sub'];
                    if ($subscriptionArray[$index]['is_sub']) {
                        $currentDateTime = Carbon::now()->startOfDay();
                        $subscriptionEndDateTime = new Carbon($subscription_end_time);
                        $diffInDays = $currentDateTime->diffInDays($subscriptionEndDateTime->endOfDay(), false);
                        $subscriptionArray[$index]['remaining_days'] =  $diffInDays;
                        $subscriptionArray[$index]['rides_left'] = is_numeric($subscription->rides) ? (string) ($subscription->rides): "Unlimited";
                    }
                }

                $responseArray['is_trial'] = false;
                $responseArray['trial_expires'] = "";

                if(Setting::get('subscription_module_stripe_trial' , 0) == 1 && isset($subscribe) && $subscribe) {
                    if ($subscribe->status == 'trialing') {
                        $responseArray['is_trial'] = true;
                        $diffInDays = Carbon::now()->startOfDay()->diffInDays(date('Y-m-d H:i:s', $subscribe->trial_end), false);
                        $responseArray['trial_expires'] = $diffInDays > 0 ? translateKeywordApis('trial_expires_in', $request) . "  $diffInDays " . translateKeywordApis('days', $request) : "";
                    }
                } else {
                    if ($subscription_status == 'trialing') {
                        $responseArray['is_trial'] = true;
                        $diffInDays = Carbon::now()->startOfDay()->diffInDays($trial_end_time, false);
                        $responseArray['trial_expires'] = $diffInDays > 0 ? translateKeywordApis('trial_expires_in', $request) . "  $diffInDays " . translateKeywordApis('days', $request) : "";
                    }
                }

                $responseArray['status'] = 200;
                $responseArray['message'] = translateKeywordApis('subscription_has_been_added_successfully', $request);
                $responseArray['packages'] = $subscriptionArray;
                $responseArray['is_sub'] = $is_sub;

                return $responseArray;
            }


            return $responseArray;

        } catch (Exception $e) {
            return response()->json(['error' => translateKeywordApis('something_went_wrong', $request), 'data' => $e->getMessage()], 500);

        }

    }

    public function setSubscriptionForUser(Request $request)
    {

        try {
            $subscription_id = $request->subscription_id;
            $user = Auth::user();
            $user_id = $user->id;
            $current_subscription_id = Auth::user()->subscription_id;
            $user = User::find($user_id);

            $cardCount = Card::where('user_id', Auth::user()->id)->where('type', 'User')->count();
            if ($cardCount == 0) {
                $responseArray['status'] = 450;
                $responseArray['message'] = "No card found, please add card.";
                return $responseArray;
            }

            $subscription = Subscription::where('type', 'USER')->where('id', $subscription_id)->get(['trial_period', 'stripe_price_id', 'title', 'rides'])->first();
            if (!$subscription)
                return response()->json([ 'error' => 'Subscription not found.' ]);
            
            if (($current_subscription_id != null || $current_subscription_id == $subscription_id) && ($subscription->rides != 'Unlimited' && ($user->rides_left > 0 || $user->rides_left != null))) {
                $responseArray['status'] = 500;
                $responseArray['message'] = 'Subscription already taken!';
            } else {

                $stripe_customer_id = $this->customer_id();
                $this->set_stripe();

                $subscriptions = \Stripe\Subscription::all(['customer' => $stripe_customer_id]);
                foreach ($subscriptions->data as $subscriptionData) {
                    $subscriptionToCancel = \Stripe\Subscription::retrieve($subscriptionData->id);
                    $subscriptionToCancel->cancel();
                }

                $existing_rides_left = 0;
                // If already subscribed and subscription is not expired
                if (
                    $current_subscription_id && // subscription exists
                    is_numeric($subscription->rides) && // subscription is not unlimited
                    $user->rides_left != -1 && // existing subscription is not unlimited
                    strtotime($user->subscription_end_time) >= time()
                ) 
                    $existing_rides_left = $user->rides_left;
                

                $subscription_obj = ['customer' => $stripe_customer_id,
                    'items' => [
                        ['price' => $subscription->stripe_price_id],
                        // "receipt_email" => Auth::user()->email
                    ],
                    'collection_method' => 'charge_automatically',
                    'payment_behavior' => 'error_if_incomplete',
                ];

                $trial_end_time = null;
                $subscription_status = null;
                if (!$user->trial_availed) {
                    if(Setting::get('subscription_module_stripe_trial' , 0) == 1 && isset($subscribe) && $subscribe) {
                        $subscription_obj['trial_period_days'] = $subscription->trial_period > 0 ? $subscription->trial_period : 0;
                        $subscription_status = 'trialing';
                    } else {
                        $subscription_obj['trial_period_days'] = 0;
                        $subscription_status = 'active';
                    }

                    $rider_trial_period = Setting::get('rider_trial_period' , 0);
                    if($rider_trial_period > 0) {
                        $trial_end_time = Carbon::now()->addDays($rider_trial_period);
                        $subscription_status = 'trialing';
                    } else {
                        $subscription_status = 'active';
                    }
                }

                $subscribe = \Stripe\Subscription::create($subscription_obj);

                $status = 'approved';

                $subscription_end = date('Y-m-d H:i:s', $subscribe->current_period_end);
                User::where('id', $user_id)->update([
                    'subscription_id' => $subscription_id,
                    'stripe_subscription_id' => $subscribe->id,
                    'subscription_start_time' => date('Y-m-d H:i:s', $subscribe->current_period_start),
                    'subscription_end_time' => $subscription_end,
                    'rides_left' => is_numeric($subscription->rides) ? $subscription->rides: -1,
                    'trial_end_time' => $trial_end_time != null ? $trial_end_time : null,
                    'trial_availed' => 1,
                    'is_subscribed' => 1,
                    'status' => $status
                ]);

                $currency = trans('currency.' . Setting::get('currency'));

                $subscriptions = Subscription::where('type', 'USER')->get(['id', 'title', 'value', 'rides']);
                $subscriptionArray = [];
                $is_sub = false;

                foreach ($subscriptions as $index => $subscription) {
                    $subscriptionArray[$index]['id'] = $subscription->id;
                    $subscriptionArray[$index]['pkg_id'] = Str::snake('pkg_' . strtolower($subscription->title));
                    $subscriptionArray[$index]['is_sub'] = $subscription->id == $subscription_id ? true : false;
                    $subscriptionArray[$index]['title'] = $subscription->title;
                    $subscriptionArray[$index]['amount'] = $currency . $subscription->value;
                    $subscriptionArray[$index]['rides_count'] = $subscription->rides;
                    $is_sub = $is_sub || $subscriptionArray[$index]['is_sub'];
                    if ($subscriptionArray[$index]['is_sub']) {
                        $currentDateTime = Carbon::now()->startOfDay();
                        $subscriptionEndDateTime = new Carbon($subscription_end);
                        $diffInDays = $currentDateTime->diffInDays($subscriptionEndDateTime->endOfDay(), false);
                        $subscriptionArray[$index]['remaining_days'] =  $diffInDays;
                        $subscriptionArray[$index]['rides_left'] = is_numeric($subscription->rides) ? (string) ($subscription->rides): "Unlimited";
                    }
                }

                $responseArray['is_trial'] = false;
                $responseArray['trial_expires'] = "";

                if(Setting::get('subscription_module_stripe_trial' , 0) == 1 && isset($subscribe) && $subscribe) {
                    if ($subscribe->status == 'trialing') {
                        $responseArray['is_trial'] = true;
                        $diffInDays = Carbon::now()->startOfDay()->diffInDays(date('Y-m-d H:i:s', $subscribe->trial_end), false);
                        $responseArray['trial_expires'] = $diffInDays > 0 ? "Trial expires in  $diffInDays day(s)" : "";
                    }
                } else {
                    if ($subscription_status == 'trialing') {
                        $responseArray['is_trial'] = true;
                        $diffInDays = Carbon::now()->startOfDay()->diffInDays($trial_end_time, false);
                        $responseArray['trial_expires'] = $diffInDays > 0 ? "Trial expires in  $diffInDays day(s)" : "";
                    }
                }

                $responseArray['status'] = 200;
                $responseArray['message'] = 'Subscription has been added successfully!';
                $responseArray['packages'] = $subscriptionArray;
                $responseArray['is_sub'] = $is_sub;
                
                return $responseArray;
            }

            return $responseArray;

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong'), 'data' => $e->getMessage()], 500);

        }

    }

    /**
     * set subscription.
     *
     * @return Response
     */

    public function cancelSubscription(Request $request)
    {

        try {
            $provider = Auth::user();
            
            if ($provider->stripe_subscription_id) {
                $stripe_customer_id = $this->customer_id();
                $this->set_stripe();
                $active_subscription = (\Stripe\Subscription::all(['customer' => $stripe_customer_id]))->data;

                foreach($active_subscription as $subscription)
                    $subscription->cancel();
            }

            $provider->update([
                'subscription_id' => null,
                'stripe_subscription_id' => null,
                // 'rides_left' => 0
            ]);

            $currency = trans('currency.' . Setting::get('currency'));
            $subscriptions = $this->getSubscriptionNames('DRIVER', $request);
            $subscriptionArray = [];
            $is_sub = false;
            
            foreach ($subscriptions as $index => $subscription) {
                $subscriptionArray[$index]['id'] = $subscription->id;
                $subscriptionArray[$index]['pkg_id'] = Str::snake('pkg_' . strtolower($subscription->title));
                $subscriptionArray[$index]['is_sub'] = ($subscription->id == $provider->subscription_id && $provider->rides_left > 0) ? true : false;
                $subscriptionArray[$index]['title'] = $subscription->translations[0]->name;
                $subscriptionArray[$index]['amount'] = $currency . $subscription->value;
                $subscriptionArray[$index]['rides_count'] = $subscription->rides;
                $is_sub = $is_sub || $subscriptionArray[$index]['is_sub'];
                if ($subscriptionArray[$index]['is_sub']) {
                    $currentDateTime = Carbon::now()->startOfDay();
                    $subscriptionEndDateTime = new Carbon($provider->subscription_end_time);
                    $diffInDays = $currentDateTime->diffInDays($subscriptionEndDateTime->endOfDay(), false);
                    $subscriptionArray[$index]['remaining_days'] =  $diffInDays;
                    $subscriptionArray[$index]['rides_left'] = $provider->rides_left == -1 ? 'Unlimited' : (string) $provider->rides_left;
                }
            }

            $responseArray['status'] = 200;
            $responseArray['packages'] = $subscriptionArray;
            $responseArray['message'] = 'Subscription has been cancelled successfully!';

            return $responseArray;

        } catch (Exception $e) {
            throw $e;
            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    public function cancelSubscriptionForUser(Request $request)
    {

        try {
            $user = Auth::user(); 
            
            if ($user->stripe_subscription_id) {
                $stripe_customer_id = $this->customer_id();
                $this->set_stripe();
                $active_subscription = (\Stripe\Subscription::all(['customer' => $stripe_customer_id]))->data;

                foreach($active_subscription as $subscription)
                    $subscription->cancel();
            }

            $user->update([
                'subscription_id' => null,
                'stripe_subscription_id' => null,
                // 'rides_left' => 0
            ]);

            $currency = trans('currency.' . Setting::get('currency'));
            $subscriptions = $this->getSubscriptionNames('DRIVER', $request);
            $subscriptionArray = [];
            $is_sub = false;
            
            foreach ($subscriptions as $index => $subscription) {
                $subscriptionArray[$index]['id'] = $subscription->id;
                $subscriptionArray[$index]['pkg_id'] = Str::snake('pkg_' . strtolower($subscription->title));
                $subscriptionArray[$index]['is_sub'] = ($subscription->id == $user->subscription_id && $user->rides_left > 0)? true : false;
                $subscriptionArray[$index]['title'] = $subscription->translations[0]->name;
                $subscriptionArray[$index]['amount'] = $currency . $subscription->value;
                $subscriptionArray[$index]['rides_count'] = $subscription->rides;
                $is_sub = $is_sub || $subscriptionArray[$index]['is_sub'];
                if ($subscriptionArray[$index]['is_sub']) {
                    $currentDateTime = Carbon::now()->startOfDay();
                    $subscriptionEndDateTime = new Carbon($user->subscription_end_time);
                    $diffInDays = $currentDateTime->diffInDays($subscriptionEndDateTime->endOfDay(), false);
                    $subscriptionArray[$index]['remaining_days'] =  $diffInDays;
                    $subscriptionArray[$index]['rides_left'] = $user->rides_left == -1 ? 'Unlimited' : (string) $user->rides_left;
                }
            }

            $responseArray['status'] = 200;
            $responseArray['packages'] = $subscriptionArray;
            $responseArray['message'] = 'Subscription has been cancelled successfully!';

            return $responseArray;

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }


    /**
     * get bank.
     *
     * @return Response
     */

    public function getBank()
    {

        try {
            $user_id = Auth::user()->id;

            $BankAccount = BankAccount::where('user_id', $user_id)->where('account_type', 'Rider')->get()->first();

            $responseArray['status'] = 200;
            $responseArray['data'] = $BankAccount;
            $responseArray['message'] = 'Bank account details successfully!';


            return $responseArray;

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    /**
     * get bank.
     *
     * @return Response
     */

    public function addBank(Request $request)
    {

        try {
            // $user_id = $request->id;
            $user_id = Auth::user()->id;

            $bankAccount = BankAccount::where('user_id', $user_id)->get(['id'])->first();

            if ($bankAccount == null) {
                $bankAccountCreate = BankAccount::create([
                    'account_name' => $request->name,
                    'type' => $request->type,
                    'account_type' => 'Rider',
                    'bank_name' => $request->bankname,
                    'account_number' => $request->accountnumber,
                    'routing_number' => $request->has('routing_number') ? $request->routing_number : '0',
                    'MICR_code' => $request->has('micr') ? $request->micr : '0',
                    'IFSC_code' => $request->has('ifsc') ? $request->ifsc : '0',
                    'user_id' => $user_id,
                    'status' => 'APPROVED',
                    'country' => $request->country,
                    'currency' => $request->currency
                ]);

                $bankAccount = $bankAccountCreate;


            } else {
                $bankAccountUpdate = BankAccount::where('id', $bankAccount->id)->update([
                    'account_name' => $request->name,
                    'type' => $request->type,
                    'account_type' => 'Rider',
                    'bank_name' => $request->bankname,
                    'account_number' => $request->accountnumber,
                    'routing_number' => $request->has('routing_number') ? $request->routing_number : '0',
                    'MICR_code' => $request->has('micr') ? $request->micr : '0',
                    'IFSC_code' => $request->has('ifsc') ? $request->ifsc : '0',
                    'user_id' => $user_id,
                    'status' => 'APPROVED',
                    'country' => $request->country,
                    'currency' => $request->currency
                ]);

                $bankAccount = BankAccount::where('id', $bankAccount->id)->get()->first();
            }

            $responseArray['status'] = 200;
            $responseArray['data'] = $bankAccount;
            $responseArray['message'] = 'Bank account details added successfully!';


            return $responseArray;

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    public function check_expiry()
    {

        try {

            $Promocode = Promocode::all();

            foreach ($Promocode as $index => $promo) {

                if (date("Y-m-d") > $promo->expiration) {

                    $promo->status = 'EXPIRED';

                    $promo->save();

                    PromocodeUsage::where('promocode_id', $promo->id)->update(['status' => 'EXPIRED']);

                } else {

                    PromocodeUsage::where('promocode_id', $promo->id)->update(['status' => 'ADDED']);

                }

            }

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    /**
     * add promo code.
     *
     * @return Response
     */

    public function add_promocode(Request $request)
    {

        $this->validate($request, [

            'promocode' => 'required|exists:promocodes,promo_code',

        ]);

        try {

            $find_promo = Promocode::where('promo_code', $request->promocode)->first();

            // $promo_passbook = new PromocodePassbook;
            // $promo_passbook->user_id = Auth::user()->id;
            // $promo_passbook->promocode_id = $find_promo->id;
            // $promo_passbook->status = "ADDED";
            // $promo->save();

            PromocodePassbook::create([

                'user_id' => Auth::user()->id,

                'promocode_id' => $find_promo->id,

                'status' => "ADDED"


            ]);


            if ($find_promo->status == 'EXPIRED' || (date("Y-m-d") > $find_promo->expiration)) {

                if ($request->ajax()) {

                    return response()->json([

                        'message' => trans('api.promocode_expired'),

                        'code' => 'promocode_expired'

                    ]);

                } else {

                    return back()->with('flash_error', trans('api.promocode_expired'));

                }

            } elseif (PromocodeUsage::where('promocode_id', $find_promo->id)->where('user_id', Auth::user()->id)->where('status', 'USED')->count() > 0) {

                if ($request->ajax()) {

                    return response()->json([

                        'message' => trans('api.promocode_already_in_use'),

                        'code' => 'promocode_already_in_use'

                    ]);

                } else {

                    return back()->with('flash_error', 'Promocode Already in use');

                }

            } elseif ($find_promo->max_count <= PromocodeUsage::where('promocode_id', $find_promo->id)->where('status', 'USED')->count()) {

                if ($request->ajax()) {

                    return response()->json([

                        'message' => 'Max Users Used',

                        'code' => 'promocode_already_in_use'

                    ]);

                } else {

                    return back()->with('flash_error', 'Promocode Already in use');

                }

            } else {

                $promo = new PromocodeUsage;

                $promo->promocode_id = $find_promo->id;

                $promo->user_id = Auth::user()->id;

                $promo->status = 'ADDED';

                $promo->save();

                if ($request->ajax()) {

                    return response()->json([

                        'message' => trans('api.promocode_applied'),

                        'code' => 'promocode_applied',

                        'amount' => $find_promo->discount

                    ]);

                } else {

                    return back()->with('flash_success', trans('api.promocode_applied'));

                }

            }

        } catch (Exception $e) {

            if ($request->ajax()) {

                return response()->json(['error' => trans('api.something_went_wrong')], 500);

            } else {

                return back()->with('flash_error', 'Something Went Wrong');

            }

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function upcoming_trips(Request $request)
    {
        try {
            // $userRequests = UserRequests::UserUpcomingTrips(Auth::user()->id)->get();
            $currentTime = Carbon::now()->toDateTimeString();

            $userRequests = UserRequests::where(function ($query) use ($currentTime) {
                $query->where('status', '=', 'SCHEDULED')
                    ->where('user_id', Auth::user()->id)
                    ->where('schedule_at', '>=', $currentTime);
            })
                ->orWhere([['status', 'REQUESTED'], ['user_id', Auth::user()->id]])
                ->with('service_type', 'provider')
                ->orderBy('schedule_at', 'ASC')
                ->get();

            if (!empty($userRequests)) {

                $map_icon = asset('asset/img/marker-start.png');

                foreach ($userRequests as $key => $value) {

                    $userRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .

                        "autoscale=1" .

                        "&size=320x130" .

                        "&maptype=terrian" .

                        "&format=png" .

                        "&visual_refresh=true" .

                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .

                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .

                        "&path=color:0x000000|weight:3|enc:" . $value->route_key .

                        "&key=" . Setting::get('map_key') . "&units=" . Setting::get('distance_system', 'metric');

                }

            }

            $filteredUserRequests = [];
            foreach($userRequests as $userRequest){
                unset($userRequest->service_type);
                $userRequest['service_type'] = $this->getServicesWithMultiLanguageAndByServiceTypeId($userRequest->service_type_id, $request);
                $filteredUserRequests[] = $userRequest;

            }


            return $filteredUserRequests;

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function upcoming_trip_details(Request $request)
    {

        $this->validate($request, [

            'request_id' => 'required|integer|exists:user_requests,id',

        ]);

        try {

            $userRequests = UserRequests::UserUpcomingTripDetails(Auth::user()->id, $request->request_id)->get();

            if (!empty($userRequests)) {

                $map_icon = asset('asset/img/marker-start.png');

                foreach ($userRequests as $key => $value) {

                    $userRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .

                        "autoscale=1" .

                        "&size=320x130" .

                        "&maptype=terrian" .

                        "&format=png" .

                        "&visual_refresh=true" .

                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .

                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .

                        "&path=color:0x000000|weight:3|enc:" . $value->route_key .

                        "&key=" . Setting::get('map_key') . "&units=" . Setting::get('distance_system', 'metric');

                }

            }

            $filteredUserRequests = [];
            foreach($userRequests as $userRequest){
                unset($userRequest->service_type);
                $userRequest['service_type'] = $this->getServicesWithMultiLanguageAndByServiceTypeId($userRequest->service_type_id, $request);
                $filteredUserRequests[] = $userRequest;

            }


            return $filteredUserRequests;

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    /**
     * Show the nearby providers.
     *
     * @return Response
     */

    public function show_providers(Request $request)
    {

        $this->validate($request, [

            'latitude' => 'required|numeric',

            'longitude' => 'required|numeric',

        ]);

        try {

            $distance = Setting::get('provider_search_radius', '10');

            $latitude = $request->latitude;

            $longitude = $request->longitude;

            if ($request->has('service')) {

                $activeProviders = ProviderService::AvailableServiceProvider($request->service)->where('is_selected', 1)->get()->pluck('provider_id');

                $providers = Provider::whereIn('id', $activeProviders)
                    ->where('status', 'approved')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->get();

            } else {

                $providers = Provider::where('status', 'approved')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->with("service")
                    ->whereHas('service', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->get();

            }

            if (count($providers) == 0) {

                if ($request->ajax()) {

                    return response()->json(['message' => "No Providers Found"]);

                } else {

                    return back()->with('flash_error', 'No Providers Found! Please try again.');

                }

            }

            return $providers;

        } catch (Exception $e) {

            if ($request->ajax()) {

                return response()->json(['error' => trans('api.something_went_wrong')], 500);

            } else {

                return back()->with('flash_error', 'Something went wrong while sending request. Please try again.');

            }

        }

    }

    /**
     * Forgot Password.
     *
     * @return Response
     */

    public function forgot_password(Request $request)
    {

        $this->validate($request, [

            'email' => 'required|email|exists:users,email',

        ]);

        try {

            $user = User::where('email', $request->email)->first();

            $otp = mt_rand(100000, 999999);

            $user->otp = $otp;

            $user->save();

            // Notification::send($user, new ResetPasswordOTP($otp));

            return response()->json([

                'message' => 'OTP sent to your email!',

                'user' => $user

            ]);

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    public function getUserNotifications()
    {
        try {

            $notifications = PushNotificationLog::where('receiver_id', Auth::user()->id)->where('app_type', 'User')->distinct()->orderBy('id', 'DESC')->get(['id', 'title', 'message', 'created_at']);

            return response()->json(['notifications' => $notifications, 'message' => 'Notifications fetched successfully!']);


        } catch (Exception $e) {


            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function deleteUserNotifications($id = null)
    {
        try {
            if ($id != null) {
                PushNotificationLog::where('id', $id)->where('app_type', 'User')->delete();
            } else {
                PushNotificationLog::where('receiver_id', Auth::user()->id)->where('app_type', 'User')->delete();
            }

            return response()->json(['message' => 'Notification(s) deleted successfully!']);


        } catch (Exception $e) {


            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function getDriverNotifications()
    {
        try {

            $notifications = PushNotificationLog::where('receiver_id', Auth::user()->id)->where('app_type', 'Driver')->distinct()->orderBy('id', 'DESC')->get(['id', 'title', 'message', 'created_at']);

            return response()->json(['notifications' => $notifications, 'message' => 'Notifications fetched successfully!']);


        } catch (Exception $e) {


            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function deleteDriverNotifications($id = null)
    {
        try {
            if ($id != null) {
                PushNotificationLog::where('id', $id)->where('app_type', 'Driver')->delete();
            } else {
                PushNotificationLog::where('receiver_id', Auth::user()->id)->where('app_type', 'Driver')->delete();
            }

            return response()->json(['message' => 'Notification(s) deleted successfully!']);


        } catch (Exception $e) {


            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    /**
     * Reset Password.
     *
     * @return Response
     */

    public function reset_password(Request $request)
    {

        $this->validate($request, [

            'password' => 'required|confirmed|min:6',

            'id' => 'required|numeric|exists:users,id'

        ]);

        try {

            $user = User::findOrFail($request->id);

            $user->password = bcrypt($request->password);

            $user->save();

            if ($request->ajax()) {

                return response()->json(['message' => 'Password Updated']);

            }

        } catch (Exception $e) {

            if ($request->ajax()) {

                return response()->json(['error' => trans('api.something_went_wrong')], 500);

            }

        }

    }

    public function verify(Request $request)

    {

        $this->validate($request, [

            'email' => 'required|email|max:255|unique:users',

        ]);

        try {

            return response()->json(['message' => trans('api.email_available')]);

        } catch (Exception $e) {

            return response()->json(['message' => trans('api.email_available')]);

        }

    }

    /**
     * Show the wallet usage.
     *
     * @return Response
     */

    public function wallet_passbook(Request $request)

    {

        try {

            return WalletPassbook::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    /**
     * Show the promo usage.
     *
     * @return Response
     */

    public function promo_passbook(Request $request)

    {

        try {

            return PromocodePassbook::where('user_id', Auth::user()->id)->with('promocode')->get();

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    /**
     * help Details.
     *
     * @return Response
     */

    public function help_details(Request $request)
    {

        try {

            if ($request->ajax()) {

                return response()->json([

                    'contact_number' => Setting::get('contact_number', ''),

                    'contact_email' => Setting::get('contact_email_address', '')

                ]);

            }

        } catch (Exception $e) {

            if ($request->ajax()) {

                return response()->json(['error' => trans('api.something_went_wrong')], 500);

            }

        }

    }

    public function deleteUser()
    {
        try {

            $user_id = Auth::user()->id;

            $checkRides = UserRequests::where('user_id', $user_id)
            ->whereIn('status', ['SEARCHING', 'ACCEPTED', 'STARTED', 'ARRIVED', 'PICKEDUP', 'DROPPED', 'COMPLETED', 'SCHEDULED'])
            ->get();

            if ($checkRides->count() > 0) {
                return response()->json(['error' => 'Account can\'t be deleted Ride is already in progress.'], 400);
            } 

            UserRequests::where('user_id', $user_id)->delete();
            UserRequestRating::where('user_id', $user_id)->delete();
            User::destroy($user_id);


            return response()->json(['message' => 'User deleted successfully!']);


        } catch (Exception $e) {


            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function deleteProvider()
    {
        try {

            $provider_id = Auth::user()->id;

            $checkRides = UserRequests::where('provider_id', $provider_id)
            ->whereIn('status', ['SEARCHING', 'ACCEPTED', 'STARTED', 'ARRIVED', 'PICKEDUP', 'DROPPED', 'COMPLETED', 'SCHEDULED'])
            ->get();

            if ($checkRides->count() > 0) {
                return response()->json(['error' => 'Account can\'t be deleted Ride is already in progress.'], 400);
            } 

            UserRequestRating::where('provider_id', $provider_id)->delete();
            ProviderDevice::where('provider_id', $provider_id)->delete();
            ProviderDocument::where('provider_id', $provider_id)->delete();
            ProviderProfile::where('provider_id', $provider_id)->delete();
            BankAccount::where('provider_id', $provider_id)->delete();

            Provider::destroy($provider_id);


            return response()->json(['message' => 'Provider deleted successfully!']);


        } catch (Exception $e) {


            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function getServicesDocuments()
    {
        try {
            $types = [];
            $serviceTypeController = new ServiceTypeController();
            $types = $serviceTypeController->getActiveServicesTypes();

            $services = ServiceType::whereIn('type', $types)->get(['id', 'name', 'type']);
            $documents = Document::where('type', 'VEHICLE')->get();

            return response()->json([

                'message' => 'Services and documents fetched successfully!',

                'services' => $services,

                'documents' => $documents


            ]);


        } catch (Exception $e) {


            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function createVehicle(Request $request)
    {
        try {

            $provider_id = Auth::user()->id;
            // $provider_id =1;
            $parentCreated = false;
            $parent_id = null;
            $vehicle = null;
            $is_selected = 0;
            $is_approved = 0;
            $status = 'offline';
            $doc_required = true;
            $servicesArray = explode(',', $request->service_type_id);

            foreach ($servicesArray as $index => $service_type_id) {
                if ($index == 0) {
                    $isChild = 0;
                } else {
                    $isChild = 1;
                }

                // This is for allowing only one vehicle to be registered in one service
                $providerServiceCount = ProviderService::where('service_type_id', $service_type_id)
                                                    ->where('service_number', strtolower($request->vehicle_number))
                                                    ->count();

                if ($providerServiceCount == 0) {

                    $serviceParent = ProviderService::where('service_model', $request->vehicle_model)
                                                    ->where('service_number', strtolower($request->vehicle_number))->whereNull('parent_id')->get([
                                                        'id', 'is_selected', 'status', 'is_approved'
                                                    ])
                                                    ->first();

                    if($serviceParent) {
                        $doc_required = $parentCreated ? true : false;
                        $parent_id = $serviceParent->id;
                        $isChild = 1;
                        $is_selected = $serviceParent->is_selected;
                        $status = $serviceParent->status;
                        // $is_approved = $serviceParent->is_approved;
                    }

                    $vehicle = ProviderService::create([
                        'service_type_id' => $service_type_id,
                        'provider_id' => $provider_id,
                        'status' => $status,
                        'service_model' => $request->vehicle_model,
                        'service_number' => $request->vehicle_number,
                        'service_weight_allowed_kg' => $request->vweight ? $request->vweight : 0,
                        'is_selected' => $is_selected,
                        'is_child' => $isChild,
                        'parent_id' => $parent_id,
                        'is_approved' => $is_approved
                    ]);

                    if (!$serviceParent && $index == 0) {
                        $parent_id = $vehicle->id;
                        $parentCreated = true;
                        $doc_required = true;
                    }
                }
            }


            return response()->json([

                'message' => $vehicle == null ?  'Vehicle and service is already added!' : 'Vehicle/service added successfully!',

                'vehicle' => $vehicle,

                'doc_required' => $vehicle == null ? false : $doc_required

            ]);


        } catch (Exception $e) {
            // dd($e);

            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function getVehicles()
    {
        try {

            $provider_id = Auth::user()->id;
            // $provider_id = 1;

            $vehicles = ProviderService::where('provider_id', $provider_id)->where('is_child', 0)->get();

            foreach ($vehicles as $vehicle) {
                $serviceTypeNamesArray = [];
                $serviceTypeDisableNamesArray = [];
                $vehicle_id = $vehicle->id;

                $serviceTypeIds = ProviderService::where(function ($query) use ($vehicle_id) {
                                        $query->where('parent_id', $vehicle_id)
                                        ->orWhere(function ($query) use ($vehicle_id) {
                                            $query
                                                ->whereNull('parent_id')
                                                ->where('id', $vehicle_id);
                                        });
                                    })->where('is_approved', 1)->pluck('service_type_id')->toArray();
                $serviceTypeNamesArray = ServiceType::whereIn('id', $serviceTypeIds)->pluck('name')->toArray();
                $service_name = implode(', ', $serviceTypeNamesArray);
                if ($service_name == null) {
                    $vehicle->service_name = 'N/A';
                    $vehicle->is_approved = 0;
                } else {
                    $vehicle->service_name = $service_name;
                    $vehicle->is_approved = 1;
                }

                $serviceTypeDisableIds = ProviderService::where(function ($query) use ($vehicle_id) {
                                                            $query->where('parent_id', $vehicle_id)
                                                            ->orWhere(function ($query) use ($vehicle_id) {
                                                                $query
                                                                    ->whereNull('parent_id')
                                                                    ->where('id', $vehicle_id);
                                                            });
                                                        })
                                                        ->where('is_approved', 0)
                                                        ->pluck('service_type_id')->toArray();
                $serviceTypeDisableNamesArray = ServiceType::whereIn('id', $serviceTypeDisableIds)->pluck('name')->toArray();
                $service_name_disable = implode(', ', $serviceTypeDisableNamesArray);
                if ($service_name_disable == null) {
                    $vehicle->service_name_disable = 'N/A';
                } else {
                    $vehicle->service_name_disable = $service_name_disable;
                }
            }

            return response()->json([

                'message' => 'Vehicles fetched successfully!',

                'vehicles' => $vehicles

            ]);


        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function selectVehicle(Request $request)
    {
        try {

            $provider_id = Auth::user()->id;
            // $provider_id = 1;
            $activeRidesCount = UserRequests::where('provider_id', $provider_id)->whereIn('status', ['ACCEPTED', 'STARTED', 'ARRIVED', 'PICKEDUP'])->count();
            if ($activeRidesCount == 0) {
                $vehicle_id = $request->vehicle_id;

                $vehicles = ProviderService::where('provider_id', $provider_id)->update(['is_selected' => 0, 'status' => 'offline']);

                // $vehicle = ProviderService::find($vehicle_id);
                // $vehicle->status = 'active';
                // $vehicle->is_selected = 1;
                // $vehicle->save();

                //parent selection
                $vehiclesParentActivated = ProviderService::where('id', $vehicle_id)->orWhere('parent_id', $vehicle_id)->update(['is_selected' => 1, 'status' => 'active']);

                $vehicle = ProviderService::where('id', $vehicle_id)->with('service_type')->get()->first();

                return response()->json([

                    'message' => 'Vehicle selected successfully!',

                    'vehicle' => $vehicle

                ]);

            } else {
                return response()->json([
                    'message' => 'Vehicle cannot be switched during active ride!',
                ], 400);
            }


        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong'), 'data' => $e]);


        }
    }

    public function deleteVehicle(Request $request)
    {
        try {
            $vehicle_id = $request->vehicle_id;
            $vehicle = ProviderService::destroy($vehicle_id);

            return response()->json([
                'message' => 'Vehicle deleted successfully!',
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    public function accept_offer(Request $request)
    {
        try {

            $offer_id = $request->offer_id;

            $requestOffer = RequestOffer::find($offer_id);

            $userRequest = UserRequests::with(['provider', 'user'])->findOrFail($requestOffer->request_id);

            $providerActiveServiceCount = ProviderService::where('provider_id',  $requestOffer->provider_id)
                                    ->where('is_selected', 1)
                                    ->where('is_approved', 1)
                                    ->where('service_type_id', $userRequest->service_type_id)
                                    ->where('status', 'active')
                                    ->count();

            if ($providerActiveServiceCount == 0) {
                return response()->json(['message' => 'This provider is not available!'], 400);
            }
            
            $requestOffer->is_accepted = 1;
            $requestOffer->save();

            $total = $requestOffer->offer_price;

            $userRequest->driver_amount = $total;
            $userRequest->amount = $total;
            $userRequest->ride_amount = $total;
            $userRequest->client_offer = $total;

            $userRequest->provider_id = $requestOffer->provider_id;
            $userRequest->current_provider_id = $requestOffer->provider_id;
            $job_status = "STARTED";
            if($userRequest->schedule_at != null) {
                $job_status = "SCHEDULED";
            }
            $userRequest->status = $job_status;
            $userRequest->save();

            RequestOffer::where('request_id', $requestOffer->request_id)->delete();

            if($job_status == "STARTED") {
                ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'riding']);
            }

            // Send Push Notification to Provider
            (new SendPushNotification)->OfferAccepted($userRequest);

            return $userRequest;

        } catch (Exception $e) {
            // return $e->getMessage();

            return response()->json(['error' => $e->getMessage()], 500);


        }
    }

    public function decline_offer(Request $request)
    {
        try {

            $offer_id = $request->offer_id;

            $requestOffer = RequestOffer::find($offer_id);
            $requestOffer->is_declined = 1;
            $requestOffer->save();

            return response()->json([
                'message' => 'Offer declined successfully!',
            ]);


        } catch (Exception $e) {
            // return $e->getMessage();
            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function refreshUserFCMToken(Request $request)
    {
        try {

            $device_token = $request->device_token ? $request->device_token : null ;
            $device_type = $request->device_type;

            $user = Auth::user();

            $userData = User::find($user->id);
            $userData->device_token = $device_token;
            $userData->device_type = $device_type;
            $userData->save();

            return response()->json([
                'message' => 'FCM token updated successfully!',
            ]);


        } catch (Exception $e) {
            // return $e->getMessage();
            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function refreshProviderFCMToken(Request $request)
    {
        try {

            $device_token = $request->device_token ? $request->device_token : null ;
            $device_type = $request->device_type;
            $udid = $request->has('udid') ? $request->udid : null;

            $provider_id = Auth::user()->id;
            $providerDevices = ProviderDevice::where('token', $device_token)->get();

            if ($providerDevices->count() > 0) {
                foreach($providerDevices as $providerDevice) {
                    $providerDeviceUpdate = ProviderDevice::find($providerDevice->id);
                    $providerDeviceUpdate->token = $device_token;
                    $providerDeviceUpdate->type = $device_type;
                    $providerDeviceUpdate->udid = $udid;
                    $providerDeviceUpdate->save();
                }
            } else {
                ProviderDevice::create([
                    'provider_id' => $provider_id,
                    'udid' => $udid,
                    'token' => $device_token,
                    'type' => $device_type,
                ]);
            }


            return response()->json([
                'message' => 'FCM token updated successfully!',
            ]);


        } catch (Exception $e) {
            // return $e->getMessage();
            return response()->json(['error' => trans('api.something_went_wrong')], 500);


        }
    }

    public function getUserFaqs(Request $request) {

        try {
            $faqs = $this->fetchFaqs('USER', $request);
            return response()->json([
                'data' => $faqs,
                'message' => translateKeywordApis('faqs_fetched_successfully', $request),
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => translateKeywordApis('something_went_wrong', $request)], 500);
        }
        
    }

    public function getDriverFaqs(Request $request) {
        try {

            $faqs = $this->fetchFaqs('DRIVER', $request);

            return response()->json([
                'data' => $faqs,
                'message' => translateKeywordApis('faqs_fetched_successfully', $request),
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => translateKeywordApis('something_went_wrong', $request)], 500);
        }
        
    }

    private function fetchFaqs($type, $request) {
        $language_id = getLanguageIdFromApis($request);
        $default_language_id = getDefautlLanguage();
        $faqs = Faqs::where('type', $type)
                    ->where('language_id', $language_id)
                    ->get(['question', 'answer']);
    
        // If no FAQs found for the requested language, fetch for default language
        if ($faqs->isEmpty()) {
            $faqs = Faqs::where('type', $type)
                        ->where('language_id', $default_language_id)
                        ->get(['question', 'answer']);
        }
    
        return $faqs;
    }
}

