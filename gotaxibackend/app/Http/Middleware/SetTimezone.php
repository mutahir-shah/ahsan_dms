<?php

namespace App\Http\Middleware;

use Closure;
use anlutro\LaravelSettings\Facade as Setting;

class SetTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Fetch timezone from settings or default to UTC
        $timezone = Setting::get('timezone', 'UTC');

        // Set application timezone
        config(['app.timezone' => $timezone]);

        // Set PHP timezone
        date_default_timezone_set($timezone);
        return $next($request);
    }
}
