<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = strtoupper($request->code);

        $coupon = Coupon::where('code', $code)
            ->where('status', 1)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon does not exist.',
            ]);
        }

        if ($coupon->start_date && $coupon->start_date->isFuture()) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon is not yet active.',
            ]);
        }

        if ($coupon->end_date && $coupon->end_date->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon has expired.',
            ]);
        }

        if ($coupon->usage_limit !== null && $coupon->usage_limit <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit reached.',
            ]);
        }

        $cart = Session::get('giohang', []);
        $subtotal = 0;

        foreach ($cart as $productId => $quantity) {
            $product = \App\Models\Product::where('id', $productId)->where('status', 1)->first();
            if ($product) {
                $subtotal += ($product->sale_price ?? $product->price) * $quantity;
            }
        }

        if ($coupon->min_order_value && $subtotal < $coupon->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Order does not meet minimum value of ' . number_format($coupon->min_order_value, 0, ',', '.') . ' VND.',
            ]);
        }

        $discount = 0;
        if ($coupon->discount_type == 'percent') {
            $discount = $subtotal * ($coupon->discount_value / 100);
        } else {
            $discount = $coupon->discount_value;
        }

        $discount = min($discount, $subtotal);

        Session::put('coupon_code', $coupon->code);
        Session::put('coupon_discount', $discount);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully.',
            'discount' => $discount,
            'code' => $coupon->code,
        ]);
    }

    public function remove()
    {
        Session::forget('coupon_code');
        Session::forget('coupon_discount');

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
        ]);
    }
}
