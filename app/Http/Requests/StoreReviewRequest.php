<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'ID sản phẩm là bắt buộc.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'rating.required' => 'Đánh giá là bắt buộc.',
            'rating.integer' => 'Đánh giá phải là số nguyên.',
            'rating.min' => 'Đánh giá phải từ 1 đến 5.',
            'rating.max' => 'Đánh giá phải từ 1 đến 5.',
            'comment.string' => 'Bình luận phải là chuỗi ký tự.',
        ];
    }
}
