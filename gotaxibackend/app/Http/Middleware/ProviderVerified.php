<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Setting;

class ProviderVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 'verification' for firebase & 'twilio_verification' for twilio
        if (Setting::get('verification', 0) == 1 || Setting::get('twilio_verification', 0) == 1) {

            $url = $request->url();

            if (strpos($url, 'verification') == false && Auth::guard('provider')->check() && Auth::guard('provider')->user()->is_verified == null || Auth::guard('provider')->user()->is_verified == "0") {
                return redirect('/provider/verification');
            } else if (strpos($url, 'verification') == true) {
                return redirect('/provider');
            }

        }

        return $next($request);
    }
}
