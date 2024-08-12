<?php

namespace App\Http\Controllers\ProviderAuth;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;

use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Notifications\ResetPasswordOTP;

use App\Http\Controllers\UserRequestController;

use Illuminate\Support\Facades\Auth;
use Config;
use JWTAuth;
use anlutro\LaravelSettings\Facade as Setting;
use App\Fleet;
use Notification;
use Validator;
use Socialite;
use Carbon\Carbon;

use App\Provider;
use App\ProviderDevice;
use App\ProviderJwtTokens;
use App\ProviderReferral;
use App\ProviderService;
use App\UserRequests;
use App\RequestFilter;
use App\RequestFilterLog;

use App\BlockUserProvider;
use App\ServiceType;
use App\User;
use App\UserReferral;
use Illuminate\Support\Facades\Storage;

class TokenController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [
            'device_id' => 'required',
            'device_type' => 'required|in:android,ios',
            // TODO: handle this properly with app devs
            // 'device_token' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => Setting::get('email_field', "0") == 1 ? 'required|email|max:255|unique:providers,email' : 'nullable',
            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:providers,mobile',
            'password' => 'required|min:6|confirmed',
            'routing_numb' => 'nullable|max:255',
            'company_name' => 'nullable',
            'company_address' => 'nullable',
            'company_vat' => 'nullable',
            'tax_tps_info' => 'nullable',
            'tax_tvq_info'  => 'nullable',
            'language' => 'nullable'
        ]);

        try {

            if (Setting::get('driver_referral') == 1) {
                $referral_code = strtoupper($request->referral_code);
                if($referral_code != '') {
                    $providerReferralCount = Provider::where('referral_code', $referral_code)->get(['id'])->count(); 
                    $userReferralCount = User::where('referral_code', $referral_code)->get(['id'])->count();

                    if(($providerReferralCount == 0 && $userReferralCount == 0))
                        return response()->json(['error' => 'invalid_data', 'message' => "Invalid referral code"], 400);
                }
            }

            $provider = $request->all();
            $provider['password'] = bcrypt($request->password);

            if ($request->hasFile('avatar')) {
                $provider['avatar'] = $request->avatar->store('provider/profile');
            }
            

            if (Setting::get('gender_pref_enabled', 0) == 1) {
                $provider['gender_pref'] = $request->gender_pref != '' ? $request->gender_pref : null;
            } else {
                $provider['gender_pref'] = null;
            }

            if (Setting::get('gender', 0) == 1) {
                $provider['gender'] = $request->gender != '' ? $request->gender : null;
            } else {
                $provider['gender'] = null;
            }

            $provider['company_name'] = $request->company_name && $request->company_name != '' ? $request->company_name : null;
            $provider['company_address'] = $request->company_address && $request->company_address != '' ? $request->company_address : null;
            $provider['company_vat'] = $request->company_vat && $request->company_vat ? $request->company_vat : null;
            $provider['tax_tps_info'] = $request->tax_tps_info && $request->tax_tps_info ? $request->tax_tps_info : null;
            $provider['tax_tvq_info'] = $request->tax_tvq_info && $request->tax_tvq_info ? $request->tax_tvq_info : null;

            $provider['language'] = $request->has('language') ? $request->language : 'en';
            $provider['routing_numb'] = $request->has('routing_numb') ? $request->routing_numb : null;
            $provider['email'] = Setting::get('email_field', "0") == 1 && $request->has('email') ? $request->email : null;
            $provider['referral_code'] = strtoupper(substr(md5(uniqid(rand(1,6))), 0, 6));

            $provider['zone_id'] = $request->has('zone_id') ? $request->zone_id : 0;

            $provider['dob'] = $request->has('dob') ? $request->dob : null;
            $provider['address'] = $request->has('address') ? $request->address : null;

            if (Setting::get('driver_verification', 0) == 1) {
                $provider['status'] = 'doc_required';
            } else {
                if (Setting::get('subscription_module', 0) == 1 && Setting::get('driver_subscription_module', 0) == 1) {
                    $provider['status'] = 'subscription_expired';
                } else {
                    $provider['status'] = 'onboarding';
                }
            }

            if(Setting::get('subscription_module_stripe_trial', 0) == 0) {
                $trial_period = Setting::get('driver_trial_period', 0);
                if($trial_period > 0) {
                    if (Setting::get('driver_verification', 0) == 1) {
                        $provider['status'] = 'doc_required';
                    } else {
                        $provider['trial_availed'] = 1;
                        $provider['trial_end_time'] = Carbon::now()->addDays($trial_period);
                        $provider['subscription_status'] = 'trialing';
                        $provider['status'] = 'onboarding';
                    }
                }
            }

            // driver_verification
            
            $provider = Provider::create($provider);
            $newCreatedProviderId = $provider->id;

            $serviceTypesArray = array();

            $isChild = 0;

            $servicesArray = explode(',', $request->vtype);
            $parent_id = null;
            $mainServiceType = null;
            foreach ($servicesArray as $index => $vtype) {
                if ($index == 0) {
                    $mainServiceType = $vtype;
                    $isChild = 0;
                } else {
                    $isChild = 1;
                }

                $providerService = ProviderService::create([
                    'provider_id' => $newCreatedProviderId,
                    'service_type_id' => $vtype,
                    'status' => 'offline',
                    'service_number' => strtolower($request->vnumber),
                    'service_model' => $request->vmodel,
                    'service_weight_allowed_kg' => $request->vweight ? $request->vweight : 0,
                    'is_approved' => 0,
                    'is_child' => $isChild,
                    'parent_id' => $parent_id
                ]);

                if ($index == 0) {
                    $parent_id = $providerService->id;
                }

                array_push($serviceTypesArray, $vtype);
            }

            if (!is_null($parent_id)) {
                ProviderService::where('id', $parent_id)->orWhere('parent_id', $parent_id)->update(['is_selected' => 1, 'status' => 'offline']);
            }

            // if (!is_null($mainServiceType)) {
            //     ProviderService::where('service_type_id', $mainServiceType)->update(['is_selected' => 1, 'status' => 'active']);
            // }

            $providerDevice = ProviderDevice::create([
                'provider_id' => $newCreatedProviderId,
                'udid' => $request->device_id,
                'token' => $request->device_token,
                'type' => $request->device_type,
            ]);

            Config::set('auth.providers.users.model', 'App\Provider');

            if (Setting::get('email_field', "0") == 1) {
                if ($request->email != null || $request->email != '') {
                    $credentials['email'] = $request->email;
                } else {
                    $credentials['mobile'] = $request->mobile;
                }
            } else {
                if ($request->mobile != null || $request->mobile != '') {
                    $credentials['mobile'] = $request->mobile;
                } else {
                    $credentials['email'] = $request->email;
                }
            }
            
            $credentials['password'] = $request->password;

            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'The email address/mobile or password you entered is incorrect.'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'Something went wrong, Please try again later!'], 500);
            }

            ProviderJwtTokens::create([
                'provider_id' => $provider->id,
                'token' => $token,
            ]);

            $provider = Provider::with('service', 'device', 'zone')->find($provider->id);

            $provider->access_token = $token;
            $provider->currency = trans('currency.' . Setting::get('currency'));
            $provider->sos = Setting::get('sos_number', '911');
            $provider->token_type = "Bearer";

            $provider->vehicle_id = (string)$providerService->id;

            $provider->fleet = Fleet::find($provider->fleet);

            $slider_images = [];
            $slider_image1 = Setting::get('slider_image1', '');
            $slider_image2 = Setting::get('slider_image2', '');
            $slider_image3 = Setting::get('slider_image3', '');
            $slider_image4 = Setting::get('slider_image4', '');
            $slider_image5 = Setting::get('slider_image5', '');

            array_push($slider_images, $slider_image1, $slider_image2, $slider_image3, $slider_image4, $slider_image5);

            $provider->slider_images = $slider_images;

            $provider->tip_collect = Setting::get('tip_collect', '0');
            $tip_suggestions = [];
            $tip_suggestion1 = Setting::get('tip_suggestion1', '0');
            $tip_suggestion2 = Setting::get('tip_suggestion2', '0');
            $tip_suggestion3 = Setting::get('tip_suggestion3', '0');

            array_push($tip_suggestions, $tip_suggestion1, $tip_suggestion2, $tip_suggestion3);

            $provider->tip_suggestions = $tip_suggestions;

            $provider->subscription_module = Setting::get('subscription_module', '0');

            $serviceTypeNamesArray = ServiceType::whereIn('id', $serviceTypesArray)->pluck('name')->toArray();
            $provider->service_name = implode(', ', $serviceTypeNamesArray);

            if (Setting::get('driver_referral') == 1) {
                $referral_code = strtoupper($request->referral_code);
                if ($referral_code != $provider->referral_code) {
                    $providerReferral = Provider::where('referral_code', $referral_code)->get(['id'])->first(); 
                    $user = User::where('referral_code', $referral_code)->get(['id'])->first();
                    
                    if ($providerReferral) {
                        if ($providerReferral->id != $newCreatedProviderId) {
                            $providerReferral = Provider::find($providerReferral->id);
                            $providerReferral->provider_referral_count = $providerReferral->provider_referral_count + 1;
                            $providerReferral->save();

                            ProviderReferral::create([
                                'provider_id' => $providerReferral->id,
                                'reffered_id' => $newCreatedProviderId, // new created provider
                                'type' => 'Driver',
                            ]);
                        }
                        
                    }
                    if ($user) {
                        $user = User::find($user->id);
                        $user->provider_referral_count = $user->provider_referral_count + 1;
                        $user->save();

                        UserReferral::create([
                            'user_id' => $user->id,
                            'reffered_id' => $newCreatedProviderId, // new created provider
                            'type' => 'Driver',
                        ]);
                    }
                }
            }

            if(Setting::get('zone_restrict_module') == 1) {
                $provider->zone_name = $provider->zone ? $provider->zone->name : 'N/A';
            }

            return $provider;
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Something went wrong, Please try again later!', 'detail' => $e->getMessage()], 500);
            }
            
            return response()->json(['error' => 'Something went wrong, Please try again later!', 'detail' => $e->getMessage()], 500);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function register(Request $request)
    {
        $this->validate($request, [
            'device_id' => 'required',
            'device_type' => 'required|in:android,ios',
            // TODO: handle this properly with app devs
            // 'device_token' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => Setting::get('email_field', "0") == 1 ? 'required|email|max:255|unique:providers,email' : 'nullable',
            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:providers,mobile',
            'password' => 'required|min:6|confirmed',
            'routing_numb' => 'nullable|max:255',
            'language' => 'nullable'
        ]);

        try {

            $provider = $request->all();
            $provider['password'] = bcrypt($request->password);

            if ($request->hasFile('avatar')) {
                $provider['avatar'] = $request->avatar->store('provider/profile');
            }

            $isApproved = 0;
            if (Setting::get('driver_verification', 0) == 1) {
                $provider['status'] = 'approved';
                $isApproved = 1;
            } else {
                $provider['status'] = 'doc_required';
            }

            $provider['language'] = $request->has('language') ? $request->language : 'en';
            $provider['routing_numb'] = $request->has('routing_numb') ? $request->routing_numb : null;
            $provider['email'] = Setting::get('email_field', "0") == 1 && $request->has('email') ? $request->email : null;

            $provider = Provider::create($provider);

            $servicesArray = is_array($request->vtype);

            if ($servicesArray) {
                foreach ($request->vtype as $vtype) {
                    $providerService = ProviderService::create([
                        'provider_id' => $provider->id,
                        'service_type_id' => $vtype,
                        'status' => 'active',
                        'service_number' => strtolower($request->vnumber),
                        'service_model' => $request->vmodel,
                        'service_weight_allowed_kg' => $request->vweight ? $request->vweight : 0,
                        'is_selected' => 1,
                        'is_approved' => $isApproved,
                    ]);
                }
            } else {
                $providerService = ProviderService::create([
                    'provider_id' => $provider->id,
                    'service_type_id' => $request->vtype,
                    'status' => 'active',
                    'service_number' => strtolower($request->vnumber),
                    'service_model' => $request->vmodel,
                    'service_weight_allowed_kg' => $request->vweight ? $request->vweight : 0,
                    'is_selected' => 1,
                    'is_approved' => $isApproved,
                ]);
            }

            ProviderDevice::create([
                'provider_id' => $provider->id,
                'udid' => $request->device_id,
                'token' => $request->device_token,
                'type' => $request->device_type,
            ]);

            return $provider;


        } catch (QueryException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Something went wrong, Please try again later!', 'detail' => $e->getMessage()], 500);
            }
            return abort(500);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'device_id' => 'required',
            'device_type' => 'required|in:android,ios',
            // TODO: handle this properly with app devs
            // 'device_token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'language' => 'nullable'
        ]);

        Config::set('auth.providers.users.model', 'App\Provider');

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'The email address or password you entered is incorrect.'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Something went wrong, Please try again later!'], 500);
        }



        $provider = Provider::with('service', 'device')->find(Auth::user()->id);
        if ($provider->referral_code == null) {
            $provider->referral_code = strtoupper(substr(md5(uniqid(rand(1,6))), 0, 6));
            $provider->save();
        }
        $provider->access_token = $token;
        $provider->currency = trans('currency.' . Setting::get('currency'));
        $provider->sos = Setting::get('sos_number', '911');
        $provider->token_type = "Bearer";

        // if ($provider->device) {
        //     ProviderDevice::where('id', $provider->device->id)->update([
        //         'udid' => $request->device_id,
        //         'token' => $request->device_token,
        //         'type' => $request->device_type,
        //     ]);

        // } else {
            ProviderDevice::create([
                'provider_id' => $provider->id,
                'udid' => $request->device_id,
                'token' => $request->device_token,
                'type' => $request->device_type,
            ]);
        // }

        return response()->json($provider);
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function authenticatev2(Request $request)
    {
        $this->validate($request, [
            'device_id' => 'required',
            'device_type' => 'required|in:android,ios',
            // TODO: handle this properly with app devs
            // 'device_token' => 'required',
            'username' => 'required',
            'password' => 'required|min:6',
            'type' => 'required|in:phone,email'
        ]);

        if (Setting::get('email_field', "0") == 1) {
            if ($request->type == 'email') {
                $provider = Provider::where('email', $request->username)->with('service', 'device')->first();
                if (!$provider) {
                    return response()->json(['error' => 'The email address/mobile or password you entered is incorrect.'], 400);
                }
            } else if ($request->type == 'phone') {
                $provider = Provider::where('mobile', $request->username)->with('service', 'device')->first();
                if (!$provider) {
                    return response()->json(['error' => 'The email address/mobile or password you entered is incorrect.'], 400);
                }
            }
        } else {
            $provider = Provider::where('mobile', $request->username)->orWhere('mobile', $request->username)->with('service', 'device')->first();
            if (!$provider) {
                return response()->json(['error' => 'The email address/mobile or password you entered is incorrect.'], 400);
            }
        }

        if (Setting::get('email_field', "0") == 1) {
            $email = $provider->email;
        } else {
            $mobile = $provider->mobile;
        }
        
        $username = $request->username;

        Config::set('auth.providers.users.model', 'App\Provider');

        if (Setting::get('email_field', "0") == 1) {
            if ($email != null || $email != '') {
                $credentials['email'] = $email;
            } else {
                $credentials['mobile'] = $mobile;
            }
        } else {
            if ($mobile != null || $mobile != '') {
                $credentials['mobile'] = $mobile;
            } else {
                $credentials['email'] = $email;
            }
        }

        $credentials['password'] = $request->password;

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'The email address/mobile or password you entered is incorrect.'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Something went wrong, Please try again later!'], 500);
        }

        if ($provider->referral_code == null) {
            $provider->referral_code = strtoupper(substr(md5(uniqid(rand(1,6))), 0, 6));
            $provider->save();
        }

        $provider->access_token = $token;
        $provider->currency = trans('currency.' . Setting::get('currency'));
        $provider->sos = Setting::get('sos_number', '911');
        $provider->token_type = "Bearer";

        /*
        if ($provider->device) {
            ProviderDevice::where('id', $provider->device->id)->update([
                'udid' => $request->device_id,
                'token' => $request->device_token,
                'type' => $request->device_type,
            ]);

        } else {
            ProviderDevice::create([
                'provider_id' => $provider->id,
                'udid' => $request->device_id,
                'token' => $request->device_token,
                'type' => $request->device_type,
            ]);
        }
        */
        
        if (Setting::get('multi_device_login_driver', 0) == 0) {
            ProviderJwtTokens::where('provider_id', $provider->id)->delete();
            ProviderDevice::where('provider_id', $provider->id)->delete();
        }

        //Forced to store every token
        ProviderDevice::create([
            'provider_id' => $provider->id,
            'udid' => $request->device_id,
            'token' => $request->device_token,
            'type' => $request->device_type,
        ]);

        ProviderJwtTokens::create([
            'provider_id' => $provider->id,
            'token' => $token,
        ]);

        $providerServicesActive = ProviderService::where('provider_id', $provider->id)->where('is_selected', 1)->where('is_approved', 1)->update([
            'status' => 'active'
        ]);

        $providerServicesActiveCount = ProviderService::where('provider_id', $provider->id)->where('is_selected', 1)->where('is_approved', 1)->count();

        if ($providerServicesActiveCount > 0) {
            $provider->service->status = 'active';
        } else {
            $provider->service->status = 'offline';
        }

        $provider->zone_name = $provider->zone ? $provider->zone->name : 'N/A';
        $provider_id = $provider->id;

        $userRequestController = new UserRequestController();
        $assignPendingRequests = $userRequestController->assignPendingRequests($provider_id);

        return response()->json($provider);
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function logout(Request $request)
    {
        try {

            $provider_id = $request->id;
            ProviderDevice::where('provider_id', $provider_id)->update(['udid' => '', 'token' => '']);
            ProviderService::where('provider_id', $provider_id)->update(['status' => 'offline']);
            
            $LogoutOpenRequest = RequestFilter::with(['request.provider', 'request'])
                ->where('provider_id', $provider_id)
                ->whereHas('request', function ($query) use ($provider_id) {
                    $query->where('status', 'SEARCHING');
                    $query->where('current_provider_id', '<>', $provider_id);
                    $query->orWhereNull('current_provider_id');
                })->pluck('id');

            if (count($LogoutOpenRequest) > 0) {
                RequestFilter::whereIn('id', $LogoutOpenRequest)->delete();
            }

            return response()->json(['message' => trans('api.logout_success')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
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
            'email' => 'required|email|exists:providers,email',
        ]);

        try {

            $provider = Provider::where('email', $request->email)->first();

            $otp = mt_rand(100000, 999999);

            $provider->otp = $otp;
            $provider->save();

            // Notification::send($provider, new ResetPasswordOTP($otp));

            return response()->json([
                'message' => 'OTP sent to your email!',
                'provider' => $provider
            ]);

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
            'id' => 'required|numeric|exists:providers,id'
        ]);

        try {

            $provider = Provider::findOrFail($request->id);

            $provider->password = bcrypt($request->password);
            $provider->save();
            if ($request->ajax()) {
                return response()->json(['message' => 'Password Updated']);
            }

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function facebookViaAPI(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'device_type' => 'required|in:android,ios',
                // TODO: handle this properly with app devs
            // 'device_token' => 'required',
                'accessToken' => 'required',
                //'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15',
                'device_id' => 'required',
                'login_by' => 'required|in:manual,facebook,google'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->messages()->all()]);
        }
        $provider = Socialite::driver('facebook')->stateless();
        $FacebookDrive = $provider->userFromToken($request->accessToken);

        try {
            $FacebookSql = Provider::where('social_unique_id', $FacebookDrive->id);
            if ($FacebookDrive->email != "") {
                $FacebookSql->orWhere('email', $FacebookDrive->email);
            }
            $AuthUser = $FacebookSql->first();
            if ($AuthUser) {
                $AuthUser->social_unique_id = $FacebookDrive->id;
                $AuthUser->login_by = "facebook";
                $AuthUser->mobile = $request->mobile ?: '';
                $AuthUser->save();
            } else {
                $AuthUser["email"] = $FacebookDrive->email;
                $name = explode(' ', $FacebookDrive->name, 2);
                $AuthUser["first_name"] = $name[0];
                $AuthUser["last_name"] = isset($name[1]) ? $name[1] : '';
                $AuthUser["password"] = bcrypt($FacebookDrive->id);
                $AuthUser["social_unique_id"] = $FacebookDrive->id;
                $AuthUser["avatar"] = $FacebookDrive->avatar;
                $AuthUser["mobile"] = $request->mobile ?: '';
                $AuthUser["login_by"] = "facebook";
                $AuthUser = Provider::create($AuthUser);

                if (Setting::get('demo_mode', 0) == 1) {
                    $AuthUser->update(['status' => 'approved']);
                    ProviderService::create([
                        'provider_id' => $AuthUser->id,
                        'service_type_id' => '1',
                        'status' => 'active',
                        'service_number' => '4pp03ets',
                        'service_model' => 'Audi R8',
                    ]);
                }
            }
            if ($AuthUser) {
                $userToken = JWTAuth::fromUser($AuthUser);
                $provider = Provider::with('service', 'device')->find($AuthUser->id);
                if ($provider->device) {
                    ProviderDevice::where('id', $provider->device->id)->update([

                        'udid' => $request->device_id,
                        'token' => $request->device_token,
                        'type' => $request->device_type,
                    ]);

                } else {
                    ProviderDevice::create([
                        'provider_id' => $provider->id,
                        'udid' => $request->device_id,
                        'token' => $request->device_token,
                        'type' => $request->device_type,
                    ]);
                }
                return response()->json([
                    "status" => true,
                    "token_type" => "Bearer",
                    "access_token" => $userToken,
                    'currency' => trans('currency.' . Setting::get('currency')),
                    'sos' => Setting::get('sos_number', '911')
                ]);
            } else {
                return response()->json(['status' => false, 'message' => "Invalid credentials!"]);
            }
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => trans('api.something_went_wrong')]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function googleViaAPI(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'device_type' => 'required|in:android,ios',
                // TODO: handle this properly with app devs
            // 'device_token' => 'required',
                'accessToken' => 'required',
                //'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15',
                'device_id' => 'required',
                'login_by' => 'required|in:manual,facebook,google'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->messages()->all()]);
        }
        $provider = Socialite::driver('google')->stateless();
        $GoogleDrive = $provider->userFromToken($request->accessToken);

        try {
            $GoogleSql = Provider::where('social_unique_id', $GoogleDrive->id);
            if ($GoogleDrive->email != "") {
                $GoogleSql->orWhere('email', $GoogleDrive->email);
            }
            $AuthUser = $GoogleSql->first();
            if ($AuthUser) {
                $AuthUser->social_unique_id = $GoogleDrive->id;
                $AuthUser->mobile = $request->mobile ?: '';
                $AuthUser->login_by = "google";
                $AuthUser->save();
            } else {
                $AuthUser["email"] = $GoogleDrive->email;
                $name = explode(' ', $GoogleDrive->name, 2);
                $AuthUser["first_name"] = $name[0];
                $AuthUser["last_name"] = isset($name[1]) ? $name[1] : '';
                $AuthUser["password"] = ($GoogleDrive->id);
                $AuthUser["social_unique_id"] = $GoogleDrive->id;
                $AuthUser["avatar"] = $GoogleDrive->avatar;
                $AuthUser["mobile"] = $request->mobile ?: '';
                $AuthUser["login_by"] = "google";
                $AuthUser = Provider::create($AuthUser);

                if (Setting::get('demo_mode', 0) == 1) {
                    $AuthUser->update(['status' => 'approved']);
                    ProviderService::create([
                        'provider_id' => $AuthUser->id,
                        'service_type_id' => '1',
                        'status' => 'active',
                        'service_number' => '4pp03ets',
                        'service_model' => 'Audi R8',
                    ]);
                }
            }
            if ($AuthUser) {
                $userToken = JWTAuth::fromUser($AuthUser);
                $provider = Provider::with('service', 'device')->find($AuthUser->id);
                if ($provider->device) {
                    ProviderDevice::where('id', $provider->device->id)->update([

                        'udid' => $request->device_id,
                        'token' => $request->device_token,
                        'type' => $request->device_type,
                    ]);

                } else {
                    ProviderDevice::create([
                        'provider_id' => $provider->id,
                        'udid' => $request->device_id,
                        'token' => $request->device_token,
                        'type' => $request->device_type,
                    ]);
                }
                return response()->json([
                    "status" => true,
                    "token_type" => "Bearer",
                    "access_token" => $userToken,
                    'currency' => trans('currency.' . Setting::get('currency')),
                    'sos' => Setting::get('sos_number', '911')
                ]);
            } else {
                return response()->json(['status' => false, 'message' => "Invalid credentials!"]);
            }
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => trans('api.something_went_wrong')]);
        }
    }


    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function refresh_token(Request $request)
    {
        try {
            Config::set('auth.providers.users.model', 'App\Provider');

            $refreshed = JWTAuth::refresh(JWTAuth::getToken());
            $provider = JWTAuth::setToken($refreshed)->toUser();

            if (!$token = JWTAuth::fromUser($provider)) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            return response()->json(['token_type' => 'Bearer', 'access_token' => $refreshed], 200);
        } catch (Exception $e) {
            return response()->json([
                'code' => 403,
                'message' => 'Token cannot be refreshed, please Login again'
            ], 403);
            // return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    /**
     * Show the email availability.
     *
     * @return Response
     */

    public function verify(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:providers',
        ]);

        try {

            return response()->json(['message' => trans('api.email_available')]);

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }
}
