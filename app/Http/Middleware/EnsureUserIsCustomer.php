<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsCustomer
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('nguoidung');

        if (!$user || ($user['role_id'] ?? null) != 2) {
            abort(403);
        }

        return $next($request);
    }
}
