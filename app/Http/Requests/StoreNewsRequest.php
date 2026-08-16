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
            'title.required' => 'Title is required.',
            'title.string' => 'Title must be a string.',
            'summary.string' => 'Summary must be a string.',
            'content.required' => 'Content is required.',
            'content.string' => 'Content must be a string.',
            'category.string' => 'Category must be a string.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status is invalid. Accepted values: draft or published.',
        ];
    }
}
