<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscription;
use Exception;
use Illuminate\Http\Response;
use ModelNotFoundException;
use anlutro\LaravelSettings\Facade as Setting;
use App\Provider;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class SubscriptionDriverResource extends Controller
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::guard('admin')->id();
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.DRIVERSUBSCRIPTIONS'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.DRIVERSUBSCRIPTIONS'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.DRIVERSUBSCRIPTIONS'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.DRIVERSUBSCRIPTIONS'));

        $subscriptions = Subscription::where('type', 'DRIVER')
            ->when($data_permission != 1, function ($query) use ($user_id) {
                return $query->where('created_by', $user_id);
            })
            ->get();
        if ($request->ajax()) {
            return $subscriptions;
        } else {
            return view('admin.subscriptions.provider.index', get_defined_vars());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.DRIVERSUBSCRIPTIONS'));
        if ($add_permission == 0) {
            abort(401);
        }
        return view('admin.subscriptions.provider.create');
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
            'value' => 'required|max:255',
            'type' => 'required',
            'rides' => 'required_if:limit_status,Limited',
            'days' => 'required',
        ]);

        try {

            $subscription = $request->all();

            
            $languages = getLanguages();
            $firstLanguage = $languages->where('is_default', 1)->first();
            $firstLanguageNameKey = 'title_' . $firstLanguage->id;
            
            $subscription['title'] = $request->input($firstLanguageNameKey, null);

            if (isset($subscription['limit_status']) && $subscription['limit_status'] == 'Unlimited') {
                $subscription['rides'] = 'Unlimited';
            }

            if (Setting::get('subscription_module_stripe_trial', 0) == 1) {
                $subscription['trial_period'] = Setting::get('driver_trial_period', 0);
            } else {
                $subscription['trial_period'] = 0;
            }

            // Create Stripe Price
            $url = 'https://api.stripe.com/v1/prices';
            $data = [
                'unit_amount' => $request->value * 100,
                'currency' => 'usd',
                'product_data' => [
                    'name' => $subscription['title']
                ],
                'recurring[interval]' => 'day',
                'recurring[interval_count]' => $request->days
            ];
            $headers = [
                'Authorization: Basic ' . base64_encode(Setting::get('stripe_secret_key') . ':'),
                'Content-Type: application/x-www-form-urlencoded',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $res = curl_exec($ch);
            if (curl_errno($ch)) {
                throw new \Exception("Unable to create stripe price.");
            }
            curl_close($ch);

            
            
            $json_res = json_decode($res);
            $subscription['stripe_price_id'] = $json_res->id;
            $subscription['created_by'] = Auth::guard('admin')->id();
            $subscription = Subscription::create($subscription);

            foreach ($languages as $language) {
                $titleKey = 'title_' . $language->id;

                if ($request->filled($titleKey)) { // Check if the name field is not empty
                    $translation = $subscription->translations()->firstOrNew([
                        'language_id' => $language->id,
                    ]);

                    $translation->name = $request->input($titleKey);
                    $translation->save();
                }
            }

            $this->logService->log('Subscriptions', 'create', 'Driver Subscription Created.', $subscription);

            return redirect()->route('admin.subscription-provider.index')->with('flash_success', translateKeyword('Subscription Details Saved'));
        } catch (Exception $e) {
            return redirect()->route('admin.subscription-provider.index')->with('flash_error', translateKeyword('Subscription Not Found'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.DRIVERSUBSCRIPTIONS'));
            if ($edit_permission == 0) {
                abort(401);
            }
            $subscription = Subscription::with('translations')->findOrFail($id);
            return view('admin.subscriptions.provider.edit', compact('subscription'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.subscription-provider.index')->with('flash_error', translateKeyword('Service Type Not Found'));
        }
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
        $this->validate($request, [
            // 'title' => 'required|max:255',
            'value' => 'required|max:255',
            'rides' => 'required_if:limit_status,Limited',
            'days' => 'required',
        ]);

        try {

            $subscription = Subscription::with('translations')->findOrFail($id);

            if ($request->limit_status == 'Unlimited') {
                $request->rides = 'Unlimited';
            }

            if ($subscription->value != $request->value) {
                // Inactive old stripe price 
                $url = "https://api.stripe.com/v1/prices/$subscription->stripe_price_id";
                $data = [
                    'active' => 'false'
                ];
                $headers = [
                    'Authorization: Basic ' . base64_encode(Setting::get('stripe_secret_key') . ':'),
                    'Content-Type: application/x-www-form-urlencoded',
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                if (curl_errno($ch)) {
                    throw new \Exception("Unable to inactive existing price.");
                }
                curl_close($ch);

                // Create Stripe Price
                $url = 'https://api.stripe.com/v1/prices';
                $data = [
                    'unit_amount' => $request->value * 100,
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $subscription->title
                    ],
                    'recurring[interval]' => 'day',
                    'recurring[interval_count]' => $request->days
                ];
                $headers = [
                    'Authorization: Basic ' . base64_encode(Setting::get('stripe_secret_key') . ':'),
                    'Content-Type: application/x-www-form-urlencoded',
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $res = curl_exec($ch);
                if (curl_errno($ch)) {
                    throw new \Exception("Unable to create stripe price.");
                }
                curl_close($ch);


                $json_res = json_decode($res);
                // dd($json_res);
                $subscription->stripe_price_id = $json_res->id;
            }

            // $subscription->title = $request->title;
            $subscription->value = $request->value;
            $subscription->rides = $request->rides;
            $subscription->updated_by = Auth::guard('admin')->id;

            if (Setting::get('subscription_module_stripe_trial', 0) == 1) {
                $subscription->trial_period = Setting::get('driver_trial_period', 0);
            } else {
                $subscription->trial_period = 0;
            }

            $subscription->trial_period = Setting::get('rider_trial_period', 0);

            $subscription->save();

            // Update translations
            $languages = getLanguages();
            foreach ($languages as $language) {
                $titleKey = 'title_' . $language->id;

                if ($request->filled($titleKey)) { // Check if the name field exists
                    $translation = $subscription->translations()->firstOrNew([
                        'language_id' => $language->id,
                    ]);

                    $translation->name = $request->input($titleKey);
                    $translation->save();
                }
            }

            $subscription = Subscription::findOrFail($id);

            $this->logService->log('Subscriptions', 'update', 'Driver Subscription Updated.', $subscription);

            return redirect()->route('admin.subscription-provider.index')->with('flash_success', translateKeyword('Subscription Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.subscription-provider.index')->with('flash_error', translateKeyword('Subscription Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $providerSubsCount = Provider::where('subscription_id', $id)->count();
            if ($providerSubsCount > 0) {
                return redirect()->route('admin.subscription-provider.index')->with('flash_error', translateKeyword('Subscription cannot be deleted subscribed'));
            }

            $subscription = Subscription::find($id);
            $url = "https://api.stripe.com/v1/prices/$subscription->stripe_price_id";
            $data = [
                'active' => 'false'
            ];
            $headers = [
                'Authorization: Basic ' . base64_encode(Setting::get('stripe_secret_key') . ':'),
                'Content-Type: application/x-www-form-urlencoded',
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Exception("Unable to deactive price.");
            }
            curl_close($ch);
            $this->logService->log('Subscriptions', 'delete', 'Driver Subscription Deleted.', $subscription);

            $subscription->translations()->delete();
            $subscription->delete();
            return redirect()->route('admin.subscription-provider.index')->with('flash_success', translateKeyword('Subscription deleted successfully'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.subscription-provider.index')->with('flash_error', translateKeyword('Subscription Not Found'));
        } catch (Exception $e) {
            return redirect()->route('admin.subscription-provider.index')->with('flash_error', translateKeyword('Subscription Not Found'));
        }
    }
}
