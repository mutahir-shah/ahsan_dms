<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Provider;
use App\ProviderService;
use App\ServiceType;

use App\UserRequests;
use App\ZoneService;
use App\UserRequestsTracking;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Setting;

class ServiceTypeController extends Controller
{
    public function getActiveServicesTypes() {
        $types = [];
        if (Setting::get('cat_app_daily') == "1") {
            array_push($types, 'daily');
        }
        if (Setting::get('cat_app_ecomony') == "1") {
            array_push($types, 'economy');
        }
        if (Setting::get('cat_app_lux') == "1") {
            array_push($types, 'luxury');
        }
        if (Setting::get('cat_app_ext') == "1") {
            array_push($types, 'extra_seat');
        }
        if (Setting::get('cat_app_out') == "1") {
            array_push($types, 'outstation');
        }
        if (Setting::get('cat_app_road_assist') == "1") {
            array_push($types, 'road_assistance');
        }
        if (Setting::get('cat_app_dream_driver') == "1") {
            array_push($types, 'dream_driver');
        }
        if (Setting::get('cat_app_rental') == "1") {
            array_push($types, 'Rental');
        }
        if (Setting::get('cat_app_personal_care') == "1") {
            array_push($types, 'personal_care');
        }
        if (Setting::get('cat_app_medical_health') == "1") {
            array_push($types, 'medical_health');
        }
        if (Setting::get('cat_app_education_training') == "1") {
            array_push($types, 'education_training');
        }
        if (Setting::get('cat_app_consulting') == "1") {
            array_push($types, 'consulting');
        }
        if (Setting::get('cat_app_cleaning_services') == "1") {
            array_push($types, 'cleaning_services');
        }
        if (Setting::get('cat_app_maintenance') == "1") {
            array_push($types, 'maintenance');
        }
        if (Setting::get('cat_app_construction') == "1") {
            array_push($types, 'construction');
        }
        if (Setting::get('cat_app_security') == "1") {
            array_push($types, 'security');
        }
        if (Setting::get('cat_app_landscaping') == "1") {
            array_push($types, 'landscaping');
        }
        if (Setting::get('cat_app_garden') == "1") {
            array_push($types, 'garden');
        }
        if (Setting::get('cat_app_outdoor_construction') == "1") {
            array_push($types, 'outdoor_construction');
        }
        if (Setting::get('cat_app_exterior_design') == "1") {
            array_push($types, 'exterior_design');
        }

        return $types;
    }

