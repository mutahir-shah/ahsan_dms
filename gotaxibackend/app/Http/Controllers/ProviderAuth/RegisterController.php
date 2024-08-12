<?php

namespace App\Http\Controllers\ProviderAuth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use anlutro\LaravelSettings\Facade as Setting;
use Validator;

use App\Provider;
use App\ProviderService;
use App\ServiceType;
use App\User;
use App\UserReferral;
use App\ProviderReferral;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/provider/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('provider.guest');
    }

    /**
     * Show the application registration form.
     *
     * @return Response
     */
    public function showRegistrationForm()
    {
        $service_types = ServiceType::where('status', 1)->get();

        return view('register-driver', compact('service_types'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone_number' => 'required|regex:/[+][0-9 ]{10,15}/|min:10|max:15|unique:providers,mobile',
            // 'country_code' => 'required',
            'email' => Setting::get('email_field', 1) ? 'required|email|max:255|unique:providers' : 'nullable',
            'password' => 'required|min:6|confirmed',
            'service_type' => 'required',
            'service_number' => 'required',
            'service_model' => 'required',
            'company_name' => 'nullable',
            'company_address' => 'nullable',
            'company_vat' => 'nullable',
            'tax_tps_info' => Setting::get('tax_tps_info_field', 0) == 1 
            ? 'required|alphanumeric'
            : 'nullable',
            'tax_tvq_info' => Setting::get('tax_tvq_info_field', 0) == 1 
            ? 'required|alphanumeric'
            : 'nullable',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return Provider
     */
    protected function create(array $data)
    {
        $provider = Provider::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => isset($data['email']) ? $data['email'] : null,
            'gender' => isset($data['gender']) ? $data['gender'] : null,
            'gender_pref' => Setting::get('gender_pref_enabled', 0) == 1 ? $data['gender_pref'] : null,
            'mobile' => str_replace(' ', '', $data['phone_number']),
            'password' => bcrypt($data['password']),
            'status' => 'doc_required',
            'company_name' => isset($data['company_name'])  ? $data['company_name'] : '',
            'company_address' => isset($data['company_address']) ? $data['company_address'] : '',
            'company_vat' => isset($data['company_vat']) ? $data['company_vat'] : '',
            'zone_id' => isset($data['zone_id']) ? $data['zone_id'] : 0,
            'dob' => isset($data['dob']) ? $data['dob'] : null,
            'tax_tps_info' => isset($data['tax_tps_info']) ? $data['tax_tps_info'] : null,
            'tax_tvq_info' => isset($data['tax_tvq_info']) ? $data['tax_tvq_info'] : null,
        ]);

        if (is_array($data['service_type']) && ($data['service_type'] !== "" || $data['service_type'] !== null)) {
            $isChild = 0;
            $parent_id = null;
            $index = 0;
            foreach ($data['service_type'] as $service) {
                // dd($service);
                
                if ($index == 0) {
                    $isChild = 0;
                } else {
                    $isChild = 1;
                }

                $provider_service = ProviderService::create([
                    'provider_id' => $provider->id,
                    'service_type_id' => $service,
                    'service_number' => strtolower($data['service_number']),
                    'service_model' => $data['service_model'],
                    'is_selected' => $index == 0 ? 1 : 0,
                    'is_child' => $isChild,
                    'parent_id' => $parent_id
                ]);

                if ($index == 0) {
                    $parent_id = $service;
                }
                $index = 1;
            }
        }

        $newCreatedProviderId = $provider->id;
        if (Setting::get('driver_referral') == 1) {
            $referral_code = strtoupper($data['referral_code']);
            if ($referral_code != $provider->referral_code) {
                $provider = Provider::where('referral_code', $referral_code)->get(['id'])->first(); 
                $user = User::where('referral_code', $referral_code)->get(['id'])->first();
                
                if ($provider) {
                    if ($provider->id != $newCreatedProviderId) {
                        $provider = Provider::find($provider->id);
                        $provider->provider_referral_count = $provider->provider_referral_count + 1;
                        $provider->save();

                        ProviderReferral::create([
                            'provider_id' => $provider->id,
                            'reffered_id' => $newCreatedProviderId, // new created provider
                            'type' => 'Driver',
                        ]);
                    }
                    
                }
                if ($user) {
                    $user = User::find($user->id);
                    $user->provider_referral_count = $user->provider_referral_count + 1;
                    $user->save();

                    UserReferral::create([
                        'user_id' => $user->id,
                        'reffered_id' => $newCreatedProviderId, // new created provider
                        'type' => 'Driver',
                    ]);
                }
            }
        }

        return $provider;
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('provider');
    }
}
