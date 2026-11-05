<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Jangan log request AJAX wilayah biar tidak penuh
        if ($request->is('wilayah/*')) {
            return $response;
        }

        UserLog::create([
            'user_id' => Auth::id(),
            'action' => $request->route() ? $request->route()->getName() : null,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return $response;
    }
}
