<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'category' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'summary.string' => 'Tóm tắt phải là chuỗi ký tự.',
            'content.required' => 'Nội dung là bắt buộc.',
            'content.string' => 'Nội dung phải là chuỗi ký tự.',
            'category.string' => 'Danh mục phải là chuỗi ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ. Chọn: draft hoặc published.',
        ];
    }
}
