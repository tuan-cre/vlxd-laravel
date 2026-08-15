<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CouponService
{
    protected string $couponKey = 'applied_coupon';

    public function apply(string $code, float $cartTotal, string $customerLevel = 'bronze'): array
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Mã giảm giá không tồn tại.'];
        }

        if ($coupon->status !== 1) {
            return ['success' => false, 'message' => 'Mã giảm giá đã bị vô hiệu hóa.'];
        }

        if ($coupon->start_date && now()->lt($coupon->start_date)) {
            return ['success' => false, 'message' => 'Mã giảm giá chưa đến thời hạn sử dụng.'];
        }

        if ($coupon->end_date && now()->gt($coupon->end_date)) {
            return ['success' => false, 'message' => 'Mã giảm giá đã hết hạn.'];
        }

        if ($coupon->usage_limit <= 0) {
            return ['success' => false, 'message' => 'Mã giảm giá đã hết lượt sử dụng.'];
        }

        if ($cartTotal < $coupon->min_order_value) {
            return [
                'success' => false,
                'message' => 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($coupon->min_order_value, 0, ',', '.') . ' VNĐ.',
            ];
        }

        $levelOrder = ['bronze' => 1, 'silver' => 2, 'gold' => 3, 'platinum' => 4];
        $requiredLevel = $levelOrder[$coupon->min_member_level] ?? 1;
        $currentLevel = $levelOrder[$customerLevel] ?? 1;

        if ($currentLevel < $requiredLevel) {
            return [
                'success' => false,
                'message' => 'Bạn cần đạt hạng ' . ucfirst($coupon->min_member_level) . ' để sử dụng mã này.',
            ];
        }

        $discount = $this->calculateDiscount($coupon, $cartTotal);

        $couponData = [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value,
            'discount_amount' => $discount,
        ];

        Session::put($this->couponKey, $couponData);

        return [
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount' => $discount,
            'coupon' => $couponData,
        ];
    }

    public function remove(): void
    {
        Session::forget($this->couponKey);
    }

    public function calculateDiscount(Coupon $coupon, float $total): float
    {
        if ($coupon->discount_type === 'percent') {
            return $total * ($coupon->discount_value / 100);
        }

        return min((float) $coupon->discount_value, $total);
    }

    public function getApplied(): ?array
    {
        return Session::get($this->couponKey);
    }
}
