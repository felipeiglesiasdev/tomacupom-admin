<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoriaRequest;
use App\Http\Requests\Admin\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    // ===================================================
    // LISTAGEM + BUSCA
    // ===================================================

    public function index(Request $request): View
    {
        // ===================================================
        // QUERY BASE (CAMPOS EM MAIUSCULO POR CAUSA DO BANCO)
        // ===================================================

        $query = Categoria::query()
            ->select(['ID_CATEGORIA', 'NOME', 'SLUG'])
            ->ordenadas();

        // ===================================================
        // BUSCA POR NOME OU SLUG
        // ===================================================

        if ($request->filled('busca')) {
            $term = '%' . trim((string) $request->input('busca')) . '%';

            $query->where(function (Builder $inner) use ($term): void {
                $inner->where('NOME', 'LIKE', $term)
                    ->orWhere('SLUG', 'LIKE', $term);
            });
        }

        // ===================================================
        // RETORNO COM PAGINACAO
        // ===================================================

        return view('admin.categorias.index', [
            'categorias' => $query->paginate(15)->withQueryString(),
        ]);
    }

    // ===================================================
    // FORM DE CRIACAO
    // ===================================================

    public function create(): View
    {
        return view('admin.categorias.create');
    }

    // ===================================================
    // CRIAR
    // ===================================================

    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        // ===================================================
        // CRIACAO (REQUEST DEVE RETORNAR CHAVES EM MAIUSCULO)
        // ===================================================

        Categoria::query()->create($request->validated());

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'CATEGORIA CRIADA COM SUCESSO.');
    }

    // ===================================================
    // FORM DE EDICAO
    // ===================================================

    public function edit(Categoria $categoria): View
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    // ===================================================
    // ATUALIZAR
    // ===================================================

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        // ===================================================
        // UPDATE (REQUEST DEVE RETORNAR CHAVES EM MAIUSCULO)
        // ===================================================

        $categoria->update($request->validated());

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'CATEGORIA ATUALIZADA COM SUCESSO.');
    }

    // ===================================================
    // EXCLUIR
    // ===================================================

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $categoria->delete();

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'CATEGORIA EXCLUIDA COM SUCESSO.');
    }
}