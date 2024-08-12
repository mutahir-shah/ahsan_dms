<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;
use Alexo\LaravelPayU\LaravelPayU;
use App\PayUOrder;
use PayUParameters;

class PayUController extends Controller
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

    public function doPing()
    {
        LaravelPayU::doPing(function ($response) {
            $code = $response->code;
            // ... check the response code
        }, function ($error) {
            // ... PayUException error handling
        });
    }

    public function getPSEBanks()
    {
        LaravelPayU::getPSEBanks(function ($banks) {
            //... Use bank data 
            foreach ($banks as $bank) {
                $bankCode = $bank->pseCode;
            }
        }, function ($error) {
            // ... Error handling PayUException, InvalidArgument 
        });
    }

    public function payWith(Request $request, $id)
    {
        $order = PayUOrder::find($id);
        $data = [
            PayUParameters::DESCRIPTION => 'Payment cc test',
            PayUParameters::IP_ADDRESS => '127.0.0.1',
            PayUParameters::CURRENCY => 'COP',
            PayUParameters::CREDIT_CARD_NUMBER => '378282246310005',
            PayUParameters::CREDIT_CARD_EXPIRATION_DATE => '2017/02',
            PayUParameters::CREDIT_CARD_SECURITY_CODE => '1234',
            PayUParameters::INSTALLMENTS_NUMBER => 1
        ];

        $order->payWith($data, function ($response, $order) {
            if ($response->code == 'SUCCESS') {
                $order->update([
                    'payu_order_id' => $response->transactionResponse->orderId,
                    'transaction_id' => $response->transactionResponse->transactionId
                ]);
                // ... The rest of the actions on the command 
            } else {
                //... The response code was not successful
            }
        }, function ($error) {
            // ... Error handling PayUException, InvalidArgument
        });
    }

    public function searchById($id)
    {
        $order = PayUOrder::find($id);
        $order->searchById(function ($response, $order) {
            // ... Use the response information 
        }, function ($error) {
            // ... Error handling PayUException, InvalidArgument
        });
    }

    public function searchByReference($id)
    {
        $order = PayUOrder::find($id);
        $order->searchByReference(function ($response, $order) {
            // ... Use the response information 
        }, function ($error) {
            // ... Error handling PayUException, InvalidArgument
        });
    }

    public function searchByTransaction($id)
    {
        $order = PayUOrder::find($id);
        $order->searchByReference(function ($response, $order) {
            // ... Use the response information 
        }, function ($error) {
            // ... Error handling PayUException, InvalidArgument
        });
    }

}
