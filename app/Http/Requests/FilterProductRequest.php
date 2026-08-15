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
            'category_id.exists' => 'Danh mục không tồn tại.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'min_price.numeric' => 'Giá tối thiểu phải là số.',
            'max_price.numeric' => 'Giá tối đa phải là số.',
            'sort.in' => 'Sắp xếp không hợp lệ. Chọn: price_asc, price_desc, newest hoặc best_selling.',
            'page.integer' => 'Trang phải là số nguyên.',
            'page.min' => 'Trang phải lớn hơn hoặc bằng 1.',
            'per_page.integer' => 'Số sản phẩm mỗi trang phải là số nguyên.',
            'per_page.min' => 'Số sản phẩm mỗi trang phải lớn hơn hoặc bằng 1.',
            'per_page.max' => 'Số sản phẩm mỗi trang không được quá 50.',
        ];
    }
}
