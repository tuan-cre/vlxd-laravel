<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthService
{
    public function login(string $email, string $password): ?User
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return null;
        }

        $hashedInput = md5($password);

        if ($user->password !== $hashedInput) {
            return null;
        }

        if ($user->status !== 1) {
            return null;
        }

        Session::put('user_id', $user->id);

        return $user;
    }

    public function register(array $data): User
    {
        $user = User::create([
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'password' => md5($data['password']),
            'role_id' => 2,
            'status' => 1,
        ]);

        Customer::create([
            'user_id' => $user->id,
            'role_id' => 2,
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'] ?? '',
            'address' => $data['address'] ?? '',
            'member_level' => 'bronze',
            'loyalty_points' => 0,
            'total_spent' => 0,
            'total_orders' => 0,
            'status' => 1,
        ]);

        Session::put('user_id', $user->id);

        return $user;
    }

    public function getCurrentUser(): ?User
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return null;
        }

        return User::with('role')->find($userId);
    }

    public function logout(): void
    {
        Session::forget('user_id');
        Session::forget('giohang');
        Session::forget('applied_coupon');
    }

    public function isAdmin(): bool
    {
        $user = $this->getCurrentUser();
        return $user && $user->role_id === 1;
    }

    public function isStaff(): bool
    {
        $user = $this->getCurrentUser();
        return $user && $user->role_id === 3;
    }

    public function isCustomer(): bool
    {
        $user = $this->getCurrentUser();
        return $user && $user->role_id === 2;
    }
}
