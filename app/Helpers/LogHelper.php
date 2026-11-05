<?php

namespace App\Helpers;

use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function log($action, $description = null)
    {
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'method' => request()->method(),
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'description' => $description
        ]);
    }
}