    public function getActiveServicesTypesWithLanguage($request = null) {
        $types = [];
        
        if (Setting::get('cat_app_daily') == "1") {
            $types[0]['value'] = 'daily';
            $types[0]['language'] = checkAndTranslateKeyword("daily", $request);
        }
        if (Setting::get('cat_app_ecomony') == "1") {
            $types[1]['value'] = 'economy';
            $types[1]['language'] = checkAndTranslateKeyword("transportation", $request);
        }
        if (Setting::get('cat_app_lux') == "1") {
            $types[2]['value'] = 'luxury';
            $types[2]['language'] = checkAndTranslateKeyword("delivery", $request);
        }
        if (Setting::get('cat_app_ext') == "1") {
            $types[3]['value'] = 'extra_seat';
            $types[3]['language'] = checkAndTranslateKeyword("truck", $request);
        }
        if (Setting::get('cat_app_out') == "1") {
            $types[4]['value'] = 'outstation';
            $types[4]['language'] = checkAndTranslateKeyword("outstation", $request);
        }
        if (Setting::get('cat_app_road_assist') == "1") {
            $types[5]['value'] = 'road_assistance';
            $types[5]['language'] =  checkAndTranslateKeyword("road_assistance", $request);
        }
        if (Setting::get('cat_app_dream_driver') == "1") {
            $types[6]['value'] = 'dream_driver';
            $types[6]['language'] =  checkAndTranslateKeyword("dream_driver", $request);
        }
        if (Setting::get('cat_app_rental') == "1") {
            $types[7]['value'] = 'rental';
            $types[7]['language'] = checkAndTranslateKeyword("rental", $request);
        }
        if (Setting::get('cat_app_personal_care') == "1") {
            $types[8]['value'] = 'personal_care';
            $types[8]['language'] = checkAndTranslateKeyword("personal_care_services", $request);
        }
        if (Setting::get('cat_app_medical_health') == "1") {
            $types[9]['value'] = 'medical_health';
            $types[9]['language'] = checkAndTranslateKeyword("medical_health_services", $request);
        }
        if (Setting::get('cat_app_education_training') == "1") {
            $types[10]['value'] = 'education_training';
            $types[10]['language'] = checkAndTranslateKeyword("education_training", $request);
        }
        if (Setting::get('cat_app_consulting') == "1") {
            $types[11]['value'] = 'consulting';
            $types[11]['language'] = checkAndTranslateKeyword("consulting_coaching", $request);
        }
        if (Setting::get('cat_app_cleaning_services') == "1") {
            $types[12]['value'] = 'cleaning_services';
            $types[12]['language'] = checkAndTranslateKeyword("cleaning_services", $request);
        }
        if (Setting::get('cat_app_maintenance') == "1") {
            $types[13]['value'] = 'maintenance';
            $types[13]['language'] = checkAndTranslateKeyword("maintenance_repairs", $request);
        }
        if (Setting::get('cat_app_construction') == "1") {
            $types[14]['value'] = 'construction';
            $types[14]['language'] = checkAndTranslateKeyword("construction_renovations", $request);
        }
        if (Setting::get('cat_app_security') == "1") {
            $types[15]['value'] = 'security';
            $types[15]['language'] = checkAndTranslateKeyword("security", $request);
        }
        if (Setting::get('cat_app_landscaping') == "1") {
            $types[16]['value'] = 'landscaping';
            $types[16]['language'] = checkAndTranslateKeyword("landscaping_services", $request);
        }
        if (Setting::get('cat_app_garden') == "1") {
            $types[17]['value'] = 'garden';
            $types[17]['language'] = checkAndTranslateKeyword("garden_maintenance", $request);
        }
        if (Setting::get('cat_app_outdoor_construction') == "1") {
            $types[18]['value'] = 'outdoor_construction';
            $types[18]['language'] = checkAndTranslateKeyword("outdoor_construction", $request);
        }
        if (Setting::get('cat_app_exterior_design') == "1") {
            $types[19]['value'] = 'exterior_design';
            $types[19]['language'] = checkAndTranslateKeyword("exterior_design_services", $request);
        }

        return $types;
    }

    public function getServiceType($service_type_id, $latitude = null, $longitude = null) {
        
        if (Setting::get('zone_module', "0") == "1") {
            $geoFencingController = new GeoFencingController();
            $currentZone = $geoFencingController->getZone($latitude, $longitude);
            
            if ($currentZone != null) {
                $service_type = ZoneService::where('zone_id', $currentZone->id)->where('service_id', $service_type_id)->get()->first();
                if (!$service_type) {
                    $service_type = ServiceType::findOrFail($service_type_id);
                }
            } else {
                $service_type = ZoneService::where('service_id', $service_type_id)->get()->first();
                if (!$service_type) {
                    $service_type = ServiceType::findOrFail($service_type_id);
                }
            }
        } else {
            $service_type = ServiceType::findOrFail($service_type_id);
        }

        return $service_type;
    }

    public function getAllServiceTypes($latitude, $longitude, $request) {

        
        $userApiController = new UserApiController();

        $types = $this->getActiveServicesTypes();
        if (Setting::get('zone_module', "0") == "1") {
            $geoFencingController = new GeoFencingController();
            $currentZone = $geoFencingController->getZone($latitude, $longitude);
            if ($currentZone != null) {
                $servicesTypes = ZoneService::where('zone_id', $currentZone->id)->whereIn('type', $types)->get();
                if (!$servicesTypes) {
                    $servicesList = $userApiController->getServicesWithMultiLanguage($types, $request);
                }
            } else {
                $servicesList = $userApiController->getServicesWithMultiLanguage($types, $request);
            }
        } else {
            $servicesList = $userApiController->getServicesWithMultiLanguage($types, $request);
        }

        $filteredServicesList = $servicesList->map(function($service) {
            $service->name = $service->translations[0]->name;
            $service->description = $service->translations[0]->description;
            unset($service->translations);
            return $service;
        });
        
        return $filteredServicesList;
    }


