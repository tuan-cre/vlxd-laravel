<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', '!=', 5)->sum('total_money');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 1)->count();
        $totalProducts = Product::where('status', 1)->count();

        $recentOrders = Order::with('customer')
            ->latest('order_date')
            ->limit(10)
            ->get();

        $lowStockProducts = Product::where('status', 1)
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        $revenueTrend = Order::where('status', '!=', 5)
            ->where('order_date', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('SUM(total_money) as revenue')
            )
            ->groupBy(DB::raw('DATE(order_date)'))
            ->orderBy('date')
            ->get();

        $totalCustomers = Customer::count();
        $newOrdersToday = Order::whereDate('order_date', today())->count();
        $revenueToday = Order::whereDate('order_date', today())
            ->where('status', '!=', 5)
            ->sum('total_money');

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'pendingOrders',
            'totalProducts',
            'recentOrders',
            'lowStockProducts',
            'revenueTrend',
            'totalCustomers',
            'newOrdersToday',
            'revenueToday'
        ));
    }
}
