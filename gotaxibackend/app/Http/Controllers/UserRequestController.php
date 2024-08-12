<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;

use App\User;
use App\Provider;
use App\UserRequests;
use App\RequestFilter;
use App\RequestFilterLog;
use App\BlockUserProvider;
use App\ProviderCancellation;

class UserRequestController extends Controller
{
    public function assignPendingRequests($provider_id = null, $request_id = null) {
        if($request_id == null) {
            $userRequestsSearching = UserRequests::where('status', 'SEARCHING')->get();
        } else {
            $userRequestsSearching = UserRequests::where('id', $request_id)->get();
        }

        $vehicle_weightage = Setting::get('vehicle_weightage', 0);
        $gender_pref_enabled = Setting::get('gender_pref_enabled', 0);
        $zone_restrict_module = Setting::get('zone_restrict_module', 0);
        $block_user = Setting::get('block_user', 0);
        $block_driver = Setting::get('block_driver', 0);
        $favourite_driver = Setting::get('favourite_driver', 0);
        $userGender = null;
        $userGenderPref = null;
        
        $userBlockedProviderIds = [];
        $providerBlockedUserIds = [];
        $cancelledRequestProviderIds = [];
        $zone_id = 0;
        
        foreach($userRequestsSearching as $userRequest) {
            $service_type_id = $userRequest->service_type_id;
            $vweight = $userRequest->vweight;

            if($gender_pref_enabled = 1) {
                $userGender = User::where('id', $userRequest->user_id)->get(['gender'])->first();
                $userGenderPref = User::where('id', $userRequest->user_id)->get(['gender_pref'])->first();
                if (Setting::get('gender_pref_run_time') == 1) {
                    $userGenderPref = $userRequest->gender_pref_run_time = $request->has('gender_pref_run_time') ? $request->gender_pref_run_time : null;
                } else if($userGenderPref ) {
                    $userGenderPref = ($userGenderPref->gender_pref != null || $userGenderPref->gender_pref != '') ? $userGenderPref->gender_pref : null;
                } else {
                    $userGenderPref = null;
                }
            }

            if ($block_user == 1) {
                $userBlockedProviderIds = BlockUserProvider::where('user_id', $userRequest->user_id)->where('blocked_by', 'USER')->pluck('provider_id')->toArray();
            }

            if($request_id != null) {
                $cancelledRequestProviderIds = ProviderCancellation::where('request_id', $userRequest->id)->pluck('provider_id')->toArray();
            }

            $providerList = Provider::with('service')
                    ->where('status', 'approved')
                    ->whereHas('service', function ($q) use ($service_type_id, $vehicle_weightage, $vweight) {
                        $q->where('status', 'active');
                        $q->where('is_selected', 1);
                        $q->where('service_type_id', $service_type_id);
                        //Handled case of vehicle_weightage
                        $q->when(($vehicle_weightage == 1 && ($vweight != null || $vweight != "")), function ($q) use ($vweight) {
                            $q->where('service_weight_allowed_kg', '>=', $vweight);
                        });
                    })
                    // Handled case of gender_pref_enabled && preference: male
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
                    ->whereNotIn('id', $cancelledRequestProviderIds)
                    ->when(($request_id == null), function ($q) use ($provider_id) {
                        $q->where('id', $provider_id);
                    })
                    ->get();

                    //dd($providerList);

                    if($providerList->count() > 0) {
                        foreach($providerList as $provider) {
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
                        
                    }
            }
    }
}
