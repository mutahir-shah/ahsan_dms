<?php

namespace App\Http\Controllers\ProviderResources;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Controllers\Controller;

use App\Http\Controllers\UserRequestController;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Support\Facades\Storage;
use Exception;
use Carbon\Carbon;

use App\ProviderProfile;
use App\UserRequests;
use App\UserRequestPayment;
use App\ProviderService;
use App\Fleet;
use App\Http\Controllers\UserApiController;
use App\Provider;
use App\ProviderDocument;
use App\RequestFilter;
use App\RequestFilterLog;
use App\ServiceType;

class ProfileController extends Controller
{
    /**
     * Create a new user instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('provider.api', ['except' => ['show', 'store', 'available', 'location_edit', 'location_update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        try {

            if (Setting::get('multi_vehicle_module', 0) == 1) {
                $providerService = Auth::user()->service = ProviderService::where('provider_id', Auth::user()->id)
                    ->where('is_selected', 1)
                    ->with('service_type')
                    ->first();
            } else {
                $providerService = Auth::user()->service = ProviderService::where('provider_id', Auth::user()->id)
                    ->with('service_type')
                    ->first();
            }

            Auth::user()->vehicle_id = $providerService ? (string)$providerService->id : (string)0;

            Auth::user()->fleet_data = Fleet::find(Auth::user()->fleet);
            Auth::user()->currency = trans('currency.' . Setting::get('currency'));
            Auth::user()->sos = Setting::get('sos_number', '911');

            $slider_images = [];
            $slider_image1 = Setting::get('slider_image1', '');
            $slider_image2 = Setting::get('slider_image2', '');
            $slider_image3 = Setting::get('slider_image3', '');
            $slider_image4 = Setting::get('slider_image4', '');
            $slider_image5 = Setting::get('slider_image5', '');

            array_push($slider_images, $slider_image1, $slider_image2, $slider_image3, $slider_image4, $slider_image5);

            Auth::user()->slider_images = $slider_images;

            Auth::user()->tip_collect = Setting::get('tip_collect', '0');
            $tip_suggestions = [];
            $tip_suggestion1 = Setting::get('tip_suggestion1', '0');
            $tip_suggestion2 = Setting::get('tip_suggestion2', '0');
            $tip_suggestion3 = Setting::get('tip_suggestion3', '0');

            array_push($tip_suggestions, $tip_suggestion1, $tip_suggestion2, $tip_suggestion3);

            Auth::user()->tip_suggestions = $tip_suggestions;

            Auth::user()->subscription_module = Setting::get('subscription_module', '0');

            // $documentsArray = [];   
            // $documents = ProviderDocument::where('provider_id', Auth::user()->id)->with('document')->get();
            // foreach($documents as $index => $document) {
            //     $documentsArray[$index]['name'] = $document->document->name;
            //     $documentsArray[$index]['type'] = $document->document->type;
            //     $documentsArray[$index]['url'] = $document->url;
            //     $documentsArray[$index]['status'] = $document->status;
            // }

            // Auth::user()->documents = $documentsArray;

            $serviceTypesArray = ProviderService::where('provider_id', Auth::user()->id)->pluck('service_type_id')->toArray();
            $serviceTypeNamesArray = ServiceType::whereIn('id', $serviceTypesArray)->pluck('name')->toArray();
            Auth::user()->service_name = implode(', ', $serviceTypeNamesArray);

            Auth::user()->zone_name = Auth::user()->zone ? Auth::user()->zone->name : 'N/A';

            $user = Auth::user();
            $user['wallet'] = $user->wallet ? strval($user->wallet) : "0";

            return $user;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            // 'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:providers,mobile',
            'avatar' => 'mimes:jpeg,bmp,png',
            // 'language' => 'max:255',
            // 'address' => 'max:255',
            // 'address_secondary' => 'max:255',
            // 'city' => 'max:255',
            // 'country' => 'max:255',
            // 'postal_code' => 'max:255',
            'tax_tps_info' => Setting::get('tax_tps_info_field', 0) == 1 
            ? 'required|alphanumeric'
            : 'nullable',
            'tax_tvq_info' => Setting::get('tax_tvq_info_field', 0) == 1 
            ? 'required|alphanumeric'
            : 'nullable'
        ]);
        try {

            $provider = Auth::user();
            if ($request->has('first_name'))
                $provider->first_name = $request->first_name;

            if ($request->has('tax_tps_info'))
                $provider->tax_tps_info = $request->tax_tps_info;

            if ($request->has('tax_tvq_info'))
                $provider->tax_tvq_info = $request->tax_tvq_info;

            if ($request->has('last_name'))
                $provider->last_name = $request->last_name;

            if ($request->has('mobile'))
                $provider->mobile = str_replace(' ', '', $request->mobile);

            if ($request->hasFile('avatar')) {
                Storage::delete($provider->avatar);
                $provider->avatar = $request->avatar->store('provider/profile');
            }

            if ($request->has('service_type')) {
                if ($provider->service) {
                    if ($provider->service->service_type_id != $request->service_type) {
                        $provider->status = 'onboarding';
                    }
                    //$ProviderService = ProviderService::where('provider_id',Auth::user()->id);
                    $provider->service->service_type_id = $request->service_type;
                    $provider->service->service_number = strtolower($request->service_number);
                    $provider->service->service_model = $request->service_model;
                    $provider->service->save();

                } else {
                    ProviderService::create([
                        'provider_id' => $provider->id,
                        'service_type_id' => $request->service_type,
                        'service_number' => strtolower($request->service_number),
                        'service_model' => $request->service_model,
                    ]);
                    $provider->status = 'onboarding';
                }
            }

            if ($provider->profile) {
                $provider->profile->update([
                    'language' => $request->language ?: $provider->profile->language,
                    'address' => $request->address ?: $provider->profile->address,
                    'address_secondary' => $request->address_secondary ?: $provider->profile->address_secondary,
                    'city' => $request->city ?: $provider->profile->city,
                    'country' => $request->country ?: $provider->profile->country,
                    'postal_code' => $request->postal_code ?: $provider->profile->postal_code,
                    'tax_tps_info' => $request->has('tax_tps_info') ?: $provider->profile->tax_tps_info,
                    'tax_tvq_info' => $request->has('tax_tvq_info') ?: $provider->profile->tax_tvq_info,
                    
                ]);
            } else {
                ProviderProfile::create([
                    'provider_id' => $provider->id,
                    'language' => $request->language,
                    'address' => $request->address,
                    'address_secondary' => $request->address_secondary,
                    'city' => $request->city,
                    'country' => $request->country,
                    'postal_code' => $request->postal_code,
                    'tax_tps_info' => $request->has('tax_tps_info'),
                    'tax_tvq_info' => $request->has('tax_tvq_info')
                ]);
            }


            $provider->save();

            return redirect(route('provider.profile.index'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Provider Not Found!'], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('provider.profile.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $request->replace([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => str_replace(' ', '', $request->mobile),
            'language' => $request->language,
            'address' => $request->address,
            'address_secondary' => $request->address_secondary,
            'city' => $request->city,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'gender' => $request->gender,
            'gender_pref' => $request->gender_pref,
            'routing_numb' => $request->has('routing_numb') ? $request->routing_numb : null,
            'company_name' => $request->has('company_name') ? $request->company_name : null,
            'company_address' => $request->has('company_address') ? $request->company_address : null,
            'company_vat' => $request->has('company_vat') ? $request->company_vat : null,
            'tax_tps_info' => $request->has('tax_tps_info') ? $request->tax_tps_info : null,
            'tax_tvq_info' => $request->has('tax_tvq_info') ? $request->tax_tvq_info : null,
        ]);

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:providers,mobile,' . Auth::user()->id,
            'avatar' => 'nullable|mimes:jpeg,bmp,png',
            'picture' => 'nullable|mimes:jpeg,bmp,png',
            'language' => 'max:255',
            'address' => 'max:255',
            'address_secondary' => 'max:255',
            'city' => 'max:255',
            'country' => 'max:255',
            'postal_code' => 'max:255',
            'gender' => 'max:255',
            'gender_pref' => 'max:255',
            'routing_numb' => 'max:255',
            'company_name' => 'nullable',
            'company_address' => 'nullable',
            'company_vat' => 'nullable',
             'tax_tps_info' => Setting::get('tax_tps_info_field', 0) == 1 
            ? 'required|alphanumeric'
            : 'nullable',
            'tax_tvq_info' => Setting::get('tax_tvq_info_field', 0) == 1 
            ? 'required|alphanumeric'
            : 'nullable'
        ]);

        try {

            $provider = Auth::user();

            if ($request->has('first_name'))
                $provider->first_name = $request->first_name;

            if ($request->has('last_name'))
                $provider->last_name = $request->last_name;

            if ($request->has('tax_tps_info'))
                $provider->tax_tps_info = $request->tax_tps_info;

            if ($request->has('tax_tvq_info'))
                $provider->tax_tvq_info = $request->tax_tvq_info;

            if ($request->has('gender'))
                $provider->gender = ($request->gender != null || $request->gender != "") ? $request->gender : $provider->gender;

            if ($request->has('gender_pref'))
                $provider->gender_pref = ($request->gender_pref != null || $request->gender_pref != "") ? $request->gender_pref : $provider->gender_pref;

            if ($request->has('mobile'))
                $provider->mobile = str_replace(' ', '', $request->mobile);

            if ($request->hasFile('avatar')) {
                Storage::delete($provider->avatar);
                $provider->avatar = $request->avatar->store('provider/profile');
            }

            if ($request->hasFile('picture')) {
                Storage::delete($provider->picture);
                $provider->picture = $request->picture->store('provider/profile');
            }

            if ($request->has('company_name'))
                $provider->company_name = $request->company_name;

            if ($request->has('company_address'))
                $provider->company_address = $request->company_address;

            if ($request->has('company_vat'))
                $provider->company_vat = $request->company_vat;

            if ($request->has('tax_tps_info'))
                $provider->tax_tps_info = $request->tax_tps_info;

            if ($request->has('tax_tvq_info'))
                $provider->tax_tvq_info = $request->tax_tvq_info;

            if ($request->has('routing_numb'))
                $provider->routing_numb = $request->routing_numb;

            if ($provider->profile) {
                $provider->profile->update([
                    'language' => $request->language ?: $provider->profile->language,
                    'address' => $request->address ?: $provider->profile->address,
                    'address_secondary' => $request->address_secondary ?: $provider->profile->address_secondary,
                    'city' => $request->city ?: $provider->profile->city,
                    'country' => $request->country ?: $provider->profile->country,
                    'postal_code' => $request->postal_code ?: $provider->profile->postal_code,
                    'tax_tps_info' => $request->tax_tps_info ?: $provider->profile->tax_tps_info,
                    'tax_tvq_info' => $request->tax_tvq_info ?: $provider->profile->tax_tvq_info,
                ]);
            } else {
                ProviderProfile::create([
                    'provider_id' => $provider->id,
                    'language' => $request->language,
                    'address' => $request->address,
                    'address_secondary' => $request->address_secondary,
                    'city' => $request->city,
                    'country' => $request->country,
                    'postal_code' => $request->postal_code,
                    'tax_tps_info' => $request->tax_tps_info ?: $provider->profile->tax_tps_infoo,
                    'tax_tvq_info' => $request->tax_tvq_info ?: $provider->profile->tax_tvq_info,
                ]);
            }


            $provider->save();

            // $provider = Provider::find($provider->id);

            return $provider;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Provider Not Found!'], 404);
        }
    }

    /**
     * Update latitude and longitude of the user.
     *
     * @param int $id
     * @return Response
     */
    public function location(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($provider = Auth::user()) {

            $provider->latitude = $request->latitude;
            $provider->longitude = $request->longitude;
            $provider->save();

            return response()->json(['message' => 'Location Updated successfully!']);

        } else {
            return response()->json(['error' => 'Provider Not Found!']);
        }
    }

