<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TwilioController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\VerificationCode;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Response;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function setPhonePasswordResetForm()
    {
        return view('user.auth.passwords.reset_phone');
    }


    public function sendPasswordResetOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        $otp = rand(111111, 999999);
        $message = "Your OTP for password reset is: " . $otp;
        $receiverNumber = $request->phone;

        $verificationCode = VerificationCode::where('phone_number', $receiverNumber)->delete();
        VerificationCode::create([
            'phone_number' => $receiverNumber,
            'otp' => $otp,
        ]);

        (new TwilioController)->sendSMS($receiverNumber, $message);

        session()->put('phone', $request->phone);

        return redirect()->route('get-password-reset-form');
    }

    public function resetPasswordFromOTP()
    {
        request()->validate([
            'otp' => 'required|numeric',
            'password' => 'required|min:8|confirmed'
        ]);

        $phone = session()->get('phone');
        $otp = request()->otp;

        if ($phone) {
            $user = User::where('mobile', $phone)->first();
            $otp_verified = $user && VerificationCode::where('phone_number', $phone)
                ->where('otp', $otp)->exists();

            if ($otp_verified) {
                $user->update([
                    'password' => Hash::make(request()->password)
                ]);
                auth()->login($user);
                VerificationCode::where('phone_number', $phone)->delete();

                return redirect('/dashboard');
            }

            throw ValidationException::withMessages([
                'otp' => 'The OTP is not correct.',
            ]);
        }

        return redirect('/password/reset');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return Response
     */
    public function showLinkRequestForm()
    {
        return view('user.auth.passwords.email');
    }
}
