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
            'fullname.required' => 'Full name is required.',
            'fullname.string' => 'Full name must be a string.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email is invalid.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.string' => 'Phone number must be a string.',
            'address.string' => 'Address must be a string.',
            'gender.in' => 'Gender is invalid. Accepted values: male, female or other.',
        ];
    }
}
