<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->date_to ?? now()->format('Y-m-d');

        $revenue = Order::where('status', '!=', 5)
            ->whereDate('order_date', '>=', $dateFrom)
            ->whereDate('order_date', '<=', $dateTo)
            ->sum('total_money');

        $orderCount = Order::whereDate('order_date', '>=', $dateFrom)
            ->whereDate('order_date', '<=', $dateTo)
            ->count();

        $completedOrders = Order::where('status', 4)
            ->whereDate('order_date', '>=', $dateFrom)
            ->whereDate('order_date', '<=', $dateTo)
            ->count();

        $cancelledOrders = Order::where('status', 5)
            ->whereDate('order_date', '>=', $dateFrom)
            ->whereDate('order_date', '<=', $dateTo)
            ->count();

        $dailyRevenue = Order::where('status', '!=', 5)
            ->whereDate('order_date', '>=', $dateFrom)
            ->whereDate('order_date', '<=', $dateTo)
            ->select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('SUM(total_money) as revenue'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy(DB::raw('DATE(order_date)'))
            ->orderBy('date')
            ->get();

        $topProducts = OrderDetail::whereHas('order', function ($q) use ($dateFrom, $dateTo) {
                $q->where('status', '!=', 5)
                  ->whereDate('order_date', '>=', $dateFrom)
                  ->whereDate('order_date', '<=', $dateTo);
            })
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(order_details.num) as total_quantity'),
                DB::raw('SUM(order_details.total_money) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        $categoryRevenue = OrderDetail::whereHas('order', function ($q) use ($dateFrom, $dateTo) {
                $q->where('status', '!=', 5)
                  ->whereDate('order_date', '>=', $dateFrom)
                  ->whereDate('order_date', '<=', $dateTo);
            })
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category_name',
                DB::raw('SUM(order_details.total_money) as revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('revenue', 'desc')
            ->get();

        return view('admin.reports.index', compact(
            'revenue', 'orderCount', 'completedOrders', 'cancelledOrders',
            'dailyRevenue', 'topProducts', 'categoryRevenue',
            'dateFrom', 'dateTo'
        ));
    }

    public function export(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->date_to ?? now()->format('Y-m-d');

        $orders = Order::with(['details.product', 'customer'])
            ->where('status', '!=', 5)
            ->whereDate('order_date', '>=', $dateFrom)
            ->whereDate('order_date', '<=', $dateTo)
            ->get();

        $csvContent = "Mã đơn,Họ tên,SĐT,Địa chỉ,Ngày đặt,Tổng tiền,Trạng thái\n";

        foreach ($orders as $order) {
            $statusText = match($order->status) {
                1 => 'Chờ xử lý',
                2 => 'Đã xác nhận',
                3 => 'Đang giao',
                4 => 'Hoàn thành',
                default => 'Không xác định',
            };

            $csvContent .= sprintf(
                "%d,%s,%s,%s,%s,%s,%s\n",
                $order->id,
                '"' . str_replace('"', '""', $order->fullname) . '"',
                $order->phone_number,
                '"' . str_replace('"', '""', $order->address) . '"',
                $order->order_date->format('d/m/Y'),
                $order->total_money,
                $statusText
            );
        }

        $filename = "bao_cao_don_hang_{$dateFrom}_{$dateTo}.csv";

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
