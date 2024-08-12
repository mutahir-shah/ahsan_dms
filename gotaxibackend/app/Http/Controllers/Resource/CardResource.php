<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Card;
use App\Subscription;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use anlutro\LaravelSettings\Facade as Setting;
use App\UserRequests;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Token;

class CardResource extends Controller
{
    public function createToken(Request $request)
    {
        // \Stripe\Stripe::setApiKey('sk_test_51KGg5cDB90NRgbBGqJuoJ9J66Xk8rMxObMqCi0JDhG8BdXdLxI3uWUVKnf8fT77HDYe1Wkit4EhJPlhBzGWeI6ZS00dxZUmemu');
        Stripe::setApiKey(Setting::get('stripe_secret_key'));

        // Create Token
        $token = \Stripe\Token::create([
            'card' => [
              'number' => '4242424242424242',
              'exp_month' => 1,
              'exp_year' => 2023,
              'cvc' => '314',
            ],
          ]);

        // Subscribe
        // $subscription = Subscription::where('id', 3)->get(['stripe_price_id'])->first();
        // $subscribe = \Stripe\Subscription::create(['customer' => 'cus_L9VQv59hagTf1J',
        //     'items' => [
        //     ['price' => $subscription->stripe_price_id],
        // ]]);

        //Token
        // $token = Token::create([
        //     'card' => [
        //         'number' => $request->card_number,
        //         'exp_month' => $request->expiry_month,
        //         'exp_year' => $request->expiry_year,
        //         'cvc' => $request->cvc,
        //     ],
        // ]);
        return $token;

        // $charge = \Stripe\Charge::create([
        //     'amount' => 200,
        //     'currency' => 'usd',
        //     'source' => $token,
        //     'description' => 'My First Test Charge (created for API docs)',
        //   ]);

        // $subscriptions = \Stripe\Subscription::all(['customer' => 'cus_LSCCtEHC4Whw20']);
        // foreach ($subscriptions->data as $subscription) {
        //     $subscription = \Stripe\Subscription::retrieve($subscription->id);
        //     $subscription->cancel();
        // }

        return json_encode('Data!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        try {

            $cards = Card::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            return $cards;

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'stripe_token' => 'required'
        ]);

