<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLojaSeoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title_seo' => ['nullable', 'string'],
            'description_seo' => ['nullable', 'string'],
            'keywords_seo' => ['nullable', 'string'],
            'text_content_seo' => ['nullable', 'string'],
        ];
    }
}
