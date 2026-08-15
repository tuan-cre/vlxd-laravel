<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('nguoidung') || Auth::check()) {
            return $next($request);
        }

        session(['redirect_after_login' => $request->url()]);

        return redirect()->route('login');
    }
}
