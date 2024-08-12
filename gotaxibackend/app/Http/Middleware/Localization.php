<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Setting;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            $systemLocale = Setting::get('website_languages', '');
            if ($systemLocale != '') {
                Session::put('locale', $systemLocale);
                App::setLocale($systemLocale);
            }
        }
        
        return $next($request);
    }
}
