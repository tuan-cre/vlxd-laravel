<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|unique:coupons,code',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'points_cost' => 'nullable|integer|min:0',
            'min_member_level' => 'nullable|in:bronze,silver,gold,platinum',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Mã giảm giá là bắt buộc.',
            'code.unique' => 'Mã giảm giá đã tồn tại.',
            'discount_type.required' => 'Loại giảm giá là bắt buộc.',
            'discount_type.in' => 'Loại giảm giá không hợp lệ. Chọn: percent hoặc fixed.',
            'discount_value.required' => 'Giá trị giảm giá là bắt buộc.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là số.',
            'discount_value.min' => 'Giá trị giảm giá không được nhỏ hơn 0.',
            'min_order_value.numeric' => 'Giá trị đơn tối thiểu phải là số.',
            'min_order_value.min' => 'Giá trị đơn tối thiểu không được nhỏ hơn 0.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'usage_limit.integer' => 'Giới hạn sử dụng phải là số nguyên.',
            'usage_limit.min' => 'Giới hạn sử dụng phải từ 1.',
            'points_cost.integer' => 'Điểm yêu cầu phải là số nguyên.',
            'points_cost.min' => 'Điểm yêu cầu không được nhỏ hơn 0.',
            'min_member_level.in' => 'Cấp thành viên không hợp lệ. Chọn: bronze, silver, gold hoặc platinum.',
        ];
    }
}
