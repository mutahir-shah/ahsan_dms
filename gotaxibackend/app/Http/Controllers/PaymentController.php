<?php

namespace App\Http\Controllers;

use anlutro\LaravelSettings\Facade as Setting;
use App\BankAccount;
use App\Card;

use App\Http\Controllers\SendPushNotification;
use App\Provider;
use App\ProviderDocument;
use App\ProviderService;
use App\RequestFilter;

use App\User;
use App\UserRequestPayment;
use App\UserRequests;

use App\WalletPassbook;
use App\WithdrawalMoney;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Error\InvalidRequest;
use Stripe\Stripe;
use Stripe\StripeInvalidRequestError;


class PaymentController extends Controller
{
    /**
     * payment for user.
     *
     * @return Response
     */
    public function payment(Request $request)
    {
        $this->validate($request, [
            'request_id' => 'required|exists:user_request_payments,request_id|exists:user_requests,id,paid,0,user_id,' . Auth::user()->id
        ]);

        $request_id = $request->request_id;
        $userRequest = UserRequests::find($request_id);
        $userRequest->payment_mode = $request->payment_mode;
        $userRequest->save();

       if ($userRequest->payment_mode == 'CARD' && Setting::get('CARD', 0) == 1) {

            $userRequest = UserRequests::find($request_id);
            $requestPayment = UserRequestPayment::where('request_id', $request_id)->first();

            $StripeCharge = $requestPayment->payable * 100;

            try {

                // $Card = Card::where('user_id',Auth::user()->id)->where('is_default',1)->first();
                Stripe::setApiKey(Setting::get('stripe_secret_key'));
                $card = Card::find($request->card_id);

                $Charge = Charge::create(array(
                    "amount" => $StripeCharge,
                    "currency" => Setting::get('currency'),
                    "customer" => Auth::user()->stripe_cust_id,
                    "card" => $request->card_id,
                    "description" => "Payment Charge for " . Auth::user()->email,
                    "receipt_email" => Auth::user()->email
                ));

                $requestPayment->payment_id = $Charge["id"];
                $requestPayment->payment_mode = 'CARD';
                // $requestPayment->payable = 0; // TODO: For adding values to rider history screen we are using 0 as a value
                $requestPayment->payable = $requestPayment->payable; // TODO: $requestPayment->payable = $StripeCharge; for adding values to rider hostory screen we are using 0 as a value
                $requestPayment->card_details = json_encode($card->only([
                    'last_four',
                    'brand',
                    'gateway_type'
                ]));
                $requestPayment->save();

                $userRequest->paid = 1;
                $userRequest->status = 'COMPLETED';

                $user_rated = 0;
                if (Setting::get('user_app_rating', 0) != 1) {
                    $userRequest->user_rated = 1;
                    $user_rated = 1;
                }

                if (Setting::get('driver_app_rating', 0) != 1) {
                    $userRequest->provider_rated = 1;
                    // Delete from filter so that it doesn't show up in status checks.
                    RequestFilter::where('request_id', $request_id)->delete();
                    ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'active']);
                }

                $userRequest->save();

                $providerController = new ProviderController();
                $deductCommission = $providerController->deductCommission($request_id, $userRequest->provider_id);

                if ($request->ajax()) {
                    return response()->json(['message' => trans('api.paid'), 'user_rated' => $user_rated ]);
                } else {
                    return redirect('dashboard')->with('flash_success', 'Paid');
                }

            } catch (InvalidRequest $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage()], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            } catch (Exception $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage()], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
        } 
    }

    /**
     * charging tip.
     *
     * @return Response
     */
    public function tip_charge(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'card_id' => 'required',
            // 'provider_id' => 'required'

        ]);

        try {
            // $Card = Card::where('card_id',$request->card_id)->get()->first();
            $StripeTipCharge = $request->amount * 100;

            Stripe::setApiKey(Setting::get('stripe_secret_key'));

            $Charge = Charge::create(array(
                "amount" => $StripeTipCharge,
                "currency" => Setting::get('currency'),
                "customer" => Auth::user()->stripe_cust_id,
                "card" => $request->card_id,
                "description" => "Tip charge"
            ));

            // $bankAccount = BankAccount::where('provider_id', $request->provider_id)->get()->first();
            // if ($bankAccount) {
            //     $bankAccountId = $bankAccount->id;
            // } else {
            //     $bankAccountId = 0;
            // }

            // WithdrawalMoney::create([
            //     'bank_account_id' => $bankAccountId,
            //     'provider_id' => $request->provider_id,
            //     'amount' => abs($StripeTipCharge)
            // ]);

            return response()->json(['message' => currency($request->amount) . ' is charged as tip',]);

        } catch (StripeInvalidRequestError $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }


    public function donate_money_user(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',

        ]);

        try {
            // $Card = Card::where('card_id',$request->card_id)->get()->first();
            $StripeWalletCharge = $request->amount * 100;

            Stripe::setApiKey(Setting::get('stripe_secret_key'));

            $Charge = Charge::create(array(
                "amount" => $StripeWalletCharge,
                "currency" => Setting::get('currency'),
                "customer" => Auth::user()->stripe_cust_id,
                "card" => $request->card_id,
                "description" => "Adding Money for " . Auth::user()->email,
                "receipt_email" => Auth::user()->email
            ));

            if ($request->ajax()) {
                return response()->json(['message' => currency($request->amount) . trans('api.donated')]);
            } else {
                return redirect('wallet')->with('flash_success', currency($request->amount) . ' donated successfully');
            }
        } catch (StripeInvalidRequestError $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }

    public function donate_money_provider(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',

        ]);

        try {
            // $Card = Card::where('card_id',$request->card_id)->get()->first();
            $StripeWalletCharge = $request->amount * 100;

            Stripe::setApiKey(Setting::get('stripe_secret_key'));

            $Charge = Charge::create(array(
                "amount" => $StripeWalletCharge,
                "currency" => Setting::get('currency'),
                "customer" => Auth::user()->stripe_cust_id,
                "card" => $request->card_id,
                "description" => "Adding Money for " . Auth::user()->email,
                "receipt_email" => Auth::user()->email
            ));

            if ($request->ajax()) {
                return response()->json(['message' => currency($request->amount) . trans('api.donated')]);
            } else {
                return redirect('wallet')->with('flash_success', currency($request->amount) . ' donated successfully');
            }
        } catch (StripeInvalidRequestError $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }

    /**
     * add wallet money for user.
     *
     * @return Response
     */
    public function add_money(Request $request)
    {

        $this->validate($request, [
            'amount' => 'required',

        ]);

        try {
            // $Card = Card::where('card_id',$request->card_id)->get()->first();
            $StripeWalletCharge = $request->amount * 100;

            Stripe::setApiKey(Setting::get('stripe_secret_key'));

            $Charge = Charge::create(array(
                "amount" => $StripeWalletCharge,
                "currency" => Setting::get('currency'),
                "customer" => Auth::user()->stripe_cust_id,
                "card" => $request->card_id,
                "description" => "Adding Money for " . Auth::user()->email,
                "receipt_email" => Auth::user()->email
            ));

            $update_user = User::find(Auth::user()->id);
            $update_user->wallet_balance += $request->amount;
            $update_user->save();

            WalletPassbook::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'status' => 'CREDITED',
                'via' => 'CARD',
            ]);

            Card::where('user_id', Auth::user()->id)->update(['is_default' => 0]);
            Card::where('card_id', $request->card_id)->update(['is_default' => 1]);

            //sending push on adding wallet money
            (new SendPushNotification)->WalletMoney(Auth::user()->id, ($request->amount));

            if ($request->ajax()) {
                return response()->json(['message' => currency($request->amount) . trans('api.added_to_your_wallet'), 'user' => $update_user]);
            } else {
                return redirect('wallet')->with('flash_success', currency($request->amount) . ' added to your wallet');
            }

        } catch (StripeInvalidRequestError $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }

    /**
     * add wallet money for user.
     *
     * @return Response
     */
    public function add_money_provider(Request $request)
    {

        $this->validate($request, [
            'amount' => 'required',

        ]);

        try {
            // $Card = Card::where('card_id',$request->card_id)->get()->first();
            $StripeWalletCharge = $request->amount * 100;

            Stripe::setApiKey(Setting::get('stripe_secret_key'));

            $Charge = Charge::create(array(
                "amount" => $StripeWalletCharge,
                "currency" => Setting::get('currency'),
                "customer" => Auth::user()->stripe_cust_id,
                "card" => $request->card_id,
                "description" => "Adding Money for " . Auth::user()->email,
                "receipt_email" => Auth::user()->email
            ));

            $update_user = Provider::find(Auth::user()->id);
            $update_user->wallet += $request->amount;


            //TODO: Check driver docs
            // $providerDocumentsCount = ProviderDocument::where('provider_id', Auth::user()->id)->where('status', 'ASSESSING')->count();
            // if ($update_user->status != 'approved' && $providerDocumentsCount == 0 && $update_user->wallet >= 0) {
            //     $update_user->status = 'approved';
            // }

            if ($update_user->status != 'approved' && $update_user->wallet >= 0) {
                $update_user->status = 'approved';
            }

            $update_user->save();

            WalletPassbook::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'status' => 'CREDITED',
                'via' => 'CARD',
                'type' => 'Provider'
            ]);

            Card::where('user_id', Auth::user()->id)->where('type', 'Provider')->update(['is_default' => 0]);
            Card::where('card_id', $request->card_id)->where('type', 'Provider')->update(['is_default' => 1]);

            //sending push on adding wallet money
            (new SendPushNotification)->WalletMoneyDriver(Auth::user()->id, ($request->amount));

            if ($request->ajax()) {
                return response()->json(['message' => currency($request->amount) . trans('api.added_to_your_wallet'), 'user' => $update_user]);
            } else {
                return redirect('wallet')->with('flash_success', currency($request->amount) . ' added to your wallet');
            }

        } catch (StripeInvalidRequestError $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }

    public function add_money_new(Request $request)
    {

        $this->validate($request, [
            'amount' => 'required',

        ]);

        try {

            $StripeWalletCharge = $request->amount * 100;


            $update_user = User::find(Auth::user()->id);
            $update_user->wallet_balance += $request->amount;
            $update_user->save();

            WalletPassbook::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'status' => 'CREDITED',
                'via' => $request->type,
            ]);


            //sending push on adding wallet money
            (new SendPushNotification)->WalletMoney(Auth::user()->id, ($request->amount));

            if ($request->ajax()) {
                return response()->json(['message' => currency($request->amount) . trans('api.added_to_your_wallet'), 'user' => $update_user]);
            } else {
                return redirect('wallet')->with('flash_success', currency($request->amount) . ' added to your wallet');
            }

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }
}
