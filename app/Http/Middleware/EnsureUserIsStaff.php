<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsStaff
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('nguoidung');

        if (!$user || !in_array($user['role_id'] ?? null, [1, 3])) {
            abort(403);
        }

        return $next($request);
    }
}
