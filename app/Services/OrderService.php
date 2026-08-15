<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderInventory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderService
{
    protected CartService $cartService;
    protected CouponService $couponService;

    public function __construct(CartService $cartService, CouponService $couponService)
    {
        $this->cartService = $cartService;
        $this->couponService = $couponService;
    }

    public function createOrder(array $data, array $cartItems, int $customerId): Order
    {
        return DB::transaction(function () use ($data, $cartItems, $customerId) {
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['subtotal'];
            }

            $couponId = null;
            $discountAmount = 0;
            $appliedCoupon = Session::get('applied_coupon');

            if ($appliedCoupon) {
                $couponId = $appliedCoupon['id'];
                $discountAmount = $this->couponService->calculateDiscount(
                    (object) $appliedCoupon,
                    $subtotal
                );
            }

            $shippingFee = (float) ($data['shipping_fee'] ?? 0);
            $totalMoney = max(0, $subtotal - $discountAmount + $shippingFee);

            $earnedPoints = (int) floor($totalMoney / 10000);

            $order = Order::create([
                'customer_id' => $customerId,
                'fullname' => $data['fullname'],
                'phone_number' => $data['phone_number'],
                'address' => $data['address'],
                'note' => $data['note'] ?? null,
                'order_date' => now(),
                'status' => 1,
                'payment_method' => $data['payment_method'] ?? 'COD',
                'payment_status' => 0,
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discountAmount,
                'total_money' => $totalMoney,
                'stock_applied' => 1,
                'coupon_id' => $couponId,
                'earned_points' => $earnedPoints,
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'price' => $item['effective_price'],
                    'num' => $item['quantity'],
                    'total_money' => $item['subtotal'],
                ]);

                $this->allocateInventory($order->id, $item['product_id'], $item['quantity']);
            }

            if ($couponId) {
                $this->applyCoupon($couponId, $customerId);
            }

            $this->updateCustomerStats($customerId, $totalMoney, $earnedPoints);

            Session::forget('applied_coupon');

            return $order->fresh(['details', 'customer']);
        });
    }

    protected function allocateInventory(int $orderId, int $productId, int $quantity): void
    {
        $remaining = $quantity;

        $inventoryRows = Inventory::where('product_id', $productId)
            ->where('stock', '>', 0)
            ->lockForUpdate()
            ->orderBy('id')
            ->get();

        foreach ($inventoryRows as $inventory) {
            if ($remaining <= 0) {
                break;
            }

            $allocate = min($remaining, $inventory->stock);

            $inventory->decrement('stock', $allocate);

            OrderInventory::create([
                'order_id' => $orderId,
                'product_id' => $productId,
                'warehouse_id' => $inventory->warehouse_id,
                'quantity' => $allocate,
            ]);

            $remaining -= $allocate;
        }

        if ($remaining > 0) {
            $product = Product::findOrFail($productId);
            $product->increment('stock', $remaining);
        }
    }

    protected function applyCoupon(int $couponId, int $customerId): void
    {
        DB::table('coupons')
            ->where('id', $couponId)
            ->decrement('usage_limit');

        DB::table('customer_coupons')
            ->where('coupon_id', $couponId)
            ->where('customer_id', $customerId)
            ->delete();
    }

    protected function updateCustomerStats(int $customerId, float $totalMoney, int $earnedPoints): void
    {
        $customer = Customer::findOrFail($customerId);

        $customer->increment('total_spent', $totalMoney);
        $customer->increment('total_orders');
        $customer->increment('loyalty_points', $earnedPoints);
        $customer->update(['last_order_date' => now()]);

        $this->updateMemberLevel($customer);
    }

    protected function updateMemberLevel(Customer $customer): void
    {
        $totalSpent = (float) $customer->total_spent;

        $level = 'bronze';
        if ($totalSpent >= 50000000) {
            $level = 'platinum';
        } elseif ($totalSpent >= 20000000) {
            $level = 'gold';
        } elseif ($totalSpent >= 5000000) {
            $level = 'silver';
        }

        if ($customer->member_level !== $level) {
            $customer->update(['member_level' => $level]);
        }
    }

    public function cancelOrder(int $orderId): Order
    {
        return DB::transaction(function () use ($orderId) {
            $order = Order::with(['details', 'orderInventories'])->findOrFail($orderId);

            if ($order->status === 4) {
                throw new \Exception('Đơn hàng đã bị hủy.');
            }

            foreach ($order->orderInventories as $oi) {
                Inventory::where('product_id', $oi->product_id)
                    ->where('warehouse_id', $oi->warehouse_id)
                    ->increment('stock', $oi->quantity);
            }

            if ($order->coupon_id) {
                DB::table('coupons')
                    ->where('id', $order->coupon_id)
                    ->increment('usage_limit');

                DB::table('customer_coupons')->insert([
                    'customer_id' => $order->customer_id,
                    'coupon_id' => $order->coupon_id,
                    'created_at' => now(),
                ]);
            }

            $customer = Customer::findOrFail($order->customer_id);
            $customer->decrement('total_spent', $order->total_money);
            $customer->decrement('total_orders');
            $customer->decrement('loyalty_points', $order->earned_points);

            $this->updateMemberLevel($customer);

            $order->update(['status' => 4]);

            return $order->fresh(['details', 'customer']);
        });
    }

    public function getOrderWithDetails(int $orderId): Order
    {
        return Order::with([
            'details.product',
            'customer',
            'coupon',
            'orderInventories.warehouse',
        ])->findOrFail($orderId);
    }
}
