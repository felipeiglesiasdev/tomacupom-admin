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
    public function edit(Loja $loja): View
    {
        return view('admin.lojas.categorias-edit', [
            'loja' => $loja->load('categorias:id_categoria,nome'),
            'categorias' => Categoria::query()->select(['id_categoria', 'nome'])->ordenadas()->get(),
        ]);
    }

    public function update(UpdateLojaCategoriasRequest $request, Loja $loja): RedirectResponse
    {
        $loja->categorias()->sync($request->validated('categorias', []));

        return redirect()->route('admin.lojas.index')->with('success', 'CATEGORIAS DA LOJA ATUALIZADAS.');
    }
}
