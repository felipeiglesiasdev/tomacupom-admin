<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLojaRequest;
use App\Http\Requests\Admin\UpdateLojaRequest;
use App\Models\Loja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LojaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Loja::query()->select(['id_loja', 'nome', 'slug', 'status', 'created_at'])->ordenadas();

        if ($request->filled('status')) {
            $query->where('status', (int) $request->string('status'));
        }

        if ($request->filled('busca')) {
            $term = '%'.$request->string('busca').'%';
            $query->where(fn ($inner) => $inner->where('nome', 'like', $term)->orWhere('slug', 'like', $term));
        }

        return view('admin.lojas.index', ['lojas' => $query->paginate(15)->withQueryString()]);
    }

    public function create(): View
    {
        return view('admin.lojas.create');
    }

    public function store(StoreLojaRequest $request): RedirectResponse
    {
        $loja = Loja::query()->create($request->validated());
        $loja->seo()->create(['id_loja' => $loja->id_loja]);

        return redirect()->route('admin.lojas.index')->with('success', 'LOJA CRIADA COM SUCESSO.');
    }

    public function edit(Loja $loja): View
    {
        return view('admin.lojas.edit', compact('loja'));
    }

    public function update(UpdateLojaRequest $request, Loja $loja): RedirectResponse
    {
        $loja->update($request->validated());

        return redirect()->route('admin.lojas.index')->with('success', 'LOJA ATUALIZADA COM SUCESSO.');
    }

    public function destroy(Loja $loja): RedirectResponse
    {
        $loja->delete();

        return redirect()->route('admin.lojas.index')->with('success', 'LOJA EXCLUIDA COM SUCESSO.');
    }
}
