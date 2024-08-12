<?php

namespace App\Http\Middleware;

use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Closure;
use Illuminate\Support\Facades\Auth;

class DriverLocalization
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
        $driverLocale = Provider::where('id', Auth::user()->id)->get(['language'])->first();
        if ($driverLocale) {
            App::setLocale($driverLocale->language);
        } else {
            App::setLocale('en');
        }

        return $next($request);
    }
}
