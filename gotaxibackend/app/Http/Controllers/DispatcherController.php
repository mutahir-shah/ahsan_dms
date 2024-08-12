<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use anlutro\LaravelSettings\Facade as Setting;
use App\BlockUserProvider;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;
use App\Helpers\Helper;
use DB;
use App\User;
use App\Dispatcher;
use App\Provider;
use App\UserRequests;
use App\ContactEnquiry;
use App\BookingRequest;
use App\RequestFilter;
use App\ProviderService;
use App\RequestFilterLog;
use App\ServiceType;
use App\ZoneService;
use Illuminate\Validation\ValidationException;
use App\Services\LogService;

require_once app_path('Helper/ViewHelper.php');

class DispatcherController extends Controller
{

    protected $logService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
        $this->middleware('demo', ['only' => ['profile_update', 'password_update']]);
    }

    public function opt(){
        return view('dispatcher.auth.otp');
    }

    public function verifyOpt(Request $request){
        $user = auth()->guard('dispatcher')->user();
        if ($user->otp == $request->otp) {
            session()->pull('dispatcher_otp');
            return redirect("/dispatcher");
        }
        throw ValidationException::withMessages([
            "otp" => 'Invalid Otp'
        ]);
        return redirect()->back();
    }

    /**
     * Dispatcher Panel.
     *
     * @param Provider $provider
     * @return Response
     */
    public function admin_index()
    {
        $user_id = Auth::guard('admin')->id();
        $data = [];
        $data['view_permission'] = Helper::CheckPermission(config('const.VIEW'), config('const.DISPATCHER'));
        $data['add_permission'] = Helper::CheckPermission(config('const.ADD'), config('const.DISPATCHER'));
        $data['edit_permission'] = Helper::CheckPermission(config('const.EDIT'), config('const.DISPATCHER'));
        $data['status_permission'] = Helper::CheckPermission(config('const.STATUS'), config('const.DISPATCHER'));
        $data['delete_permission'] = Helper::CheckPermission(config('const.DELETE'), config('const.DISPATCHER'));
        $data['data_permission'] = Helper::CheckPermission(config('const.DATA'), config('const.DISPATCHER'));
        $data['dispatcher'] = translateKeyword('Dispatcher');
        $data['active_jobs'] = translateKeyword('active_jobs');
        $data['cancelled_jobs'] = translateKeyword('cancelled_jobs');
        $data['add'] = translateKeyword('add');
        $data['scheduled_list'] = translateKeyword('scheduled_list');
        $data['pending'] = translateKeyword('pending');
        $data['from'] = translateKeyword('from');
        $data['to'] = translateKeyword('to');
        $data['payment'] = translateKeyword('payment');
        $data['otp'] = translateKeyword('otp');
        $data['type'] = translateKeyword('type');
        $data['scheduled_at'] = translateKeyword('scheduled_at');
        $data['cancelled_at'] = translateKeyword('cancelled_at');
        $data['Job_list'] = translateKeyword('Job_list');
        $data['cancelled_list'] = translateKeyword('cancelled_list');
        $data['booking_id'] = translateKeyword('booking_id');
        $data['user'] = translateKeyword('user');
        $data['cancelled_by'] = translateKeyword('cancelled_by');
        $data['cancelled_reason'] = translateKeyword('cancelled_reason');
        $data['payment'] = translateKeyword('payment');
        $data['amount'] = translateKeyword('amount');
        $data['distance'] = translateKeyword('distance');
        $data['notes'] = translateKeyword('notes');
        $data['schedule'] = translateKeyword('schedule');
        $data['cancel_ride'] = translateKeyword('cancel_ride');
        $data['assign_driver'] = translateKeyword('assign_driver');
        $data['completed'] = translateKeyword('completed');
        $data['cancelled'] = translateKeyword('cancelled');
        $data['searching'] = translateKeyword('searching');
        $data['pickedup'] = translateKeyword('pickedup');
        $data['scheduled'] = translateKeyword('Schedulednow');
        $data['requested'] = translateKeyword('requested');
        $data['change_driver'] = translateKeyword('change_driver');
        $data['update_schedule'] = translateKeyword('update_schedule');
        $data['ride_details'] = translateKeyword('ride-details');
        $data['phone'] = translateKeyword('phone');
        $data['first_name'] = translateKeyword('first_name');
        $data['last_name'] = translateKeyword('last_name');
        $data['email'] = translateKeyword('email');
        $data['pickup_address'] = translateKeyword('pickup_address');
        $data['dropoff_address'] = translateKeyword('dropoff_address');
        $data['schedule_date_time'] = translateKeyword('schedule_date_time');
        $data['special_note'] = translateKeyword('special_note');
        $data['request_category'] = translateKeyword('request_category');
        $data['normal'] = translateKeyword('normal');
        $data['metered'] = translateKeyword('metered');
        $data['auto_assign_driver'] = translateKeyword('auto_assign_driver');
        $data['cancel'] = translateKeyword('cancel');
        $data['submit'] = translateKeyword('submit');
        $data['map'] = translateKeyword('map');
        $data['assign_date'] = translateKeyword('assign_date');
        $data['requested_date'] = translateKeyword('requested_date');
        $data['source_and_destination_address_should_not_be_same'] = translateKeyword('source_and_destination_address_should_not_be_same');
        $data['please_enter_any_extra_details_here'] = translateKeyword('please_enter_any_extra_details_here');
        $data['car_model'] = translateKeyword('car_model');
        $data['car_number'] = translateKeyword('car_number');
        $data['rating'] = translateKeyword('rating');

        return view('admin.dispatcher', get_defined_vars());
    }

    /**
     * Dispatcher Panel.
     *
     * @param Provider $provider
     * @return Response
     */
    public function dispatcher_index()
    {
        return view('dispatcher.dispatcher');
    }


    public function editSchedule($id)
    {
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.DISPATCHER'));
        if($edit_permission == 0){
            abort(401);
        }
        return view('admin.dispatcher.update-schedule', compact("id"));
    }

    public function updateSchedule(Request $request, UserRequests $user_request)
    {
        $request->validate([
            'schedule_at' => 'required'
        ]);

        $user_request->update([
            'schedule_at' => Carbon::parse($request->schedule_at)
        ]);

        $user_request = $user_request->refresh();

        $this->logService->log('Dispatcher', 'update', 'Dispacther Schedule Updated.', $user_request);

        return redirect()->route('admin.dispatcher.index');
    }
    /**
     * Map of all Users and Drivers.
     *
     * @return Response
     */

    public function map_ajax()

    {

        try {

            $providers = Provider::where('latitude', '!=', 0)
                ->where('status', 'approved')
                ->where('longitude', '!=', 0)
                ->with(['service' => function ($q) {
                    $q->where('status', '!=', 'riding');
                }])
                ->get();

            // $Users = User::where('latitude', '!=', 0)
            //     ->where('longitude', '!=', 0)
            //     ->get();

            // for ($i = 0; $i < sizeof($Users); $i) {

            //     $Users[$i]->status = 'user';
            // }

            // $All = $Users->merge($providers);

            return $providers;
        } catch (Exception $e) {

            return [];
        }
    }

    /**
     * Display a listing of the active trips in the application.
     *
     * @return Response
     */
    public function trips(Request $request)
    {
        if ($request->has('q') && !is_null($request->q)) {
            $q = $request->q;
            $Trips = UserRequests::with('user', 'provider', 'service_type')
                ->when($q, function ($query) use ($q) {
                    $query->where(function ($query) use ($q) {
                        $query->where('booking_id', 'LIKE', '%' . $q . '%')
                            ->orWhereHas('user', function ($query) use ($q) {
                                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $q . '%']);
                                if (is_numeric($q))
                                    $query->orWhere('mobile', 'LIKE', '%' . $q . '%');
                            });
                    });
                })
            ->orderBy('id', 'desc');
        } else {
            $Trips = UserRequests::with('user', 'provider', 'service_type')->orderBy('id', 'desc');
        }

        if ($request->type == "SEARCHING") {
            $currentTime = Carbon::now()->toDateTimeString();

            $Trips = $Trips->where('status', '!=', 'CANCELLED')->where('status', '!=', 'COMPLETED')
                ->orWhere(function ($query) use ($currentTime) {
                    $query->where('status', '=', 'SCHEDULED')->where('schedule_at', '>=', $currentTime);
                });
            // ->('status', '=', 'REQUESTED');
            // ->where('status', '!=', 'SCHEDULED')->orWhere(function ($query) {
            // $query->where('status', '=', 'SCHEDULED')->where('provider_id', '=', 0);
            // });
        } else if ($request->type == "CANCELLED") {
            $Trips = $Trips->where('status', $request->type);
        } else if ($request->type == "ONGOING") {
            $Trips = $Trips->where('status', '!=', 'CANCELLED')->where('status', '!=', 'COMPLETED')->where('status', '!=', 'SCHEDULED')->orWhere(function ($query) {
                $query->where('status', '=', 'SCHEDULED')->where('provider_id', '=', 0);
            });
        } else if ($request->type == "SCHEDULED") {
            $Trips = $Trips->where('status', '=', 'SCHEDULED');
        }

        $trips = $Trips->paginate(10);

        $trips->each(function ($trip) {
            $trip->formatted_amount = currency($trip->amount);
            $trip->formatted_distance = distance($trip->distance);
        });

        $show_otp = Setting::get('ride_otp', 0) == 1;

        return  compact("show_otp", "trips");
    }

    /**
     * Display a listing of the active trips in the application.
     *
     * @return Response
     */
    public function count_new_data()
    {
        $trips_count = UserRequests::where('status', '!=', 'CANCELLED')
            ->where('status', '!=', 'COMPLETED')
            ->where('status', '!=', 'SCHEDULED')
            ->orWhere(function ($query) {
                $query->where('status', '=', 'SCHEDULED')->where('provider_id', '=', 0);
            })
            ->count();

        $users_count = User::where('newly_created',  true)->count();
        $providers_count = Provider::where('newly_created', true)->count();
        $contact_enquiries_count = ContactEnquiry::where('newly_created', true)->count();
        $booking_requests_form_count = BookingRequest::where('newly_created', true)->count();


        return compact("trips_count", "users_count", "providers_count", 
                       "contact_enquiries_count", "booking_requests_form_count");
    }

    public function mark_providers_as_viewed()
    {
        Provider::query()->update([
            'newly_created' => false
        ]);
    }


    public function mark_users_as_viewed()
    {
        User::query()->update([
            'newly_created' => false
        ]);
    }

    public function mark_booking_requests_as_viewed()
    {
        BookingRequest::query()->update([
            'newly_created' => false
        ]);
    }

    public function mark_contact_enquiries_as_viewed()
    {
        ContactEnquiry::query()->update([
            'newly_created' => false
        ]);
    }

    /**
     * Display a listing of the users in the application.
     *
     * @return Response
     */
    public function users(Request $request)
    {
        $Users = new User;

        if ($request->has('mobile')) {
            $Users->where('mobile', 'like', $request->mobile . "%");
        }

        if ($request->has('first_name')) {
            $Users->where('first_name', 'like', $request->first_name . "%");
        }

        if ($request->has('last_name')) {
            $Users->where('last_name', 'like', $request->last_name . "%");
        }

        if ($request->has('email')) {
            $Users->where('email', 'like', $request->email . "%");
        }

        return $Users->paginate(10);
    }

    /**
     * Display a listing of the active trips in the application.
     *
     * @return Response
     */
    public function providers(Request $request)
    {
        $dataProviders = [];

        if ($request->has('latitude') && $request->has('longitude')) {
            $activeProviders = ProviderService::AllAvailableServiceProvider($request->service_type)
                ->where('is_selected', 1)
                ->where('is_approved', 1)
                ->where('status', 'active')
                ->get()
                ->pluck('provider_id')
                ->toArray();

            if (Setting::get('all_provider_dispatcher', 0) == 1) {
                $offlineProviders = ProviderService::AllOfflineServiceProvider($request->service_type)
                ->where('is_selected', 1)
                ->where('is_approved', 1)
                ->where('status', 'active')
                ->get()
                ->pluck('provider_id')
                ->toArray();
            } else {
                $offlineProviders = [];
            }

            $allProviders = array_merge($activeProviders, $offlineProviders);
            $allProviders = array_unique($allProviders);
            $distance = Setting::get('provider_search_radius', '10');
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $service_type = $request->service_type;
            // return $service_type;

            $q = $request->q;
            $current_provider = $request->current_provider;
            $currentDate = date('Y-m-d');

            if (Setting::get('all_provider_dispatcher', 0) == 1) {
                $providers = Provider::whereIn('id', $allProviders)
                    ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"), 'id', 'providers.*')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->where('status', 'approved')
                    ->with(['service' => function ($q) use ($service_type) {
                        $q->where('is_selected', 1)
                        ->where('is_approved', 1)
                        ->where('status', 'active')
                        ->where('service_type_id', '=', $service_type);
                    }, 'service.service_type'])
                    ->when($q, function ($query) use ($q) {
                        $query->where(function ($query) use ($q) {
                            $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $q . '%']);
                            if (is_numeric($q))
                                $query->orWhere('mobile', 'LIKE', '%' . $q . '%');
                        });
                    })
                    ->when($current_provider, function ($query) use ($current_provider) {
                        $query->where('id', '<>', $current_provider);
                    })
                    ->orderBy('distance');
            } else {
                $providers = Provider::whereIn('id', $allProviders)
                    ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"), 'id', 'providers.*')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->where('status', 'approved')
                    ->with(['service' => function ($q) use ($service_type) {
                        $q->where('is_selected', 1)
                        ->where('is_approved', 1)
                        ->where('status', 'active')
                        ->where('service_type_id', '=', $service_type);
                    }, 'service.service_type'])
                    ->when($q, function ($query) use ($q) {
                        $query->where(function ($query) use ($q) {
                            $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $q . '%']);
                            if (is_numeric($q))
                                $query->orWhere('mobile', 'LIKE', '%' . $q . '%');
                        });
                    })
                    ->when($current_provider, function ($query) use ($current_provider) {
                        $query->where('id', '<>', $current_provider);
                    })
                    ->orderBy('distance');
            }

            $now = Carbon::now();
            $assignedProviders = UserRequests::whereIn('provider_id', $allProviders)
                ->where("schedule_at", '>', $now->subMinutes(15)->format('Y-m-d H:i:s'))
                ->where("schedule_at", '<', $now->addMinutes(15)->format('Y-m-d H:i:s'))
                ->select('provider_id')
                ->pluck('provider_id');

            $providers = $providers->whereNotIn('id', $assignedProviders)->get();
            
            foreach($providers as $provider) {
                foreach($provider->service as $provider_service) {
                    $providerWithService = Provider::where('id', $provider->id)
                    ->with(['service' => function ($q) use ($provider_service) {
                        $q->where('is_selected', 1)
                        ->where('is_approved', 1)
                        ->where('status', 'active')
                        ->where('id', '=', $provider_service->id);
                    }, 'service.service_type'])->first();

                    array_push($dataProviders, $providerWithService);
                }
            }

            $responseArray['data'] = $dataProviders;

            return $responseArray;
        }

        return $dataProviders;
    }

    /**
     * Create manual request.
     *
     * @return Response
     */
    public function assign($request_id, $provider_id)
    {
        try {
            $userRequest = UserRequests::findOrFail($request_id);
            $provider = Provider::findOrFail($provider_id);
            $userRequestData = UserRequests::with(['user', 'provider', 'service_type'])->find($request_id);
            
            $userBlockedProviderCount = 0;
            if (Setting::get('block_user', 0) == 1) {
                $userBlockedProviderCount = BlockUserProvider::where('user_id', $userRequest->user_id)->where('provider_id', $provider_id)->where('blocked_by', 'USER')->count();
            }

            $providerBlockedUserCount = 0;
            if (Setting::get('block_driver', 0) == 1) {
                $providerBlockedUserCount = BlockUserProvider::where('user_id', $userRequest->user_id)->where('provider_id', $provider_id)->where('blocked_by', 'PROVIDER')->count();
            }

            if ($userBlockedProviderCount > 0 || $providerBlockedUserCount > 0) {
                if (Auth::guard('admin')->user()) {
                    return redirect()->route('admin.dispatcher.index')->with('flash_error', translateKeyword('cannot assigned to blocked user/provider!'));
                } elseif (Auth::guard('dispatcher')->user()) {
                    return redirect()->route('dispatcher.index')->with('flash_error', translateKeyword('cannot assigned to blocked user/provider!'));
                }
            }

            if (Setting::get('force_schedule_job', 0) == 1 || $userRequest->status == 'SCHEDULED') {
                $userRequest->status = 'SCHEDULED';
            } else {
                $userRequest->status = 'STARTED';
            }

            $changing_provider =  (!!$userRequest->provider_id) && $userRequest->provider_id != $provider_id;

            if ($changing_provider) {
                (new SendPushNotification)->provider_changed_to_provider($userRequest->provider_id);
                (new SendPushNotification)->provider_changed_to_user($userRequestData->user_id);
                ProviderService::where('provider_id', $userRequest->provider_id)
                    ->update(['status' => 'active']);
            }

            $userRequest->provider_id = $provider->id;
            $userRequest->current_provider_id = $provider->id;
            $userRequest->save();

            $this->logService->log('Dispatcher', 'status', 'Dispacther Status Updated.', $userRequest);

            $filter = new RequestFilter;
            $filter->request_id = $userRequest->id;
            $filter->provider_id = $provider->id;
            $filter->status = 0;
            $filter->save();

            if ($userRequest->status != 'SCHEDULED') {
                ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'riding']);
            }

            $timeOut = Setting::get('provider_select_timeout', 180);
            $userRequestData->time_left_to_respond = $timeOut - (time() - strtotime($userRequestData->assigned_at));

            $price = (float) $userRequestData->amount;

            $service_type_id = $userRequest->service_type_id;

            $serviceTypeController = new ServiceTypeController();
            $service_type = $serviceTypeController->getServiceType($service_type_id);
            
            $commissionDetail = $serviceTypeController->getCommissionPrice($service_type, $price);
            $commission_price = $commissionDetail['commission_price'];
            $price += $commission_price;

            $taxDetail = $serviceTypeController->getTaxPrice($service_type, $price);
            $tax_price = $taxDetail['tax_price'];
            $total = $price + $tax_price;

            $providerPay = $total - $commission_price;

            //TOdo: we'll handle this request latitude and longitude for pickup time
            // if (Setting::get('pickup_time_switch', 0) == 1) {
            //     $s_latitude = $request->latitude;
            //     $s_longitude = $request->longitude;
            //     $d_latitude = $userRequestData->s_latitude;
            //     $d_longitude = $userRequestData->s_longitude;

            //     $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);

            //     $userRequestData->pickup_duration = $duration;
            //     $userRequestData->pickup_distance = $distance;
            // }

            if($userRequestData->status != 'REQUESTED') {
                (new SendPushNotification)->IncomingRequest($userRequest->current_provider_id, $userRequestData);
            }

            try {
                RequestFilter::where('request_id', $userRequest->id)
                    ->where('provider_id', $provider->id)
                    ->firstOrFail();
            } catch (Exception $e) {
                $filter = new RequestFilter;
                $filter->request_id = $userRequest->id;
                $filter->provider_id = $provider->id;
                $filter->status = 0;
                $filter->save();

                $filter = new RequestFilterLog;
                $filter->request_id = $userRequest->id;
                $filter->provider_id = $provider->id;
                $filter->save();
            }

            if (Auth::guard('admin')->user()) {
                return redirect()
                    ->route('admin.dispatcher.index')
                    ->with('flash_success', translateKeyword('Request Assigned to Provider!'));
            } elseif (Auth::guard('dispatcher')->user()) {
                return redirect()
                    ->route('dispatcher.index')
                    ->with('flash_success', translateKeyword('Request Assigned to Provider!'));
            }
        } catch (Exception $e) {
            // dd($e->getMessage());
            if (Auth::guard('admin')->user()) {
                return redirect()->route('admin.dispatcher.index')->with('flash_error', translateKeyword('something_went_wrong'));
            } elseif (Auth::guard('dispatcher')->user()) {
                return redirect()->route('dispatcher.index')->with('flash_error', translateKeyword('something_went_wrong'));
            }
        }
    }


    /**
     * Create manual request.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            's_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
            'distance' => 'required|numeric',
            // 'mobile' => 'nullable|numeric',
            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15',
        ]);

        try {
            $user = User::when($request->email, function($query) use ($request) {
                $query->where('email', $request->email);
            })->orWhere('mobile', $request->mobile)->firstOrFail();
        } catch (Exception $e) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => str_replace(' ', '', $request->mobile),
                'password' => bcrypt($request->mobile),
                'payment_mode' => 'CASH'
            ]);
        }

        if ($request->has('schedule')) {
            try {
                $CheckScheduling = UserRequests::where('status', 'SCHEDULED')
                    ->where('user_id', $user->id)
                    ->where('schedule_at', '>', strtotime($request->schedule_time . " - 1 hour"))
                    ->where('schedule_at', '<', strtotime($request->schedule_time . " + 1 hour"))
                    ->firstOrFail();

                    return response()->json(false);
            } catch (Exception $e) {
                // Do Nothing
            }
        }

        if (Setting::get('instant_booking', 0) == 1) {
            if (UserRequests::where('user_id', $user->id)->where('status', 'REQUESTED')->count() > 0) {
                return response()->json(false);
            }
        } else {
            $status = ['SEARCHING','ACCEPTED','STARTED','ARRIVED','PICKEDUP','SCHEDULED'];
            if (UserRequests::where('user_id', $user->id)->whereIn('status', $status)->count() > 0) {
                return response()->json(false);
            }
        }

        try {

            $details = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $request->s_latitude . "," . $request->s_longitude . "&destination=" . $request->d_latitude . "," . $request->d_longitude . "&mode=driving&key=" . Setting::get('map_key') . "&units=" . Setting::get('distance_system', 'metric');
            $json = curl($details);
            $details = json_decode($json, TRUE);
            $route_key = $details['routes'][0]['overview_polyline']['points'];

            $details1 = $this->estimated_fare($request);
            
            $service_type_id = $request->service_type;

            $userRequest = new UserRequests;
            $userRequest->booking_id = Helper::generate_booking_id();
            $userRequest->user_id = $user->id;
            $userRequest->current_provider_id = 0;
            $userRequest->service_type_id = $service_type_id;
            $userRequest->payment_mode = 'CASH';

            if ($request->has('schedule')) {
                $userRequest->status = 'SCHEDULED';
            } else if (Setting::get('instant_booking', 0) == 1) {
                $userRequest->status = 'REQUESTED';
            } else {
                $userRequest->status = 'SEARCHING';
            }

            $userRequest->s_address = $request->s_address ?: "";
            $userRequest->s_latitude = $request->s_latitude;
            $userRequest->s_longitude = $request->s_longitude;
            $userRequest->otp = rand(1000, 9999);

            $userRequest->d_address = $request->d_address ?: "";
            $userRequest->d_latitude = $request->d_latitude;
            $userRequest->d_longitude = $request->d_longitude;
            $userRequest->route_key = $route_key;

            $s_latitude = $request->s_latitude;
            $s_longitude = $request->s_longitude;
            $d_latitude = $request->d_latitude;
            $d_longitude = $request->d_longitude;

            $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
            $meter = $googleDistanceAndTime['distanceValue'];

            $kilometer = Helper::applyDistanceSystem($meter);
            $userRequest->distance = $kilometer;
            $userRequest->assigned_at = Carbon::now();
            $userRequest->use_wallet = 0;
            $userRequest->surge = 0;        // Surge is not necessary while adding a manual dispatch
            $userRequest->specialNote = $request->has('specialNote') ? $request->specialNote : null;
            $userRequest->amount = $details1->estimated_fare;

            if ($request->has('schedule')) {
                $userRequest->schedule_at = Carbon::parse($request->schedule_time);
            }

            if ($request->has('request_category')) {
                $userRequest->request_category = $request->request_category;
            }

            $userRequest->save();

            $this->logService->log('Dispatcher', 'create', 'Dispacther Created', $userRequest);

            if ($request->has('provider_auto_assign')) {
                $activeProviders = ProviderService::AvailableServiceProvider($request->service_type)
                    ->where('is_selected', 1)
                    ->get()
                    ->pluck('provider_id');

                $distance = Setting::get('provider_search_radius', '10');
                $latitude = $request->s_latitude;
                $longitude = $request->s_longitude;

                $providers = Provider::whereIn('id', $activeProviders)
                    ->where('status', 'approved')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->get();

                // List Providers who are currently busy and add them to the filter list.
                if (count($providers) == 0) {
                    if ($request->ajax()) {
                        // Push Notification to User
                        return response()->json(['message' => trans('api.ride.no_providers_found')]);
                    } else {
                        return back()->with('flash_error', translateKeyword('no_providers_found'));
                    }
                }

                if (Setting::get('instant_booking', 0) == 1 || Setting::get('force_schedule_job', 0) == 1) {
                    $userRequest->current_provider_id = 0;
                } else {
                    $providers[0]->service()->update(['status' => 'riding']);
                    $userRequest->current_provider_id = $providers[0]->id;
                }

                $userRequest->save();

                // Log::info('New Dispatch : ' . $userRequest->id);
                // Log::info('Assigned Provider : ' . $userRequest->current_provider_id);

                // Incoming request push to provider
                $timeOut = Setting::get('provider_select_timeout', 180);
                $userRequestData = UserRequests::with(['user', 'provider', 'service_type'])->find($userRequest->id);
                $userRequestData->time_left_to_respond = $timeOut - (time() - strtotime($userRequestData->assigned_at));

                $price = (float) $userRequestData->amount;

                $service_type = $serviceTypeController->getServiceType($service_type_id);
            
                $serviceTypeController = new ServiceTypeController();
                $commissionDetail = $serviceTypeController->getCommissionPrice($service_type, $price);
                $commission_price = $commissionDetail['commission_price'];
                $price += $commission_price;

                $taxDetail = $serviceTypeController->getTaxPrice($service_type, $price);
                $tax_price = $taxDetail['tax_price'];
                $total = $price + $tax_price;

                $providerPay = $otal - $commission_price;

                //Todo: we'll handle request latitude and longitude
                // if (Setting::get('pickup_time_switch', 0) == 1) {

                //     $s_latitude = $request->latitude;
                //     $s_longitude = $request->longitude;
                //     $d_latitude = $userRequestData->s_latitude;
                //     $d_longitude = $userRequestData->s_longitude;

                //     $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                    
                //     $distance = $googleDistanceAndTime['distanceText'];
                //     $duration = $googleDistanceAndTime['durationText'];

                //     $userRequestData->pickup_duration = $duration;
                //     $userRequestData->pickup_distance = $distance;
                // }

                if($userRequestData->status != 'REQUESTED') {
                    (new SendPushNotification)->IncomingRequest($userRequest->current_provider_id, $userRequestData);
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

                    // incoming request push to provider
                    if (Setting::get('broadcast_request_all', 0) == 1) {
                        if($userRequestData->status != 'REQUESTED') {
                            if ($index == 0) {
                                $index = 1;
                                (new SendPushNotification)->IncomingRequest($provider->id, $userRequestData);
                            }
                        }
                    }

                    $filter->request_id = $userRequest->id;
                    $filter->provider_id = $provider->id;
                    $filter->save();

                    $filter = new RequestFilterLog;
                    $filter->request_id = $userRequest->id;
                    $filter->provider_id = $provider->id;
                    $filter->save();

                }
                
            }

            if ($request->ajax()) {
                return $userRequest;
            } else {
                return redirect('dashboard');
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong'), 'message' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', translateKeyword('Something wrong-try again'));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function profile()
    {
        return view('dispatcher.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function profile_update(Request $request)
    {
        try {
            $dispatcher = Auth::guard('admin')->user();
            $this->validate($request, [
                'name' => 'required|max:255',
                'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:dispatchers,mobile,' . $dispatcher->id,
            ]);

            $dispatcher = Auth::guard('admin')->user();
            $dispatcher->name = $request->name;
            $dispatcher->mobile = str_replace(' ', '', $request->mobile);
            $dispatcher->save();

            return redirect()->back()->with('flash_success', translateKeyword('profile_updated'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function password()
    {
        return view('dispatcher.account.change-password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function password_update(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $Dispatcher = Dispatcher::find(Auth::guard('admin')->user()->id);

            if (password_verify($request->old_password, $Dispatcher->password)) {
                $Dispatcher->password = bcrypt($request->password);
                $Dispatcher->save();

                return redirect()->back()->with('flash_success', translateKeyword('password_updated'));
            }
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function cancel(Request $request)
    {

        $this->validate($request, [
            'request_id' => 'required|numeric|exists:user_requests,id',
        ]);

        try {

            $userRequest = UserRequests::findOrFail($request->request_id);

            if ($userRequest->status == 'CANCELLED') {
                if ($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_cancelled')], 500);
                } else {
                    return back()->with('flash_error', translateKeyword('already_cancelled'));
                }
            }

            if (in_array($userRequest->status, ['SEARCHING', 'STARTED', 'ARRIVED', 'SCHEDULED', 'REQUESTED'])) {


                $userRequest->status = 'CANCELLED';
                $userRequest->cancel_reason = "Cancelled by Admin";
                $userRequest->cancelled_by = 'NONE';
                $userRequest->save();

                $this->logService->log('Dispatcher', 'status', 'Dispacther Status Updated', $userRequest);
                RequestFilter::where('request_id', $userRequest->id)->delete();

                if ($userRequest->status != 'SCHEDULED') {

                    if ($userRequest->provider_id != 0) {

                        ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'active']);
                    }
                }

                // Send Push Notification to User
                (new SendPushNotification)->UserCancellRide($userRequest);
                (new SendPushNotification)->ProviderCancellRide($userRequest);

                if ($request->ajax()) {
                    return response()->json(['message' => trans('api.ride.ride_cancelled')]);
                } else {
                    return back()->with('flash_success', translateKeyword('Request Cancelled Successfully'));
                }
            } else {
                if ($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_onride')], 500);
                } else {
                    return back()->with('flash_error', translateKeyword('Service Already Started!'));
                }
            }
        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            } else {
                return back()->with('flash_error', translateKeyword('No Request Found!'));
            }
        }
    }

    /**
     * Booking Requests.
     *
     * @return Response
     */

    public function booking_requests()
    {
        try {
            $bookingRequests = BookingRequest::orderBy('id', 'DESC')->get();
            return view('dispatcher.booking_requests', compact('bookingRequests'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    private function estimated_fare(Request $request)
    {

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

            if (Setting::get('zone_module', "0") == "1") {
                $geoFencingController = new GeoFencingController();
                if ($currentZone != null) {
                    $service_type = ZoneService::where('zone_id', $currentZone->id)->where('service_id', $request->service_type)->get()->first();
                    if (!$service_type) {
                        $service_type = ServiceType::findOrFail($request->service_type);
                    }
                } else {
                    $service_type = ZoneService::where('service_id', $request->service_type)->get()->first();
                    if (!$service_type) {
                        $service_type = ServiceType::findOrFail($request->service_type);
                    }
                }
            } else {
                $service_type = ServiceType::findOrFail($request->service_type);
            }

            $commission_tax_apply = Setting::get('commission_tax_apply', 'global');

            if ($commission_tax_apply == 'global') {
                $tax_percentage = Setting::get('tax_percentage', 10);
                $commission_type = Setting::get('commission_type', 'percentage');
                $provider_commission_percentage = Setting::get('commission_percentage', 10);
                $commission_percentage = Setting::get('commission_percentage', 10);
            } else if ($commission_tax_apply == 'service') {
                if (Setting::get('zone_module', "0") == "1") {
                    // $service_type = ZoneService::where('service_id', $userRequest->service_type_id)->get()->first();
                    $tax_percentage = $service_type->tax_percentage == null ? 0 : $service_type->tax_percentage;
                    $commission_type = $service_type->commission_type == null ? 'percentage' : $service_type->commission_type;
                    $provider_commission_percentage = $service_type->commission_percentage == null ? 0 : $service_type->commission_percentage;
                    $commission_percentage = $provider_commission_percentage;
                } else {
                    // $service_type = ServiceType::findOrFail($userRequest->service_type_id)->first();
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

            $extra_amount_percentage = Setting::get('extra_amount_percentage', '100');

            $price = $service_type->fixed;

            $phourfrom = $service_type->phourfrom;

            $phourto = $service_type->phourto;

            $pextra = $service_type->pextra == null ? 0 : $service_type->pextra;

            $base_distance = $service_type->distance;

            if ($kilometer <= $base_distance) {
                $kilometer = $base_distance;
            }
            $after_1_price = $service_type->price;
            $after_2_price = $service_type->after_2_price;
            $after_3_price = $service_type->after_3_price;
            $after_4_price = $service_type->after_4_price;
            // $kilometer0 = $base_distance;
            // $base_price = $base_distance > 0 ? $price : 0; //TODO: for handling base price with distance
            $base_price = $price;

            $kilometer_tiers = Helper::kilometer_tiers($kilometer, $service_type);

            $kilometer1 = $kilometer_tiers['kilometer1'];
            $kilometer2 = $kilometer_tiers['kilometer2'];
            $kilometer3 = $kilometer_tiers['kilometer3'];
            $kilometer4 = $kilometer_tiers['kilometer4'];
            $tier = $kilometer_tiers['tier'];

            $finalprice = 0;

            $isextraprice = 0;
            $extraprice = 0;
            if ($pextra != 0) {
                if (time() >= strtotime($phourfrom) && time() <= strtotime($phourto)) {
                    $isextraprice = 1;
                    $extraprice = $pextra;
                }
            }

            if ($service_type->calculator == 'MIN') {
                $finalprice += $base_price + $service_type->minute * $minutes;
                // $finalprice += $service_type->minute * $minutes;
            } else if ($service_type->calculator == 'HOUR') {
                $finalprice += $base_price + $service_type->minute * $hours;
                // $finalprice += $service_type->minute * 60;
            } else if ($service_type->calculator == 'DISTANCE') {
                $finalprice += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4);
                // $finalprice += ($kilometer * $service_type->price);
            } else if ($service_type->calculator == 'DISTANCETIER') {
                if ($tier == 1) {
                    $finalprice += $base_price + ($after_1_price * $kilometer);
                }

                if ($tier == 2) {
                    $finalprice += $base_price + ($after_2_price * $kilometer);
                }

                if ($tier == 3) {
                    $finalprice += $base_price + ($after_3_price * $kilometer);
                }

                if ($tier == 4) {
                    $finalprice += $base_price + ($after_4_price * $kilometer);
                }
                // $finalprice += ($kilometer * $service_type->price);
            } else if ($service_type->calculator == 'DISTANCEMIN') {
                $finalprice += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4) + ($service_type->minute * $minutes);
                // $finalprice += ($kilometer * $service_type->price) + ($service_type->minute * $minutes);
            } else if ($service_type->calculator == 'DISTANCEHOUR') {
                $finalprice += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4) + ($service_type->minute * $hours);
                // $finalprice += ($kilometer * $service_type->price) + ($service_type->minute * $minutes * 60);
            } else if ($service_type->calculator == 'DISTANCEWEIGHT') {
                $weight = $request->weight ? $request->weight : 0;
                $finalprice += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4) + ($service_type->weight * $weight);
                // $finalprice += ($kilometer * $service_type->price) + ($service_type->minute * $minutes * 60);
            } else if ($service_type->calculator == 'FIXED') {
                $finalprice += $price;
            } else {
                $finalprice += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4);
                // $finalprice += ($kilometer * $service_type->price);
            }

            $price = $finalprice < $price ? $price : $finalprice;

            $tax_price = ($tax_percentage / 100) * $price;

            if (strpos($origin_address, 'Terminal T1') !== false) {
                $price = $price + 4.30;
            } else if (strpos($destination_address, 'Terminal T1') !== false) {
                $price = $price + 4.30;
            } else if (strpos($origin_address, 'Terminal T2') !== false) {
                $price = $price + 4.30;
            } else if (strpos($destination_address, 'Terminal T2') !== false) {
                $price = $price + 4.30;
            } else if (strpos($origin_address, 'Barcelona Airport') !== false) {
                $price = $price + 4.30;
            } else if (strpos($destination_address, 'Barcelona Airport') !== false) {
                $price = $price + 4.30;
            } else if (strpos($origin_address, 'Aeropuerto') !== false) {
                $price = $price + 4.30;
            } else if (strpos($destination_address, 'Aeropuerto') !== false) {
                $price = $price + 4.30;
            } else if (strpos($origin_address, 'Aeroport') !== false) {
                $price = $price + 4.30;
            } else if (strpos($destination_address, 'Aeroport') !== false) {
                $price = $price + 4.30;
            } else if (strpos($origin_address, '08820') !== false) {
                $price = $price + 4.30;
            } else if (strpos($destination_address, '08820') !== false) {
                $price = $price + 4.30;
            }

            //  else if (strpos($destination_address, 'University Teaching Hospital') !== false) {
            //     $price += $price * ($extra_amount_percentage / 100);
            // } else if (strpos($origin_address, 'University Teaching Hospital') !== false) {
            //     $price += $price * ($extra_amount_percentage / 100);
            // }

            $total = $price + $tax_price;

            return (object)[

                'estimated_fare' => Helper::customRoundtoMultiple($price, 2),

                'time' => $time,

                'total' => Helper::customRoundtoMultiple($total, 2)

            ];
        } catch (Exception $e) {

            (object)[

                'estimated_fare' => 0,

                'time' => 0,

                'total' => 0

            ];
        }
    }
}
