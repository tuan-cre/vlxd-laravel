<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('giohang', []);
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

        $couponDiscount = Session::get('coupon_discount', 0);
        $couponCode = Session::get('coupon_code', null);

        return view('cart.cart', compact('cartItems', 'total', 'couponDiscount', 'couponCode'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $product = Product::where('id', $productId)->where('status', 1)->firstOrFail();

        if ($product->stock < $quantity) {
            return back()->with('error', 'Số lượng tồn kho không đủ.');
        }

        $cart = Session::get('giohang', []);

        if (isset($cart[$productId])) {
            $newQty = $cart[$productId] + $quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Số lượng tồn kho không đủ.');
            }
            $cart[$productId] = $newQty;
        } else {
            $cart[$productId] = $quantity;
        }

        Session::put('giohang', $cart);

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        $product = Product::where('id', $productId)->where('status', 1)->firstOrFail();

        if ($quantity > $product->stock) {
            return back()->with('error', 'Số lượng tồn kho không đủ.');
        }

        $cart = Session::get('giohang', []);
        $cart[$productId] = $quantity;
        Session::put('giohang', $cart);

        return back()->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function remove($productId)
    {
        $cart = Session::get('giohang', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('giohang', $cart);
        }

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function clear()
    {
        Session::forget('giohang');
        Session::forget('coupon_code');
        Session::forget('coupon_discount');

        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng.');
    }
}
