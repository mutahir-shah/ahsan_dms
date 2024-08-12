<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\OTPVerificationController;
use App\Models\BusinessSetting;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\AppEmailVerificationNotification;
use Illuminate\Support\Facades\Http;
use Hash;


class AuthController extends Controller
{
    private function send_otp($phone_number, $otp)
    {
        $msegat_send_msg_url = 'https://www.msegat.com/gw/sendsms.php';
        Http::post($msegat_send_msg_url, [
            "userName" => env("MSEGAT_USERNAME"),
            "userSender" => env("MSEGAT_SENDER"),
            "apiKey" => env("MSEGAT_API_KEY"),
            "numbers" => $phone_number,
            "msg" => "Your verification code for cloudmart is $otp"
        ]);
    }

    private function generateOTP()
    {
        return str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function signup(Request $request)
    {
        if (User::where('phone', $request->phone)->first() != null) {
            return response()->json([
                'result' => false,
                'message' => translate('User already exists.'),
                'user_id' => 0
            ], 201);
        }

        $otp = $this->generateOTP();
        $user = new User([
            'name' => $request->name,
            'phone' => $request->phone,
            'verification_code' => $otp
        ]);
        $user->save();

        $this->send_otp($request->phone, $otp);

        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();

        //create token
        $user->createToken('tokens')->plainTextToken;

        return response()->json([
            'result' => true,
            'message' => translate('Registration Successful. Please verify and log in to your account.'),
            'user_id' => $user->id
        ], 201);
    }

    public function resendCode(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if ($user !== null) {
            $otp = $this->generateOTP();
            $user->verification_code = $otp;
            $user->save();

            $this->send_otp($request->number, $otp);
        }

        return response()->json([
            'result' => true,
            'message' => translate('Verification code is sent again'),
        ], 200);
    }

    public function confirmCode(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        $verification_code_match = $user != null &&  $user->verification_code == $request->verification_code;

        if ($verification_code_match) {
            $user->verification_code = null;
            $user->save();

            return $this->loginSuccess($user);
        }

        return response()->json([
            'result' => false,
            'message' => translate('Code does not match, you can request for resending the code'),
        ], 200);
    }

    public function login(Request $request)
    {
        /*$request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);*/

        $delivery_boy_condition = $request->has('user_type') && $request->user_type == 'delivery_boy';

        if ($delivery_boy_condition) {
            $user = User::whereIn('user_type', ['delivery_boy'])->where('phone', $request->phone)->first();
        } else {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('phone', $request->phone)->first();
        }

        if (!$user) {
             return response()->json([
                'result' => false,
                'message' => translate('Invalid credentials.')
            ], 400);
        }

        // if (!$delivery_boy_condition) {
        //     if (\App\Utility\PayhereUtility::create_wallet_reference($request->identity_matrix) == false) {
        //         return response()->json(['result' => false, 'message' => 'Identity matrix error', 'user' => null], 401);
        //     }
        // }

        $otp = $this->generateOTP();

        $user->verification_code = $otp;
        $user->save();

        $this->send_otp($user->phone, $otp);

        $user->createToken('tokens')->plainTextToken;

        return response()->json([
            'result' => true,
            'message' => translate('Successfully logged in'),
            'user_id' => $user->id
        ], 200);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'result' => true,
            'message' => translate('Successfully logged out')
        ]);
    }

    public function socialLogin(Request $request)
    {
        if (!$request->provider) {
            return response()->json([
                'result' => false,
                'message' => translate('User not found'),
                'user' => null
            ]);
        }

        $existingUserByProviderId = User::where('provider_id', $request->provider)->first();

        if ($existingUserByProviderId) {
            return $this->loginSuccess($existingUserByProviderId);
        } else {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'provider_id' => $request->provider,
                'email_verified_at' => Carbon::now()
            ]);
            $user->save();
            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->save();
        }
        return $this->loginSuccess($user);
    }

    protected function loginSuccess($user)
    {
        $token = $user->createToken('API Token')->plainTextToken;
        return response()->json([
            'result' => true,
            'message' => translate('Successfully logged in'),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => null,
            'user' => [
                'id' => $user->id,
                'type' => $user->user_type,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'avatar_original' => api_asset($user->avatar_original),
                'phone' => $user->phone
            ]
        ]);
    }
}
