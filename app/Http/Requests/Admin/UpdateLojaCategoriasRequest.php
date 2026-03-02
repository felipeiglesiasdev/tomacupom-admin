<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLojaCategoriasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categorias' => ['nullable', 'array'],
            'categorias.*' => ['integer', 'exists:mysql_app.categorias,id_categoria'],
        ];
    }
}
