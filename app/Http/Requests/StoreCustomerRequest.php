<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullname' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:male,female,other',
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Họ tên là bắt buộc.',
            'fullname.string' => 'Họ tên phải là chuỗi ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'gender.in' => 'Giới tính không hợp lệ. Chọn: male, female hoặc other.',
        ];
    }
}
