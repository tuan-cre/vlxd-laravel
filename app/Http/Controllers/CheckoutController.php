<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('giohang', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::with(['images', 'category', 'brand'])
                ->where('id', $productId)
                ->where('status', 1)
                ->first();

            if ($product) {
                $itemTotal = ($product->sale_price ?? $product->price) * $quantity;
                $total += $itemTotal;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'item_total' => $itemTotal,
                ];
            }
        }

        $customer = null;
        $addresses = [];
        $nguoidung = Session::get('nguoidung');

        if ($nguoidung && $nguoidung->role_id == 2) {
            $customer = Customer::where('user_id', $nguoidung->id)->first();
            if ($customer) {
                $addresses = $customer->addresses()->get();
            }
        }

        $couponDiscount = Session::get('coupon_discount', 0);
        $couponCode = Session::get('coupon_code', null);
        $shippingFee = 0;
        $grandTotal = $total - $couponDiscount + $shippingFee;

        return view('cart.checkout', compact(
            'cartItems', 'total', 'couponDiscount', 'couponCode',
            'shippingFee', 'grandTotal', 'customer', 'addresses'
        ));
    }

    public function store(StoreOrderRequest $request)
    {
        $cart = Session::get('giohang', []);

        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống.');
        }

        DB::transaction(function () use ($request, $cart) {
            $nguoidung = Session::get('nguoidung');
            $customerId = null;

            if ($nguoidung && $nguoidung->role_id == 2) {
                $customer = Customer::where('user_id', $nguoidung->id)->first();
                $customerId = $customer?->id;
            }

            $subtotal = 0;
            foreach ($cart as $productId => $quantity) {
                $product = Product::where('id', $productId)->where('status', 1)->first();
                if ($product) {
                    $price = $product->sale_price ?? $product->price;
                    $subtotal += $price * $quantity;
                }
            }

            $couponId = null;
            $discountAmount = Session::get('coupon_discount', 0);
            $couponCode = Session::get('coupon_code');

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                if ($coupon) {
                    $couponId = $coupon->id;
                }
            }

            $shippingFee = 0;
            $grandTotal = $subtotal - $discountAmount + $shippingFee;
            $earnedPoints = floor($grandTotal / 10000);

            $orderId = DB::table('orders')->insertGetId([
                'customer_id' => $customerId,
                'fullname' => $request->fullname,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'note' => $request->note,
                'order_date' => now(),
                'status' => 1,
                'payment_method' => $request->payment_method,
                'payment_status' => 0,
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discountAmount,
                'total_money' => $grandTotal,
                'stock_applied' => 0,
                'coupon_id' => $couponId,
                'earned_points' => $earnedPoints,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($cart as $productId => $quantity) {
                $product = Product::where('id', $productId)->where('status', 1)->first();

                if ($product) {
                    $price = $product->sale_price ?? $product->price;
                    $totalMoney = $price * $quantity;

                    DB::table('order_details')->insert([
                        'order_id' => $orderId,
                        'product_id' => $productId,
                        'price' => $price,
                        'num' => $quantity,
                        'total_money' => $totalMoney,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    Product::where('id', $productId)->decrement('stock', $quantity);
                }
            }

            if ($customerId) {
                Customer::where('id', $customerId)->increment('loyalty_points', $earnedPoints);
                Customer::where('id', $customerId)->increment('total_orders');
                Customer::where('id', $customerId)->increment('total_spent', $grandTotal);
                Customer::where('id', $customerId)->update(['last_order_date' => now()]);
            }

            if ($couponId) {
                $coupon = Coupon::find($couponId);
                if ($coupon && $coupon->usage_limit) {
                    Coupon::where('id', $couponId)->decrement('usage_limit');
                }
            }
        });

        Session::forget('giohang');
        Session::forget('coupon_code');
        Session::forget('coupon_discount');

        $orderId = DB::table('orders')->latest('id')->first()->id;

        return redirect()->route('checkout.success', $orderId);
    }

    public function success($orderId)
    {
        $order = Order::with(['details.product', 'coupon'])
            ->where('id', $orderId)
            ->firstOrFail();

        return view('cart.message', compact('order'));
    }
}
