<?php

namespace App\Http\Controllers;

use App\VerificationCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use anlutro\LaravelSettings\Facade as Setting;

class TwilioController extends Controller
{

    public function sendOTP(Request $request)
    {

        try {
            $otp = rand(111111, 999999);
            $message = "Your OTP for account verification is: " . $otp;
            $receiverNumber = $request->phone_number;

            $verificationCode = VerificationCode::where('phone_number', $receiverNumber)->delete();
            VerificationCode::create([
                'phone_number' => $receiverNumber,
                'otp' => $otp,
            ]);

            $this->sendSMS($receiverNumber, $message);

            $responseArray['status'] = 200;
            $responseArray['message'] = 'OTP sent successfully!';

            return $responseArray;

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }

    }

    // public function resendOTP(Request $request) {

    //     try {
    //         $otp = rand(111111,999999);
    //         $message = "Your OTP for account verification is: " . $otp;
    //         $receiverNumber = $request->phone_number;

    //         $verificationCode = VerificationCode::where('phone_number', $receiverNumber)->delete();
    //         VerificationCode::create([
    //             'phone_number' => $receiverNumber,
    //             'otp' => $otp,
    //         ]);

    //         $this->sendSMS($receiverNumber, $message);

    //         $responseArray['status'] = 200;
    //         $responseArray['message'] = 'OTP sent successfully!';

    //         return $responseArray;

    //     } catch (\Exception $e) {
    //         return response()->json(['error' => trans('api.something_went_wrong')], 500);

    //     }

    // }

    public function verifyOTP(Request $request)
    {
        try {

            $otp = $request->otp;
            $receiverNumber = $request->phone_number;

            $count = VerificationCode::where('phone_number', $receiverNumber)->where('otp', $otp)->count();

            if ($count > 0) {
                VerificationCode::where('phone_number', $receiverNumber)->delete();
                $responseArray['status'] = 200;
                $responseArray['message'] = 'OTP verified successfully!';
            } else {
                $responseArray['status'] = 401;
                $responseArray['message'] = 'OTP is invalid!';
            }

            return $responseArray;

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }
    }

    public function sendSMS($receiverNumber, $message)
    {

        try {
            $account_sid = Setting::get('twilio_sid');
            $auth_token = Setting::get('twilio_token');
            $twilio_number = Setting::get('twilio_from');

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message]);

            return true;

        } catch (Exception $e) {
            return false;

        }
    }

    public function sendTestSMS($receiverNumber, $message)
    {

        try {
            $account_sid = Setting::get('twilio_sid');
            $auth_token = Setting::get('twilio_token');
            $twilio_number = Setting::get('twilio_from');

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message]);

            return true;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function sendUserOTP()
    {
        try {

            $user = Auth::guard('web')->user();

            if (Setting::get('twilio_verification', 0) == 1) {
                $receiverNumber = $user->mobile;

                $count = VerificationCode::where('phone_number', $receiverNumber)->count();
                if ($count <= 0) {
                    $otp = rand(111111, 999999);
                    $message = "Your OTP for account verification is: " . $otp;
                    $verificationCode = VerificationCode::where('phone_number', $receiverNumber)->delete();
                    VerificationCode::create([
                        'phone_number' => $receiverNumber,
                        'otp' => $otp,
                    ]);
                    $this->sendSMS($receiverNumber, $message);
                }
                return view('user.auth.verify', compact('user'));
            } else {
                return view('user.auth.verify', compact('user'));
            }

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }
    }

    public function verifyUserOTP(Request $request)
    {
        try {
            $user = Auth::guard('web')->user();

            if (Setting::get('twilio_verification', 0) == 1) {
                $otp = $request->otp;
                $receiverNumber = $user->mobile;

                $count = VerificationCode::where('phone_number', $receiverNumber)->where('otp', $otp)->count();

                if ($count > 0) {
                    $user->is_verified = 1;
                    $user->save();
                    VerificationCode::where('phone_number', $receiverNumber)->delete();
                    return redirect('/dashboard');
                } else {
                    return back()->with('flash_error', 'Your OTP is invalid!');
                }
            } else {
                $user->is_verified = 1;
                $user->save();
                return redirect('/dashboard');
            }

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);

        }
    }

    public function sendProviderOTP()
    {
        try {

            $provider = Auth::guard('provider')->user();

            if (Setting::get('twilio_verification', 0) == 1) {
                $receiverNumber = $provider->mobile;

                $count = VerificationCode::where('phone_number', $receiverNumber)->count();
                if ($count <= 0) {
                    $otp = rand(111111, 999999);
                    $message = "Your OTP for account verification is: " . $otp;
                    $verificationCode = VerificationCode::where('phone_number', $receiverNumber)->delete();
                    VerificationCode::create([
                        'phone_number' => $receiverNumber,
                        'otp' => $otp,
                    ]);
                    $this->sendSMS($receiverNumber, $message);
                }

                return view('provider.auth.verify', compact('provider'));
            } else {
                return view('provider.auth.verify', compact('provider'));
            }


        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);

        }
    }

    public function verifyProviderOTP(Request $request)
    {
        try {

            $provider = Auth::guard('provider')->user();

            if (Setting::get('twilio_verification', 0) == 1) {
                $otp = $request->otp;
                $receiverNumber = $provider->mobile;

                $count = VerificationCode::where('phone_number', $receiverNumber)->where('otp', $otp)->count();

                if ($count > 0) {
                    $provider->is_verified = 1;
                    $provider->save();
                    VerificationCode::where('phone_number', $receiverNumber)->delete();
                    return redirect('/provider');
                } else {
                    return back()->with('flash_error', 'Your OTP is invalid!');
                }
            } else {
                $provider->is_verified = 1;
                $provider->save();
                return redirect('/provider');
            }

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);

        }
    }
}
