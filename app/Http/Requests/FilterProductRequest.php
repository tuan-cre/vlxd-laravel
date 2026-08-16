<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
            'sort' => 'nullable|in:price_asc,price_desc,newest,best_selling',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.exists' => 'Category does not exist.',
            'brand_id.exists' => 'Brand does not exist.',
            'min_price.numeric' => 'Minimum price must be a number.',
            'max_price.numeric' => 'Maximum price must be a number.',
            'sort.in' => 'Sort is invalid. Accepted values: price_asc, price_desc, newest or best_selling.',
            'page.integer' => 'Page must be an integer.',
            'page.min' => 'Page must be greater than or equal to 1.',
            'per_page.integer' => 'Items per page must be an integer.',
            'per_page.min' => 'Items per page must be greater than or equal to 1.',
            'per_page.max' => 'Items per page must not exceed 50.',
        ];
    }
}
