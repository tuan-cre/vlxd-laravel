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
            'code.required' => 'Coupon code is required.',
            'code.unique' => 'Coupon code is already taken.',
            'discount_type.required' => 'Discount type is required.',
            'discount_type.in' => 'Discount type is invalid. Accepted values: percent or fixed.',
            'discount_value.required' => 'Discount value is required.',
            'discount_value.numeric' => 'Discount value must be a number.',
            'discount_value.min' => 'Discount value must not be less than 0.',
            'min_order_value.numeric' => 'Minimum order value must be a number.',
            'min_order_value.min' => 'Minimum order value must not be less than 0.',
            'start_date.date' => 'Start date is invalid.',
            'end_date.date' => 'End date is invalid.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'usage_limit.integer' => 'Usage limit must be an integer.',
            'usage_limit.min' => 'Usage limit must be at least 1.',
            'points_cost.integer' => 'Points cost must be an integer.',
            'points_cost.min' => 'Points cost must not be less than 0.',
            'min_member_level.in' => 'Member level is invalid. Accepted values: bronze, silver, gold or platinum.',
        ];
    }
}
