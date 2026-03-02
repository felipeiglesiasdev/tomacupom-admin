<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOfertaRequest;
use App\Http\Requests\Admin\UpdateOfertaRequest;
use App\Models\Loja;
use App\Models\Oferta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfertaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Oferta::query()->select(['id_oferta', 'id_loja', 'titulo', 'status', 'data_expiracao'])->with('loja:id_loja,nome')->ordenadas();

        if ($request->filled('id_loja')) {
            $query->where('id_loja', (int) $request->string('id_loja'));
        }

        if ($request->filled('status')) {
            $query->where('status', (int) $request->string('status'));
        }

        if ($request->string('expiracao') === 'hoje') {
            $query->whereDate('data_expiracao', now()->toDateString());
        }

        if ($request->string('expiracao') === '7dias') {
            $query->whereBetween('data_expiracao', [now()->toDateString(), now()->addDays(7)->toDateString()]);
        }

        return view('ofertas.index', [
            'ofertas' => $query->paginate(15)->withQueryString(),
            'lojas' => Loja::query()->select(['id_loja', 'nome'])->ordenadas()->get(),
        ]);
    }

    public function create(): View
    {
        return view('ofertas.create', ['lojas' => Loja::query()->select(['id_loja', 'nome'])->ordenadas()->get()]);
    }

    public function store(StoreOfertaRequest $request): RedirectResponse
    {
        Oferta::query()->create($request->validated());

        return redirect()->route('admin.ofertas.index')->with('success', 'OFERTA CRIADA COM SUCESSO.');
    }

    public function edit(Oferta $oferta): View
    {
        return view('ofertas.edit', ['oferta' => $oferta, 'lojas' => Loja::query()->select(['id_loja', 'nome'])->ordenadas()->get()]);
    }

    public function update(UpdateOfertaRequest $request, Oferta $oferta): RedirectResponse
    {
        $oferta->update($request->validated());

        return redirect()->route('admin.ofertas.index')->with('success', 'OFERTA ATUALIZADA COM SUCESSO.');
    }

    public function destroy(Oferta $oferta): RedirectResponse
    {
        $oferta->delete();

        return redirect()->route('admin.ofertas.index')->with('success', 'OFERTA EXCLUIDA COM SUCESSO.');
    }
}
