<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Setting;

class DemoModeMiddleware
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
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at meemcolart@gmail.com');
        }
        return $next($request);
    }
}
