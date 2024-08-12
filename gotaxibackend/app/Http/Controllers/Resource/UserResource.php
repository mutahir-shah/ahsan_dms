<?php

namespace App\Http\Controllers\Resource;

use App\Provider;
use App\User;
use App\UserRequests;
use App\Document;
use App\UserDocument;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use anlutro\LaravelSettings\Facade as Setting;
use App\Http\Controllers\SendPushNotification;
use App\Zones;
use App\WalletPassbook;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserResource extends Controller
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
        $this->middleware('demo', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user_id = Auth::guard('admin')->id();
        $view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.USERS'));
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.USERS'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.USERS'));
        $notify_permission = Helper::CheckPermission(config('const.NOTIFY'), config('const.USERS'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.USERS'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.USERS'));
        
        $users = User::orderBy('created_at', 'desc')
        ->when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->get();


        return view('admin.users.index', get_defined_vars());
    }

    public function enable(User $user)
    {
        if(Setting::get('subscription_module', 0) == 1 && Setting::get('rider_subscription_module', 0) == 1 && Setting::get('subscription_module_stripe_trial', 0) == 0) {
            $trial_period = Setting::get('rider_trial_period', 0);
            if($trial_period > 0 && $user->trial_availed == 0) {
                $user->trial_availed = 1;
                $user->trial_end_time = Carbon::now()->addDays($trial_period);
                $user->subscription_status = 'trialing';
            }
        }

        $user->status = 'approved';
        $user->updated_by = Auth::guard('admin')->id();
        $user->save();

        $this->logService->log('Users', 'status', 'User Account Enabled.', $user);

        return back()->with('flash_success', translateKeyword('User Enabled'));
    }
    
    public function disable(User $user)
    {
        $user->status = 'violation';
        $user->updated_by = Auth::guard('admin')->id();
        $user->save();

        $this->logService->log('Users', 'status', 'User Account Disabled.', $user);
        return back()->with('flash_success', translateKeyword('User Disabled'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.USERS'));
        if($add_permission == 0){
            abort(401);
        }
        $zones = Zones::where('status', 'active')->get();

        return view('admin.users.create', get_defined_vars());
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => Setting::get('email_field', 0) == 1 ? 'required|unique:users,email|email|max:255' : 'nullable',
            'mobile' => 'required|numeric|regex:/[+][0-9 ]{10,15}/|min:5|unique:users,mobile',
            // 'wallet' => 'required',
            'wallet_suggestion' => 'nullable',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
            'gender' => 'max:255',
            'gender_pref' => 'max:255',
            'zone_id' => 'nullable',
            'dob' => 'nullable',
            'address' => 'nullable',
        ]);

        try {
            $user = $request->all();

            $user['payment_mode'] = 'CASH';
            $user['password'] = bcrypt($request->password);
            if ($request->hasFile('picture')) {
                $user['picture'] = $request->picture->store('user/profile');
            }
            $user['mobile'] = str_replace(' ', '', $request->mobile);
            $user['wallet_balance'] = $request->wallet ? $request->wallet : 0;
            $user['email'] = $request->email ? $request->email : null;

            if ($request->wallet_suggestion != null) {
                $user['wallet_balance'] = $user['wallet_balance'] + $request->wallet_suggestion;
            }
            $user['reward_points'] = $request->reward_points ? $request->reward_points : 0;
            $user['created_by'] = Auth::guard('admin')->id();
            $user = User::create($user);

            $this->logService->log('Users', 'create', 'User Account Created.', $user);

            return back()->with('flash_success', translateKeyword('User Details Saved Successfully'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('user_not_found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show($id)
    {
        try {
            $view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.USERS'));
            $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.USERS'));
            if($view_permission == 0){
                abort(401);
            }
            $user = User::findOrFail($id);

            if($data_permission == 0 && $user->created_by != Auth::guard('admin')->id()){
                abort(401);
            }

            return view('admin.users.user-details', compact('user'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit($id)
    {
        try {
            $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.USERS'));
            $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.USERS'));

            if($edit_permission == 0){
                abort(401);
            }

            $user = User::findOrFail($id);
            if($data_permission == 0 && $user->created_by != Auth::guard('admin')->id()){
                abort(401);
            }
            
            $zones = Zones::where('status', 'active')->get();

            return view('admin.users.edit', compact('user', 'zones'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->replace([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email ?: null,
            'mobile' => str_replace(' ', '', $request->mobile),
            'wallet' => $request->wallet,
            'reward_points' => $request->reward_points,
            'password' => $request->password,
            'gender' => $request->gender ?: null,
            'gender_pref' => $request->gender_pref ?: null,
            'wallet_suggestion' => $request->wallet_suggestion ?: 0,
            'zone_id' => $request->zone_id ?: 0,
            'dob' => $request->dob ?: null,
            'address' => $request->address ?: null,
        ]);

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'mobile' => 'required|numeric|regex:/[+][0-9 ]{10,15}/|min:5|unique:users,mobile,' . $id,
            // 'wallet' => 'required',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'gender' => 'max:255',
            'gender_pref' => 'max:255',
            'wallet_suggestion' => 'nullable',
            'email' => Setting::get('email_field', 0) == 1 ? 'required|email|max:255' : 'nullable',
            'zone_id' => 'nullable',
            'dob' => 'nullable',
            'address' => 'nullable',
        ]);

        try {
            $user = User::findOrFail($id);
          
            $oldWalletAmount = $user->wallet_balance;

            if ($request->hasFile('picture')) {
                Storage::delete($user->picture);
                $user->picture = $request->picture->store('user/profile');
            }

            $pass = '';

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->address = $request->address;
            $user->dob = $request->dob;
            $user->mobile = str_replace(' ', '', $request->mobile);
            $user->wallet_balance = $request->wallet ? $request->wallet : 0;
            $user->email = $request->email ? $request->email : null;
            $user->reward_points = $request->reward_points ? $request->reward_points : 0;

            if ($user->reward_points > $request->reward_points) {
                // Send Push Notification to User
                (new SendPushNotification)->points_earned($id, $request->reward_points, true);
            }

            if ($request->wallet_suggestion != null) {
                $user->wallet_balance = $user->wallet_balance + $request->wallet_suggestion;
            }

            if ($user->wallet_balance > $oldWalletAmount) {
                $addedAmount = $user->wallet_balance - $oldWalletAmount;
                // Send Push Notification to User
                (new SendPushNotification)->WalletMoney($id, $addedAmount);

                WalletPassbook::create([
                    'user_id' => Auth::guard('admin')->user()->id,
                    'amount' => $addedAmount,
                    'status' => 'CREDITED',
                    'via' => 'ADMIN',
                ]);
            }

            if ($user->wallet_balance < $oldWalletAmount) {
                $deductedAmount =  $oldWalletAmount - $user->wallet_balance;
                // Send Push Notification to User
                (new SendPushNotification)->WalletMoneyDeducted($id, $deductedAmount);

                WalletPassbook::create([
                    'user_id' => Auth::guard('admin')->user()->id,
                    'amount' => $deductedAmount,
                    'status' => 'DEBITED',
                    'via' => 'ADMIN',
                ]);
            }

            if ($request->password != '') {
                $pass = Hash::make($request->password);
                $user->password = $pass;
            }

            $user->gender = $request->gender;

            if ($request->has('gender_pref')) {

                $user->gender_pref = $request->gender_pref;
            }

            $user->save();

            $this->logService->log('Users', 'update', 'User Account Updated.', $user);
            return redirect()->route('admin.user.index')->with('flash_success', translateKeyword('User Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('user_not_found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy($id)
    {

        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.USERS'));
        $user = User::find($id);

        if($delete_permission == 0){
            abort(401);
        }

       
        try {

            $userRequestsActiveCount = UserRequests::where('user_id', $id)
                ->whereIn('status', ['ACCEPTED', 'STARTED', 'ARRIVED', 'PICKEDUP', 'DROPPED', 'SCHEDULED', 'REQUESTED'])
                ->count();

            if ($userRequestsActiveCount == 0) {
                $this->logService->log('Users', 'delete', 'User Account Deleted.', $user);
                $user->delete();
                return back()->with('flash_success', translateKeyword('User deleted successfully'));
            } else {
                return back()->with('flash_error', translateKeyword('User can\'t be deleted Ride is already in progress.'));
            }
        } catch (Exception $e) {
            return $e->getMessage();
            return back()->with('flash_error', translateKeyword('user_not_found'));
        }
    }

    /**
     * Remove the multiple resources from storage.
     *
     * @param User $user
     * @return Response
     */
    public function massDestroy(Request $request)
    {

        try {
            foreach($request->deleteids_arr as $id) {
                $user = User::find($id);
                $this->logService->log('Users', 'delete', 'User Account Deleted.', $user);
                $user->delete();
            }
            return translateKeyword('Users deleted successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('user_not_found'));
        }
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
            $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.USERS'));
            $user = User::find($id);

            $requests = UserRequests::where('user_requests.user_id', $id)
                ->RequestHistory()
                ->get();

            return view('admin.request.index', get_defined_vars());
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    public function resetUserReferral(Request $request, $user_id)
    {
        try {
            User::where('id', $user_id)->update(['user_referral_count' => 0]);
            return back()->with('flash_success', translateKeyword('User referral count reset successfully'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found!'));
        }
    }

    public function resetDriverReferral(Request $request, $user_id)
    {
        try {
            User::where('id', $user_id)->update(['provider_referral_count' => 0]);
            return back()->with('flash_success', translateKeyword('User referral count reset successfully'));

        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found!'));
        }
    }
}
