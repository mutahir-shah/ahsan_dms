<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;

class MlajanController extends Controller
{
    public $baseURL = null;
    public $paymobApiKey = null;
    public $hashKey = null;
    public $integrationId = null;
    public $currency = null;

    public function __construct()
    {
        $this->baseURL = 'http://uat-api.mlajan.com:2010/merchant_service/api/mlajan';
        $this->paymobApiKey = Setting::get('paymob_api_key', 'ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SndjbTltYVd4bFgzQnJJam96T1RjM016TXNJbU5zWVhOeklqb2lUV1Z5WTJoaGJuUWlMQ0p1WVcxbElqb2lhVzVwZEdsaGJDSjkuVDZNbXNxb1MyeklfbUZ3RHF5b3JfR3pabjl3MXo3cDR0NXJZSmhxc1otdmFQTXhNYkFmYUs2MzRqNGVEX0ItRmtRdVp4dmZTYXNxbEZHUG5XMmlVLWc=');
        $this->hashKey = Setting::get('hash_key', '11BDBF5BAD6D3ABABD3B3EAD92DD9E57');
        $this->integrationId = Setting::get('integration_id', '2666599');
        $this->currency = Setting::get('currency', 'USD');
    }

    public function payNow(Request $request)
    {
        try {
            $amount = floatval($request->amount);
            $title = $request->title;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->baseURL . '/merchent_pay',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                "merchent_code" : "M90100",
                "password" : "cg559d44e9",
                "amount" : "' . $amount . '",
                "reference_id": "' . $title . '",
                "redirect_url": "http://redirect-cancel-url",
                "redirect_success_url": "http://redirect-success-url"
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Module: JW9tc0ByZWRsdGQl'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($response, true);
            $authorisation_url = $response['payload']['authorisation_url'];

            return response()->json([
                'status' => 200,
                'message' => 'Authorisation url is generated successfully!',
                'authorisation_url' => $authorisation_url,
            ], 200);

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong'), 'message' => $e->getMessage()], 500);
        }
    }
}
