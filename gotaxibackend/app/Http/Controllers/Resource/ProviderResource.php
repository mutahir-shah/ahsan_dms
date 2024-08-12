<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// use Illuminate\Support\Facades\DB;

use DB;
use Exception;
use anlutro\LaravelSettings\Facade as Setting;
use App\Document;
use App\Fleet;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;

use App\Provider;
use App\UserRequestPayment;
use App\UserRequests;
use App\Helpers\Helper;
use App\Http\Controllers\SendPushNotification;
use App\ProviderDevice;
use App\ProviderService;
use App\PushNotificationLog;
use Illuminate\Support\Facades\Auth;
use App\Zones;
use App\WalletPassbook;
use App\Services\LogService;

class ProviderResource extends Controller
{
    protected $logService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy', 'disapprove']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::guard('admin')->id();
        $view_permission = Helper::CheckPermission(config('const.EDIT'), config('const.DRIVERS'));
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.DRIVERS'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.DRIVERS'));
        $notify_permission = Helper::CheckPermission(config('const.NOTIFY'), config('const.DRIVERS'));
        $status_permission = Helper::CheckPermission(config('const.STATUS'), config('const.DRIVERS'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.DRIVERS'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.DRIVERS'));

        $allProviders = Provider::with('service', 'accepted', 'cancelled', 'subscription', 'providerRating', 'fleetData')
        ->orderBy('id', 'DESC')
        ->when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        });
        
        $driverDocsCount = Document::where('type', 'DRIVER')->count();
        $driverVehiclesDocsCount = Document::where('type', 'VEHICLE')->count();

        if (request()->has('fleet')) {
            $providers = $allProviders->where('fleet', $request->fleet)->get();
        } else {
            $providers = $allProviders->get();
        }

        return view('admin.providers.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.DRIVERS'));
        if($add_permission == 0){
            abort(401);
        }
        $fleets = Fleet::all();
        $zones = Zones::where('status', 'active')->get();

        return view('admin.providers.create', compact('fleets', 'zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::guard('admin')->id();

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'company_name' => 'nullable',
            'company_address' => 'nullable',
            'company_vat' => 'nullable',
            'email' => Setting::get('email_field', 0) == 1 ? 'required|unique:providers,email|email|max:255' : 'nullable',
            'mobile' => 'required|numeric|regex:/[+][0-9 ]{10,15}/|min:11|unique:providers,mobile',
            'wallet' => Setting::get('wallet', 0) == 1 ? 'required' : 'nullable',
            'wallet_suggestion' => 'nullable',
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
            'gender' => 'max:255',
            'gender_pref' => 'max:255',
            'fleet' => 'nullable',
            'zone_id' => 'nullable',
            'dob' => 'nullable',
            'address' => 'nullable',
            'tax_tps_info' => Setting::get('tax_tps_info_field', 0) == 1 
            ? 'required|alphanumeric'
            : 'nullable',
            'tax_tvq_info' => Setting::get('tax_tvq_info_field', 0) == 1 
            ? 'required|alphanumeric'
            : 'nullable',
        ]);

        try {
            $provider = $request->all();
            $provider['created_by'] = $user_id;
            $provider['mobile'] = str_replace(' ', '', $request->mobile);

            if ($request->wallet_suggestion != null) {
                $provider['wallet'] = $provider['wallet'] + $request->wallet_suggestion;
            }

            $provider['password'] = bcrypt($request->password);
            if ($request->hasFile('avatar')) {
                $provider['avatar'] = $request->avatar->store('provider/profile');
            }

            $provider = Provider::create($provider);
            $this->logService->log('Providers', 'create', 'Provider Created.', $provider);

            return redirect()->route('admin.provider.index')->with('flash_success', translateKeyword('Provider Details Saved Successfully'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Provider $provider
     * @return Response
     */
    public function show($id)
    {
        try {

            $view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.DRIVERS'));
            if($view_permission == 0){
                abort(401);
            }

            $provider = Provider::findOrFail($id);
            
            return view('admin.providers.provider-details', get_defined_vars());
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Provider $provider
     * @return Response
     */
    public function edit($id)
    {
        try {
            $user_id = Auth::guard('admin')->id();
            
            $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.DRIVERS'));
            if($edit_permission == 0){
                abort(401);
            }

            $provider = Provider::findOrFail($id);
            $fleets = Fleet::all();
            $zones = Zones::where('status', 'active')->get();

            return view('admin.providers.edit', compact('provider', 'fleets', 'zones'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Provider $provider
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user_id = Auth::guard('admin')->id();
       
        $request->replace([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email ?: null,
            'company_name' => $request->company_name ?: null,
            'company_address' => $request->company_address ?: null,
            'company_vat' => $request->company_vat ?: null,
            'mobile' => str_replace(' ', '', $request->mobile),
            'wallet' => $request->wallet ?: null,
            'password' => $request->password,
            'gender' => $request->gender ?: null,
            'gender_pref' => $request->gender_pref ?: null,
            'wallet_suggestion' => $request->wallet_suggestion ?: 0,
            'fleet' => $request->fleet ?: 0,
            'zone_id' => $request->zone_id ?: 0,
            'dob' => $request->dob ?: null,
            'address' => $request->address ?: null,
            'tax_tps_info' => $request->tax_tps_info ?: null,
            'tax_tvq_info' => $request->tax_tvq_info ?: null
        ]);

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => Setting::get('email_field', 0) == 1 ? 'required|email|max:255' : 'nullable',
            'company_name' => 'nullable',
            'company_address' => 'nullable',
            'company_vat' => 'nullable',
            'mobile' => 'required|numeric|regex:/[+][0-9 ]{10,15}/|min:5|unique:providers,mobile,' . $id,
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'gender' => 'max:255',
            'gender_pref' => 'max:255',
            'wallet_suggestion' => 'nullable',
            'fleet' => 'nullable',
            'zone_id' => 'nullable',
            'dob' => 'nullable',
            'address' => 'nullable',
            'tax_tps_info' => Setting::get('tax_tps_info_field', 0) == 1 
            ? 'required|alphanumeric'
            : 'nullable',
            'tax_tvq_info' => Setting::get('tax_tvq_info_field', 0) == 1 
            ? 'required|alphanumeric'
            : 'nullable',
        ]);

        try {
            $provider = Provider::findOrFail($id);
            $oldWalletAmount = $provider->wallet;

            if ($request->hasFile('avatar')) {
                if ($provider->avatar) {
                    Storage::delete($provider->avatar);
                }
                $provider->avatar = $request->avatar->store('provider/profile');
            }

            $pass = '';

            $provider->first_name = $request->first_name;
            $provider->last_name = $request->last_name;
            $provider->company_name = $request->company_name;
            $provider->company_address = $request->company_address;
            $provider->company_vat = $request->company_vat;
            $provider->mobile = str_replace(' ', '', $request->mobile);
            $provider->wallet = $request->wallet ?: null;
            $provider->email = $request->email ?: null;
            $provider->gender = $request->gender;
            $provider->fleet = $request->fleet;
            $provider->zone_id = $request->zone_id;
            $provider->address = $request->address;
            $provider->tax_tps_info = $request->tax_tps_info;
            $provider->tax_tvq_info = $request->tax_tvq_info;
            $provider->dob = $request->dob;
            $provider['updated_by'] = $user_id;

            if ($request->has('gender_pref')) {
                $provider->gender_pref = $request->gender_pref;
            }

            if ($request->password != '') {
                $pass = Hash::make($request->password);
                $provider->password = $pass;
            }

            if ($request->wallet_suggestion != null) {
                $provider->wallet = $provider->wallet + $request->wallet_suggestion;
            }

            if ($provider->wallet > $oldWalletAmount) {
                $addedAmount = $provider->wallet - $oldWalletAmount;
                // Send Push Notification to User
                (new SendPushNotification)->ProviderWalletMoney($id, $addedAmount);
            }

            if ($provider->wallet < $oldWalletAmount) {
                $deductedAmount =  $oldWalletAmount - $provider->wallet;
                // Send Push Notification to User
                (new SendPushNotification)->ProviderWalletMoneyDeducted($id, $deductedAmount);
            }

            $provider->save();
            $this->logService->log('Providers', 'updated', 'Provider Updated.', $provider);
            return redirect()->route('admin.provider.index')->with('flash_success', translateKeyword('Provider Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function destroy($id)
    {

        try {
            $user_id = Auth::guard('admin')->id();
       
            $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.DRIVERS'));
            if($delete_permission == 0){
                abort(401);
            }

            $userRequestsActiveCount = UserRequests::where('current_provider_id', $id)
                ->whereIn('status', ['ACCEPTED', 'STARTED', 'ARRIVED', 'PICKEDUP', 'DROPPED', 'SCHEDULED', 'REQUESTED'])
                ->count();

            if ($userRequestsActiveCount == 0) {
                $provider = Provider::find($id);
                $this->logService->log('Providers', 'delete', 'Provider Updated.', $provider);
                $provider->delete();
                return back()->with('flash_success', translateKeyword('Provider deleted successfully'));
            } else {
                return back()->with('flash_error', translateKeyword('Provider can\'t be deleted Ride is already in progress.'));
            }
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function approve($id)
    {
        try {
            $provider = Provider::findOrFail($id);

            if ($provider->service) {

                if(Setting::get('subscription_module', 0) == 1 && Setting::get('driver_subscription_module', 0) == 1 && Setting::get('subscription_module_stripe_trial', 0) == 0) {
                    $trial_period = Setting::get('rider_trial_period', 0);
                    if($trial_period > 0 && $provider->trial_availed == 0) {
                        $provider->trial_availed = 1;
                        $provider->trial_end_time = Carbon::now()->addDays($trial_period);
                        $provider->subscription_status = 'trialing';
                    }
                }

                $provider->status = 'approved';
                $provider->is_approved = 1;
                $provider->save();
                $this->logService->log('Providers', 'status', 'Provider Status Updated.', $provider);
                return back()->with('flash_success', translateKeyword('Provider Approved'));
            } else {
                return redirect()->route('admin.provider.document.index', $id)->with('flash_error', translateKeyword('Provider has not been assigned a service type!'));
            }
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Something went wrong! Please try again later.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function approveVehicle($vehicle_id)
    {
        try {

            $vehicle = ProviderService::find($vehicle_id);
            $vehicle->status = 'active';
            $vehicle->is_approved = 1;
            $vehicle->save();

            $provider = ProviderDevice::where('provider_id', $vehicle->provider_id)->with('provider')->first();

            if (isset($provider->token) && $provider->token != "") {
                PushNotificationLog::firstOrCreate([
                    'title' => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved",
                    'message' => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved",
                    'receiver_id' => $vehicle->provider_id,
                    'app_type' => 'Driver',
                    'category' => 'General',
                ]);

                $request = (object)array("title" => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved", 'message' => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved");

                (new SendPushNotification)->driver_push($request, $provider->token);
            }
            $this->logService->log('ProviderServices', 'status', 'Provider Service Status Updated.', $vehicle);

            return back()->with('flash_success', translateKeyword('Vehicle approved'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Something went wrong! Please try again later.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function selectVehicle($vehicle_id, $provider_id)
    {
        try {

            $vehicles = ProviderService::where('provider_id', $provider_id)->update(['is_selected' => 0, 'status' => 'offline']);

            $vehicle = ProviderService::find($vehicle_id);
            $vehicle->status = 'active';
            $vehicle->is_selected = 1;
            $vehicle->save();

            //parent selection
            if ($vehicle->parent_id) {
                $vehiclesParentActivated = ProviderService::where('id', $vehicle->parent_id)->orWhere('parent_id', $vehicle->parent_id)->update(['is_selected' => 1, 'status' => 'active']);
            }

            return back()->with('flash_success', translateKeyword('Vehicle selected'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Something went wrong! Please try again later.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function disapproveVehicle($vehicle_id)
    {
        try {

            $vehicle = ProviderService::find($vehicle_id);
            $vehicle->status = 'offline';
            $vehicle->is_approved = 0;
            $vehicle->save();
            $this->logService->log('ProviderServices', 'update', 'Provider Service Updated.', $vehicle);

            return back()->with('flash_success', translateKeyword('Vehicle disapproved'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Something went wrong! Please try again later.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function disapprove($id)
    {
        $provider = Provider::where('id', $id);
        $provider->update(['status' => 'violation']);
        $this->logService->log('Providers', 'status', 'Provider Status Updated.', $provider);
        return back()->with('flash_success', translateKeyword('Provider Disapproved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function request($id)
    {
        try {
            $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.DRIVERS'));

            $requests = UserRequests::where('user_requests.provider_id', $id)
                ->RequestHistory()
                ->get();

            return view('admin.request.index', get_defined_vars());
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }


    public function changestatus($id)
    {
        try {
           
            ProviderService::where('id', $id)
            ->where('status', '!=', 'riding')
            ->update(['status' => \DB::raw("IF(status = 'active', 'offline', 'active')")]);
            $provider = ProviderService::find($id);
            $this->logService->log('ProviderServices', 'status', 'Provider Service Status Updated.', $provider);
            return back()->with('flash_success', translateKeyword('Provider Status Updated successfully'));
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
    public function statement($id)
    {

        try {
            $pagecode = 2;
            $requests = UserRequests::where('provider_id', $id)
                ->where('status', 'COMPLETED')
                ->with('payment')
                ->get();

            $rides = UserRequests::where('provider_id', $id)->with('payment')->orderBy('id', 'desc')->paginate(10);
            $cancel_rides = UserRequests::where('status', 'CANCELLED')->where('provider_id', $id)->count();
            $provider = Provider::find($id);
            $revenue = UserRequestPayment::whereHas('request', function ($query) use ($id) {
                $query->where('provider_id', $id)->where("payment_mode", "CASH");
            })->select(DB::raw(
                'SUM(ROUND(provider_pay)) as overall, SUM(ROUND(provider_commission)) as commission'
            ))->get();
            $comm = UserRequestPayment::where('provider_commission_paid', "0")->whereHas('request', function ($query) use ($id) {
                $query->where('provider_id', $id)->where("payment_mode", "CASH");
            })->select(DB::raw(
                'SUM(ROUND(provider_pay)) as overall, SUM(ROUND(provider_commission)) as commission'
            ))->get();

            $onlinepayment = UserRequestPayment::where('provider_commission_paid', "0")->whereHas('request', function ($query) use ($id) {
                $query->where('provider_id', $id)->where("payment_mode", "!=", "CASH");
            })->select(DB::raw(
                'SUM(ROUND(provider_pay)) as overall, SUM(ROUND(provider_commission)) as commission'
            ))->get();

            $finalcommission = $comm[0]->commission + $onlinepayment[0]->commission - $onlinepayment[0]->overall;


            $Joined = $provider->created_at ? '- Joined ' . $provider->created_at->diffForHumans() : '';

            $provider_id = $id;

            return view('admin.providers.statement', compact('pagecode', 'rides', 'cancel_rides', 'revenue', 'provider_id', "comm", "finalcommission"))
                ->with('page', $provider->first_name . "'s Overall Statement " . $Joined);
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    public function Accountstatement($id)
    {
        try {

            $requests = UserRequests::where('provider_id', $id)
                ->where('status', 'COMPLETED')
                ->with('payment')
                ->get();

            $rides = UserRequests::where('provider_id', $id)->with('payment')->orderBy('id', 'desc')->paginate(10);
            $cancel_rides = UserRequests::where('status', 'CANCELLED')->where('provider_id', $id)->count();
            $provider = Provider::find($id);
            $revenue = UserRequestPayment::whereHas('request', function ($query) use ($id) {
                $query->where('provider_id', $id)->where("payment_mode", "CASH");
            })->select(DB::raw(
                'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
            ))->get();

            $comm = UserRequestPayment::where('provider_commission_paid', "0")->whereHas('request', function ($query) use ($id) {
                $query->where('provider_id', $id)->where("payment_mode", "CASH");
            })->select(DB::raw(
                'SUM(ROUND(provider_commission)) as commission'
            ))->get();

            $onlinepayment = UserRequestPayment::where('provider_commission_paid', "0")->whereHas('request', function ($query) use ($id) {
                $query->where('provider_id', $id)->where("payment_mode", "!=", "CASH");
            })->select(DB::raw(
                'SUM(ROUND(provider_pay)) as overall, SUM(ROUND(provider_commission)) as commission'
            ))->get();

            $finalcommission = $comm[0]->commission + $onlinepayment[0]->commission - $onlinepayment[0]->overall;

            $Joined = $provider->created_at ? '- Joined ' . $provider->created_at->diffForHumans() : '';
            $provider_id = $id;
            return view('account.providers.statement', compact('rides', 'cancel_rides', 'revenue', "provider_id", "comm", "finalcommission"))
                ->with('page', $provider->first_name . "'s Overall Statement " . $Joined);
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Remove the multiple resources from storage.
     *
     * @param User $admin
     * @return Response
     */
    public function massDestroy(Request $request)
    {
        try {
            foreach($request->deleteids_arr as $id){
                $provider = Provider::find($id);
                $this->logService->log('Providers', 'delete', 'Provider Deleted.', $provider);
                $provider->delete();
            }
            // return back()->with('flash_success', 'Admins deleted successfully');
            return translateKeyword('providers deleted successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found'));
        }
    }

    public function resetUserReferral(Request $request, $provider_id)
    {
        try {
            $provider = Provider::find($provider_id);
            $provider->update(['user_referral_count' => 0]);
            $this->logService->log('Providers', 'update', 'Provider Updated.', $provider);
            return back()->with('flash_success', translateKeyword('User referral count reset successfully'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found'));
        }
    }

    public function resetDriverReferral(Request $request, $provider_id)
    {
        try {
            $provider = Provider::find($provider_id);
            $provider->update(['provider_referral_count' => 0]);
            $this->logService->log('Providers', 'update', 'Provider Updated.', $provider);
            return back()->with('flash_success', translateKeyword('Driver referral count reset successfully'));

        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found'));
        }
    }
}
