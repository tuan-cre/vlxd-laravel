<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $cartKey = 'giohang';
    protected string $couponKey = 'applied_coupon';

    public function getItems(): array
    {
        $cart = Session::get($this->cartKey, []);

        if (empty($cart)) {
            return [];
        }

        $products = Product::whereIn('id', array_keys($cart))->get();

        $items = [];
        foreach ($products as $product) {
            $effectivePrice = $product->sale_price > 0 ? $product->sale_price : $product->price;
            $quantity = $cart[$product->id];

            $items[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'thumbnail' => $product->thumbnail,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'effective_price' => $effectivePrice,
                'unit' => $product->unit,
                'stock' => $product->stock,
                'quantity' => $quantity,
                'subtotal' => $effectivePrice * $quantity,
            ];
        }

        return $items;
    }

    public function add(int $productId, int $qty = 1): bool
    {
        $product = Product::find($productId);

        if (!$product || $product->status !== 1) {
            return false;
        }

        $cart = Session::get($this->cartKey, []);
        $currentQty = $cart[$productId] ?? 0;
        $newQty = $currentQty + $qty;

        if ($newQty > $product->stock) {
            return false;
        }

        $cart[$productId] = $newQty;
        Session::put($this->cartKey, $cart);

        return true;
    }

    public function update(int $productId, int $qty): bool
    {
        $product = Product::find($productId);

        if (!$product) {
            return false;
        }

        if ($qty <= 0) {
            return $this->remove($productId);
        }

        if ($qty > $product->stock) {
            return false;
        }

        $cart = Session::get($this->cartKey, []);

        if (!isset($cart[$productId])) {
            return false;
        }

        $cart[$productId] = $qty;
        Session::put($this->cartKey, $cart);

        return true;
    }

    public function remove(int $productId): bool
    {
        $cart = Session::get($this->cartKey, []);

        if (!isset($cart[$productId])) {
            return false;
        }

        unset($cart[$productId]);
        Session::put($this->cartKey, $cart);

        return true;
    }

    public function clear(): void
    {
        Session::forget($this->cartKey);
        Session::forget($this->couponKey);
    }

    public function getCount(): int
    {
        $cart = Session::get($this->cartKey, []);
        return array_sum($cart);
    }

    public function getTotal(): float
    {
        $items = $this->getItems();
        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += $item['subtotal'];
        }

        $coupon = Session::get($this->couponKey);

        if ($coupon) {
            $discount = $this->calculateCouponDiscount($coupon, $subtotal);
            $subtotal = max(0, $subtotal - $discount);
        }

        return $subtotal;
    }

    protected function calculateCouponDiscount(array $coupon, float $total): float
    {
        if ($coupon['discount_type'] === 'percent') {
            return $total * ($coupon['discount_value'] / 100);
        }

        return min((float) $coupon['discount_value'], $total);
    }
}