        try {
            $customer_id = $this->customer_id();
            $this->set_stripe();
            $customer = Customer::retrieve($customer_id);
            // $customer->update(
            //     'cus_LP5bWRqlDFFnJo',
            //     [ 'source' => $request->stripe_token ]
            // );

            //cURL to attach source
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/' . $customer_id . '/sources');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "source=" . $request->stripe_token);
            curl_setopt($ch, CURLOPT_USERPWD, Setting::get('stripe_secret_key') . ':' . '');

            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            $response = json_decode($result);
            if (isset($response->error)) {
                $error_code = $response->error->code;
                $decline_code = isset($response->error->decline_code) ? $response->error->decline_code : 'null';
                if ($error_code == 'card_declined') {
                    if ($decline_code == 'generic_decline') {
                        $message = 'Your card is declined';
                    } else if ($decline_code == 'insufficient_funds') {
                        $message = 'Your card is declined due to insufficent funds';
                    } else if ($decline_code == 'lost_card') {
                        $message = 'Your card is declined as it is marked as lost';
                    } else if ($decline_code == 'stolen_card') {
                        $message = 'Your card is declined as it is marked as stolen';
                    }
                } else if ($error_code == 'expired_card') {
                    $message = 'Your card is declined as it is expired';
                } else if ($error_code == 'incorrect_cvc') {
                    $message = 'Your card is declined as it has invalid cvc';
                } else if ($error_code == 'processing_error') {
                    $message = 'Your card is declined due to processing error';
                } else if ($error_code == 'incorrect_number') {
                    $message = 'Your card is declined due to incorrect number';
                } else {
                    $message = 'Your card is declined';
                }

                if ($request->ajax()) {
                    return response()->json(['error' => $message], 500);
                } else {
                    return back()->with('flash_success', $message);
                }
            }

            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            $cardResponse = Token::retrieve($request->stripe_token, []);

            $exist = Card::where('user_id', Auth::user()->id)
                ->where('last_four', $cardResponse->card->last4)
                ->where('brand', $cardResponse->card->brand)
                ->where('type', 'User')
                ->count();

            $cardCount = Card::where('user_id', Auth::user()->id)->count();
            $is_default = $cardCount == 0 ? 1 : 0;

            if ($exist == 0) {
                $create_card = new Card;
                $create_card->user_id = Auth::user()->id;
                $create_card->card_id = $cardResponse->card->id;
                $create_card->last_four = $cardResponse->card->last4;
                $create_card->brand = $cardResponse->card->brand;
                $create_card->is_default = $is_default;
                $create_card->type = 'User';
                $create_card->token = $request->stripe_token;
                $create_card->save();
            } else {
                $card = Card::where('user_id', Auth::user()->id)
                    ->where('last_four', $cardResponse->card->last4)
                    ->where('type', 'User')
                    ->where('brand', $cardResponse->card->brand)->get()->first();
                $cardUpdate = Card::find($card->id);
                // $cardUpdate->is_default = $is_default;
                $cardUpdate->token = $request->stripe_token;
                $cardUpdate->save();
                return response()->json(['message' => 'Card Already Added', 'error' => true]);
            }

            if ($request->ajax()) {
                return response()->json(['message' => 'Card Added']);
            } else {
                return back()->with('flash_success', 'Card Added');
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
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {

        $this->validate($request, [
            'card_id' => 'required|exists:cards,card_id,user_id,' . Auth::user()->id,
        ]);

        try {

            $userRequestsOngoingCount = UserRequests::whereNotIn('status', ['CANCELLED', 'SCHEDULED', 'REQUESTED', 'SEARCHING', 'COMPLETED'])->where('user_id', Auth::user()->id)->count();
            if ($userRequestsOngoingCount > 0) {
                return response()->json(['message' => 'Card cannot be deleted as ride in on-going!']);
            }
            
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods/' . $request->card_id . '/detach');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_USERPWD, Setting::get('stripe_secret_key') . ':' . '');

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            Card::where('card_id', $request->card_id)->delete();

            if ($request->ajax()) {
                return response()->json(['message' => 'Card Deleted']);
            } else {
                return back()->with('flash_success', 'Card Deleted');
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
     * setting stripe.
     *
     * @return Response
     */
    public function set_stripe()
    {
        return Stripe::setApiKey(Setting::get('stripe_secret_key'));
    }

    /**
     * Get a stripe customer id.
     *
     * @return Response
     */
    public function customer_id()
    {
        if (Auth::user()->stripe_cust_id != null) {

            return Auth::user()->stripe_cust_id;

        } else {

            try {

                $stripe = $this->set_stripe();

                $customer = Customer::create([
                    'email' => Auth::user()->email,
                ]);

                User::where('id', Auth::user()->id)->update(['stripe_cust_id' => $customer['id']]);
                return $customer['id'];

            } catch (Exception $e) {
                return $e;
            }
        }
    }

    /**
     * Set a default card.
     *
     * @return Response
     */
    public function set_default_card(Request $request)
    {
        $this->validate($request, [
            'card_id' => 'required|exists:cards,card_id,user_id,' . Auth::user()->id,
        ]);

        try {

            $customer_id = $this->customer_id();
            $this->set_stripe();
            // $customer = \Stripe\Customer::retrieve($customer_id);

            //For setting default source
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/' . $customer_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "default_source=" . $request->card_id);
            curl_setopt($ch, CURLOPT_USERPWD, Setting::get('stripe_secret_key') . ':' . '');

            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            Card::where('user_id', Auth::user()->id)->update(['is_default' => 0]);
            Card::where('card_id', $request->card_id)->update(['is_default' => 1]);

            if ($request->ajax()) {
                return response()->json(['message' => 'This card has been set as default']);
            } else {
                return back()->with('flash_success', 'This card has been set as default');
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
