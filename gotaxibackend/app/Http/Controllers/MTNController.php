<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;

class MTNController extends Controller
{
    public $referenceID = null;
    public $accessToken = null;
    public $apiKey = null;
    public $baseURL = null;
    public $primaryCollectionSubscriptionKey = null;
    public $secondaryCollectionSubscriptionKey = null;
    public $primaryDisbursementSubscriptionKey = null;
    public $secondaryDisbursementSubscriptionKey = null;
    public $gatewayEnv = null;
    public $currency = null;
    public $authorizationToken = null;

    public function __construct()
    {
        $this->referenceID = 'a5e821d4-f249-4b73-a5ed-6788428aab56';

        $this->gatewayEnv = Setting::get('mtn_mode', 'sandbox');
        $this->baseURL = $this->gatewayEnv == 'production' ? 'https://momodeveloper.mtn.com/' : 'https://sandbox.momodeveloper.mtn.com/';
        $this->primaryCollectionSubscriptionKey = Setting::get('mtn_primary_subscription_key_collection', '0ef328c9ec0e4019b2c4a237c3372a66');
        $this->secondaryCollectionSubscriptionKey = Setting::get('mtn_secondary_subscription_key_collection', '49761721c2044697b4929c6204eb5895');
        $this->primaryDisbursementSubscriptionKey = Setting::get('mtn_primary_subscription_key_disbursement', '0ff5efb839fa49049fbf1f8bacec06d9');
        $this->secondaryDisbursementSubscriptionKey = Setting::get('mtn_secondary_subscription_key_disbursement', '11b181a23d80484b9d99f42c30a3de49');
        $this->currency = Setting::get('currency', 'EUR');
        $this->authorizationToken = base64_encode(Setting::get('mtn_user_id') . ':' . Setting::get('mtn_user_key'));
    }

    public function curlRequest($requestString = '', $payload = null, $additionalHeaders = [], $method = 'GET', $subscriptionType = null)
    {

        $requestUrl = $this->baseURL . $requestString;
        $curl = curl_init();

        $subscriptionKey = null;

        if ($subscriptionType == 'collection') {
            $subscriptionKey = $this->primaryCollectionSubscriptionKey;
        }

        if ($subscriptionType == 'disbursement') {
            $subscriptionKey = $this->primaryDisbursementSubscriptionKey;
        }

        $currentHeaders = array(
            'Content-Type: application/json',
            'Ocp-Apim-Subscription-Key: ' . $subscriptionKey,
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

    public function apiUserCollection()
    {
        $payload = '{
            "providerCallbackHost": "callbacks-do-not-work-in-sandbox.com"
        }';

        $additionalHeaders = array(
            'X-Reference-Id: ' . $this->referenceID
        );

        $response = $this->curlRequest('v1_0/apiuser', $payload, $additionalHeaders, 'POST', 'collection');

        return response()->json([
            'response' => $response
        ]);
    }

    public function apiUserCollectionReferenceKey()
    {
        $response = $this->curlRequest('v1_0/apiuser/' . $this->referenceID . '/apikey', null, [], 'POST', 'collection');
        $this->apiKey = $response->apiKey;

        return response()->json([
            'response' => $response
        ]);
    }

    public function token()
    {
        $additionalHeaders = array(
            'Authorization:Basic ' . $this->authorizationToken
        ); //TODO:: We have to make OAuth 2.0 Dynamic base64(apiuserid:apikey)

        $response = $this->curlRequest('collection/token/', null, $additionalHeaders, 'POST', 'collection');

        return $response->access_token;
    }

    public function requestToPayCollection($mobile_number = null, $amount = null)
    {

        $payload = '{
            "amount": "' . $amount . '",
            "currency": "' . $this->currency . '",
            "externalId": "' . $this->referenceID . '",
            "payer": {
              "partyIdType": "msisdn",
              "partyId": "' . $mobile_number . '"
            },
            "payerMessage": "Ride payment",
            "payeeNote": "This is a ride booking payment"
        }';

        $additionalHeaders = array(
            'Authorization:Bearer ' . $this->accessToken,
            'X-Reference-Id:' . $this->referenceID,
            'X-Target-Environment: ' . $this->gatewayEnv
        );

        $response = $this->curlRequest('collection/v1_0/requesttopay', $payload, $additionalHeaders, 'POST', 'collection');

        return response()->json([
            'response' => $response
        ]);
    }

    public function requestToPayState()
    {
        $payload = '';

        $additionalHeaders = array(
            'Authorization:Bearer ' . $this->accessToken,
            'X-Target-Environment: ' . $this->gatewayEnv
        );

        $response = $this->curlRequest('collection/v1_0/requesttopay/' . $this->referenceID, $payload, $additionalHeaders, 'GET', 'collection');

        return $response;
    }

    public function payNow(Request $request)
    {

        $this->validate($request, [
            'request_id' => 'required', //'exists:user_request_payments,request_id|exists:user_requests,id,paid,0,user_id,' . Auth::user()->id
            'amount' => 'required',
            'mobile_number' => 'required'
        ]);

        $this->accessToken = $this->token();

        $this->requestToPayCollection($request->mobile_number, $request->amount);

        $status = null;

        if ($request->mobile_number == '46733123450') {
            $status = 'failed';
        }

        if ($request->mobile_number == '46733123451') {
            $status = 'rejected';
        }

        if ($request->mobile_number == '46733123452') {
            $status = 'timeout';
        }

        if ($request->mobile_number == '46733123453') {
            $status = 'success';
        }

        if ($request->mobile_number == '46733123454') {
            $status = 'pending';
        }

        if ($status == null) {
            $status = 'pending';
        }

        sleep(30);

        if ($status == null) {
            $responseData = $this->requestToPayState();
            $status = $responseData->status;
        } else {
            $responseData = 'The payment is: ' . $status;
        }

        return response()->json([
            'status' => $status,
            'data' => $responseData,
        ]);
    }

    public function requestToTransferState()
    {
        $payload = '';

        $additionalHeaders = array(
            'Authorization:Bearer ' . $this->accessToken,
            'X-Target-Environment: ' . $this->gatewayEnv
        );

        $response = $this->curlRequest('disbursement/v1_0/deposit' . $this->referenceID, $payload, $additionalHeaders, 'GET', 'disbursement');

        return $response;
    }

    public function requestToPayDisbursement()
    {
        return null;
    }

    public function depositNow(Request $request)
    {

        // $this->validate($request, [ 
        //     'amount' => 'required',
        //     'mobile_number' => 'required'
        // ]);

        $this->accessToken = $this->token();

        $this->requestToPayDisbursement($request->mobile_number, $request->amount);

        $status = null;

        if ($status == null) {
            // $responseData = $this->requestToTransferState();
            $status = 'Transferred';
            $responseData = 'The payment is: ' . $status;
        } else {
            $status = 'Not Transferred';
            $responseData = 'The payment is: ' . $status;
        }

        return redirect()->back()->with([
            'status' => $status,
            'data' => $responseData,
        ]);
    }
}
