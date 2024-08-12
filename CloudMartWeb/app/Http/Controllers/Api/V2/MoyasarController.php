<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;

use Session;
use Redirect;
use App\Models\CombinedOrder;
use App\Models\Seller;
use App\Models\User;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Input;
use App\Models\CustomerPackage;
use App\Models\SellerPackage;
use App\Http\Controllers\CustomerPackageController;
use App\Utility\SendSMSUtility;
use App\Utility\NotificationUtility;
use App\Models\Cart;
use App\Models\Wallet;
use Auth;

class MoyasarController extends Controller
{
    public function payWithMoyasar(Request $request)
    {

        $payment_type = $request->payment_type;
        $combined_order_id = $request->combined_order_id;
        $amount = $request->amount;
        $user_id = $request->user_id;
        $user = User::find($user_id);

        if ($payment_type) {
            if ($payment_type == 'cart_payment') {
                $combined_order = CombinedOrder::findOrFail($combined_order_id);
                $shipping_address = json_decode($combined_order->shipping_address, true);
                return view('frontend.moyasar_wallet.mobile_flow.order_payment', compact('user', 'combined_order', 'shipping_address'));
            } elseif ($payment_type == 'wallet_payment') {
                return view('frontend.moyasar_wallet.mobile_flow.wallet_payment', compact('user', 'amount'));
            }
        }
    }

    public function payment(Request $request)
    {
        //Input items of form
        $input = $request->all();

        //Fetch payment information by moyasar_payment_id
        $payment_id = $input['id'];

        if (count($input)  && $input['status'] == 'failed') {

            return response()->json(['result' => false, 'message' => $input['message'], 'payment_details' => '']);
        }



        if (count($input)  && !empty($input['id'])) {
            $payment_details = null;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.moyasar.com/v1/payments/' . $payment_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            curl_setopt($ch, CURLOPT_USERPWD, env('MOYASAR_SECRET_KEY') . ':' . '');

            $payment_details = curl_exec($ch);
            if (curl_errno($ch)) {


                return response()->json(['result' => false, 'message' => curl_error($ch), 'payment_details' => '']);
            }

            return response()->json(['result' => true, 'message' => translate("Payment Successful"), 'payment_details' => $payment_details]);
        }
    }

    public function success(Request $request)
    {
        try {

            $payment_type = $request->payment_type;

            if ($payment_type == 'cart_payment') {

                checkout_done($request->combined_order_id, $request->payment_details);
                $combined_order = CombinedOrder::find($request->combined_order_id);

                foreach ($combined_order->orders as $key => $order) {
                    $order->payment_status = 'paid';
                    $order->payment_details = $request->payment_details;
                    $order->save();

                    try {
                        NotificationUtility::sendOrderPlacedNotification($order);
                        calculateCommissionAffilationClubPoint($order);
                    } catch (\Exception $e) {
                    }
                }
            }

            if ($payment_type == 'wallet_payment') {

                $user = \App\Models\User::find($request->user_id);
                $user->balance = $user->balance + $request->amount;
                $user->save();

                $wallet = new Wallet;
                $wallet->user_id = $user->id;
                $wallet->amount = $request->amount;
                $wallet->payment_method = 'Moyasar';
                $wallet->payment_details = $request->payment_details;
                $wallet->save();
            }

            Cart::where('user_id', $request->user_id)->delete();

            return response()->json(['result' => true, 'message' => translate("Payment is successful")]);
        } catch (\Exception $e) {
            return response()->json(['result' => false, 'message' => $e->getMessage()]);
        }
    }
}
