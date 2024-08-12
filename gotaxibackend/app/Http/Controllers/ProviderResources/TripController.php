<?php

namespace App\Http\Controllers\ProviderResources;

use anlutro\LaravelSettings\Facade as Setting;
use App\Admin;
use App\BankAccount;
use App\Card;
use App\Document;
use App\RejectedRequest;

use App\Http\Controllers\UserRequestController;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GeoFencingController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SendPushNotification;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UserApiController;

use App\Promocode;
use App\PromocodePassbook;
use App\PromocodeUsage;
use App\Provider;
use App\ProviderCancellation;
use App\ProviderDocument;
use App\ProviderService;
use App\RequestFilter;
use App\RequestOffer;
use App\RequestReportImages;
use App\ServiceType;
use App\User;
use App\UserRequestPayment;
use App\UserRequestRating;
use App\UserRequests;
use App\WalletPassbook;
use App\WithdrawalMoney;
use App\ZoneCharge;
use App\ZoneService;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Location\Coordinate;
use Location\Distance\Vincenty;
use App\UserRequestsTracking;

use Log;
use Stripe\Charge;
use Stripe\Stripe;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $provider = Auth::user();
            } else {
                $provider = Auth::guard('provider')->user();
            }

            $provider_id = $provider->id;

            $activeServiceCount = $provider->service()->where('is_selected', 1)->where('is_approved', 1)->where('status', 'active')->count();
            $ridingServiceCount = $provider->service()->where('is_selected', 1)->where('is_approved', 1)->where('status', 'riding')->count();

            if($activeServiceCount > 0) {
                $service_status = 'active';
            } else if($ridingServiceCount > 0) {
                $service_status = 'riding';
            } else {
                $service_status = 'offline';
            }

            if (Setting::get('driver_verification', 0) == 1) {
                $documents = Document::whereIn('type', [ 'DRIVER', 'VEHICLE' ])->get(['id as document_id'])->pluck('document_id');
                $documentsCount = $documents->count(); //8
                $providerDocsCount = ProviderDocument::where('provider_id', $provider_id)->whereIn('document_id', $documents)->count();
                // 11 > 11
                if ($documentsCount > $providerDocsCount) {
                    Provider::where('id', $provider_id)->update(['status' => 'doc_required']);
                    
                    $responseArray = [
                        'account_status' => 'doc_required',
                        'service_status' => $service_status,
                        'requests' => [],
                        'pending_scheduled_jobs' => 0
                    ];

                    return $responseArray;
                } 
            }

            // else if($documentsCount >= $providerDocsCount) {
            //     Provider::where('id', $provider_id)->update(['status' => 'onboarding']);
            // }

            $activeRequests = UserRequests::PendingDriverRequest($provider_id)->count();
            $providerServicesActivatedCount = ProviderService::where('provider_id', $provider_id)->where('is_approved', 1)->where('is_selected', 1)->count(); 

            if ($activeRequests == 0 && $providerServicesActivatedCount == 0) {
                $service_status = 'disabled';
                if ($activeServiceCount == 0) {
                    $responseArray = [
                        'account_status' => $provider->status,
                        'service_status' => $service_status,
                        'requests' => [],
                        'pending_scheduled_jobs' => 0
                    ];
                    return $responseArray;
                }
            }

            if(Setting::get('subscription_module_stripe_trial', 0) == 0) {
                $trial_period = Setting::get('driver_trial_period', 0);
                if($trial_period > 0) {
                    $now = Carbon::now();
                    $providerUpdate = Provider::find($provider_id);
                    $trial_end_time = $providerUpdate->trial_end_time; 
                    if ($now > $trial_end_time) {
                        $providerUpdate->subscription_status = 'inactive';
                        $providerUpdate->save();
                    }
                }
            }

            // $statusArray = ['onboarding', 'banned', 'suspended', 'violation', 'low_balance', 'doc_required', 'in_review', 'subscription_expired'];

            if (Setting::get('subscription_module', 0) == 1 && Setting::get('driver_subscription_module', 0) == 1 && $provider->status == 'approved' && $provider->subscription_status != 'trialing') {
                $now = Carbon::now();
                $providerUpdate = Provider::find($provider_id);

                // $trialActive = true;
                // if($providerUpdate->trial_availed == 1) {
                //     $trialActive = false;
                // }
                $trialActive = false;
                $driver_trial_period = Setting::get('driver_trial_period', 0);

                if($trialActive == false) {
                    // $providerDocumentsPendingCount = ProviderDocument::where('provider_id', $provider_id)->where('status', 'ASSESSING')->count();
                    $pendingReviewCount = UserRequests::where('provider_id', $provider_id)->whereIn('status', ['DROPPED','COMPLETED'])->where('provider_rated', 0)->count();
                    if (
                        ($providerUpdate->rides_left == 0 && $pendingReviewCount == 0) 
                        || ($now > $providerUpdate->subscription_end_time)) {
                        $providerUpdate->is_subscribed = 0;
                        // $providerUpdate->status = 'subscription_expired';
                    }
                    // || $providerDocumentsPendingCount == 0 
                    // else if ($providerUpdate->rides_left > 0) {
                    //     $providerUpdate->is_subscribed = 1;
                    // } 
                    $providerUpdate->save();
                    $providerUpdate = $providerUpdate->refresh();
                    if ($providerUpdate->is_subscribed == 0) {
                        return response()->json(['account_status' => 'subscription_expired', 'service_status' => $service_status, 'requests' => [], 'pending_scheduled_jobs' => 0]);
                    }
                }
            }

            $AfterAssignProvider = RequestFilter::with(['request.user', 'request.payment', 'request'])
                ->where('provider_id', $provider_id)
                ->whereHas('request', function ($query) use ($provider_id) {
                    $query->where('status', '<>', 'CANCELLED');
                    $query->where('status', '<>', 'SCHEDULED');
                    $query->where('status', '<>', 'REQUESTED');
                    $query->where('provider_id', $provider_id);
                    // $query->where('current_provider_id', $provider);
                    // $query->where(function ($query) use($provider) {
                    //     $query->where(DB::raw("(SELECT count(*) FROM block_users_providers WHERE blocked_by='USER' AND user_id=user_id AND provider_id=$provider)"), "=", "0");
                    // });
            });
            // dd($AfterAssignProvider->get());

            // $incomingRequests = $AfterAssignProvider->count();

            // if ($incomingRequests == 0) {

            // }

            if($request->has('request_id') && $request->request_id != '') {
                UserRequestsTracking::create([
                    'provider_id' => $provider_id,
                    'request_id' => $request->request_id,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);
            }

            if (Setting::get('negotiation_module', 0) == 1) {
                $skippedRequests = RequestOffer::where('provider_id', $provider_id)->where('is_skipped', 1)->pluck('request_id')->toArray();
                // dd($skippedRequests);
                // bid requests are the ones that are being sent requests which are pending be offered from client
                $bidRequests = RequestOffer::where('provider_id', $provider_id)->where('is_declined', 0)->where('is_skipped', 0)->pluck('request_id')->toArray();
                // dd($bidRequests);
                $requestsFilterArray = array_merge($skippedRequests, $bidRequests);
                // dd($requestsFilterArray);
                $userRequestsArray = UserRequests::where('status', 'SEARCHING')->get(['id', 'updated_at']);
                foreach ($userRequestsArray as $userRequestValue) {
                    $offers = RequestOffer::where('request_id', $userRequestValue->id)
                        ->where('is_declined', 0)
                        ->latest()
                        ->get();

                    $offersCount = $offers->count();
                    if ($offersCount > 0) {
                        $dateNow = Carbon::now();
                        $updated_at = $offers[0]['updated_at'];
                        $totalDuration = $dateNow->diffInSeconds($updated_at);

                        if (
                            $totalDuration >= 60
                        ) {
                            array_push($requestsFilterArray, $offers[0]['request_id']);
                        }
                    } else {
                        $dateNow = Carbon::now();
                        $updated_at = $userRequestValue->updated_at;
                        $totalDuration = $dateNow->diffInSeconds($updated_at);

                        if (
                            $totalDuration >= 60
                        ) {
                            array_push($requestsFilterArray, $userRequestValue->id);
                        }
                    }
                }

                //Handling the case of ride started or ongoing
                $userRequestsOngoing = UserRequests::whereNotIn('status', ['CANCELLED', 'SCHEDULED', 'REQUESTED', 'SEARCHING'])->where('provider_id', $provider_id)->pluck('id')->toArray();
                $requestsFilterArray = array_merge($requestsFilterArray, $userRequestsOngoing);
                
                $BeforeAssignProvider = RequestFilter::with(['request.user' , 'request.payment', 'request'])
                    ->where('provider_id', $provider_id)
                    ->whereHas('request', function ($query) use ($provider_id, $requestsFilterArray) {
                        $query->whereNotIn('id', $requestsFilterArray);
                        $query->where('status', '<>', 'CANCELLED');
                        $query->where('status', '<>', 'SCHEDULED');
                        $query->where('status', '<>', 'REQUESTED');
                        $query->where('status', '=', 'SEARCHING');
                    });
            } else if (Setting::get('broadcast_request_all', 0) == 1) {
                $BeforeAssignProvider = RequestFilter::with(['request.user' , 'request.payment', 'request'])
                    ->where('provider_id', $provider_id)
                    ->whereHas('request', function ($query) use ($provider_id) {
                        $query->where('status', '<>', 'CANCELLED');
                        $query->where('status', '<>', 'SCHEDULED');
                        $query->where('status', '<>', 'REQUESTED');
                        $query->where('status', '=', 'SEARCHING');
                    });
            } else if (Setting::get('broadcast_request', 0) == 1) {
                $BeforeAssignProvider = RequestFilter::with(['request.user', 'request.payment', 'request'])
                    ->where('provider_id', $provider_id)
                    ->whereHas('request', function ($query) use ($provider_id) {
                        $query->where('status', '<>', 'CANCELLED');
                        $query->where('status', '<>', 'SCHEDULED');
                        $query->where('status', '<>', 'REQUESTED');
                        $query->where('current_provider_id', 0);
                    });
            } else {
                $BeforeAssignProvider = RequestFilter::with(['request.user', 'request.payment', 'request'])
                    ->where('provider_id', $provider_id)
                    ->whereHas('request', function ($query) use ($provider_id) {
                        $query->where('status', '<>', 'CANCELLED');
                        $query->where('status', '<>', 'SCHEDULED');
                        $query->where('status', '<>', 'REQUESTED');
                        $query->where('current_provider_id', $provider_id);
                    });
            }

            // $cancelledRequestProviderIds = ProviderCancellation::where('request_id', $incomingRequests[$i]->request->id)->pluck('provider_id')->toArray();

            $incomingRequests = $BeforeAssignProvider->union($AfterAssignProvider)->orderBy('request_id', 'DESC')->get();
            // return $incomingRequests;
            if (!empty($request->latitude)) {
                $provider->update([
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);

                // Get Zone Charges
                $geoFencingController = new GeoFencingController();
                $currentZone = $geoFencingController->getZone($request->latitude, $request->longitude);
                if($currentZone) {
                    $zoneCharges = ZoneCharge::where('zone_id', $currentZone->id)->get();

                    $zoneChargesSyncData = array_reduce($zoneCharges->toArray(), function($c, $i) {
                        $c[$i['id']] = [
                            'charge_value' => $i['charge_value']
                        ];
                        
                        return $c;
                    }, []);

                    foreach ($incomingRequests as $userRequest) {
                        $userRequestZoneCharge = UserRequests::find($userRequest->request_id);
                        $userRequestZoneCharge->zone_charges()->sync($zoneChargesSyncData);
                    }
                }
            }

            if (Setting::get('broadcast_request_all', 0) == 1) {
                for ($i = 0; $i < sizeof($incomingRequests); $i++) {
                    $timeOut = Setting::get('provider_select_timeout', 180);
                    $incomingRequests[$i]->time_left_to_respond = $timeOut - (time() - strtotime($incomingRequests[$i]->request->assigned_at));
                    if ($incomingRequests[$i]->request->status == 'SEARCHING' && $incomingRequests[$i]->time_left_to_respond < 0) {
                        if (Setting::get('negotiation_module', 0) == 0) {
                            if (Setting::get('broadcast_request', 0) == 1) {
                                $this->assign_destroy($incomingRequests[$i]->request->id);
                            } else {
                                $this->assign_next_provider($incomingRequests[$i]->request->id);
                            }
                        }
                    }
                }
            } else if (Setting::get('manual_request', 0) == 0) {
                $timeOut = Setting::get('provider_select_timeout', 180);
                if (!empty($incomingRequests)) {
                    for ($i = 0; $i < sizeof($incomingRequests); $i++) {
                        $incomingRequests[$i]->time_left_to_respond = $timeOut - (time() - strtotime($incomingRequests[$i]->request->assigned_at));
                        if ($incomingRequests[$i]->request->status == 'SEARCHING' && $incomingRequests[$i]->time_left_to_respond < 0) {
                            if (Setting::get('negotiation_module', 0) == 0) {
                                if (Setting::get('broadcast_request', 0) == 1) {
                                    $this->assign_destroy($incomingRequests[$i]->request->id);
                                } else {
                                    $this->assign_next_provider($incomingRequests[$i]->request->id);
                                }
                            }
                        }
                    }
                }
            }

            if (sizeof($incomingRequests) == 0) {
                if (($provider->service)) {
                    foreach($provider->service as $provider_service) {
                        if ($provider_service->status == 'riding') {
                            $provider_service->update(['status' => 'active']);
                        }
                    }
                }
            }

            if (Setting::get('driver_acc_blockage_doc', 0) == 1) {
                $ridesThreshold = Setting::get('driver_acc_blockage_doc_value', 0);
                $ridesCount = UserRequests::where('provider_id', $provider_id)->where('status', 'COMPLETED')->where('provider_rated', 1)->count();
                $providerDocumentsCount = ProviderDocument::where('provider_id', $provider_id)->count();
                if ($providerDocumentsCount == 0 && $ridesCount >= $ridesThreshold) {
                    $provider = Provider::find($provider_id);
                    $provider->status = 'doc_required';
                    $provider->save();
                }
            }

            foreach ($incomingRequests as $IncomingRequest) {
                
                $IncomingRequest->request->driver_amount = (string)Helper::customRoundtoMultiple($IncomingRequest->request->driver_amount, 2);

                if (Setting::get('negotiation_module', '') == 1) {

                    $negotiation_type = Setting::get('negotiation_type', 0);
                    $negotiation_min_threshold = Setting::get('negotiation_min_threshold', 0);
                    $negotiation_max_threshold = Setting::get('negotiation_max_threshold', 0);

                    if ($negotiation_type == 'percentage') {
                        $IncomingRequest->request->estimated_max_value = $IncomingRequest->request->client_offer + ($IncomingRequest->request->client_offer * ($negotiation_max_threshold / 100));
                        $minValue = ($IncomingRequest->request->client_offer * ($negotiation_min_threshold / 100));
                        // if ($minValue <= 0) {
                        //     $minValue = $IncomingRequest->request->client_offer;
                        // }
                        $IncomingRequest->request->estimated_min_value = $IncomingRequest->request->client_offer - ($minValue);

                        $difference = $IncomingRequest->request->client_offer * ($negotiation_max_threshold / 100);
                        $difference_part = $difference / 3;
                        $counter_offer_one = $IncomingRequest->request->client_offer + $difference_part;
                        $counter_offer_two = $counter_offer_one + $difference_part;
                        $counter_offer_three = $counter_offer_two + $difference_part;

                        $IncomingRequest->request->counter_offer_one = $counter_offer_one;
                        $IncomingRequest->request->counter_offer_two = $counter_offer_two;
                        $IncomingRequest->request->counter_offer_three = $counter_offer_three;
                    } else {
                        $IncomingRequest->request->estimated_max_value = $IncomingRequest->request->client_offer + ($negotiation_max_threshold);
                        $minValue = ($negotiation_min_threshold);
                        if ($minValue <= 0 || $minValue >= $IncomingRequest->request->client_offer) {
                            $minValue = $IncomingRequest->request->client_offer;
                        } else {
                            $minValue = $IncomingRequest->request->client_offer - ($minValue);
                        }
                        $IncomingRequest->request->estimated_min_value = $minValue;
                        $difference = $negotiation_max_threshold;
                        $difference_part = $difference / 3;
                        $counter_offer_one = $IncomingRequest->request->client_offer + $difference_part;
                        $counter_offer_two = $counter_offer_one + $difference_part;
                        $counter_offer_three = $counter_offer_two + $difference_part;

                        $IncomingRequest->request->counter_offer_one = $counter_offer_one;
                        $IncomingRequest->request->counter_offer_two = $counter_offer_two;
                        $IncomingRequest->request->counter_offer_three = $counter_offer_three;
                    }

                    $IncomingRequest->request->request_category = 'Normal';
                    $IncomingRequest->request->orders_count = UserRequests::where('user_id', $IncomingRequest->request->user_id)->count();
                }

                if (Setting::get('pickup_time_switch', 0) == 1) {

                    $s_latitude = $request->latitude;
                    $s_longitude = $request->longitude;
                    $d_latitude = $IncomingRequest->request->s_latitude;
                    $d_longitude = $IncomingRequest->request->s_longitude;

                    $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                    
                    $distance = $googleDistanceAndTime['distanceText'];
                    $duration = $googleDistanceAndTime['durationText'];

                    $IncomingRequest->request->orders_count = UserRequests::where('user_id', $IncomingRequest->request->user_id)->count();
                    $IncomingRequest->request->pickup_duration = $duration;
                    $IncomingRequest->request->pickup_distance = $distance;

                }

                if (Setting::get('drop_time_switch', 0) == 1) {

                    $s_latitude = $IncomingRequest->request->s_latitude;
                    $s_longitude = $IncomingRequest->request->s_longitude;
                    $d_latitude = $IncomingRequest->request->d_latitude;
                    $d_longitude = $IncomingRequest->request->d_longitude;

                    $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                    
                    $distance = $googleDistanceAndTime['distanceText'];
                    $duration = $googleDistanceAndTime['durationText'];

                    $IncomingRequest->request->drop_duration = $duration;
                    $IncomingRequest->request->drop_distance = $distance;
                }

                if (Setting::get('cancellation_deduction', 0) == 1) {
                    if ($IncomingRequest->request->status == 'ARRIVED' || $IncomingRequest->request->status == 'PICKEDUP') {
                        // $cancellationTimeout = Setting::get('cancellation_time', 5);
                        $arrivedAt = $IncomingRequest->request->arrived_at;
                        $arrivedDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $arrivedAt);
                        $dateNow = Carbon::now();
                        // $IncomingRequest->request->cancellation_enabled = $dateNow->diffInMinutes($arrivedDateTime) >= $cancellationTimeout ? true : false;
                        // $minutes = $dateNow->diffInMinutes($arrivedDateTime);
                        // $seconds = ($dateNow->diffInSeconds($arrivedDateTime) % 60);
                        // $IncomingRequest->request->job_arrived_duration = CarbonInterval::minutes($minutes)->seconds($seconds)->forHumans();
                        $IncomingRequest->request->job_arrived_duration = $dateNow->diffInSeconds($arrivedDateTime);
                    }
                }
                
            }
            
            // if ($provider->wallet < 1){
            //     $provider->status = 'banned';
            //     $provider->save();
            // }
            // else if ($provider->wallet > 0 && $provider->status = 'banned'){
            //     $provider->status = 'approved';
            //     $provider->save();
            // }

            if (Setting::get('driver_cancellation_block', 0) == 1) {
                $max_allowed_cancellation = Setting::get('max_allowed_cancellation', 3);
                $allowed_cancellation_unit = Setting::get('allowed_cancellation_unit', 'day');
                $allowed_cancellation_unit_value = Setting::get('allowed_cancellation_unit_value', 1);
                
                $timeStamp = null;
                if ($allowed_cancellation_unit == 'day') {
                    $timeStamp = Carbon::now()->subDays($allowed_cancellation_unit_value);
                }
                else if ($allowed_cancellation_unit == 'hour') {
                    $timeStamp = Carbon::now()->subHours($allowed_cancellation_unit_value);
                }
                else if ($allowed_cancellation_unit == 'min') {
                    $timeStamp = Carbon::now()->subMinutes($allowed_cancellation_unit_value);
                }

                $cancellation_count = ProviderCancellation::where('provider_id', Auth::user()->id)
                    ->when(isset($timeStamp), function ($query) use ($timeStamp) {
                        $query->where('created_at', '>', $timeStamp);  
                    })
                    ->count();
                
                if ($cancellation_count >= $max_allowed_cancellation) {
                    $incomingRequests = [];
                } 
            }
            
            // $activeServiceCount = $provider->service()->where('is_selected', 1)->where('is_approved', 1)
            //                             ->where(function($q) {
            //                                     $q->where('status', 'active')->orWhere('status', 'riding');
            //                             })->count();

            $currentTime = Carbon::now()->toDateTimeString();

            $pending_scheduled_jobs = UserRequests::where(function ($query) use ($currentTime) {
                $query->where('status', '=', 'SCHEDULED')
                    ->where('provider_id', Auth::user()->id)
                    ->where('schedule_at', '>=', $currentTime);
                })
                ->orWhere([['status', 'REQUESTED'], ['provider_id', Auth::user()->id]])
                ->count();

            $filteredInComingRequests = [];
            $userApiController = new UserApiController();
            foreach($incomingRequests as $userRequest){
                unset($userRequest->service_type);
                $userRequest['service_type'] = $userApiController->getServicesWithMultiLanguageAndByServiceTypeId($userRequest->request->service_type_id,$request);
                $filteredInComingRequests[] = $userRequest;

            }
            $responseArray = [
                'account_status' => $provider->status,
                'service_status' => $service_status,
                'requests' => $filteredInComingRequests,
                'pending_scheduled_jobs' => $pending_scheduled_jobs
            ];

            return $responseArray;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => translateKeywordApis("something_went_wrong", $request)]);
        }
    }

    public function capture_payment(Request $request)
    {
        try {
            $request_id = $request->request_id;
            $userRequest = UserRequests::findOrFail($request_id);
            // return $userRequest;
            if (Setting::get('booking_prepayment_method', 0) == 1 || Setting::get('booking_pre_payment', 0) == 1) {
                $userRequest->paid = 1;
                $userRequest->status = 'COMPLETED';
            }  

            if($userRequest->status == 'COMPLETED') {
                $userRequestController = new UserRequestController();
                $assignPendingRequests = $userRequestController->assignPendingRequests($userRequest->provider_id);
            }

            $requestPayment = UserRequestPayment::where('request_id', $request_id)->get()->first();
            
            if (Setting::get('booking_pre_payment', 0) == 1 ) {
                // If value of capturing greater than held amount
                if($userRequest->returnUserApiController == 1 && $userRequest->is_return_trip == 1){
                    $estimatedCapturedAmount = ($userRequest->return_amount * 1.20);
                }else{
                    $estimatedCapturedAmount = ($userRequest->amount * 1.20);
                }
                if ($requestPayment->payable > $estimatedCapturedAmount) {
                    // dd($requestPayment->payable);
                    $remainingAmount = $requestPayment->payable - $estimatedCapturedAmount;
                    $userStripe = User::find($userRequest->user_id);
                    $Card = Card::where('user_id', $userRequest->user_id)->where('is_default', 1)->first();
                    $requestPayment->card_details = json_encode($Card->only([
                        'last_four',
                        'brand',
                        'gateway_type'
                    ]));
                    
                    Stripe::setApiKey(Setting::get('stripe_secret_key'));
                    $Charge = Charge::create(array(
                        "amount" => intval($remainingAmount * 100),
                        "currency" => Setting::get('currency'),
                        "customer" => $userStripe->stripe_cust_id,
                        "card" => $Card->card_id,
                    ));
                    $estimatedAmount = intval($estimatedCapturedAmount * 100);
                } else {
                    $estimatedAmount = intval($requestPayment->payable * 100);
                }

                // $userRequest->prebooking_amount = $estimatedCapturedAmount;

                $charge_id = $userRequest->charge_id;

                // \Stripe\Stripe::setApiKey(Setting::get('stripe_secret_key'));
                //cURL to capture charge
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/charges/' . $charge_id . '/capture');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "amount=" . intval($estimatedAmount));
                curl_setopt($ch, CURLOPT_USERPWD, Setting::get('stripe_secret_key') . ':' . '');

                $headers = array();
                $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);

            }

            if (Setting::get('user_app_rating', 0) != 1) {
                $userRequest->user_rated = 1;
            }

            if (Setting::get('driver_app_rating', 0) != 1) {
                $userRequest->provider_rated = 1;
                // Delete from filter so that it doesn't show up in status checks.
                RequestFilter::where('request_id', $request_id)->delete();
                ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'active']);
            }

            $userRequest->save();

            $providerController = new ProviderController();
            $deductCommission = $providerController->deductCommission($request_id, $userRequest->provider_id);

            return response()->json(['message' => 'Amount captured successfully!'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }

    /**
     * Calculate distance between two coordinates.
     *
     * @return Response
     */

    public function calculate_distance(Request $request, $id)
    {
        $this->validate($request, [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);
        try {

            if ($request->ajax()) {
                $provider = Auth::user();
            } else {
                $provider = Auth::guard('provider')->user();
            }

            $userRequest = UserRequests::where('status', 'PICKEDUP')
                ->where('provider_id', $provider->id)
                ->find($id);

            if ($userRequest && ($request->latitude && $request->longitude)) {

                // Log::info("REQUEST ID:" . $userRequest->id . "==SOURCE LATITUDE:" . $userRequest->track_latitude . "==SOURCE LONGITUDE:" . $userRequest->track_longitude);

                if ($userRequest->track_latitude && $userRequest->track_longitude) {

                    $coordinate1 = new Coordinate($userRequest->track_latitude, $userRequest->track_longitude);
                    /** Set Distance Calculation Source Coordinates ****/
                    $coordinate2 = new Coordinate($request->latitude, $request->longitude);
                    /** Set Distance calculation Destination Coordinates ****/

                    $calculator = new Vincenty();

                    /***Distance between two coordinates using spherical algorithm (library as mjaschen/phpgeo) ***/

                    $mydistance = $calculator->getDistance($coordinate1, $coordinate2);

                    $meters = Helper::customRoundtoMultiple($mydistance);

                    // Log::info("REQUEST ID:" . $userRequest->id . "==BETWEEN TWO COORDINATES DISTANCE:" . $meters . " (m)");

                    if ($meters >= 100) {
                        /*** If traveled distance riched houndred meters means to be the source coordinates ***/
                        $traveldistance = Helper::customRoundtoMultiple(($meters / 1000), 8);

                        $calulatedistance = $userRequest->track_distance + $traveldistance;

                        $userRequest->track_distance = $calulatedistance;
                        $userRequest->distance = $calulatedistance;
                        $userRequest->track_latitude = $request->latitude;
                        $userRequest->track_longitude = $request->longitude;
                        $userRequest->save();
                    }
                } else if (!$userRequest->track_latitude && !$userRequest->track_longitude) {
                    $userRequest->distance = 0;
                    $userRequest->track_latitude = $request->latitude;
                    $userRequest->track_longitude = $request->longitude;
                    $userRequest->save();
                }
            }
            return $userRequest;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    /**
     * Cancel given request.
     *
     * @return Response
     */
    public function cancel(Request $request)
    {
        $this->validate($request, [
            'cancel_reason' => 'required',
        ]);

        try {

            $userRequest = UserRequests::find($request->id);

            if (!$userRequest) {
                return response()->json(['error' => translateKeywordApis("no_request_found", $request)]);
            }

            $Cancellable = ['SEARCHING', 'ACCEPTED', 'ARRIVED', 'STARTED', 'CREATED', 'SCHEDULED', 'REQUESTED'];

            if (!in_array($userRequest->status, $Cancellable)) {
                return response()->json(['error' => translateKeywordApis("cannot_cancel_request_at_this_stage", $request)]);
            }

            RejectedRequest::create([
                'provider_id' => Auth::user()->id,
                'user_request_id' => $request->id
            ]);

            $userRequest->status = "CANCELLED";

            if (is_string($request->cancel_reason)) {
                $userRequest->cancel_reason = $request->cancel_reason;
            } else {
                $userRequest->cancellation_reason_id = $request->cancel_reason;
            }

            $userRequest->cancelled_by = "PROVIDER";
            
            $userRequest->save();

            $provider_id = $userRequest->provider_id;
            $provider = Provider::find($provider_id);

            //Log data into cancellation table
            ProviderCancellation::create([
                'request_id' => $userRequest->id,
                'user_id' => $userRequest->user_id,
                'provider_id' => $provider_id,
            ]);

            //OLD Logic
            // if (!isset($provider->last_cancellation_time) || !$provider->last_cancellation_time->isToday()) {
            //     // Reset cancellation data for a new day
            //     $provider->last_cancellation_time = Carbon::now();
            //     $provider->cancelled_rides_today = 0;
            // }
            
            // // Increment the number of cancelled rides for today
            // $provider->cancelled_rides_today += 1;
            
            // if ($provider->cancelled_rides_today >= Setting::get('max_allowed_cancellation', 3))
            //     $provider->status = 'violation';

            // // Save the changes to the database
            // $provider->save();

            $cancellation_amount = Setting::get('cancellation_amount', 0);
            $price = 0;
            $cancel_amount_driver = 0;
            if ($request->has('is_no_show') && $request->is_no_show == 1) {
                
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
                                "description" => translateKeywordApis('cancellation_charge_for', $request) . ' ' . $userUpdate->email,
                                "receipt_email" => $userUpdate->email
                            ));
                        }
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

                    // $cancelPaymentDetailsJson = json_encode($cancelPaymentDetailsArray);
                    $userRequest->cancel_payment_details = $cancelPaymentDetailsArray;
                    $userRequest->cancel_amount = $cancellation_amount != null ? $price : 0.00;
                    $userRequest->cancel_amount_driver = $cancel_amount_driver;
                }
            }

            $userRequest->cancel_amount_driver = $cancel_amount_driver;
            $userRequest->save();
        
            //old logic
            // $currentDateTime = Carbon::now()->toDateTimeString();
            // $cancellationTimeout = Setting::get('cancellation_time', 5);
            // $rideDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $userRequest->created_at)->addMinutes($cancellationTimeout)->toDateTimeString();
            // if ($currentDateTime > $rideDateTime) {
            //     $cancellation_amount = Setting::get('cancellation_amount', 0);
            //     $provider->wallet = $provider->wallet - $cancellation_amount;
            //     $provider->save();
            // }                

            RequestFilter::where('request_id', $userRequest->id)->delete();

            ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'active']);

            //add job in searching and assign providers
            $request_id = $userRequest->id;
            $currentDateTime = Carbon::now();
            UserRequests::where('id', $request_id)->update(['status' => 'SEARCHING', 'assigned_at' => $currentDateTime]);

            $userRequestController = new UserRequestController();
            $assignPendingRequests = $userRequestController->assignPendingRequests(null, $request_id);

            // Send Push Notification to User
            (new SendPushNotification)->ProviderCancellRide($userRequest);

            return $userRequest;

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => translateKeywordApis("something_went_wrong", $request) , 'data' => $e->getMessage()]);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function rate(Request $request, $id)
    {

        $this->validate($request, [
            'rating' => 'required|integer|in:1,2,3,4,5',
            'comment' => 'max:255',
            'tip_amount' => 'nullable|numeric'
        ]);

        try {

            $userRequest = UserRequests::where('id', $id)
                ->where('status', 'COMPLETED')
                ->firstOrFail();
            $provider = Provider::find($userRequest->provider_id);

            if (Setting::get('report_images_driver', 0) == 1) {
                if ($request->has('driver_report_images')) {
                    foreach ($request->file('driver_report_images') as $imagefile) {
                        $image = $imagefile->store('reports');
                        $image = asset('storage/' . $image);
                        $userImage = new RequestReportImages();
                        $userImage->request_id = $id;
                        $userImage->image = $image;
                        $userImage->type = 'Driver';
                        $userImage->save();
                    }
                }
            }

            if ($userRequest->rating == null) {
                UserRequestRating::create([
                    'provider_id' => $userRequest->provider_id,
                    'user_id' => $userRequest->user_id,
                    'request_id' => $userRequest->id,
                    'provider_rating' => $request->rating,
                    'provider_comment' => $request->comment,
                ]);

            } else {
                $userRequest->rating->update([
                    'provider_rating' => $request->rating,
                    'provider_comment' => $request->comment,
                ]);
            }

            //Adding tip to user requests
            if ($request->tip_amount != null || $request->tip_amount != 0) {
                try {
                    if ($request->payment_method == 'CARD') {
                        $Card = Card::where('user_id', Auth::user() - id)->get()->first();
                        if (!$Card) {
                            return response()->json(['message' => 'Card is not available'], 501);
                        }

                        $StripeTipCharge = $request->amount * 100;

                        Stripe::setApiKey(Setting::get('stripe_secret_key'));

                        $Charge = Charge::create(array(
                            "amount" => $StripeTipCharge,
                            "currency" => Setting::get('currency'),
                            "customer" => Auth::user()->stripe_cust_id,
                            "card" => $Card->card_id,
                            "description" => "Tip charge"
                        ));
                    }


                    $userRequest->update(['tip_amount' => $request->tip_amount]);

                    $provider->wallet = $provider->wallet + $request->amount;
                    $provider->save();

                    return response()->json(['message' => currency($request->amount) . ' is charged as tip']);

                } catch (StripeInvalidRequestError $e) {
                    if ($request->ajax()) {
                        return response()->json(['error' => $e->getMessage()], 500);
                    } else {
                        return back()->with('flash_error', $e->getMessage());
                    }
                }
            }

            $userRequest->update(['provider_rated' => 1]);

            // Delete from filter so that it doesn't show up in status checks.
            RequestFilter::where('request_id', $id)->delete();

            ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'active']);

            // Send Push Notification to Provider 
            $average = UserRequestRating::where('provider_id', $userRequest->provider_id)->avg('provider_rating');

            $userRequest->user->update(['rating' => $average]);

            return response()->json(['message' => 'Request Completed!']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Request not yet completed!'], 500);
        }
    }

    /**
     * Get the trip history of the provider
     *
     * @return Response
     */
    public function scheduled(Request $request)
    {

        try {

            $currentTime = Carbon::now()->toDateTimeString();

            $Jobs = UserRequests::where('provider_id', Auth::user()->id)
                ->where('status', 'SCHEDULED')
                ->where('schedule_at', '>=', $currentTime)
                ->with('service_type')
                ->orderBy('schedule_at', 'ASC')
                ->get();

            if (!empty($Jobs)) {
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($Jobs as $key => $value) {
                    $Jobs[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .
                        "autoscale=1" .
                        "&size=320x130" .
                        "&maptype=terrian" .
                        "&format=png" .
                        "&visual_refresh=true" .
                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .
                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .
                        "&path=color:0x000000|weight:3|enc:" . $value->route_key .
                        "&key=" . Setting::get('map_key');
                }
            }

            $filteredUserRequests = [];
            $userApiController = new UserApiController();
            foreach($Jobs as $userRequest){
                unset($userRequest['service_type']);
                $userRequest['service_type'] = $userApiController->getServicesWithMultiLanguageAndByServiceTypeId($userRequest->service_type_id,$request);
                $filteredUserRequests[] = $userRequest;

            }

            return $filteredUserRequests;

        } catch (Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }

    /**
     * Get the trip history of the provider
     *
     * @return Response
     */
    public function history(Request $request)
    {
        if ($request->ajax()) {

            $Jobs = UserRequests::where('provider_id', Auth::user()->id)
                ->where(function ($query) {
                    $query->where('status', 'COMPLETED')
                        ->orWhere('status', 'CANCELLED');
                })
                ->orderBy('created_at', 'desc')
                ->with('payment', 'service_type')
                ->get();

            

            if (!empty($Jobs)) {
                $map_icon = asset('asset/marker.png');
                foreach ($Jobs as $key => $value) {
                    $Jobs[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .
                        "autoscale=1" .
                        "&size=320x130" .
                        "&maptype=terrian" .
                        "&format=png" .
                        "&visual_refresh=true" .
                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .
                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .
                        "&path=color:0x000000|weight:3|enc:" . $value->route_key .
                        "&key=" . Setting::get('map_key');
                }
            }

            $filteredUserRequests = [];
            $userApiController = new UserApiController();
            foreach($Jobs as $userRequest){
                unset($userRequest['service_type']);
                $userRequest['service_type'] = $userApiController->getServicesWithMultiLanguageAndByServiceTypeId($userRequest->service_type_id,$request);
                $filteredUserRequests[] = $userRequest;

            }

            return $filteredUserRequests;
        }
        $Jobs = UserRequests::where('provider_id', Auth::guard('provider')->user()->id)->with('user', 'service_type', 'payment', 'rating')->get();
        return view('provider.trip.index', compact('Jobs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function accept(Request $request, $id)
    {
        try {

            $userRequest = UserRequests::findOrFail($id);

            if (Setting::get('instant_booking', 0) == 0 || Setting::get('force_schedule_job', 0) == 0) {
                if ($userRequest->status != "SEARCHING") {
                    return response()->json(['message' => 'Request already under progress!'], 200);
                }
            }

            $userRequest->provider_id = Auth::user()->id;

            // TODO: removed check for broadcast_request for not updating current_provider_id
            // if (Setting::get('broadcast_request', 0) == 1) {
                $userRequest->current_provider_id = Auth::user()->id;
            // }

            if ($userRequest->schedule_at != "") {

                $beforeschedule_time = strtotime($userRequest->schedule_at . "- 1 hour");
                $afterschedule_time = strtotime($userRequest->schedule_at . "+ 1 hour");

                $currentTime = Carbon::now()->toDateTimeString();
                $CheckScheduling = UserRequests::where('status', 'SCHEDULED')
                    ->where('provider_id', Auth::user()->id)
                    ->whereBetween('schedule_at', [$beforeschedule_time, $afterschedule_time])
                    ->where('schedule_at', '>=', $currentTime)
                    ->count();

                if ($CheckScheduling > 0) {
                    if ($request->ajax()) {
                        return response()->json(['error' => trans('api.ride.request_already_scheduled')]);
                    } else {
                        return redirect('dashboard')->with('flash_error', 'If the ride is already scheduled then we cannot schedule/request another ride for the after 1 hour or before 1 hour');
                    }
                }

                RequestFilter::where('request_id', $userRequest->id)->where('provider_id', Auth::user()->id)->update(['status' => 2]);

                $Filters = RequestFilter::where('request_id', $userRequest->id)->get();
                // dd($Filters->toArray());
                foreach ($Filters as $filter) {
                    (new SendPushNotification)->IncomingRequestClear($filter->provider_id);
                }
                $userRequest->route_key = $userRequest->route_key; 
                $userRequest->status = "SCHEDULED";
                $userRequest->save();
            } else {

                $userRequest->status = "STARTED";
                $userRequest->save();

                ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'riding']);

                $Filters = RequestFilter::where('request_id', $userRequest->id)->get();
                // dd($Filters->toArray());
                foreach ($Filters as $filter) {
                    (new SendPushNotification)->IncomingRequestClear($filter->provider_id);
                }

                $Filters = RequestFilter::where('request_id', $userRequest->id)->where('provider_id', '!=', Auth::user()->id)->get();
                // dd($Filters->toArray());
                foreach ($Filters as $filter) {
                    $filter->delete();
                }
            }

            $UnwantedRequest = RequestFilter::where('request_id', '!=', $userRequest->id)
                ->where('provider_id', Auth::user()->id)
                ->whereHas('request', function ($query) {
                    $query->where('status', '<>', 'SCHEDULED');
                    $query->where('status', '<>', 'REQUESTED');
                });

            if ($UnwantedRequest->count() > 0) {
                $UnwantedRequest->delete();
            }

            // Send Push Notification to User
            (new SendPushNotification)->RideAccepted($userRequest);

            return $userRequest->with('user')->get();

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Unable to accept, Please try again later']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Connection Error']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|in:ACCEPTED,STARTED,ARRIVED,PICKEDUP,DROPPED,PAYMENT,COMPLETED',
        ]);

        try {

            $userRequest = UserRequests::with('user')->findOrFail($id);

            
            if($request->status == 'DROPPED' && Setting::get('subscription_module', 0) == 1) {
               
                if (Setting::get('rider_subscription_module', 0) == 1) {
                    $user_id = $userRequest->user_id;
                    $userSub = User::find($user_id);
                    
                    if ($userSub->rides_left > 0) {
                        if ($userRequest->is_free == 0) {
                            $userSub->rides_left = (int) $userSub->rides_left - 1;
                        }
                    }
                
                    $userSub->save();
                }
                
                if (Setting::get('driver_subscription_module', 0) == 1) {
                    $provider_id = $userRequest->provider_id;
                    $providerSub = Provider::find($provider_id);

                    if ($providerSub->rides_left > 0) {
                        if ($userRequest->is_free == 0) {
                            $providerSub->rides_left = (int) $providerSub->rides_left - 1;
                        }
                    }
    
                    $providerSub->save();
                }
            }

            if ($request->status == 'DROPPED' && $userRequest->is_free == true) {
                if (Setting::get('user_app_rating', 0) != 1) {
                    $userRequest->user_rated = 1;
                }

                if (Setting::get('driver_app_rating', 0) != 1) {
                    $userRequest->provider_rated = 1;
                    // Delete from filter so that it doesn't show up in status checks.
                    RequestFilter::where('request_id', $id)->delete();
                    ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'active']);
                }

                $userRequest->paid = 1;
                $userRequest->status = 'COMPLETED';
            } else if ($request->status == 'DROPPED' && $userRequest->payment_mode != 'CASH') {
                if (Setting::get('booking_pre_payment', 0) == 1 || Setting::get('booking_prepayment_method', 0) == 1) {
                    $userRequest->status = 'DROPPED';
                } else {
                    $userRequest->status = 'COMPLETED';
                }

                if (Setting::get('fleet_manager_address_nif') == 1) {
                    $userRequestCount = UserRequests::where('provider_id', $userRequest->provider_id)->where('status', 'COMPLETED')->count();
                    $providerFleetUpdate = Provider::find($userRequest->provider_id);
                    $providerFleetUpdate->fleet_invoice = $userRequestCount + 1;
                    $providerFleetUpdate->save();
                }
            } else if ($request->status == 'COMPLETED' && $userRequest->payment_mode == 'CASH') {
                if (Setting::get('user_app_rating', 0) != 1) {
                    $userRequest->user_rated = 1;
                }

                if (Setting::get('driver_app_rating', 0) != 1) {
                    $userRequest->provider_rated = 1;
                    // Delete from filter so that it doesn't show up in status checks.
                    RequestFilter::where('request_id', $id)->delete();
                    ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'active']);
                }

                $userRequest->status = $request->status;
                $userRequest->paid = 1;
                // ProviderService::where('provider_id',$userRequest->provider_id)->update(['status' =>'active']);
                //This is the case of cash
                $request_id = $userRequest->id;
            } else {
                $userRequest->status = $request->status;
                if ($request->status == 'ARRIVED') {
                    $userRequest->arrived_at = Carbon::now();
                    if (Setting::get('pickup_location_radius', 0) == 1) {

                        $s_latitude = $userRequest->s_latitude;
                        $s_longitude = $userRequest->s_longitude;
                        $d_latitude = $request->current_latitude;
                        $d_longitude = $request->current_longitude;

                        $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                        
                        $distance = $googleDistanceAndTime['distanceText'];
                        $duration = $googleDistanceAndTime['durationText'];
                        $meter = $googleDistanceAndTime['distanceValue'];
                        
                        $kilometer = Helper::applyDistanceSystem($meter);

                        $pickup_location_radius_value = Setting::get('pickup_location_radius_value', 0); //pickup_location_radius_value: 1
                        if ($kilometer > $pickup_location_radius_value) {
                            return response()->json(['error' => 'You cannot mark yourself arrived as you are away from the user!']);
                        }
                    } else {
                        if ($userRequest->track_longitude == '0.00000000' || $userRequest->track_latitude == '0.00000000') {
                            $s_latitude = $userRequest->s_latitude;
                            $s_longitude = $userRequest->s_longitude;
                            $d_latitude = $userRequest->d_latitude;
                            $d_longitude = $userRequest->d_longitude;
                        } else {
                            $s_latitude = $userRequest->s_latitude;
                            $s_longitude = $userRequest->s_longitude;
                            $d_latitude = $userRequest->track_latitude;
                            $d_longitude = $userRequest->track_longitude;
                        }

                        $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);

                        $meter = $googleDistanceAndTime['distanceValue'];

                        $kilometer = Helper::applyDistanceSystem($meter);
                        $userRequest->distance = $kilometer;
                    }

                    //kilometer: 10
                    (new SendPushNotification)->Arrived($userRequest);
                }
            }

            if ($request->status == 'PICKEDUP') {
                if ($userRequest->is_track == "YES") {
                    $userRequest->distance = 0;
                }
                $userRequest->started_at = Carbon::now();

                if (Setting::get('vehicle_weightage', 0) == 1) {
                    $userRequest->vweight = $request->confirm_weight;
                }
            }

            if ($request->status == 'DROPPED') {
                //TODO: disable this as this is not updating address on dropping
                if ($userRequest->is_track == "YES") {
                    $userRequest->d_latitude = $request->current_latitude ? : $userRequest->d_latitude;
                    $userRequest->d_longitude = $request->current_latitude ? : $userRequest->d_longitude;
                    $userRequest->d_address = $request->address ? : $userRequest->d_address;
                }

                if ($userRequest->payment_mode == 'CASH') {
                    if (Setting::get('bypass_invoice', 0) == 1) {
                        $userRequest->status = 'COMPLETED';
                        $userRequest->paid = 1;
                    }
                }

                if ($request->has('current_latitude') && $request->has('current_longitude')) {
                    $s_latitude = $userRequest->s_latitude;
                    $s_longitude = $userRequest->s_longitude;
                    $d_latitude = $request->current_latitude;
                    $d_longitude = $request->current_longitude;
                }
                
                if ($userRequest->track_longitude == '0.00000000' || $userRequest->track_latitude == '0.00000000') {
                    $s_latitude = $userRequest->s_latitude;
                    $s_longitude = $userRequest->s_longitude;
                    $d_latitude = $userRequest->d_latitude;
                    $d_longitude = $userRequest->d_longitude;
                } else {
                    $s_latitude = $userRequest->s_latitude;
                    $s_longitude = $userRequest->s_longitude;
                    $d_latitude = $userRequest->track_latitude;
                    $d_longitude = $userRequest->track_longitude;
                }

                $request_id = $userRequest->id;
                $serviceTypeController = new ServiceTypeController();
                $calculatedDistance = $serviceTypeController->calculateDistance($request_id);
                $meter = $calculatedDistance['totalDistance'];
                // $seconds = $calculatedDistance['totalDuration'];

                $googleDistanceAndTime = Helper::googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude);
                    
                $destination_address = $googleDistanceAndTime['destinationAddress'];
                $userRequest->d_address = $destination_address;
                // $meter = $googleDistanceAndTime['distanceValue']; // OLD Logic with start and end lat

                $kilometer = Helper::applyDistanceSystem($meter);
                $userRequest->distance = $kilometer;

                $polylinePoints = $serviceTypeController->getUserRequestPolylinePoints($request_id);
                $polylineData = Helper::getPolylineGoogleForRequest($polylinePoints['origin'], $polylinePoints['destination'], $polylinePoints['waypoints']);
                $route_key = $polylineData['points'] ? $polylineData['points'] : null;

                $userRequest->route_key = $route_key;

                //TODO: Check this time calculation thing
                $startedDate = date_create($userRequest->started_at);
                $finisedDate = Carbon::now();
                $userRequest->finished_at = Carbon::now();
                $timeInterval = date_diff($startedDate, $finisedDate);
                $hoursTime = $timeInterval->h;
                $mintuesTime = $timeInterval->i;
                $secondsTime = $timeInterval->s;
                $totalTimeTravelled = $hoursTime > 0 ? $hoursTime . " HOUR(s) " : "0 HOUR(s) ";
                $totalTimeTravelled .= $mintuesTime > 0 ? " " . $mintuesTime . " MIN(s)" : "0 MIN(s)";
                $totalTimeTravelled .= $secondsTime > 0 ? " " . $secondsTime . " SEC(s)" : " 0 SEC(s)";
                $userRequest->travel_time = $totalTimeTravelled;
                $userRequest->save();

                $userRequest = UserRequests::with('user')->findOrFail($id);
                if (Setting::get('zone_metering', '') == 1 || $request->category == 'Metered') {
                    if ($userRequest->request_category == 'Normal') {
                        $userRequest->invoice = $this->invoice($id);
                    } else {
                        // $amount = $request->amount;
                        // $userRequest->invoice = $this->invoice($id, $amount); // for metering we will not call invoice to update values
                    }
                } else {
                    $userRequest->invoice = $this->invoice($id);
                }

                (new SendPushNotification)->Dropped($userRequest);

                // Todo: this is invoice email to customer
                // Helper::site_sendmail($userRequest);
            }

            if ($request->status == 'COMPLETED' && $userRequest->payment_mode == 'CASH') {
                $providerController = new ProviderController();
                $deductCommission = $providerController->deductCommission($request_id, $userRequest->provider_id);
            }

            $userRequest->save();

            if($userRequest->status == 'COMPLETED') {
                $userRequestController = new UserRequestController();
                $assignPendingRequests = $userRequestController->assignPendingRequests($userRequest->provider_id);
            }

            return $userRequest;

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage(), 'error' => 'Unable to update, Please try again later']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $userRequest = UserRequests::find($id);
        try {

            $rejectable = ['SEARCHING'];

            if($userRequest) {
                if(in_array($userRequest->status, $rejectable)) {
                    $this->assign_next_provider($userRequest->id);
                    
                    return $userRequest->with('user')->get();
                }
            }
            
            return response()->json(['error' => 'Unable to reject, Please try again later']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Unable to reject, Please try again later']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Connection Error']);
        }
    }

    public function nextpro(Request $request)
    {
        try {

            $rejectable = ['SEARCHING'];
            $userRequest = UserRequests::findOrFail($request->id);
            RejectedRequest::create([
                'provider_id' => Auth::user()->id,
                'user_request_id' => $request->id
            ]);
            if (Setting::get('broadcast_request_all', 0) == 1) {
                if(in_array($userRequest->status, $rejectable)) {
                    RequestFilter::where('provider_id', Auth::user()->id)
                        ->where('request_id', $request->id)
                        ->delete();
                }
            } else {
                if(in_array($userRequest->status, $rejectable)) {
                    $userRequest = UserRequests::findOrFail($request->id);
                    $this->assign_next_provider($userRequest->id);
                }
            }
            return response()->json(['message' => 'Job rejected successfully']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Something went wrong']);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function assign_destroy($id)
    {
        $userRequest = UserRequests::find($id);
        try {
            UserRequests::where('id', $userRequest->id)->update(['status' => 'CANCELLED']);
            // No longer need request specific rows from RequestMeta
            RequestFilter::where('request_id', $userRequest->id)->delete();
            //  request push to user provider not available
            (new SendPushNotification)->ProviderNotAvailable($userRequest->user_id);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Unable to reject, Please try again later']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Connection Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */

    public function assign_next_provider($request_id)
    {

        try {
            $userRequest = UserRequests::findOrFail($request_id);
        } catch (ModelNotFoundException $e) {
            // Cancelled between update.
            return false;
        }

        if (Setting::get('code_base_job_req', 0) == 1 && ($userRequest->driver_job_code != null || $userRequest->driver_job_code != "")) {
            (new SendPushNotification)->driver_job_declined($userRequest->user_id);
        }

        $RequestFilter = RequestFilter::where('provider_id', $userRequest->current_provider_id)
            ->where('request_id', $userRequest->id)
            ->delete();

        try {

            $next_provider = RequestFilter::where('request_id', $userRequest->id)
                ->orderBy('id')
                ->firstOrFail();

            $userRequest->current_provider_id = $next_provider->provider_id;
            $userRequest->assigned_at = Carbon::now();
            $userRequest->save();


            // incoming request push to provider
            $timeOut = Setting::get('provider_select_timeout', 180);
            $userRequestData = UserRequests::with(['user', 'provider'])->find($request_id);
            $userRequestData->time_left_to_respond = $timeOut - (time() - strtotime($userRequestData->assigned_at));
            $userRequestData->driver_amount = (string) Helper::customRoundtoMultiple($userRequestData->driver_amount, 2);
            $index = 0;
            // $userRequest->status == 'SEARCHING' || 
            if (Setting::get('broadcast_request_all', 0) == 1) {
                if($userRequestData->status != 'REQUESTED') {
                    if ($index == 0) {
                        $index = 1;
                        (new SendPushNotification)->IncomingRequest($next_provider->id, $userRequestData);
                    }
                }
            }

        } catch (ModelNotFoundException $e) {

            UserRequests::where('id', $userRequest->id)->update(['status' => 'CANCELLED']);

            // No longer need request specific rows from RequestMeta
            RequestFilter::where('request_id', $userRequest->id)->delete();

            //  request push to user provider not available
            (new SendPushNotification)->ProviderNotAvailable($userRequest->user_id);
        }
    }


    public function invoice($request_id)
    {
        try {
            $userRequest = UserRequests::findOrFail($request_id);

            $service_type_id = $userRequest->service_type_id;
            $s_latitude = $userRequest->s_latitude;
            $s_longitude = $userRequest->s_longitude;
            $vweight = $userRequest->vweight;
            $origin_address = $userRequest->s_address;
            $destination_address = $userRequest->destination_address;
            $distance = $kilometer = $userRequest->distance;
            $schedule_time = $userRequest->schedule_time ? $schedule_time : null;
            $schedule_date = $userRequest->schedule_date ? $schedule_date : null;
            $schedule_web = false; //TODO: handle this from user_requests table
            $is_surge = $userRequest->surge;
            $is_peak = $userRequest->is_peak;
            
            $start_time = Carbon::parse($userRequest->started_at);
            $end_time = Carbon::parse($userRequest->finished_at);
            $seconds = $end_time->diffInSeconds($start_time);
            $minutes = $seconds / 60;
            $hours = $minutes / 60;

            $serviceTypeController = new ServiceTypeController();
            $userApiController = new UserApiController();

            $service_type = $serviceTypeController->getServiceType($service_type_id, $s_latitude, $s_longitude);

            $base_price = $service_type->fixed;
            // $base_distance = $service_type->distance;
            $locked_pricing = $service_type->locked_pricing;

            $calculationData = $userApiController->calculatePricingWithServiceType($service_type, $schedule_date, $schedule_time, $schedule_web, $kilometer, $seconds, $origin_address, $destination_address, $s_latitude, $s_longitude, $vweight);
            $peakActive = $calculationData['peakActive'];
            // $isextraprice = $calculationData['isextraprice'];
            if($userRequest->returntrip == 1 && $userRequest->is_return_trip == 1){
                $price = $calculationData['rideReturnPrice'];
            }else{
                $price = $calculationData['ridePrice'];
            }
            $ridePrice = $price;

            if ($locked_pricing == 1) {
                if (Setting::get('negotiation_module', 0) == 1) {
                    $price = $userRequest->client_offer;
                    $ridePrice = $price;
                } else {
                    if($userRequest->returntrip == 1 && $userRequest->is_return_trip == 1){
                        $price = $userRequest->return_ride_amount;
                    }else{
                        $price = $userRequest->ride_amount;
                    }
                    $ridePrice = $price;
                }
            } else {
                if (Setting::get('negotiation_module', 0) == 1) {
                    $price = $userRequest->client_offer;
                    $ridePrice = $price;
                }
            }

            $peakDetail = $serviceTypeController->getPeakPrice($service_type, $price, $peakActive);
            $peakActive = $peakDetail['peakActive'];
            $peakPrice = $peakDetail['peakPrice'];
            $peakType = $peakDetail['peakType'];
            $peakValue = $peakDetail['peakValue'];
            $price += $peakPrice;

            $surgePrice = 0;
            $surgePercentage = 0;
            if ($is_surge) {
                $surgeDetail = $serviceTypeController->getSurgeAmount($price);
                $surgePrice = $surgeDetail['surgePrice'];
                $surgePercentage = $surgeDetail['surge_percentage'];
                $price += $surgePrice;
            }
             
            //TODO: we'll discuss this later to apply commission on which price
            $commissionDetail = $serviceTypeController->getCommissionPrice($service_type, $price);
            $commission_price = $commissionDetail['commission_price'];
            $commission_type = $commissionDetail['commission_type'];
            $commission_deduction = $commissionDetail['commission_deduction'];
            $commission_source = $commissionDetail['commission_source'];
            $commission_value = $commissionDetail['commission_percentage'];
            $price += $commission_price;

            $bookingFeeDetail = $serviceTypeController->getBookingPrice($service_type);
            $bookingFeeActive = $bookingFeeDetail['bookingFeeActive'];
            $bookingFeeAmount = $bookingFeeDetail['bookingFeeAmount'];
            $price += $bookingFeeAmount;

            $taxDetail = $serviceTypeController->getTaxPrice($service_type, $price);
            $tax_price = $taxDetail['tax_price'];
            $tax_percentage = $taxDetail['tax_percentage'];
            $tax_active = $taxDetail['tax_active'];

            $governmentChargesDetail = $serviceTypeController->getGovernmentCharges($service_type, $price);
            $government_charges_active = $governmentChargesDetail['government_charges_active'];
            $government_charges = $governmentChargesDetail['government_charges'];

            $tollFeeDetail = $serviceTypeController->getTollFee($userRequest->id);
            $toll_fee_active = $tollFeeDetail['toll_fee_active'];
            $toll_fee = $tollFeeDetail['toll_fee'];

            $airportChargesDetail = $serviceTypeController->getAirportCharges($userRequest->id);
            $airport_charges_active = $airportChargesDetail['airport_charges_active'];
            $airport_charges = $airportChargesDetail['airport_charges'];

            $additionalCharges = $government_charges + $toll_fee + $airport_charges;
            $price += $additionalCharges;

            $total = $price + $tax_price;

            $bankChargesDetail = $serviceTypeController->getBankCharges($service_type, $total);
            $bank_charges_active = $bankChargesDetail['bank_charges_active'];
            $bank_charges_type = $bankChargesDetail['bank_charges_type'];
            $bank_charges_value = $bankChargesDetail['bank_charges_value'];
            $bank_charges_amount = $bankChargesDetail['bank_charges_amount'];

            if($userRequest->payment_mode == 'CARD') {
                $grand_total = $total + $bank_charges_amount;
            } else {
                $bank_charges_active = 0;
                $grand_total = $total;
            }
            
            // dd($service_type);
            // $extra_amount_percentage = Setting::get('extra_amount_percentage', '100');

            $discount = 0; // Promo Code discounts should be added here.
            $wallet = 0;
            $providerCommission = 0;
            $companyCommission = 0;
            $providerPay = 0;
            
            // Company Commission: Booking Fee + Company Commission + Tax
            $companyCommission =  $commission_price + $bookingFeeAmount + $tax_price; //Company Comission
            // Provider Commission: Total - (Booking Fee + Company Commission + Tax
            $providerCommission = $total - ($companyCommission + $additionalCharges);
            $providerPay = $providerCommission;

            if ($promocodeUsage = PromocodeUsage::where('user_id', $userRequest->user_id)->where('status', 'ADDED')->first()) {
                if ($Promocode = Promocode::find($promocodeUsage->promocode_id)) {
                    $discount = $Promocode->discount;
                    $promocodeUsage->status = 'USED';
                    $promocodeUsage->save();

                    PromocodePassbook::create([
                        'user_id' => Auth::user()->id,
                        'status' => 'USED',
                        'promocode_id' => $promocodeUsage->promocode_id
                    ]);
                }

                if ($promocodeUsage->promocode->discount_type == 'amount') {
                    $total -= $discount;
                } else {
                    $total = ($total) - (($total) * ($discount / 100));
                    $discount = (($total) * ($discount / 100));
                }
            }

            if ($total < 0) {
                $total = 0.00; // prevent from negative value
            }

            $payment = new UserRequestPayment;

            $payment->peak_active = (bool) $is_peak;
            $payment->peak_value = $peakValue;
            $payment->peak_price = $peakPrice;
            $payment->peak_type = $peakType;

            $payment->surge_active = (bool) $is_surge;
            $payment->surge_percentage = $surgePercentage;
            $payment->surge = $surgePrice;

            $payment->commission_active = (bool) $commission_deduction;
            $payment->commision = $commission_price;
            $payment->commission_type = $commission_type;
            $payment->commission_value = $commission_value;
            $payment->commission_source = $commission_source;

            $payment->booking_fee_active = (bool) $bookingFeeActive;
            $payment->booking_fee = $bookingFeeAmount;

            $payment->tax_active = (bool) $tax_active;
            $payment->tax_percentage = $tax_percentage;
            $payment->tax = $tax_price;

            $payment->government_charges_active = (bool) $government_charges_active;
            $payment->government_charges = $government_charges;

            $payment->toll_fee_active = (bool) $toll_fee_active;
            $payment->toll_fee = $toll_fee;

            $payment->airport_charges_active = (bool) $airport_charges_active;
            $payment->airport_charges = $airport_charges;

            $payment->bank_charges_active = (bool) $bank_charges_active;
            $payment->bank_charges_type = $bank_charges_type;
            $payment->bank_charges_value = $bank_charges_value;
            $payment->bank_charges_amount = $bank_charges_amount;

            $payment->request_id = $request_id;
            $payment->fixed = $base_price;
            $payment->distance = $distance;
            $payment->company_commission = $companyCommission;
            $payment->provider_commission = $providerCommission;
            $payment->t_price = $ridePrice;
            $payment->total = $grand_total;
            $payment->provider_pay = $providerPay;
            if ($discount != 0 && $promocodeUsage) {
                $payment->promocode_id = $promocodeUsage->promocode_id;
            }
            $payment->discount = $discount;

            if ($discount == ($base_price + $price + $tax_price)) {
                $userRequest->paid = 1;
            }

            if ($userRequest->use_wallet == 1 && $grand_total > 0) {
                $user = User::find($userRequest->user_id);
                $wallet = $user->wallet_balance;
                if ($wallet != 0) {
                    if ($grand_total > $wallet) {
                        $payment->wallet = $wallet;
                        $payable = $grand_total - $wallet;

                        $providerController = new ProviderController();
                        $bankAccountId = $providerController->getBankAccount($userRequest->provider_id);

                        $amountToProvider = $wallet;
                        WithdrawalMoney::create([
                            'bank_account_id' => $bankAccountId,
                            'provider_id' => $userRequest->provider_id,
                            'amount' => abs($amountToProvider)
                        ]);

                        User::where('id', $userRequest->user_id)->update(['wallet_balance' => 0]);
                        $payment->payable = abs($payable);

                        WalletPassbook::create([
                            'user_id' => $userRequest->user_id,
                            'amount' => $wallet,
                            'status' => 'DEBITED',
                            'via' => 'TRIP',
                        ]);

                        // charged wallet money push 
                        (new SendPushNotification)->ChargedWalletMoney($userRequest->user_id, ($wallet));

                    } else {

                        $payment->payable = 0;
                        $WalletBalance = $wallet - $grand_total;
                        User::where('id', $userRequest->user_id)->update(['wallet_balance' => $WalletBalance]);
                        $payment->wallet = $grand_total;
                        $payment->save();

                        $request_id = $userRequest->id;
                        $providerController = new ProviderController();
                        $deductCommission = $providerController->deductCommission($request_id, $userRequest->provider_id);

                        if (Setting::get('booking_pre_payment', 0) == 0 || Setting::get('booking_prepayment_method', 0) == 0) {
                            $payment->payment_id = 'WALLET';
                            $payment->payment_mode = 'WALLET';
                            $userRequest->paid = 1;
                            $userRequest->status = 'COMPLETED';
                        }

                        $userRequest->save();

                        if($userRequest->status == 'COMPLETED') {
                            $userRequestController = new UserRequestController();
                            $assignPendingRequests = $userRequestController->assignPendingRequests($userRequest->provider_id);
                        }

                        WalletPassbook::create([
                            'user_id' => $userRequest->user_id,
                            'amount' => $grand_total,
                            'status' => 'DEBITED',
                            'via' => 'TRIP',
                        ]);

                        $bank_charges_active = 0;
                        $grand_total = $total;

                        // charged wallet money push 
                        (new SendPushNotification)->ChargedWalletMoney($userRequest->user_id, ($grand_total));
                    }
                }

            } else {
                $payment->total = abs($grand_total);
                $payment->payable = abs($grand_total);
            }

            if ((Setting::get('booking_pre_payment', 0) == 1 && Setting::get('CARD', 0) == 1) || Setting::get('booking_prepayment_method', 0) == 1) {
                if ($userRequest->payment_mode == 'CARD') {
                    $payment->payment_id = 'CARD';
                    $payment->payment_mode = 'CARD';
                } else {
                    $payment->payment_id = 'CASH';
                    $payment->payment_mode = 'CASH';
                }
            }

            $payment->save();

            return $payment;

        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * Get the trip history details of the provider
     *
     * @return Response
     */
    public function history_details(Request $request)
    {
        $this->validate($request, [
            'request_id' => 'required|integer|exists:user_requests,id',
        ]);

        if ($request->ajax()) {

            $Jobs = UserRequests::where('id', $request->request_id)
                ->where('provider_id', Auth::user()->id)
                ->with('payment', 'service_type', 'user', 'rating', 'provider', 'userReportImages','driverReportImages')
                ->get();
            if (!empty($Jobs)) {
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($Jobs as $key => $value) {
                    $Jobs[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .
                        "autoscale=1" .
                        "&size=320x130" .
                        "&maptype=terrian" .
                        "&format=png" .
                        "&visual_refresh=true" .
                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .
                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .
                        "&path=color:0x000000|weight:3|enc:" . $value->route_key .
                        "&key=" . Setting::get('map_key');

                    // $Jobs[$key]->cancel_booking_fee_amt = $Jobs[$key]->cancel_amount + $Jobs[$key]->booking_fee;
                }
            }

            $filteredUserRequests = [];
            $userApiController = new UserApiController();
            foreach($Jobs as $userRequest){
                unset($userRequest['service_type']);
                $userRequest['service_type'] = $userApiController->getServicesWithMultiLanguageAndByServiceTypeId($userRequest->service_type_id,$request);
                $filteredUserRequests[] = $userRequest;

            }

            return $filteredUserRequests;
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function upcoming_trips()
    {

        try {
            $UserRequests = UserRequests::ProviderUpcomingRequest(Auth::user()->id)->get();
            if (!empty($UserRequests)) {
                $map_icon = asset('asset/marker.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .
                        "autoscale=1" .
                        "&size=320x130" .
                        "&maptype=terrian" .
                        "&format=png" .
                        "&visual_refresh=true" .
                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .
                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .
                        "&path=color:0x000000|weight:3|enc:" . $value->route_key .
                        "&key=" . Setting::get('map_key');
                }
            }
            return $UserRequests;
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Get the trip history details of the provider
     *
     * @return Response
     */
    public function upcoming_details(Request $request)
    {
        $this->validate($request, [
            'request_id' => 'required|integer|exists:user_requests,id',
        ]);

        if ($request->ajax()) {

            $Jobs = UserRequests::where('id', $request->request_id)
                ->where('provider_id', Auth::user()->id)
                ->with('service_type', 'user')
                ->get();
            if (!empty($Jobs)) {
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($Jobs as $key => $value) {
                    $Jobs[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .
                        "autoscale=1" .
                        "&size=320x130" .
                        "&maptype=terrian" .
                        "&format=png" .
                        "&visual_refresh=true" .
                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .
                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .
                        "&path=color:0x000000|weight:3|enc:" . $value->route_key .
                        "&key=" . Setting::get('map_key');
                }
            }

            return $Jobs;
        }

    }

    /**
     * Get the trip history details of the provider
     *
     * @return Response
     */
    public function summary(Request $request)
    {
        try {
            if ($request->ajax()) {
                $rides = UserRequests::where('provider_id', Auth::user()->id)->where('status', 'COMPLETED')->count();
                // $revenues = UserRequestPayment::whereHas('request', function ($query) {
                //     $query->where('provider_id', Auth::user()->id)
                //           ->where('status', 'COMPLETED')
                //           ->where('is_free', false);
                // })->sum('total');

                $revenues = UserRequests::where('provider_id', Auth::user()->id)
                ->where('status', 'COMPLETED')
                ->with('payment') // Only load the payment relationship if needed elsewhere
                ->get()
                ->sum(function ($ride) {
                    return $ride->payment ? $ride->payment->total : 0;
                });

                $revenue = UserRequestPayment::where('provider_commission_paid', "0")->whereHas('request', function ($query) use ($request) {
                    $query->where('provider_id', Auth::user()->id)->where('is_free', 0);
                })
                    ->sum('total');
                $providerpay = UserRequestPayment::where('provider_commission_paid', "0")->whereHas('request', function ($query) use ($request) {
                    $query->where('provider_id', Auth::user()->id)->where('is_free', 0);
                })
                    ->sum('provider_pay');
                $cashpayment = UserRequestPayment::where('provider_commission_paid', "0")->whereHas('request', function ($query) use ($request) {
                    $query->where('provider_id', Auth::user()->id)->where('is_free', 0);
                })
                    ->sum('payable');
                $sercharge = UserRequestPayment::where('provider_commission_paid', "0")->whereHas('request', function ($query) use ($request) {
                    $query->where('provider_id', Auth::user()->id)->where('is_free', 0);
                })
                    ->sum('provider_commission');
                $commission_percentage = Setting::get('commission_percentage', 10);
                $sercharge = Helper::customRoundtoMultiple($sercharge, 2);
                $cancel_rides = RejectedRequest::where('provider_id', Auth::user()->id)->count();
                $scheduled_rides = UserRequests::where('status', 'SCHEDULED')->where('provider_id', Auth::user()->id)->count();
                $acp = $providerpay - $cashpayment;
                $wdp = $cashpayment - $providerpay;

                if ($acp > 0) {
                    $withdraw = $acp;
                } else {
                    $withdraw = '0.00';
                }
                if ($wdp > 0) {
                    $amountcopay = $wdp;
                } else {
                    $amountcopay = '0.00';
                }

                $RidesCompleted = UserRequests::where('provider_id', Auth::user()->id)
                    ->whereIn('status', ['COMPLETED', 'SCHEDULED', 'ACCEPTED'])
                    ->with('payment', 'service_type')
                    ->orderBy('id', 'DESC')
                    ->get();
                
                $RidesCompletedCount = $RidesCompleted->count() == 0 ? 0 : $RidesCompleted->count();
                $total_tip_amount = UserRequests::where('provider_id', Auth::user()->id)
                                    ->where('status', 'COMPLETED')->where('is_free', 0)
                                    ->sum('tip_amount_driver');

                $total_tip = UserRequests::where('provider_id', Auth::user()->id)
                                    ->where('status', 'COMPLETED')->where('is_free', 0)
                                    ->sum('tip_amount');

                $total_commission_tip_amount = UserRequests::where('provider_id', Auth::user()->id)
                                    ->where('status', 'COMPLETED')->where('is_free', 0)
                                    ->sum('commission_tip_amount');

                $total_cancel_amount = UserRequests::where('provider_id', Auth::user()->id)
                                    ->where('status', 'CANCELLED')->where('is_free', 0)
                                    ->sum('cancel_amount_driver');

                $totalRequestsSent = UserRequests::where('provider_id', Auth::user()->id)->get();
                $totalRequestsSentCount = $totalRequestsSent->count();

                $acceptance_rate = ($RidesCompletedCount > 0 && $totalRequestsSentCount > 0) ? ($RidesCompletedCount / $totalRequestsSentCount) : 0;
                $acceptance_percentage = ($RidesCompletedCount > 0 && $totalRequestsSentCount > 0) ? ($RidesCompletedCount / $totalRequestsSentCount) * 100 : 0;

                $total_revenue_amount = $total_tip + $revenues;
                $total_revenue = $revenues;

                $freeRidesCount = UserRequests::where('provider_id', Auth::user()->id)->where('is_free', 1)->count();

                return response()->json([
                    'rides' => $rides,
                    'rides_count' => $totalRequestsSentCount,
                    'free_rides_count' => $freeRidesCount,
                    'rides_accepted_count' => $RidesCompletedCount,
                    'acceptance_rate' => Helper::customRoundtoMultiple($acceptance_rate, 2),
                    'acceptance_percentage' => Helper::customRoundtoMultiple($acceptance_percentage, 2),
                    'total_tip_amount' => Helper::customRoundtoMultiple($total_tip_amount, 2),
                    'total_tip' => Helper::customRoundtoMultiple($total_tip, 2),
                    'total_commission_tip_amount' => Helper::customRoundtoMultiple($total_commission_tip_amount, 2),
                    'total_cancel_amount' => Helper::customRoundtoMultiple($total_cancel_amount, 2),
                    'revenue' => Helper::customRoundtoMultiple($total_revenue_amount, 2), //old: $revenues
                    'total_revenue' => Helper::customRoundtoMultiple($total_revenue, 2), //old: $revenues
                    // 'total_revenue' => Helper::customRoundtoMultiple($total_revenue_amount, 2),
                    'serch' => Helper::customRoundtoMultiple($sercharge, 2),
                    'cashpayment' => Helper::customRoundtoMultiple($cashpayment, 2),
                    'amountcopay' => Helper::customRoundtoMultiple($amountcopay, 2),
                    'withdraw' => Helper::customRoundtoMultiple($withdraw, 2),
                    'cancel_rides' => Helper::customRoundtoMultiple($cancel_rides, 2),
                    'scheduled_rides' => Helper::customRoundtoMultiple($scheduled_rides, 2)
                ]);
            }

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

    public function current_location($provider_id)
    {
        $provider = Provider::where('id', $provider_id)->get(['latitude', 'longitude'])->first();
        return $provider->latitude . ',' . $provider->longitude;
    }

    public function send_offer(Request $request)
    {
        try {

            $this->validate($request, [
                'request_id' => 'required|integer',
                'offer_price' => 'required|numeric',
            ]);

            $provider_id = Auth::user()->id;
            $request_id = $request->request_id;
            $offer_price = $request->offer_price;

            RequestOffer::create([
                'request_id' => $request_id,
                'provider_id' => $provider_id,
                'offer_price' => $offer_price
            ]);

            return response()->json(['message' => 'Offer sent successfully!']);

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    public function skip_request(Request $request)
    {
        try {

            $this->validate($request, [
                'request_id' => 'required|integer',
            ]);

            $provider_id = Auth::user()->id;
            $request_id = $request->request_id;

            $requestOfferCount = RequestOffer::where([
                'request_id' => $request_id,
                'provider_id' => $provider_id,
            ])->count();

            if ($requestOfferCount > 0) {
                RequestOffer::where([
                    'request_id' => $request_id,
                    'provider_id' => $provider_id,
                ])->update([
                    'is_declined' => 1,
                    'is_skipped' => 1
                ]);
            } else {
                RequestOffer::create([
                    'request_id' => $request_id,
                    'provider_id' => $provider_id,
                    'offer_price' => 0,
                    'is_declined' => 1,
                    'is_skipped' => 1
                ]);
            }

            return response()->json(['message' => 'Request skipped successfully!']);

        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong'), 'data' => $e->getMessage()], 500);
        }
    }

}
