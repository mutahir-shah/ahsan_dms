<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Support\Facades\Auth;

class PaymobController extends Controller
{

    public $baseURL = null;
    public $paymobApiKey = null;
    public $hashKey = null;
    public $integrationId = null;
    public $currency = null;
    public $iFrameId = null;

    public function __construct()
    {
        $this->baseURL = 'https://accept.paymob.com/api';
        $this->paymobApiKey = Setting::get('paymob_api_key', '');
        $this->hashKey = Setting::get('hash_key', '');
        $this->integrationId = Setting::get('integration_id', '');
        $this->iFrameId = Setting::get('iframe_id', '');
        $this->currency = 'EGP';
    }

    // public function curlRequest($requestString = '', $payload = null, $additionalHeaders = [],  $method = 'GET') {

    //     $requestUrl = $this->baseURL . $requestString;
    //     $curl = curl_init();

    //     $currentHeaders = array(
    //         'Content-Type: application/json'
    //     );

    //     $headers = array_merge($currentHeaders, $additionalHeaders);

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $requestUrl,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => $method,
    //         CURLOPT_POSTFIELDS => $payload,
    //         CURLOPT_HTTPHEADER => $headers,
    //     ));

    //     $response = curl_exec($curl);

    //     // $info = curl_getinfo($curl);
    //     // $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //     // echo $http_status;

    //     curl_close($curl);

    //     return json_decode($response);
    // }

    public function payMobToken()
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->baseURL . '/auth/tokens',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "api_key": "' . $this->paymobApiKey . '",
                    "hash": "' . $this->hashKey . '"
                }',
                CURLOPT_HTTPHEADER => array(
                    'X-Requested-With: XMLHttpRequest',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);


            curl_close($curl);
            $response = json_decode($response, true);
            $token = $response['token'];

            return $token;
        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong'), 'message' => $e->getMessage()], 500);

        }
    }

    public function orderRegister($amount, $title)
    {
        try {
            $token = $this->payMobToken();

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->baseURL . '/ecommerce/orders',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                "auth_token":  "' . $token . '",
                "delivery_needed": "false",
                "amount_cents": "' . $amount . '",
                "currency": "' . $this->currency . '",
                "items": [
                    {
                        "name": "' . $title . '",
                        "amount_cents": "' . $amount . '",
                        "description": "' . $title . '",
                        "quantity": "1"
                    }
                    ]
                }',
                CURLOPT_HTTPHEADER => array(
                    'X-Requested-With: XMLHttpRequest',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($response, true);

            $responseArray = [];
            $responseArray['token'] = $token;
            $responseArray['id'] = $response['id'];

            return $responseArray;
        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong'), 'message' => $e->getMessage()], 500);
        }
    }

    public function paymentKeyRequest(Request $request)
    {
        try {
            $amount = intval($request->amount * 100);
            $title = $request->title;

            $order = $this->orderRegister($amount, $title);
            $user = Auth::user();

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->baseURL . '/acceptance/payment_keys',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                "auth_token": "' . $order['token'] . '",
                "amount_cents": "' . $amount . '", 
                "expiration": 3600, 
                "order_id": "' . $order['id'] . '",
                "billing_data": {
                    "apartment": "NA", 
                    "email": "' . $user->email . '", 
                    "floor": "NA", 
                    "first_name": "' . $user->first_name . '", 
                    "street": "NA", 
                    "building": "NA", 
                    "phone_number": "' . $user->mobile . '", 
                    "shipping_method": "NA", 
                    "postal_code": "NA", 
                    "city": "NA", 
                    "country": "NA", 
                    "last_name": "' . $user->last_name . '", 
                    "state": "NA"
                }, 
                "currency": "' . $this->currency . '",
                "integration_id": ' . $this->integrationId . ',
                "lock_order_when_paid": "false"
                }',
                CURLOPT_HTTPHEADER => array(
                    'X-Requested-With: XMLHttpRequest',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($response, true);
            // dd($response);
            $payment_key = $response['token'];

            return response()->json([
                'status' => 200,
                'message' => 'Payment key is generated successfully!',
                'payment_key' => $payment_key,
                'endpoint' => 'https://accept.paymob.com/api/acceptance/iframes/457144?payment_token=' . $payment_key,
                'iframe_id' => $this->iFrameId,
            ], 200);

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong'), 'message' => $e->getMessage()], 500);
        }
    }
}