    public function getServiceZoneInbound($s_latitude, $s_longitude, $d_latitude, $d_longitude) {

        $inbound = false;
        $zones = Zones::get(['id'])->pluck('id');

        $geoFencingController = new GeoFencingController();
        $inboundSource = $geoFencingController->getZoneInbound($s_latitude, $s_longitude, $zones);
        $inboundDestination = $geoFencingController->getZoneInbound($d_latitude, $d_longitude, $zones);
        $inbound = false;

        if ($inboundSource == true && $inboundDestination == true) {
            $inbound = true;
        }

        return $inbound;
    }

    public function isZoneListExists($latitude, $longitude) {

        $zoneList = false;
        $geoFencingController = new GeoFencingController();
        $currentZone = $geoFencingController->getZone($latitude, $longitude);
        if ($currentZone != null) {
            $zoneList = true;
        }

        return $zoneList;
    }

    public function isInPeakDays($service_type, $schedule_date = null, $schedule_time = null, $schedule_web = null) {
        
        $isInPeakDays = false;
        $peakDaysArray = [];
        if ($service_type->peak_monday == 1 || $service_type->peak_monday == "1") {
            array_push($peakDaysArray, "Monday");
        }
        if ($service_type->peak_tuesday == 1 || $service_type->peak_tuesday == "1") {
            array_push($peakDaysArray, "Tuesday");
        }
        if ($service_type->peak_wednesday == 1 || $service_type->peak_wednesday == "1") {
            array_push($peakDaysArray, "Wednesday");
        }
        if ($service_type->peak_thursday == 1 || $service_type->peak_thursday == "1") {
            array_push($peakDaysArray, "Thursday");
        }
        if ($service_type->peak_friday == 1 || $service_type->peak_friday == "1") {
            array_push($peakDaysArray, "Friday");
        }
        if ($service_type->peak_saturday == 1 || $service_type->peak_saturday == "1") {
            array_push($peakDaysArray, "Saturday");
        }
        if ($service_type->peak_sunday == 1 || $service_type->peak_sunday == "1") {
            array_push($peakDaysArray, "Sunday");
        }

        if ($schedule_date == null && $schedule_time == null) {
            $currentDay = Carbon::now()->format('l');
        } else {
            if ($schedule_web && $schedule_web == 'yes') {
                $currentDay = Carbon::createFromFormat('m/d/Y', $schedule_date)->format('l');
            } else {
                $currentDay = Carbon::createFromFormat('j-n-Y', $schedule_date)->format('l');
            }
        }

        $isInPeakDays = in_array($currentDay, $peakDaysArray);

        return $isInPeakDays;
    }

    public function isInPeakTime($service_type, $schedule_date = null, $schedule_time = null, $schedule_web = null) {
        
        if ($schedule_date == null && $schedule_time == null) {
            $currentTime = Carbon::now()->format('H:i:s');
        } else {
            if ($schedule_web && $schedule_web == 'yes') {
                $currentTime = Carbon::createFromFormat('H:i', $schedule_time)->format('H:i:s');
            } else {
                $currentTime = Carbon::createFromFormat('H:i', $schedule_time)->format('H:i:s');
            }
        }
        
        if ($service_type->phourfrom == null || $service_type->phourfrom == '') {
            $peakTimeFrom = Carbon::now()->format('H:i:s');
        } else {
            $peakTimeFrom = Carbon::createFromFormat('H:i:s', $service_type->phourfrom)->format('H:i:s');
        }

        if ($service_type->phourto == null || $service_type->phourto == '') {
            $peakTimeTo = Carbon::now()->format('H:i:s');
        } else {
            $peakTimeTo = Carbon::createFromFormat('H:i:s', $service_type->phourto)->format('H:i:s');
        }

        $peakActive = false;
        if ($peakTimeFrom >= $peakTimeTo) {
            $dayStartTime = Carbon::createFromFormat('H:i:s', '00:00:00')->format('H:i:s');
            $dayEndTime = Carbon::createFromFormat('H:i:s', '23:59:59')->format('H:i:s');
            if (
                ($currentTime >= $peakTimeFrom && $currentTime <= $dayEndTime)
                ||
                ($currentTime >= $dayStartTime && $currentTime <= $peakTimeTo)
            ) {
                $peakActive = true;
            }
        } else {
            if (($currentTime >= $peakTimeFrom && $currentTime <= $peakTimeTo)) {
                $peakActive = true;
            }
        }

        return $peakActive;
    }

