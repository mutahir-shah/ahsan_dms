<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminProtectOTP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!session()->has('admin_otp')){
            return redirect('/admin/dashboard');
        }
        return $next($request);
    }
}