<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfertaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_loja' => ['required', 'exists:mysql_dados.lojas,id_loja'],
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'link_oferta' => ['required', 'url', 'string'],
            'imagem_oferta' => ['nullable', 'url', 'max:255'],
            'data_inicio' => ['nullable', 'date'],
            'data_expiracao' => ['nullable', 'date', 'after_or_equal:data_inicio'],
            'status' => ['required', 'in:0,1'],
        ];
    }
}
