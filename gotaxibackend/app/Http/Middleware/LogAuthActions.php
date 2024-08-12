<?php
namespace App\Http\Middleware;

use Closure;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;

class LogAuthActions
{
    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::guard('admin')->check()) {
            $this->logService->log('login', 'User logged in.');
        } else {
            $this->logService->log('logout', 'User logged out.');
        }

        return $response;
    }
}
