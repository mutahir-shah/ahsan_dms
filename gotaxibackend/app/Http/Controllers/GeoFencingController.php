<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Zones;

class GeoFencingController extends Controller
{
    public function getZoneInbound($currentLat = null, $currentLong = null, $zones = null)
    {
        $p = array();
        $p["lat"] = $currentLat;
        $p["long"] = $currentLong;

        $zones = Zones::whereIn('id', $zones)->get(['name', 'coordinate']);
        $polygonsArray = [];

        foreach ($zones as $zone) {
            $coordinates = unserialize($zone->coordinate);

            $polygon = [];
            foreach ($coordinates as $index => $coordinate) {
                $coordinateString = explode(',', $coordinate);
                $polygon[$index]['lat'] = $coordinateString[0];
                $polygon[$index]['long'] = $coordinateString[1];
            }

            array_push($polygonsArray, $polygon);
        }

        $inboundZone = 0;
        foreach ($polygonsArray as $polygon) {
            $inbound = $this->pointInPolygon($p, $polygon);
            $inbound == true ? $inboundZone++ : null;
        }

        if ($inboundZone > 0) {
            // return 'Inbound';
            return true;
        } else {
            // return 'Outbound';
            return false;
        }
    }

    public function getZone($currentLat = null, $currentLong = null)
    {
        $p = array();
        $p["lat"] = $currentLat;
        $p["long"] = $currentLong;

        $zones = Zones::get(['id', 'name', 'coordinate']);
        $polygonsArray = [];

        foreach ($zones as $zone) {
            $coordinates = unserialize($zone->coordinate);

            $polygon = [];
            foreach ($coordinates as $index => $coordinate) {
                $coordinateString = explode(',', $coordinate);
                $polygon[$index]['lat'] = $coordinateString[0];
                $polygon[$index]['long'] = $coordinateString[1];
            }
            array_push($polygonsArray, $polygon);
        }

        $zone_id = null;
        foreach ($polygonsArray as $index => $polygon) {
            $zone = $this->pointInPolygon($p, $polygon);
            if ($zone == true) {
                $zone_id = $zones[$index]['id'];
                break;
            }
        }

        if ($zone_id !== null) {
            return Zones::find($zone_id);
        }

        return null;
    }

    /*
    public function verifyZone($zone, $lat, $long) {
        $p = array();
        $p["lat"] = $lat;
        $p["long"] = $long;

        $savourZone = Zones::where('zone','=', $zone)->get(['lat', 'long']);

        if ($this->pointInPolygon($p, $savourZone)) {
            return true;
        } else {
            return false;
        }
    }
    */

    //the Point in Polygon function
    function pointInPolygon($p, $polygon)
    {
        //if you operates with (hundred) thousands of points
        set_time_limit(60);
        $c = 0;
        $p1 = $polygon[0];
        $n = count($polygon);
        // dd(1 % $n);
        // dd($polygon[1]);

        for ($i = 1; $i <= $n; $i++) {
            $p2 = $polygon[$i % $n];
            // print_r($p1); exit();
            if ($p['long'] > min($p1['long'], $p2['long'])
                && $p['long'] <= max($p1['long'], $p2['long'])
                && $p['lat'] <= max($p1['lat'], $p2['lat'])
                && $p1['long'] != $p2['long']
            ) {
                $xinters = ($p['long'] - $p1['long']) * ($p2['lat'] - $p1['lat']) / ($p2['long'] - $p1['long']) + $p1['lat'];
                if ($p1['lat'] == $p2['lat'] || $p['lat'] <= $xinters) {
                    $c++;
                    // return dd('nested-if');
                } else {
                    // return dd('nested-else');
                }
            } else {
                // return dd('else');
            }
            $p1 = $p2;
        }

        // if the number of edges we passed through is even, then it's not in the poly.
        return $c % 2 != 0;
    }
}