    /**
     * Toggle service availability of the provider.
     *
     * @param Request $request
     * @return Response
     */
    public function available(Request $request)
    {
        //TODO: update multi_services_module
        $this->validate($request, [
            'service_status' => 'required|in:active,offline',
        ]);

        $authProvider = Auth::user();
        $provider_id = $authProvider->id;

        ProviderService::where('provider_id', $provider_id)->update(['status' => 'offline']);

        $provider = Provider::where('id', $provider_id)->with('service')->get()->first();

        if ($provider) {

            $OfflineOpenRequest = RequestFilter::with(['request.provider', 'request'])
                ->where('provider_id', $provider_id)
                ->whereHas('request', function ($query) use ($provider_id) {
                    $query->where('status', 'SEARCHING');
                    $query->where('current_provider_id', '<>', $provider_id);
                    $query->orWhereNull('current_provider_id');
                })->pluck('id');

            if (count($OfflineOpenRequest) > 0) {
                RequestFilter::whereIn('id', $OfflineOpenRequest)->delete();
            }

            $provider->service()->where('is_approved', 1)->where('is_selected', 1)->update(['status' => $request->service_status]);

            $userRequestController = new UserRequestController();
            $assignPendingRequests = $userRequestController->assignPendingRequests($provider_id);

        } else {
            return response()->json(['error' => 'You account has not been approved for driving']);
        }

        $filteredRequests = [];
            $userApiController = new UserApiController();
            foreach($provider->service as $userRequest){
                unset($userRequest->service_type);
                $userRequest['service_type'] = $userApiController->getServicesWithMultiLanguageAndByServiceTypeId($userRequest->service_type_id,$request);
                $filteredRequests[] = $userRequest;

            }
        $provider->service = $filteredRequests;
        return $provider;
    }

