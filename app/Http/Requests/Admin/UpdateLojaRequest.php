<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLojaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $loja = $this->route('loja');

        return [
            'nome' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:160', Rule::unique('mysql_app.lojas', 'slug')->ignore($loja?->id_loja, 'id_loja')],
            'titulo_pagina' => ['required', 'string', 'max:255'],
            'descricao_pagina' => ['required', 'string', 'max:255'],
            'url_site' => ['nullable', 'url', 'max:255'],
            'url_base_afiliado' => ['nullable', 'url', 'max:255'],
            'logo_image_link' => ['nullable', 'url', 'max:255'],
            'alt_text_logo' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:0,1'],
        ];
    }
}
