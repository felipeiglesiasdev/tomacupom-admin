<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateLojaCategoriasRequest;
use App\Models\Categoria;
use App\Models\Loja;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LojaCategoriaController extends Controller
{
    // ===================================================
    // FORM PARA EDITAR CATEGORIAS DA LOJA
    // ===================================================

    public function edit(Loja $loja): View
    {
        // ===================================================
        // CARREGAR CATEGORIAS DA LOJA (COLUNAS EM MAIUSCULO)
        // ===================================================

        $loja->load('categorias:ID_CATEGORIA,NOME');

        // ===================================================
        // LISTAR TODAS AS CATEGORIAS PARA SELECAO
        // ===================================================

        $categorias = Categoria::query()
            ->select(['ID_CATEGORIA', 'NOME'])
            ->ordenadas()
            ->get();

        return view('admin.lojas.categorias-edit', [
            'loja' => $loja,
            'categorias' => $categorias,
        ]);
    }

    // ===================================================
    // ATUALIZAR CATEGORIAS DA LOJA
    // ===================================================

    public function update(UpdateLojaCategoriasRequest $request, Loja $loja): RedirectResponse
    {
        // ===================================================
        // SINCRONIZAR IDS DE CATEGORIAS (ARRAY DE ID_CATEGORIA)
        // ===================================================

        $ids = $request->validated('categorias', []);

        // ===================================================
        // SYNC NA PIVOT LOJA_CATEGORIA
        // OBS: RELACIONAMENTO NAO DEVE TER withTimestamps() SE A PIVOT NAO TEM UPDATED_AT
        // ===================================================

        $loja->categorias()->sync($ids);

        return redirect()
            ->route('admin.lojas.index')
            ->with('success', 'CATEGORIAS DA LOJA ATUALIZADAS.');
    }
}