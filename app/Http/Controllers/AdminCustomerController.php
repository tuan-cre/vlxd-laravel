<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('addresses');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('fullname', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('phone_number', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query->latest()->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = Customer::with([
            'addresses',
            'orders' => function ($q) {
                $q->latest('order_date')->limit(20);
            },
            'coupons',
        ])->findOrFail($id);

        $totalOrders = $customer->orders()->count();
        $totalSpent = $customer->orders()
            ->where('status', '!=', 5)
            ->sum('total_money');

        return view('admin.customers.show', compact('customer', 'totalOrders', 'totalSpent'));
    }
}