    public function getCalculatedReturnPrice($service_type, $kilometer, $seconds, $vweight, $peakActive) {

        $kilometer_tiers = Helper::kilometer_tiers($kilometer, $service_type);
        $kilometer1 = $kilometer_tiers['kilometer1'];
        $kilometer2 = $kilometer_tiers['kilometer2'];
        $kilometer3 = $kilometer_tiers['kilometer3'];
        $kilometer4 = $kilometer_tiers['kilometer4'];
        $calcKilometers = $kilometer_tiers['calcKilometers'];
        $tier = $kilometer_tiers['tier'];

        $base_price = $service_type->fixed ? (float) $service_type->fixed : 0;
        $price = 0;
        $minutes = $seconds / 60;
        $hours = $seconds / 3600;

        if ($peakActive) {
            $after_1_price = $service_type->peak_return_trip_price_1;
            $after_2_price = $service_type->peak_return_trip_price_2;
            $after_3_price = $service_type->peak_return_trip_price_3;
            $after_4_price = $service_type->peak_return_trip_price_4;
        } else {
            $after_1_price = $service_type->return_trip_price_1;
            $after_2_price = $service_type->return_trip_price_2;
            $after_3_price = $service_type->return_trip_price_3;
            $after_4_price = $service_type->return_trip_price_4;
        }

        if ($service_type->calculator == 'MIN') {
            $price += $base_price + $service_type->minute * $minutes;
        } else if ($service_type->calculator == 'HOUR') {
            $price += $base_price + $service_type->minute * $hours;
        } else if ($service_type->calculator == 'DISTANCE') {
            $price += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4);
        } else if ($service_type->calculator == 'DISTANCETIER') {
            if ($tier == 1) {
                $price += $base_price + ($after_1_price * $calcKilometers);
            } else if ($tier == 2) {
                $price += $base_price + ($after_2_price * $calcKilometers);
            } else if ($tier == 3) {
                $price += $base_price + ($after_3_price * $calcKilometers);
            } else if ($tier == 4) {
                $price += $base_price + ($after_4_price * $calcKilometers);
            }
        } else if ($service_type->calculator == 'DISTANCEMIN') {
            $price += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4) + ($service_type->minute * $minutes);
        } else if ($service_type->calculator == 'DISTANCEWEIGHT') {
            $price += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4) + ($service_type->weight * $vweight);
        } else if ($service_type->calculator == 'DISTANCEHOUR') {
            $price += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4) + ($service_type->minute * $hours);
        } else if ($service_type->calculator == 'FIXED') {
            $price += $base_price;
        }

        $price = $price < $base_price ? $base_price : $price;

        return $price;
    }
    public function getCalculatedPrice($service_type, $kilometer, $seconds, $vweight, $peakActive) {

        $kilometer_tiers = Helper::kilometer_tiers($kilometer, $service_type);
        $kilometer1 = $kilometer_tiers['kilometer1'];
        $kilometer2 = $kilometer_tiers['kilometer2'];
        $kilometer3 = $kilometer_tiers['kilometer3'];
        $kilometer4 = $kilometer_tiers['kilometer4'];
        $calcKilometers = $kilometer_tiers['calcKilometers'];
        $tier = $kilometer_tiers['tier'];

        $base_price = $service_type->fixed ? (float) $service_type->fixed : 0;
        $price = 0;
        $minutes = $seconds / 60;
        $hours = $seconds / 3600;

        if ($peakActive) {
            $after_1_price = $service_type->peak_after_1_price;
            $after_2_price = $service_type->peak_after_2_price;
            $after_3_price = $service_type->peak_after_3_price;
            $after_4_price = $service_type->peak_after_4_price;
        } else {
            $after_1_price = $service_type->price;
            $after_2_price = $service_type->after_2_price;
            $after_3_price = $service_type->after_3_price;
            $after_4_price = $service_type->after_4_price;
        }

        if ($service_type->calculator == 'MIN') {
            $price += $base_price + $service_type->minute * $minutes;
        } else if ($service_type->calculator == 'HOUR') {
            $price += $base_price + $service_type->minute * $hours;
        } else if ($service_type->calculator == 'DISTANCE') {
            $price += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4);
        } else if ($service_type->calculator == 'DISTANCETIER') {
            if ($tier == 1) {
                $price += $base_price + ($after_1_price * $calcKilometers);
            } else if ($tier == 2) {
                $price += $base_price + ($after_2_price * $calcKilometers);
            } else if ($tier == 3) {
                $price += $base_price + ($after_3_price * $calcKilometers);
            } else if ($tier == 4) {
                $price += $base_price + ($after_4_price * $calcKilometers);
            }
        } else if ($service_type->calculator == 'DISTANCEMIN') {
            $price += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4) + ($service_type->minute * $minutes);
        } else if ($service_type->calculator == 'DISTANCEWEIGHT') {
            $price += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4) + ($service_type->weight * $vweight);
        } else if ($service_type->calculator == 'DISTANCEHOUR') {
            $price += $base_price + ($after_1_price * $kilometer1) + ($after_2_price * $kilometer2) + ($after_3_price * $kilometer3) + ($after_4_price * $kilometer4) + ($service_type->minute * $hours);
        } else if ($service_type->calculator == 'FIXED') {
            $price += $base_price;
        }

        $price = $price < $base_price ? $base_price : $price;

        return $price;
    }

    public function getPeakPrice($service_type, $price, $peakActive) {

        $pextra = $service_type->pextra ? (float) $service_type->pextra : 0;
        $peakPrice = 0;
        $peakType = null;
        
        if ($peakActive) {
            if ($service_type->peak_percentage == 1 || $service_type->peak_percentage == "1" ) {
                if ($pextra > 0) {
                    $peakPrice = ($pextra / 100) * $price;
                    $peakType = 'percentage';
                }
            } else if ( $service_type->peak_fixed_pricing == 1 || $service_type->peak_fixed_pricing == "1") {
                if ($pextra > 0) {
                    $peakPrice = $pextra;
                    $peakType = 'fixed';
                }
            }
        }

        $detailsArray['peakValue'] = $pextra;
        $detailsArray['peakActive'] = $peakActive;
        $detailsArray['peakPrice'] = $peakPrice;
        $detailsArray['peakType'] = $peakType;
        
        return $detailsArray;
    }

    public function applyLocationPrice($price, $origin_address, $destination_address) {

        $addressArray = ['Terminal T1', 'Terminal T2', 'Barcelona Airport', 'Aeropuerto', 'Aeroport', '08820'];
        $additionalCharge = 4.30;
        
        foreach($addressArray as $address) {
            if (strpos($origin_address, $address) !== false) {
                $price = $price + $additionalCharge;
            } else if (strpos($destination_address, $address) !== false) {
                $price = $price + $additionalCharge;
            }
        }
        
        return $price;
    }

    public function getCommissionPrice($service_type, $price) {

        $commission_tax_apply = Setting::get('commission_tax_apply', 'global');
        $commission_type = Setting::get('commission_type', 'percentage');
        $commission_percentage = Setting::get('commission_percentage', 10);
        $commission_deduction = Setting::get('commission_deduction', 0);
        $commission_deduction_wallet_driver = Setting::get('commission_deduction_wallet_driver', 0);
        $commission_deduction_account_driver = Setting::get('commission_deduction_account_driver', 0);
        $commission_source = null;
        
        $commission_price = 0;
        $detailsArray = [];

        if ($commission_deduction == 1) {
            if ($commission_tax_apply == 'service') {
                if (Setting::get('zone_module', "0") == "1") {
                    // $service_type = ZoneService::where('service_id', $userRequest->service_type_id)->get()->first();
                    $commission_type = $service_type->commission_type ? $service_type->commission_type : $commission_type;
                    $commission_percentage = $service_type->commission_percentage ? $service_type->commission_percentage : $commission_percentage;
                } else {
                    // $service_type = ServiceType::findOrFail($userRequest->service_type_id)->first();
                    $commission_type = $service_type->commission_type ? $service_type->commission_type : $commission_type;
                    $commission_percentage = $service_type->commission_percentage ? $service_type->commission_percentage : $commission_percentage;
                }
            }

            if ($commission_type == 'percentage') {
                $commission_price = ($commission_percentage / 100) * $price;
            } else if ($commission_type == 'fixed') {
                $commission_price = ($commission_percentage);
            }

            if($commission_deduction_wallet_driver == 1) {
                $commission_source = 'Wallet';
            } else if($commission_deduction_account_driver == 1) {
                $commission_source = 'Account';
            }
        }

        $detailsArray['commission_deduction'] = $commission_deduction;
        $detailsArray['commission_tax_apply'] = $commission_tax_apply;
        $detailsArray['commission_type'] = $commission_type;
        $detailsArray['commission_percentage'] = $commission_percentage;
        $detailsArray['commission_price'] = $commission_price;
        $detailsArray['commission_source'] = $commission_source;
        
        return $detailsArray;
    }

    // public function getCommissionType() {
    //     $commission_tax_apply = Setting::get('commission_tax_apply', 'global');
    //     $commission_type = Setting::get('commission_type', 'percentage');
    //     $commission_deduction = Setting::get('commission_deduction', 0);

    //     if ($commission_deduction == 1) {
    //         if ($commission_tax_apply == 'service') {
    //             if (Setting::get('zone_module', "0") == "1") {
    //                 $commission_type = $service_type->commission_type ? $service_type->commission_type : $commission_type;
    //             } else {
    //                 $commission_type = $service_type->commission_type ? $service_type->commission_type : $commission_type;
    //             }
    //         }
    //     }

    //     return $commission_type;
    // }

    public function getTaxPrice($service_type, $price) {

        $commission_tax_apply = Setting::get('commission_tax_apply', 'global');
        $tax_percentage = Setting::get('tax_percentage', 10);
        $tax_price = 0;
        $tax_active = 0;
        $detailsArray = [];

        if ($commission_tax_apply == 'service') {
            if (Setting::get('zone_module', "0") == "1") {
                // $service_type = ZoneService::where('service_id', $userRequest->service_type_id)->get()->first();
                $tax_percentage = $service_type->tax_percentage ? $service_type->tax_percentage : $tax_percentage;
            } else {
                // $service_type = ServiceType::findOrFail($userRequest->service_type_id)->first();
                $tax_percentage = $service_type->tax_percentage ? $service_type->tax_percentage : $tax_percentage;
            }
        }

        if ($tax_percentage > 0) {
            $tax_price = ($tax_percentage / 100) * $price;
            $tax_active = 1;
        }
        

        $detailsArray['commission_tax_apply'] = $commission_tax_apply;
        $detailsArray['tax_percentage'] = $tax_percentage;
        $detailsArray['tax_price'] = $tax_price;
        $detailsArray['tax_active'] = $tax_active;
        
        return $detailsArray;
    }

    public function getBookingPrice($service_type) {

        $bookingFeeActive = Setting::get('booking_fee', 0);
        $bookingFeeAmount = 0;
        $detailsArray = [];

        if ($bookingFeeActive == 1) {
            $bookingFeeAmount = Setting::get('booking_fee_amount', 0);
            $booking_fee_category = Setting::get('booking_fee_category', 'global');
            // $booking_fee_type = Setting::get('booking_fee_type', 'percentage');
            if ($booking_fee_category == 'service') {
                if (Setting::get('zone_module', "0") == "1") {
                    // $service_type = ZoneService::where('service_id', $userRequest->service_type_id)->get()->first();
                    $bookingFeeAmount = $service_type->booking_fee_amount ? $service_type->booking_fee_amount : $bookingFeeAmount;
                } else {
                    // $service_type = ServiceType::findOrFail($userRequest->service_type_id)->first();
                    //TODO: Bug to be fixed for exception
                    $bookingFeeAmount = $service_type->booking_fee_amount ? $service_type->booking_fee_amount : $bookingFeeAmount;
                }
            }
        }

        $detailsArray['bookingFeeActive'] = $bookingFeeActive;
        $detailsArray['bookingFeeAmount'] = $bookingFeeAmount;
        
        return $detailsArray;
    }

    public function getSurge($service_type, $price, $s_latitude, $s_longitude) {

        $is_active = 0;
        $surgePrice = 0;
        $surge_peak_switch = Setting::get('surge_peak_switch', 0);
        $surgePercentage = Setting::get('surge_percentage', 0);
        $surge_trigger = Setting::get('surge_trigger', 0);
        $detailsArray = [];

        if ($surge_peak_switch == 1) {
            $activeProviderIds = ProviderService::AvailableServiceProvider($service_type->id)->where('is_selected', 1)->get()->pluck('provider_id');
            $distance = Setting::get('provider_search_radius', '10');
            $check_lux = DB::table('service_types')->where('id', $service_type->id)->first();

            if (!is_null($check_lux)) {
                if ($check_lux->type == 'luxury') {
                    $distance = Setting::get('provider_search_radius_delivery', '10');
                }
            }

            $providersInRadiusCount = Provider::whereIn('id', $activeProviderIds)
                ->where('status', 'approved')
                ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$s_latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$s_longitude') ) + sin( radians('$s_latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                ->count();
            
            if ($providersInRadiusCount <= $surge_trigger && $providersInRadiusCount > 0) {
                if ($surgePercentage > 0) {
                    $surgePrice = ($surgePercentage / 100) * $price;
                    $is_active = 1;
                }
                // $surgePrice = (Setting::get('surge_percentage') / 100) * $total; //Old
            }
        }

        $detailsArray['surgeActive'] = $is_active;
        $detailsArray['surgePrice'] = $surgePrice;
        $detailsArray['surge_percentage'] = $surgePercentage;
        
        return $detailsArray;
    }

    public function getSurgeAmount($price) {

        $is_active = 0;
        $surgePrice = 0;
        $surge_peak_switch = Setting::get('surge_peak_switch', 0);
        $surgePercentage = Setting::get('surge_percentage', 0);
        // $surge_trigger = Setting::get('surge_trigger', 0);
        $detailsArray = [];

        if ($surge_peak_switch == 1) {
            if ($surgePercentage > 0){
                $surgePrice = ($surgePercentage / 100) * $price;
                $is_active = 1;
            }
        }

        $detailsArray['surge_active'] = $is_active;
        $detailsArray['surgePrice'] = $surgePrice;
        $detailsArray['surge_percentage'] = $surgePercentage;
        
        return $detailsArray;
    }

    public function getGovernmentCharges($service_type, $price) {

        $detailsArray = [];

        $government_charges_active = Setting::get('government_charges', 0);
        $government_charges_value = Setting::get('government_charges_value', 0);

        if($government_charges_active == 0 || $government_charges_value == '' || $government_charges_value == null) {
            $government_charges_value = 0;
        }

        $detailsArray['government_charges_active'] = (bool) $government_charges_active;
        $detailsArray['government_charges'] = (float) $government_charges_value;
        
        return $detailsArray;
    }

    public function getBankCharges($service_type, $price) {

        $bank_charges_active = Setting::get('bank_charges', 0);
        $bank_charges_type = Setting::get('bank_charges_type', 'fixed');
        $bank_charges_value = Setting::get('bank_charges_value', 0);
        $bank_charges_amount = 0;

        if ($bank_charges_active == 1) {
            if ($bank_charges_type == 'percentage') {
                $bank_charges_amount = ($bank_charges_value / 100) * $price;
            } else if ($bank_charges_type == 'fixed') {
                $bank_charges_amount = $bank_charges_value;
            }
        }

        $detailsArray['bank_charges_active'] = $bank_charges_active;
        $detailsArray['bank_charges_type'] = $bank_charges_type;
        $detailsArray['bank_charges_value'] = (int)$bank_charges_value;
        $detailsArray['bank_charges_amount'] = $bank_charges_amount;
        
        return $detailsArray;
    }

    public function getTollFee($request_id = null) {

        $detailsArray = [];

        $toll_fee_active = false;
        $toll_charge = 0;

        if (Setting::get('zone_module', "0") == "1") {
            $userRequest = UserRequests::with(['zone_charges' => function($query) {
                                $query->where('type', 'TOLL_CHARGE');
                            }])
                            ->find($request_id);

            if($userRequest) {
                $toll_charge = $userRequest->zone_charges->sum('charge_value');
                $toll_fee_active = $toll_charge > 0 ? true : false;
            }
        }
        
        $detailsArray['toll_fee_active'] = $toll_fee_active;
        $detailsArray['toll_fee'] = (float) $toll_charge;
        
        return $detailsArray;
    }

    public function getAirportCharges($request_id = null)
    {
        $detailsArray = [];

        $airport_charges_active = false;
        $airport_charges = 0;

        if (Setting::get('zone_module', "0") == "1") {
            $userRequest = UserRequests::with(['zone_charges' => function($query) {
                                $query->where('type', 'AIRPORT_SURCHARGE');
                            }])
                            ->find($request_id);

            if($userRequest) {
                $airport_charges = $userRequest->zone_charges->sum('charge_value');
                $airport_charges_active = $airport_charges > 0 ? true : false;
            }
        }

        $detailsArray['airport_charges_active'] = $airport_charges_active;
        $detailsArray['airport_charges'] = (float) $airport_charges;

        return $detailsArray;
    }

    public function getUserRequestTrackingCoordinates($request_id) {
        $userRequestTrackings = UserRequestsTracking::where('request_id', $request_id)->get(['latitude', 'longitude'])->toArray();
        $userRequestTrackingsCount = count($userRequestTrackings);
        $coordinates = [];

        foreach($userRequestTrackings as $key => $value) {
            if($key == 0 || ($key % 20 == 19) || $key == ($userRequestTrackingsCount - 1)) {
                array_push($coordinates, $value);
            }
        }

        return $coordinates;
    }

    public function getUserRequestPolylinePoints($request_id) {
        $userRequestPolylineTrackings = UserRequestsTracking::where('request_id', $request_id)->get(['latitude', 'longitude'])->toArray();
        $userRequestPolylineTrackingsCount = count($userRequestPolylineTrackings);

        $waypoints = '';

        if($userRequestPolylineTrackingsCount > 0) {
            $origin = $userRequestPolylineTrackings[0]['latitude'].  ',' . $userRequestPolylineTrackings[0]['longitude'];
            $destination = $userRequestPolylineTrackings[$userRequestPolylineTrackingsCount - 1]['latitude'].  ',' . $userRequestPolylineTrackings[$userRequestPolylineTrackingsCount - 1]['longitude'];

            $indexForWayPoint = floor($userRequestPolylineTrackingsCount / 23);

            for($index = 1; $index <= 23; $index++) {
                $waypoints .= $userRequestPolylineTrackings[$index * $indexForWayPoint]['latitude'].  ',' . $userRequestPolylineTrackings[$index * $indexForWayPoint]['longitude'];
                if($index != 23) {
                    $waypoints .= '|';
                }
            }
        } else {
            $userRequest = UserRequests::where('id', $request_id)->get(['s_latitude', 's_longitude', 'd_latitude', 'd_longitude'])->first()->toArray();
            $origin = $userRequest['s_latitude'].  ',' . $userRequest['s_latitude'];
            $destination = $userRequest['d_latitude'].  ',' . $userRequest['d_latitude'];
        }

        return ['origin' => $origin, 'destination' => $destination, 'waypoints' => $waypoints];
    }

    public static function calculateDistance($request_id) {

        $distanceSystem = Setting::get('distance_system_calculation', 'local');
        $detailsArray = [];
        $totalDistance = 0;
        $totalDuration = 0;
        $duration = 0;

        $serviceTypeController = new ServiceTypeController();
        $coordinates = $serviceTypeController->getUserRequestTrackingCoordinates($request_id);

        for ($i = 0; $i < count($coordinates) - 1; $i++) {
            $origin = $coordinates[$i]["latitude"] . "," . $coordinates[$i]["longitude"];
            $destination = $coordinates[$i + 1]["latitude"] . "," . $coordinates[$i + 1]["longitude"];
            
            if ($distanceSystem == 'local') {
                $distance = Helper::calculateDistanceAndDurationLocal($coordinates[$i]["latitude"], $coordinates[$i]["longitude"], $coordinates[$i + 1]["latitude"], $coordinates[$i + 1]["longitude"]);
                $distance = $distance * 1000;
            } else if ($distanceSystem == 'google'){
                $result = Helper::calculateDistanceAndDurationGoogle($origin, $destination);
                if ($result) {
                    $distance = $result['distance']; // Convert distance to kilometers
                    $duration = $result['duration'];
                    
                    // Accumulate total distance and duration
                    $totalDistance += $distance;
                    $totalDuration += $duration;
                } else {
                    echo "Error occurred while fetching distance and duration.";
                    break; // Exit loop if API request fails
                }
            }

            // Accumulate total distance and duration
            $totalDistance += $distance;
            $totalDuration += $duration;
        }

        $detailsArray['totalDistance'] = $totalDistance; //In meters
        $detailsArray['totalDuration'] = $totalDuration; //In seconds

        return $detailsArray;
    }
}
