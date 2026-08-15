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
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'brand_id.required' => 'Thương hiệu là bắt buộc.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được nhỏ hơn 0.',
            'sale_price.numeric' => 'Giá khuyến mãi phải là số.',
            'sale_price.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
            'unit.required' => 'Đơn vị là bắt buộc.',
            'unit.string' => 'Đơn vị phải là chuỗi ký tự.',
            'content.string' => 'Nội dung phải là chuỗi ký tự.',
            'stock.required' => 'Tồn kho là bắt buộc.',
            'stock.integer' => 'Tồn kho phải là số nguyên.',
            'stock.min' => 'Tồn kho không được nhỏ hơn 0.',
            'is_featured' => 'Nổi bật phải là giá trị boolean.',
            'status' => 'Trạng thái phải là giá trị boolean.',
        ];
    }
}
