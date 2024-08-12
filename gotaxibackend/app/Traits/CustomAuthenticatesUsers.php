<?php 
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Jobs\SendOtpEmailJob;
use App\Mail\SendOtpEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers as BaseAuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use anlutro\LaravelSettings\Facade as Setting;
use App\Log;
trait CustomAuthenticatesUsers
{
     use BaseAuthenticatesUsers {
        sendLoginResponse as protected traitSendLoginResponse;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        // Custom logic here
        $user = $this->guard()->user();
        $otp = random_int(100000, 999999);
        $user->otp = $otp;
        $user->save();

        $guards = [
            'admin' => 'admin_otp',
            'account' => 'account_otp',
            'fleet' => 'fleet_otp',
            'dispatcher' => 'dispatcher_otp',
        ];

        Log::create([
            'user_id' => $user->id,
            'module' => 'Authentication',
            'type' => 'Login',
            'action' => 'User Logged In.',
            'description' => '',
            'payload' => $user,
        ]);

        foreach ($guards as $guard => $sessionKey) {
            if (Setting::get($guard.'_login_otp', 0) == 1 && auth()->guard($guard)->check()) {
                session()->put($sessionKey, true);
                Bus::dispatch(new SendOtpEmailJob($user->email, $otp));
            }else{
                session()->pull($sessionKey);
            }
        }

        return $this->traitSendLoginResponse($request);
        
    }
}