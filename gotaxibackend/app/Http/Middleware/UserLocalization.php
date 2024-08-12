<?php

namespace App\Http\Middleware;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserLocalization
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
        $userLocale = User::where('id', Auth::user()->id)->get(['language'])->first();
        if ($userLocale) {
            App::setLocale($userLocale->language);
        } else {
            App::setLocale('en');
        }

        return $next($request);
    }
}
