<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use Closure;
use Illuminate\Http\Request;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $operation, $name)
    {

        if(Helper::CheckPermission($name, $operation) == 1)
        {
            return $next($request);
        }
        abort(404);
    }
}
