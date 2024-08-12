<?php

namespace App\Http\Controllers;

use App\City;
use App\CityCopy;
use App\Country;
use App\State;
use Exception;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public $accessToken = null;
    public $baseURL = null;

    public function __construct()
    {

        $this->baseURL = 'https://api.countrystatecity.in/v1/';
        $this->accessToken = 'eFc2QmdjclRkYTRaYW9PYnU4TFpvWjdmcDhqTFI2VlJhalRNVldBVw==';
    }

    public function curlRequest($requestString = '', $payload = null, $additionalHeaders = [], $method = 'GET')
    {

        $requestUrl = $this->baseURL . $requestString;
        $curl = curl_init();

        $currentHeaders = array(
            'Content-Type: application/json',
            'X-CSCAPI-KEY: ' . $this->accessToken,
        );

        $headers = array_merge($currentHeaders, $additionalHeaders);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $requestUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        // $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // echo $http_status;

        curl_close($curl);

        return json_decode($response);
    }

    public function fetchCountries()
    {
        $payload = [];
        $additionalHeaders = [];

        $countries = $this->curlRequest('countries', $payload, $additionalHeaders, 'GET');

        foreach ($countries as $country) {

            $countryDetail = $this->curlRequest('countries/' . $country->iso2, $payload, $additionalHeaders, 'GET');

            Country::create([
                'id' => $country->id,
                'name' => $country->name,
                'iso2' => $country->iso2,
                'details' => json_encode($countryDetail),
            ]);
        }

        return response()->json([
            'response' => 'All countries fetched successfully!'
        ]);
    }

    public function fetchStates()
    {
        $payload = [];
        $additionalHeaders = [];

        $countries = Country::all();

        foreach ($countries as $country) {

            $states = $this->curlRequest('countries/' . $country->iso2 . '/states', $payload, $additionalHeaders, 'GET');

            foreach ($states as $state) {
                State::create([
                    'id' => $state->id,
                    'name' => $state->name,
                    'iso2' => $state->iso2,
                    'country_id' => $country->id
                ]);
            }
        }

        return response()->json([
            'response' => 'All states fetched successfully!'
        ]);
    }

    public function fetchStatesDetail()
    {
        $payload = [];
        $additionalHeaders = [];

        // Chunk 1
        $countries = Country::with('states')->where('id', '<=', '125')->get();
        //Chunk 2
        $countries = Country::with('states')->where('id', '>=', '125')->get();

        foreach ($countries as $country) {

            foreach ($country->states as $state) {

                $stateDetail = $this->curlRequest('countries/' . $country->iso2 . '/states' . '/' . $state->iso2, $payload, $additionalHeaders, 'GET');

                State::where('id', $state->id)->update([
                    'details' => json_encode($stateDetail),
                ]);
            }
        }

        return response()->json([
            'response' => 'All states detail fetched successfully!',
        ]);
    }

    public function fetchCities()
    {
        $payload = [];
        $additionalHeaders = [];

        // Chunk 1
        $countries = Country::with('states')->where('id', '<=', '50')->get();
        // Chunk 2
        // $countries = Country::with('states')->where('id', '>', '50')->where('id', '<=', '100')->get();
        // Chunk 3
        // $countries = Country::with('states')->where('id', '>', '100')->where('id', '<=', '150')->get();
        // Chunk 4
        // $countries = Country::with('states')->where('id', '>', '150')->where('id', '<=', '200')->get();
        // Chunk 5
        // $countries = Country::with('states')->where('id', '>', '200')->where('id', '<=', '250')->get();

        foreach ($countries as $country) {

            foreach ($country->states as $state) {

                $cities = $this->curlRequest('countries/' . $country->iso2 . '/states' . '/' . $state->iso2 . '/cities', $payload, $additionalHeaders, 'GET');

                if ($cities) {
                    foreach ($cities as $city) {
                        City::create([
                            'id' => $city->id,
                            'name' => $city->name,
                            'country_id' => $country->id,
                            'state_id' => $state->id
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'response' => 'All cities fetched successfully!',
        ]);
    }

    public function removeDuplicateCities()
    {
        $cities = City::get();

        foreach ($cities as $city) {
            CityCopy::firstOrCreate([
                'id' => $city->id,
                'name' => $city->name,
                'country_id' => $city->country_id,
                'state_id' => $city->state_id
            ]);
        }

        return response()->json([
            'response' => 'All cities duplicates removed successfully!',
        ]);
    }

    public function getCountries()
    {
        try {
            $countries = Country::get(['id', 'name']);

            return response()->json($countries);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong'), 'message' => $e], 500);
        }
    }

    public function getStates($country_id)
    {
        try {
            $states = State::where('country_id', $country_id)->get(['id', 'name']);

            return response()->json($states);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong'), 'message' => $e], 500);
        }
    }

    public function getCities($state_id)
    {
        try {
            $cities = City::where('state_id', $state_id)->get(['id', 'name']);

            return response()->json($cities);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong'), 'message' => $e], 500);
        }
    }
}
