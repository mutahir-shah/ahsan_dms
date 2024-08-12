<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Redirect;
use App\Models\CombinedOrder;
use App\Models\Seller;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Input;
use App\Models\CustomerPackage;
use App\Models\SellerPackage;
use App\Http\Controllers\CustomerPackageController;
use Auth;

class MoyasarController extends Controller
{
    public function payWithMoyasar($request)
    {
        $view = '';
        if(Session::has('payment_type')){
            if(Session::get('payment_type') == 'cart_payment'){
                $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
                $view = 'frontend.moyasar_wallet.order_payment_Moyasar';
            }
            elseif (Session::get('payment_type') == 'wallet_payment') {
                $view = 'frontend.moyasar_wallet.wallet_payment_Moyasar';
            }
            elseif (Session::get('payment_type') == 'customer_package_payment') {
                $view = 'frontend.moyasar_wallet.customer_package_payment_Moyasar';
            }
            elseif (Session::get('payment_type') == 'seller_package_payment') {
                $view = 'frontend.moyasar_wallet.seller_package_payment_Moyasar';
            }
            return view($view, compact('combined_order'));
        }

    }

    public function payment(Request $request)
    {
        //Input items of form
        $input = $request->all();

        //Fetch payment information by moyasar_payment_id
		$payment_id = $input['id'];

		if(count($input)  && $input['status'] == 'failed') {

			\Session::put('error', $input['message']);
			flash(translate($input['message']))->error();
			return redirect()->back();

		}



        if(count($input)  && !empty($input['id'])) {
            $payment_detalis = null;

            $ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://api.moyasar.com/v1/payments/'.$payment_id);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

			curl_setopt($ch, CURLOPT_USERPWD, env('MOYASAR_SECRET_KEY') . ':' . '');

			$payment_detalis = curl_exec($ch);
			if (curl_errno($ch)) {

				\Session::put('error',curl_error($ch));

				return redirect()->back();
			}

            // Do something here for store payment details in database...
            if(Session::has('payment_type')){
                if(Session::get('payment_type') == 'cart_payment'){
                    $checkoutController = new CheckoutController;
                    return $checkoutController->checkout_done(Session::get('combined_order_id'), $payment_detalis);
                }
                elseif (Session::get('payment_type') == 'wallet_payment') {
                    $walletController = new WalletController;
                    return $walletController->wallet_payment_done(Session::get('payment_data'), $payment_detalis);
                }
                elseif (Session::get('payment_type') == 'customer_package_payment') {
                    $customer_package_controller = new CustomerPackageController;
                    return $customer_package_controller->purchase_payment_done(Session::get('payment_data'), $payment);
                }
                elseif (Session::get('payment_type') == 'seller_package_payment') {
                    $seller_package_controller = new SellerPackageController;
                    return $seller_package_controller->purchase_payment_done(Session::get('payment_data'), $payment);
                }
            }
        }
    }
}
