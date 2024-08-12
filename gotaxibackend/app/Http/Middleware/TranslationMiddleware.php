<?php

namespace App\Http\Middleware;

use App\Language;
use Closure;

class TranslationMiddleware
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
        if (!session()->has('translation')) {
            $language_id = Language::where('is_default', 1)->pluck('id')->first();
            session()->put('translation', $language_id);
        }

        return $next($request);
    }
}
