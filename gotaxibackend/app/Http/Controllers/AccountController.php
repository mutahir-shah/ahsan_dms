<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Helpers\Helper;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use anlutro\LaravelSettings\Facade as Setting;
use Exception;
use Carbon\Carbon;

use App\User;
use App\Fleet;
use App\Account;
use App\Provider;
use App\UserPayment;
use App\ServiceType;
use App\UserRequests;
use App\ProviderService;
use App\UserRequestRating;
use App\UserRequestPayment;
use App\Complaint;
use Illuminate\Validation\ValidationException;
class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('account');
    }

    public function opt(){
        return view('account.auth.otp');
    }

    public function verifyOpt(Request $request){
        $user = auth()->guard('account')->user();
        if ($user->otp == $request->otp) {
            session()->pull('account_otp');
            return redirect("/account");
        }
        throw ValidationException::withMessages([
            "otp" => 'Invalid Otp'
        ]);
        return redirect()->back();
        
    }

    /**
     * Dashboard.
     *
     * @param Provider $provider
     * @return Response
     */
    public function dashboard()
    {

        try {
            $rides = UserRequests::has('user')->orderBy('id', 'desc')->get();
            $cancel_rides = UserRequests::where('status', 'CANCELLED');
            $scheduled_rides = UserRequests::where('status', 'SCHEDULED')->count();
            $user_cancelled = $cancel_rides->where('cancelled_by', 'USER')->count();
            $provider_cancelled = $cancel_rides->where('cancelled_by', 'PROVIDER')->count();
            $cancel_rides = $cancel_rides->count();
            $service = ServiceType::count();
            $fleet = Fleet::count();
            $revenue = UserRequestPayment::sum('total');
            $providers = Provider::take(10)->orderBy('rating', 'desc')->get();

            return view('account.dashboard', compact('providers', 'fleet', 'scheduled_rides', 'service', 'rides', 'user_cancelled', 'provider_cancelled', 'cancel_rides', 'revenue'));
        } catch (Exception $e) {
            return redirect()->route('account.user.index')->with('flash_error', translateKeyword('Something Went Wrong with Dashboard!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function profile()
    {
        return view('account.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function profile_update(Request $request)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!').' '.'meemcolart@gmail.com');
        }

        try {

            $account = Auth::guard('account')->user();

            $this->validate($request, [
                'name' => 'required|max:255',
                'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:accounts,mobile,' . $account->id,
            ]);

            $account->name = $request->name;
            $account->mobile = str_replace(' ', '', $request->mobile);
            // $account->save();

            return redirect()->back()->with('flash_success', translateKeyword('profile_updated'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function password()
    {
        return view('account.account.change-password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function password_update(Request $request)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!').' '.'meemcolart@gmail.com');
        }

        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $Account = Account::find(Auth::guard('account')->user()->id);

            if (password_verify($request->old_password, $Account->password)) {
                $Account->password = bcrypt($request->password);
                // $Account->save();

                return redirect()->back()->with('flash_success', translateKeyword('password_updated'));
            }
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * account statements.
     *
     * @param Provider $provider
     * @return Response
     */
    public function statement($type = 'individual', $request = null)
    {

        try {

            $page = 'Ride Statement';

            if ($type == 'individual') {
                $revenues = UserRequestPayment::sum('total');
                $commision = UserRequestPayment::sum('commision');
                $page = 'Driver Ride';

            } elseif ($type == 'today') {

                $page = 'Today Statement - ' . date('d M Y');

            } elseif ($type == 'monthly') {

                $page = 'This Month Statement - ' . date('F');

            } elseif ($type == 'yearly') {

                $page = 'This Year Statement - ' . date('Y');

            } elseif ($type == 'range') {

                $page = 'Ride Statement from ' . Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d M Y') . ' to ' . Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d M Y');
            }

            $rides = UserRequests::with('payment')->orderBy('id', 'desc');
            $cancel_rides = UserRequests::where('status', 'CANCELLED');
            $revenue = UserRequestPayment::select(DB::raw(
                'SUM(fixed + distance) as overall, SUM(commision) as commission,SUM(tax) as tax,SUM(discount) as discount'
            ));

            $revenues = UserRequestPayment::sum('total');
            $commision = UserRequestPayment::sum('commision');

            if ($type == 'today') {

                $rides->where('created_at', '>=', Carbon::today());
                $cancel_rides->where('created_at', '>=', Carbon::today());
                $revenue->where('created_at', '>=', Carbon::today());

            } elseif ($type == 'monthly') {

                $rides->where('created_at', '>=', Carbon::now()->month);
                $cancel_rides->where('created_at', '>=', Carbon::now()->month);
                $revenue->where('created_at', '>=', Carbon::now()->month);

            } elseif ($type == 'yearly') {

                $rides->where('created_at', '>=', Carbon::now()->year);
                $cancel_rides->where('created_at', '>=', Carbon::now()->year);
                $revenue->where('created_at', '>=', Carbon::now()->year);

            } elseif ($type == 'range') {

                if ($request->from_date == $request->to_date) {
                    $rides->whereDate('created_at', date('Y-m-d', strtotime($request->from_date)));
                    $cancel_rides->whereDate('created_at', date('Y-m-d', strtotime($request->from_date)));
                    $revenue->whereDate('created_at', date('Y-m-d', strtotime($request->from_date)));
                } else {
                    $rides->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $request->from_date), Carbon::createFromFormat('Y-m-d', $request->to_date)]);
                    $cancel_rides->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $request->from_date), Carbon::createFromFormat('Y-m-d', $request->to_date)]);
                    $revenue->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $request->from_date), Carbon::createFromFormat('Y-m-d', $request->to_date)]);
                }
            }

            $rides = $rides->get();
            $cancel_rides = $cancel_rides->count();
            $revenue = $revenue->get();

            return view('account.providers.statement', compact('rides', 'cancel_rides', 'revenue', 'commision'))
                ->with('page', $page);

        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }


    /**
     * account statements today.
     *
     * @param Provider $provider
     * @return Response
     */
    public function statement_today()
    {
        return $this->statement('today');
    }

    /**
     * account statements today.
     *
     * @param Provider $provider
     * @return Response
     */
    public function statement_range(Request $request)
    {
        return $this->statement('range', $request);
    }

    /**
     * account statements monthly.
     *
     * @param Provider $provider
     * @return Response
     */
    public function statement_monthly()
    {
        return $this->statement('monthly');
    }

    /**
     * account statements monthly.
     *
     * @param Provider $provider
     * @return Response
     */
    public function statement_yearly()
    {
        return $this->statement('yearly');
    }


    /**
     * account statements.
     *
     * @param Provider $provider
     * @return Response
     */
    public function statement_provider()
    {
        try {
            $commision = UserRequestPayment::sum('commision');
            $revenues = UserRequestPayment::sum('total');
            $providers = Provider::all();

            foreach ($providers as $index => $provider) {

                $Rides = UserRequests::where('provider_id', $provider->id)
                    ->where('status', '<>', 'CANCELLED')
                    ->get()->pluck('id');

                $providers[$index]->rides_count = $Rides->count();

                $providers[$index]->payment = UserRequestPayment::whereIn('request_id', $Rides)
                    ->select(DB::raw(
                        'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
                    ))->get();
            }

            return view('account.providers.provider-statement', compact('Providers', 'commision'))->with('page', 'Driver Statement');

        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    public function openTicket($type)
    {

        $mytime = Carbon::now();

        if ($type == 'new') {

            $data = Complaint::whereDate('created_at', $mytime->toDateString())->where('transfer', 3)->where('status', 1)->get();
            $title = 'New Tickets';
        }
        if ($type == 'open') {

            $data = Complaint::where('transfer', 3)->where('status', 1)->get();
            $title = 'Open Tickets';
        }

        return view('account.open_ticket', compact('data', 'title'));
    }

    public function closeTicket()
    {

        $data = Complaint::where('transfer', 3)->where('status', 0)->get();

        return view('account.close_ticket', compact('data'));
    }

    public function openTicketDetail($id)
    {
        $data = Complaint::where('id', $id)->first();
        return view('account.open_ticket_details', compact('data'));
    }

    public function lost_management()
    {
        $data = LostItem::get();
        return view('account.open_ticket_details', compact('data'));
    }

    public function transfer($id, Request $request)
    {

        $data = Complaint::where('id', $id)->first();
        $data->status = $request->status;
        $data->transfer = $request->transfer;
        $data->reply = $request->reply;
        $data->save();
        return redirect()->back()->with('flash_success', translateKeyword('Ticket Updated'));

    }
}
