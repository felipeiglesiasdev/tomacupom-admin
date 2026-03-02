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
        // CARREGAR CATEGORIAS DA LOJA
        // ===================================================

        $loja->load('categorias:id_categoria,nome');

        // ===================================================
        // LISTAR TODAS AS CATEGORIAS PARA SELECAO
        // ===================================================

        $categorias = Categoria::query()
            ->select(['id_categoria', 'nome'])
            ->ordenadas()
            ->get();

        return view('lojas.categorias-edit', [
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
        // SINCRONIZAR IDS DE CATEGORIAS
        // ===================================================

        $ids = $request->validated('categorias', []);

        $loja->categorias()->sync($ids);

        return redirect()
            ->route('admin.lojas.index')
            ->with('success', 'CATEGORIAS DA LOJA ATUALIZADAS.');
    }
}