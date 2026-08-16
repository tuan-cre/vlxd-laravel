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
            'fullname.required' => 'Full name is required.',
            'fullname.string' => 'Full name must be a string.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.string' => 'Phone number must be a string.',
            'address.required' => 'Address is required.',
            'address.string' => 'Address must be a string.',
            'note.string' => 'Note must be a string.',
            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Payment method is invalid. Accepted values: COD or bank_transfer.',
        ];
    }
}
