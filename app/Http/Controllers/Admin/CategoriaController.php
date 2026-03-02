<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoriaRequest;
use App\Http\Requests\Admin\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Categoria::query()->select(['id_categoria', 'nome', 'slug'])->ordenadas();

        if ($request->filled('busca')) {
            $term = '%'.$request->string('busca').'%';
            $query->where(fn ($inner) => $inner->where('nome', 'like', $term)->orWhere('slug', 'like', $term));
        }

        return view('admin.categorias.index', ['categorias' => $query->paginate(15)->withQueryString()]);
    }

    public function create(): View
    {
        return view('admin.categorias.create');
    }

    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        Categoria::query()->create($request->validated());

        return redirect()->route('admin.categorias.index')->with('success', 'CATEGORIA CRIADA COM SUCESSO.');
    }

    public function edit(Categoria $categoria): View
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($request->validated());

        return redirect()->route('admin.categorias.index')->with('success', 'CATEGORIA ATUALIZADA COM SUCESSO.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('success', 'CATEGORIA EXCLUIDA COM SUCESSO.');
    }
}
