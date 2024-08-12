<?php 

namespace App\Services;

use App\Log;
use Illuminate\Support\Facades\Auth;

class LogService
{
    public function log( $module, $type ,$action, $payload = null, $description = null)
    {
        Log::create([
            'user_id' => Auth::guard('admin')->check() ? Auth::guard('admin')->id() : null,
            'module' => $module,
            'type' => $type,
            'action' => $action,
            'description' => $description,
            'payload' => $payload,
        ]);
    }
}
