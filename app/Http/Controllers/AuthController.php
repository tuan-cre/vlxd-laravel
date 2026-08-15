<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $user = DB::table('users')
            ->where('email', $request->email)
            ->where('password', md5($request->password))
            ->where('status', 1)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không đúng.',
            ])->onlyInput('email');
        }

        Session::put('nguoidung', $user);

        switch ($user->role_id) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 3:
                return redirect()->route('admin.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    public function register(RegisterRequest $request)
    {
        DB::transaction(function () use ($request) {
            $userId = DB::table('users')->insertGetId([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => md5($request->password),
                'role_id' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('customers')->insert([
                'user_id' => $userId,
                'role_id' => 2,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'loyalty_points' => 0,
                'total_spent' => 0,
                'total_orders' => 0,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        $user = DB::table('users')
            ->where('email', $request->email)
            ->where('password', md5($request->password))
            ->first();

        Session::put('nguoidung', $user);

        return redirect()->route('home');
    }

    public function logout()
    {
        Session::flush();

        return redirect()->route('home');
    }
}
