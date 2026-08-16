<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function index()
    {
        $nguoidung = Session::get('nguoidung');

        if (!$nguoidung) {
            return redirect()->route('login');
        }

        $user = Customer::where('user_id', $nguoidung['id'])->first();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('account.index', compact('user'));
    }

    public function update(Request $request)
    {
        $nguoidung = Session::get('nguoidung');

        if (!$nguoidung) {
            return redirect()->route('login');
        }

        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $customer = Customer::where('user_id', $nguoidung['id'])->first();

        if ($customer) {
            $data = $request->only(['fullname', 'phone_number', 'address', 'birthday', 'gender']);

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/avatars'), $filename);
                $data['avatar'] = 'uploads/avatars/' . $filename;
            }

            $customer->update($data);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function addresses()
    {
        $nguoidung = Session::get('nguoidung');

        if (!$nguoidung) {
            return redirect()->route('login');
        }

        $customer = Customer::where('user_id', $nguoidung['id'])->first();
        $addresses = $customer ? $customer->addresses()->get() : [];

        return view('account.addresses', compact('addresses'));
    }

    public function orders()
    {
        $nguoidung = Session::get('nguoidung');

        if (!$nguoidung) {
            return redirect()->route('login');
        }

        $customer = Customer::where('user_id', $nguoidung['id'])->first();

        $orders = $customer
            ? $customer->orders()->with('details.product')->latest('order_date')->paginate(10)
            : collect();

        return view('account.orders', compact('orders'));
    }

    public function points()
    {
        $nguoidung = Session::get('nguoidung');

        if (!$nguoidung) {
            return redirect()->route('login');
        }

        $customer = Customer::where('user_id', $nguoidung['id'])->first();
        $points = $customer ? $customer->loyalty_points : 0;
        $memberLevel = $customer ? $customer->member_level : 'bronze';

        return view('account.points', compact('points', 'memberLevel'));
    }
}