    /**
     * Update password of the provider.
     *
     * @param Request $request
     * @return Response
     */
    public function password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed',
            'password_old' => 'required',
        ]);

        $provider = Auth::user();

        if (password_verify($request->password_old, $provider->password)) {
            $provider->password = bcrypt($request->password);
            $provider->save();

            return response()->json(['message' => 'Password changed successfully!']);
        } else {
            return response()->json(['error' => 'Required is new password should not be same as old password'], 400);
        }
    }

    /**
     * Show providers daily target.
     *
     * @param Request $request
     * @return Response
     */
    public function target(Request $request)
    {
        try {


            $RidesCompletedToday = UserRequests::where('provider_id', Auth::user()->id)
                ->where('status', 'COMPLETED')
                ->where('created_at', '>=', Carbon::today())
                ->with('payment')
                ->orderBy('id', 'DESC')
                ->get();
            
            $userApiController = new UserApiController();
            $RidesCompletedToday = $RidesCompletedToday->map(function($ride) use ($userApiController, $request) {
                $ride['service_type'] = $userApiController->getServicesWithMultiLanguageAndByServiceTypeId($ride->service_type_id, $request);
                return $ride;
            });
            

            $RidesCompletedTodayCount = $RidesCompletedToday->count();

            $totalRequestsSentToday = RequestFilterLog::where('provider_id', Auth::user()->id)
                ->where('created_at', '>=', Carbon::today())
                ->get();
            $totalRequestsSentTodayCount = $totalRequestsSentToday->count() == 0 ? 1 : $totalRequestsSentToday->count();

            $acceptance_rate = ($RidesCompletedTodayCount / $totalRequestsSentTodayCount);
            $acceptance_percentage = ($RidesCompletedTodayCount / $totalRequestsSentTodayCount) * 100;

            return response()->json([
                'rides' => $RidesCompletedToday,
                'rides_count' => $RidesCompletedTodayCount,
                'acceptance_rate' => $acceptance_rate,
                'acceptance_percentage' => $acceptance_percentage,
                'target' => Setting::get('daily_target', '0')
            ]);

        } catch (Exception $e) {
            // return dd($e->getMessage());
            return response()->json(['error' => translateKeywordApis("something_went_wrong", $request)]);
        }
    }

    public function target7(Request $request)
    {
        try {
            $RidesCompleted7Days = UserRequests::where('provider_id', Auth::user()->id)
                ->where('status', 'COMPLETED')
                ->where('created_at', '>=', date('Y-m-d', strtotime('-7 days')))
                ->with('payment')
                ->orderBy('id', 'DESC')
                ->get();

            $userApiController = new UserApiController();
            $RidesCompleted7Days = $RidesCompleted7Days->map(function($ride) use ($userApiController, $request) {
                $ride['service_type'] = $userApiController->getServicesWithMultiLanguageAndByServiceTypeId($ride->service_type_id, $request);
                return $ride;
            });

            $RidesCompleted7DaysCount = $RidesCompleted7Days->count() == 0 ? 1 : $RidesCompleted7Days->count();

            // $totalRequestsSent7Days = RequestFilterLog::where('provider_id', Auth::user()->id)
            //                         ->where('created_at', '>=', date('Y-m-d', strtotime('-7 days')))
            //                         ->get();
            // $totalRequestsSent7DaysCount = $totalRequestsSent7Days->count() == 0 ? 1 : $totalRequestsSent7Days->count();

            $totalRequestsSent7Days = UserRequests::where('provider_id', Auth::user()->id)
                ->where('created_at', '>=', date('Y-m-d', strtotime('-7 days')))
                ->get();
            $totalRequestsSent7DaysCount = $totalRequestsSent7Days->count() == 0 ? 0 : $totalRequestsSent7Days->count();

            $acceptance_rate = $RidesCompleted7DaysCount > 0 && $totalRequestsSent7DaysCount > 0 ?  ($RidesCompleted7DaysCount / $totalRequestsSent7DaysCount) : 0;
            $acceptance_percentage = $acceptance_rate * 100;

            $today_earnings = UserRequestPayment::whereHas('request', function ($query) {
                            $query->where('provider_id', Auth::user()->id);
                            $query->where('created_at', '>=', Carbon::now()->subWeekdays(1));
                        })->sum('provider_pay');

            $weekly_earnings = UserRequestPayment::whereHas('request', function ($query) {
                            $query->where('provider_id', Auth::user()->id);
                            $query->where('created_at', '>=', Carbon::now()->subWeekdays(7));
                        })->sum('provider_pay');

            return response()->json([
                'rides' => $RidesCompleted7Days,
                'rides_count' => $RidesCompleted7DaysCount,
                'acceptance_rate' => $acceptance_rate,
                'acceptance_percentage' => $acceptance_percentage,
                'today_earnings' => $today_earnings,
                'weekly_earnings' => $weekly_earnings,
                'target7' => Setting::get('weekly_target', '0')
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }

}
