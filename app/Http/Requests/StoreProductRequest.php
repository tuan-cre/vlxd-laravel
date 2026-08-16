<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'unit' => 'required|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'status' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'name.string' => 'Product name must be a string.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Category does not exist.',
            'brand_id.required' => 'Brand is required.',
            'brand_id.exists' => 'Brand does not exist.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price must not be less than 0.',
            'sale_price.numeric' => 'Sale price must be a number.',
            'sale_price.min' => 'Sale price must not be less than 0.',
            'unit.required' => 'Unit is required.',
            'unit.string' => 'Unit must be a string.',
            'content.string' => 'Content must be a string.',
            'stock.required' => 'Stock is required.',
            'stock.integer' => 'Stock must be an integer.',
            'stock.min' => 'Stock must not be less than 0.',
            'is_featured' => 'Featured must be a boolean value.',
            'status' => 'Status must be a boolean value.',
        ];
    }
}
