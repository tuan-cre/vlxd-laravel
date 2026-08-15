<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderInventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('fullname', 'like', "%{$keyword}%")
                  ->orWhere('phone_number', 'like', "%{$keyword}%")
                  ->orWhere('id', $keyword);
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        $orders = $query->latest('order_date')->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with([
            'customer',
            'coupon',
            'details.product',
            'orderInventories.warehouse',
        ])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:1,2,3,4,5',
        ]);

        $order = Order::findOrFail($id);
        $newStatus = $request->status;

        DB::transaction(function () use ($order, $newStatus) {
            $oldStatus = $order->status;

            if ($newStatus == 2 && !$order->stock_applied) {
                $details = OrderDetail::where('order_id', $order->id)->get();

                foreach ($details as $detail) {
                    $product = Product::find($detail->product_id);
                    if (!$product) continue;

                    $remainingQty = $detail->num;

                    $inventories = Inventory::where('product_id', $detail->product_id)
                        ->where('stock', '>', 0)
                        ->orderBy('stock', 'desc')
                        ->get();

                    foreach ($inventories as $inventory) {
                        if ($remainingQty <= 0) break;

                        $deduct = min($inventory->stock, $remainingQty);

                        Inventory::where('id', $inventory->id)->decrement('stock', $deduct);

                        OrderInventory::create([
                            'order_id' => $order->id,
                            'product_id' => $detail->product_id,
                            'warehouse_id' => $inventory->warehouse_id,
                            'quantity' => $deduct,
                        ]);

                        $remainingQty -= $deduct;
                    }
                }

                Order::where('id', $order->id)->update(['stock_applied' => 1]);
            }

            if ($newStatus == 5 && $oldStatus != 5) {
                $orderInventories = OrderInventory::where('order_id', $order->id)->get();

                foreach ($orderInventories as $oi) {
                    Inventory::where('product_id', $oi->product_id)
                        ->where('warehouse_id', $oi->warehouse_id)
                        ->increment('stock', $oi->quantity);
                }

                $details = OrderDetail::where('order_id', $order->id)->get();
                foreach ($details as $detail) {
                    Product::where('id', $detail->product_id)->increment('stock', $detail->num);
                }

                Order::where('id', $order->id)->update(['stock_applied' => 0]);
            }

            Order::where('id', $order->id)->update(['status' => $newStatus]);
        });

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}
