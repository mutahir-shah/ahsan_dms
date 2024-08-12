<?php

use App\PromocodeUsage;
use App\ServiceType;
use anlutro\LaravelSettings\Facade as Setting;

function currency($value = '')
{
    if ($value == "") {
        return trans('currency.' . Setting::get('currency')) . "0.00";
    } else {
        return trans('currency.' . Setting::get('currency')) . $value;
    }
    // if (Setting::get('currency') == 'XOF' || Setting::get('currency') == 'EUR') {
    //     if ($value == "") {
    //         return "0.00" . '' . trans('currency.' . Setting::get('currency'));
    //     } else {
    //         return $value . '' . trans('currency.' . Setting::get('currency'));
    //     }
    // } else {
    //     if ($value == "") {
    //         return trans('currency.' . Setting::get('currency')) . "0.00";
    //     } else {
    //         return trans('currency.' . Setting::get('currency')) . '' . $value;
    //     }
    // }
}

function currencySymbol($value = '')
{
    return trans('currency.' . Setting::get('currency'));
}

function distance($value = '')
{
    $distance = '';
    $distanceSystem = Setting::get('distance_system', 'metric'); 
    if ($distanceSystem == 'imperial') {
        $distance = ' Mile(s)';
    } else {
        $distance = ' KM(s)';
    }
    if ($value == "") {
        return "0" . $distance;
    } else {
        return $value . $distance;
    }
}

function img($img)
{
    if ($img == "") {
        return asset('main/avatar.jpg');
    } else if (strpos($img, 'http') !== false) {
        return $img;
    } else {
        return asset($img);
    }
}

function image($img)
{
    if ($img == "") {
        return asset('main/avatar.jpg');
    } else {
        return asset($img);
    }
}

function promo_used_count($promo_id)
{
    return PromocodeUsage::where('status', 'ADDED')->where('promocode_id', $promo_id)->count();
}

function curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($ch);
    curl_close($ch);
    return $return;
}

function get_all_service_types()
{
    $serviceTypes = ServiceType::all();
    return $serviceTypes;
}

function get_service_types($service_type)
{
    $serviceTypes = ServiceType::where('type', $service_type)->get(['name']);
    return json_encode($serviceTypes);
}

function demo_mode()
{
    if (Setting::get('demo_mode', 0) == 1) {
        return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at meemcolart@gmail.com');
    }
}
