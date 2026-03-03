<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCupomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_loja' => ['required', 'exists:mysql_app.lojas,id_loja'],
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'regras' => ['nullable', 'string'],
            'tipo' => ['required', 'integer', 'min:1'],
            'codigo' => ['nullable', 'string', 'max:50'],
            'link_redirecionamento' => ['nullable', 'url', 'max:255'],
            'data_inicio' => ['nullable', 'date'],
            'data_expiracao' => ['nullable', 'date', 'after_or_equal:data_inicio'],
            'status' => ['required', 'in:0,1'],
        ];
    }
}
