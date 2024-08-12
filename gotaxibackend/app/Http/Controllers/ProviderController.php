<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\UserRequests;
use App\UserRequestPayment;
use App\RequestFilter;
use App\Provider;
use Carbon\Carbon;
use App\Http\Controllers\ProviderResources\TripController;
use Illuminate\Http\Response;
use Setting;

use App\WithdrawalMoney;
use App\BankAccount;

class ProviderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request = null)
    {
        $this->middleware('provider');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('provider.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function incoming(Request $request)
    {
        return (new TripController())->index($request);
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function accept(Request $request, $id)
    {
        return (new TripController())->accept($request, $id);
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function reject($id)
    {
        return (new TripController())->destroy($id);
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function update(Request $request, $id)
    {
        return (new TripController())->update($request, $id);
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function rating(Request $request, $id)
    {
        return (new TripController())->rate($request, $id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function earnings()
    {
        $provider = Provider::where('id', Auth::guard('provider')->user()->id)
            ->with('service', 'accepted', 'cancelled')
            ->get();

        $weekly = UserRequests::where('provider_id', Auth::guard('provider')->user()->id)
            ->with('payment')
            ->where('created_at', '>=', Carbon::now()->subWeekdays(7))
            ->get();

        $weekly_sum = UserRequestPayment::whereHas('request', function ($query) {
            $query->where('provider_id', Auth::guard('provider')->user()->id);
            $query->where('created_at', '>=', Carbon::now()->subWeekdays(7));
        })
            ->sum('provider_pay');

        $today = UserRequests::where('provider_id', Auth::guard('provider')->user()->id)
            ->where('created_at', '>=', Carbon::today())
            ->count();

        $fully = UserRequests::where('provider_id', Auth::guard('provider')->user()->id)
            ->with('payment', 'service_type')
            ->get();

        $fully_sum = UserRequestPayment::whereHas('request', function ($query) {
            $query->where('provider_id', Auth::guard('provider')->user()->id);
        })
            ->sum('provider_pay');

        return view('provider.payment.earnings', compact('provider', 'weekly', 'fully', 'today', 'weekly_sum', 'fully_sum'));
    }

    /**
     * available.
     *
     * @return Response
     */
    public function available(Request $request)
    {
        (new ProviderResources\ProfileController)->available($request);
        return back();
    }

    /**
     * Show the application change password.
     *
     * @return Response
     */
    public function change_password()
    {
        return view('provider.profile.change_password');
    }

    /**
     * Change Password.
     *
     * @return Response
     */
    public function update_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed',
            'old_password' => 'required',
        ]);

        $provider = Auth::user();

        if (password_verify($request->old_password, $provider->password)) {
            $provider->password = bcrypt($request->password);
            $provider->save();

            return back()->with('flash_success', translateKeyword('Password changed successfully!'));
        } else {
            return back()->with('flash_error', translateKeyword('Please enter correct password'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function location_edit()
    {
        return view('provider.location.index');
    }

    /**
     * Update latitude and longitude of the user.
     *
     * @param int $id
     * @return Response
     */
    public function location_update(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($provider = Auth::user()) {

            $provider->latitude = $request->latitude;
            $provider->longitude = $request->longitude;
            $provider->save();

            return back()->with(['flash_success' => translateKeyword('Location Updated successfully!')]);

        } else {
            return back()->with(['flash_error' => translateKeyword('Provider Not Found!')]);
        }
    }

    /**
     * upcoming history.
     *
     * @return Response
     */
    public function upcoming_trips()
    {
        $fully = (new ProviderResources\TripController)->upcoming_trips();
        return view('provider.payment.upcoming', compact('fully'));
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */


    public function cancel(Request $request)
    {
        try {
            (new TripController)->cancel($request);
            return back();
        } catch (ModelNotFoundException $e) {
            return back()->with(['flash_error' => translateKeyword('something_went_wrong')]);
        }
    }

    public function getBankAccount($providerId) {
        $bankAccountId = 0;
        $bankAccount = BankAccount::where('provider_id', $providerId)->get()->first();
        if ($bankAccount) {
            $bankAccountId = $bankAccount->id;
        } 
        
        return $bankAccountId;
    }

    public function deductCommission($request_id, $provider_id) {

        $commission_deduction = Setting::get('commission_deduction', 0);
        $commission_deduction_wallet_driver = Setting::get('commission_deduction_wallet_driver', 0);
        $commission_deduction_wallet_blockage = Setting::get('commission_deduction_wallet_blockage', 0);
        $commission_deduction_account_driver = Setting::get('commission_deduction_account_driver', 0);
        $commission_deduction_account_blockage = Setting::get('commission_deduction_account_blockage', 0);
        $driver_wallet_threshold = Setting::get('driver_wallet_threshold', 0);
        $driver_account_threshold = Setting::get('driver_account_threshold', 0);

        $requestPayment = UserRequestPayment::where('request_id', $request_id)->first();
        $bankAccountId = $this->getBankAccount($provider_id);
        $provider = Provider::find($provider_id);

        $price = 0;
        // $surgePrice =  $requestPayment->surge;
        // $bookingFeeAmount =  $requestPayment->booking_fee;
        $tax_price = $requestPayment->tax;
        $company_commission_price = $requestPayment->commision;
        $provider_commission_price = $requestPayment->provider_commission;
        // $total = $requestPayment->total;

        $deductionAmount = 0;

        if ($commission_deduction == 1 && $requestPayment == null) {
            if ($requestPayment->payment_mode == 'CASH') {

                $deductionAmount = $company_commission_price;
                if ($commission_deduction_wallet_driver == 1) {

                    $provider->wallet -= $deductionAmount;

                    if ($commission_deduction_wallet_blockage == 1) {
                        if ($provider->wallet < $driver_wallet_threshold) {
                            $provider->status = 'low_balance';
                        }
                    }

                    $provider->save();

                } else if ($commission_deduction_account_driver == 1) {

                    WithdrawalMoney::create([
                        'bank_account_id' => $bankAccountId,
                        'provider_id' => $provider_id,
                        'amount' => -$deductionAmount
                    ]);

                    if ($commission_deduction_account_blockage == 1) {
                        $account_current_balance = WithdrawalMoney::where('provider_id', $provider_id)->whereNull('status')->sum('amount');
                        if ($account_current_balance < $driver_wallet_threshold) {
                            $provider->status = 'low_balance';
                            $provider->save();
                        }
                    }
                }

            } else if ($requestPayment->payment_mode == 'CARD') {

                $deductionAmount = $provider_commission_price;
                if ($commission_deduction_account_driver == 1) {

                    WithdrawalMoney::create([
                        'bank_account_id' => $bankAccountId,
                        'provider_id' => $provider_id,
                        'amount' => -$deductionAmount
                    ]);

                    if ($commission_deduction_account_blockage == 1) {
                        $account_current_balance = WithdrawalMoney::where('provider_id', $provider_id)->whereNull('status')->sum('amount');
                        if ($account_current_balance < $driver_wallet_threshold) {
                            $provider->status = 'low_balance';
                            $provider->save();
                        }
                    }
                }
            }
        }

        return true;
    }
}