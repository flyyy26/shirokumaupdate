<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Jika belum login → redirect ke login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Jika role tidak sesuai → tampilkan 404
        if (!in_array(auth()->user()->role, $roles)) {
            abort(404);
        }

        return $next($request);
    }
}