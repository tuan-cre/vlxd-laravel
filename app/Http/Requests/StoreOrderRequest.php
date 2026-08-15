<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullname' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:COD,bank_transfer',
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Họ tên là bắt buộc.',
            'fullname.string' => 'Họ tên phải là chuỗi ký tự.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'note.string' => 'Ghi chú phải là chuỗi ký tự.',
            'payment_method.required' => 'Phương thức thanh toán là bắt buộc.',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ. Chọn: COD hoặc bank_transfer.',
        ];
    }
}
