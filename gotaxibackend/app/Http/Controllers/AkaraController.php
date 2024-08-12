<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Support\Facades\Auth;

class AkaraController extends Controller
{
    public $baseURL = null;
    public $accessToken = null;
    public $akaraEmail = null;
    public $akaraPassword = null;
    public $currency = null;
    public $akaraPaymentPageId = null;
    public $transactionId = null;

    public function __construct()
    {
        $this->baseURL = 'https://araka-api-uat.azurewebsites.net/';
        $this->akaraEmail = Setting::get('araka_email');
        $this->akaraPassword = Setting::get('araka_password');
        $this->akaraPaymentPageId = Setting::get('araka_payment_page_id');
        $this->currency = Setting::get('currency', 'EUR');
    }

    public function curlRequest($requestString = '', $payload = null, $additionalHeaders = [], $method = 'GET')
    {

        $requestUrl = $this->baseURL . $requestString;
        $curl = curl_init();

        $currentHeaders = array(
            'Content-Type: application/json'
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

        // $info = curl_getinfo($curl);
        // $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // echo $http_status;

        curl_close($curl);

        return json_decode($response);
    }

    public function token()
    {
        $payload = '{
            "emailAddress": "' . $this->akaraEmail . '",
            "password": "' . $this->akaraPassword . '"
        }';

        $additionalHeaders = array();

        $response = $this->curlRequest('api/login', $payload, $additionalHeaders, 'POST');

        // return response()->json([
        //     'response' => $response
        // ]);

        return $response->token;
    }

    public function requestToPay($mobile_number = null, $amount = null, $request_id = null, $user)
    {

        $payload = '{
            "order": {
              "paymentPageId": "' . $this->akaraPaymentPageId . '",
              "customerFullName": "' . $user->first_name . ' ' . $user->last_name . '",
              "customerPhoneNumber": "' . $mobile_number . '",
              "customerEmailAddress": "' . $user->email . '",
              "transactionReference": "' . $request_id . '",
              "amount": "' . $amount . '",
              "currency": "' . $this->currency . '",
              "redirectURL": "https://mbotexpress.com/"
            },
            "paymentChannel": {
              "channel": "MOBILEMONEY",
              "provider": "MPESA",
              "walletID": "+243000000000"
            }
        }';

        $additionalHeaders = array(
            'Authorization:Bearer ' . $this->accessToken,
        );

        $response = $this->curlRequest('api/Pay/paymentrequest', $payload, $additionalHeaders, 'POST');

        return $response;
    }

    public function sendMobileMoney($mobile_number = null, $amount = null, $request_id = null, $user)
    {

        $payload = '{
            "order": {
              "paymentPageId": "' . $this->akaraPaymentPageId . '",
              "customerFullName": "' . $user->first_name . ' ' . $user->last_name . '",
              "customerPhoneNumber": "' . $mobile_number . '",
              "customerEmailAddress": "' . $user->email . '",
              "transactionReference": "' . $request_id . '",
              "amount": "' . $amount . '",
              "currency": "' . $this->currency . '",
              "redirectURL": "https://mbotexpress.com/"
            },
            "paymentChannel": {
              "channel": "MOBILEMONEY",
              "provider": "MPESA",
              "walletID": "+243000000000"
            }
        }';

        $additionalHeaders = array(
            'Authorization:Bearer ' . $this->accessToken,
        );

        $response = $this->curlRequest('api/Pay/sendmobilemoney', $payload, $additionalHeaders, 'POST');

        return response()->json([
            'response' => $response
        ]);
    }

    public function requestToPayState($transactionId)
    {
        $payload = '';

        $additionalHeaders = array(
            'Authorization:Bearer ' . $this->accessToken,
        );

        $response = $this->curlRequest('api/Reporting/transactionstatus/' . $transactionId, $payload, $additionalHeaders, 'GET');

        return $response;
    }

    public function payNow(Request $request)
    {

        $this->validate($request, [
            'request_id' => 'required', //'exists:user_request_payments,request_id|exists:user_requests,id,paid,0,user_id,' . Auth::user()->id
            'amount' => 'required',
            'mobile_number' => 'required'
        ]);

        $user = Auth::user();

        $this->accessToken = $this->token();

        $paymentResponse = $this->requestToPay($request->mobile_number, $request->amount, $request->request_id, $user);

        // $mobileMoneyRequest = $this->requestToPay($request->mobile_number, $request->amount, $paymentResponse->transactionId, $user);

        if ($paymentResponse->statusCode == 202) {
            sleep(30);
            // $responseData = $this->requestToPayState($paymentResponse->transactionId);
            return response()->json([
                'status' => $paymentResponse->statusDescription,
                'status_code' => $paymentResponse->statusCode,
                // 'data' => $paymentResponse,
            ]);
        } else {
            sleep(30);
            return response()->json([
                'status' => "FAILED",
                'status_code' => 400,
            ]);
        }
    }
}
