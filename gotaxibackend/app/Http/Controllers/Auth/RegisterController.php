<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use anlutro\LaravelSettings\Facade as Setting;

use App\Provider;
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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return Response
     */
    public function showRegistrationForm()
    {
        $zones = Zones::where('status', 'active')->get();

        return view('user.auth.register', compact('zones'));
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
            'phone_number' => 'required|regex:/[+][0-9 ]{10,15}/|min:10|max:15|unique:users,mobile',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'gender' => $data['gender'] ?: null,
            'gender_pref' => Setting::get('gender_pref_enabled', 0) == 1 ? $data['gender_pref'] : null,
            'mobile' => str_replace(' ', '', $data['phone_number']),
            'password' => bcrypt($data['password']),
            'payment_mode' => 'CASH',
            'zone_id' => isset($data['zone_id']) ? $data['zone_id'] : 0,
            'dob' => isset($data['dob']) ? $data['dob']: null,
            'address' => isset($data['address']) ? $data['address']: null,
        ]);

        $newCreatedUserId = $user->id;
        if (Setting::get('user_referral') == 1) {
            $referral_code = strtoupper($data['referral_code']);
            if ($referral_code != $user->referral_code) {
                $providerReferral = Provider::where('referral_code', $referral_code)->get(['id'])->first(); 
                $userReferral = User::where('referral_code', $referral_code)->get(['id'])->first();
                
                if ($providerReferral) {
                    $provider = Provider::find($providerReferral->id);
                    $provider->user_referral_count = $provider->user_referral_count + 1;
                    $provider->save();

                    ProviderReferral::create([
                        'provider_id' => $provider->id,
                        'reffered_id' => $newCreatedUserId, // new created user
                        'type' => 'User',
                    ]);
                }
                if ($userReferral) {
                    if ($userReferral->id != $newCreatedUserId) {
                        $user = User::find($user->id);
                        $user->user_referral_count = $user->user_referral_count + 1;
                        $user->save();

                        UserReferral::create([
                            'user_id' => $user->id,
                            'reffered_id' => $newCreatedUserId, // new created user
                            'type' => 'User',
                        ]);
                    }
                }
            }
        }

        return $user;
        // send welcome email here
    }
}
