<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(StoreCouponRequest $request)
    {
        Coupon::create([
            'code' => strtoupper($request->code),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value ?? 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'usage_limit' => $request->usage_limit,
            'status' => 1,
            'points_cost' => $request->points_cost ?? 0,
            'min_member_level' => $request->min_member_level,
            'requires_claim' => $request->requires_claim ?? 0,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Tạo mã giảm giá thành công.');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(StoreCouponRequest $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->update([
            'code' => strtoupper($request->code),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value ?? 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'usage_limit' => $request->usage_limit,
            'points_cost' => $request->points_cost ?? 0,
            'min_member_level' => $request->min_member_level,
            'requires_claim' => $request->requires_claim ?? 0,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Cập nhật mã giảm giá thành công.');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        if ($coupon->orders()->count() > 0) {
            return back()->with('error', 'Không thể xóa mã giảm giá đã được sử dụng.');
        }

        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Xóa mã giảm giá thành công.');
    }
}
