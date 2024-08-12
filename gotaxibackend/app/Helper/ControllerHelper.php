<?php

namespace App\Helpers;

use File;
use anlutro\LaravelSettings\Facade as Setting;
use App\Module;
use App\Privilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Helper
{
    
    public static function getModules(){
        return Module::with(['operations' => function($query){
            return $query->where('is_active', 1)->where('type', '!=', 3)->orderBy('sort', 'asc');
        }])->where('is_active', 1)->where('parent', 0)->where('type', '!=', 3)->orderBy('sort', 'asc')->get();
    }

    public static function getModulePrivilege($module_id){
        return Privilege::where(['module_id' => $module_id, 'role_id' => self::CheckUserRole(), 'is_view' => 1])->first();
    }

    public static function CheckPermission($name, $id)
    {
        $permission = Privilege::where([$name => 1, 'module_id' => $id, 'role_id' => self::CheckUserRole()])->first();

        if(is_null($permission))
        {
            return 0;
        }
        else
        {
            return 1;
        }

    }

    public static function CheckUserRole()
    {
        if(Auth::guard('admin')->user()->role_id == 0)
        {
            $id = 1;
        }
        else
        {
            $id = Auth::guard('admin')->user()->role_id;
        }

        return $id;
    }

    public static function upload_picture($picture)
    {
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $picture->move(public_path() . "/uploads", $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;

            $assetURL = env("ASSET_URL", "public/");

            $s3_url = url('/') . "/" . $assetURL . "uploads/" . $local_url;

            return $s3_url;
        }
        return "";
    }


    public static function delete_picture($picture)
    {
        File::delete(public_path() . "/uploads/" . basename($picture));
        return true;
    }

    public static function generate_booking_id()
    {
        return Setting::get('booking_prefix') . mt_rand(100000, 999999);
    }

    public static function site_sendmail($user)
    {

        $site_details = Setting::all();


        Mail::send('emails.invoice', ['user' => $user, 'site_details' => $site_details], function ($mail) use ($user, $site_details) {
            // $mail->from('harapriya@appoets.com', 'Your Application');

            $mail->to($user->user->email, $user->user->first_name . ' ' . $user->user->last_name)->subject('Invoice');
        });

        return true;
    }

    public static function kilometer_tiers($kilometers, $service_type)
    {
        $totalKilometers = $kilometers;

        $base_distance = abs($service_type->distance); // Skipping base distance from calculation
        // $kilometers = abs($kilometers - $base_distance); // Skipping base distance from calculation
        if ($kilometers > $base_distance)
            $calcKilometers = abs($kilometers - $base_distance); // Skipping base distance from calculation
        else
            $calcKilometers = $kilometers;

        $apply_after_1_km = $service_type->apply_after_1;
        $apply_after_2_km = $service_type->apply_after_2;
        $apply_after_3_km = $service_type->apply_after_3;
        $apply_after_4_km = $service_type->apply_after_4;
        $tier = 0;
        $condition = '';

        if ($kilometers > $apply_after_4_km) {
            $condition = 'a';
            $kilometer4 = abs($kilometers - $apply_after_4_km);
            $kilometer3 = abs($apply_after_4_km - $apply_after_3_km);
            $kilometer2 = abs($apply_after_3_km - $apply_after_2_km);
            $kilometer1 = abs($apply_after_2_km - $apply_after_1_km);
        } else if ($kilometers > $apply_after_3_km) {
            $condition = 'b';
            $kilometer4 = 0;
            $kilometer3 = abs($kilometers - $apply_after_3_km);
            $kilometer2 = abs($apply_after_3_km - $apply_after_2_km);
            $kilometer1 = abs($apply_after_2_km - $apply_after_1_km);
        } else if ($kilometers > $apply_after_2_km) {
            $condition = 'c';
            $kilometer4 = 0;
            $kilometer3 = 0;
            $kilometer2 = abs($kilometers - $apply_after_2_km);
            $kilometer1 = abs($apply_after_2_km - $apply_after_1_km);
        } else if ($kilometers > $apply_after_1_km) {
            $condition = 'd';
            $kilometer4 = 0;
            $kilometer3 = 0;
            $kilometer2 = 0;
            $kilometer1 = abs($kilometers - $apply_after_1_km);
        } else if ($kilometers < $apply_after_1_km) {
            $condition = 'e';
            $kilometer4 = 0;
            $kilometer3 = 0;
            $kilometer2 = 0;
            $kilometer1 = 0;
        } else {
            $condition = 'f';
            $kilometer4 = 0;
            $kilometer3 = 0;
            $kilometer2 = 0;
            $kilometer1 = 0;
        }

        if ($kilometers <= $apply_after_2_km) {
            $tier = 1;
        } else if ($kilometers > $apply_after_2_km && $kilometers <= $apply_after_3_km) {
            $tier = 2;
        } else if ($kilometers > $apply_after_3_km && $kilometers <= $apply_after_4_km) {
            $tier = 3;
        } else if ($kilometers > $apply_after_4_km) {
            $tier = 4;
        }

        // dd(['tier' => $tier, 'baseDistance'=> $service_type->distance, 'totalKilometers' => $totalKilometers, 'kilometer1' => $kilometer1, 'kilometer2' => $kilometer2, 'kilometer3' => $kilometer3, 'kilometer4' => $kilometer4]);

        return ['condition' => $condition, 'tier' => $tier, 'baseDistance'=> $service_type->distance, 'totalKilometers' => $totalKilometers, 'calcKilometers' => $calcKilometers, 'kilometer1' => $kilometer1, 'kilometer2' => $kilometer2, 'kilometer3' => $kilometer3, 'kilometer4' => $kilometer4];
    }

    public static function customRoundtoMultiple($n, $places = 2)
    {

        $number = (float)$n;
        if (Setting::get('multiple_of_five', 0) == 1) {
            $firstPrecision = (float)(($number * 10) % 10);
            $firstPrecisionInDecimals = (float)($firstPrecision / 10);
            $secondPrecision = (float)(($number * 100) % 10);
            $secondPrecisionInDecimals = (float)($secondPrecision / 100);

            if ($secondPrecisionInDecimals == 0.00) {
                $result = (float)(floor($number) + ($firstPrecisionInDecimals + 0.00));
            } else if ($secondPrecisionInDecimals <= 0.05) {
                $result = (float)(floor($number) + ($firstPrecisionInDecimals + 0.05));
            } else {
                $result = (float)(floor($number) + ($firstPrecisionInDecimals + 0.10));
            }

            return (float) number_format($result, 2);
        } else {
            // return (float) number_format(round($number, $places), $places);
            return (float) round($number, $places);
        }

        // if (Setting::get('multiple_of_five', 0) == 1) {
        //     $number = floatval(number_format($n, $places));
        //     $decimalValueConversion = abs(floor($number) - $number) * 100;
        //     $valueAfterDecimalLast =  $decimalValueConversion % 10; //Here is the problem
        //     $valueAfterDecimalFirst =  floor($decimalValueConversion - $valueAfterDecimalLast);

        //     $arrayTest = [$number, $decimalValueConversion, $valueAfterDecimalFirst, $valueAfterDecimalLast];

        //     return dd($arrayTest);

        //     if ($valueAfterDecimalLast <= 5) {
        //         $valueAfterDecimal = $valueAfterDecimalFirst / 100 + 0.05;
        //     } else {
        //         $valueAfterDecimal = $valueAfterDecimalFirst / 100 + 0.10;
        //     }

        //     return number_format(floor($n) + $valueAfterDecimal, $places);
        // } else {
        //     return round($n, $places);
        // }

    }

    public static function googleDistanceAndTime($s_latitude, $s_longitude, $d_latitude, $d_longitude) {

        $mapKey = Setting::get('map_key', '');
        $distanceSystem = Setting::get('distance_system', 'metric'); //imperial
        $detailsArray = [];
        if ($mapKey != '') {
            $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $s_latitude . "," . $s_longitude . "&destinations=" . $d_latitude . "," . $d_longitude . "&mode=driving&sensor=false&key=" . $mapKey . "&units=" . $distanceSystem;

            $json = curl($details);

            $details = json_decode($json, TRUE);
            //Todo: Add a check with status = 'OK' 
            if ($details['status'] != 'REQUEST_DENIED') {
                if ($details['rows'][0]['elements'][0]['status'] != 'ZERO_RESULTS' && $details['rows'][0]['elements'][0]['status'] != 'NOT_FOUND') {
                    $detailsArray['originAddress'] = $details['origin_addresses'][0];
                    $detailsArray['destinationAddress'] = $details['destination_addresses'][0];
                    $detailsArray['distanceText'] = $details['rows'][0]['elements'][0]['distance']['text'];
                    $detailsArray['distanceValue'] = $details['rows'][0]['elements'][0]['distance']['value']; //Info: This is in meters
                    $detailsArray['durationText'] = $details['rows'][0]['elements'][0]['duration']['text'];
                    $detailsArray['durationValue'] = $details['rows'][0]['elements'][0]['duration']['value']; // Info: This is in seconds
                }
            }
        } 

        if (empty($detailsArray)) {
            $detailsArray['originAddress'] = null;
            $detailsArray['destinationAddress'] = null;
            $detailsArray['distanceText'] = null;
            $detailsArray['distanceValue'] = 0;
            $detailsArray['durationText'] = null;
            $detailsArray['durationValue'] = 0;
        }

        return $detailsArray;
    }

    public static function getPolylineGoogleForRequest($origin, $destination, $waypoints) {

        $mapKey = Setting::get('map_key', '');
        $distanceSystem = Setting::get('distance_system', 'metric'); //imperial
        $detailsArray = [];

        if ($mapKey != '') {
            if($waypoints != '') {
                $details = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $origin . "&destination=" . $destination . "&waypoints=" . $waypoints . "&mode=driving&sensor=false&key=" . $mapKey . "&units=" . $distanceSystem;
            } else {
                $details = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $origin . "&destination=" . $destination . "&mode=driving&sensor=false&key=" . $mapKey . "&units=" . $distanceSystem;
            }

            $json = curl($details);

            $details = json_decode($json, TRUE);
            if ($details && $details['status'] == 'OK' && $details['status'] != 'ZERO_RESULTS') {
                $detailsArray['points'] = $details['routes'][0]['overview_polyline']['points'];
            }
        } 

        if (empty($detailsArray)) {
            return ['points' => []];
        }

        return $detailsArray;
    }


    public static function applyDistanceSystem($distanceInMeters) {
        $distanceSystem = Setting::get('distance_system', 'metric'); 

        if ($distanceSystem == 'metric') {
            $distance = $distanceInMeters / 1000;
        } else if ($distanceSystem == 'imperial') {
            $distance = $distanceInMeters / 1000;
            $distance = $distance / 1.609;
        } else {
            $distance = $distanceInMeters / 1000;
        }
        
        return $distance;
    }

    // Function to calculate distance between two coordinates using Haversine formula
    public static function calculateDistanceAndDurationLocal($lat1, $lon1, $lat2, $lon2) {
        $r = 6371; // Radius of the Earth in km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $r * $c; // Distance in km

        return $d;
    }

    // Function to calculate distance and duration between two coordinates using Google Distance Matrix API
    public static function calculateDistanceAndDurationGoogle($origin, $destination) {
        
        $mapKey = Setting::get('map_key', '');
        $distanceSystem = Setting::get('distance_system', 'metric'); //imperial

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origin&destinations=$destination&key=$mapKey&units=$distanceSystem";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        if ($data['status'] == 'OK') {
            $distance = $data['rows'][0]['elements'][0]['distance']['value']; // Distance in meters
            $duration = $data['rows'][0]['elements'][0]['duration']['value']; // Duration in seconds
            
            return ['distance' => $distance, 'duration' => $duration];
        } else {
            return false; // API request failed
        }
    }

}
