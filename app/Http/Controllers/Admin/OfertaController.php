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
    // ===================================================
    // LISTAGEM + FILTROS
    // ===================================================

    public function index(Request $request): View
    {
        // ===================================================
        // QUERY BASE (SELECIONA APENAS COLUNAS NECESSARIAS)
        // ===================================================

        $query = Oferta::query()
            ->select(['id_oferta', 'id_loja', 'titulo', 'status', 'data_expiracao', 'descricao', 'link_oferta', 'imagem_oferta', 'data_inicio'])
            ->with('loja:id_loja,nome')
            ->ordenadas();

        // ===================================================
        // FILTRO: LOJA
        // ===================================================

        if ($request->filled('id_loja')) {
            $query->where('id_loja', (int) $request->input('id_loja'));
        }

        // ===================================================
        // FILTRO: STATUS (1 ATIVO / 0 INATIVO)
        // ===================================================

        if ($request->filled('status')) {
            $query->where('status', (int) $request->input('status'));
        }

        // ===================================================
        // FILTRO: EXPIRACAO (HOJE / 7 DIAS)
        // ===================================================

        $expiracao = (string) $request->input('expiracao', '');

        if ($expiracao === 'hoje') {
            $query->whereDate('data_expiracao', now()->toDateString());
        }

        if ($expiracao === '7dias') {
            $query->whereBetween('data_expiracao', [
                now()->toDateString(),
                now()->addDays(7)->toDateString(),
            ]);
        }

        // ===================================================
        // LISTA DE LOJAS PARA O SELECT DE FILTRO
        // ===================================================

        $lojas = Loja::query()
            ->select(['id_loja', 'nome'])
            ->ordenadas()
            ->get();

        return view('ofertas.index', [
            'ofertas' => $query->paginate(15)->withQueryString(),
            'lojas' => $lojas,
        ]);
    }

    // ===================================================
    // FORM DE CRIACAO
    // ===================================================

    public function create(): View
    {
        return view('ofertas.create', [
            'lojas' => Loja::query()->select(['id_loja', 'nome'])->ordenadas()->get(),
        ]);
    }

    // ===================================================
    // CRIAR
    // ===================================================

    public function store(StoreOfertaRequest $request): RedirectResponse
    {
        // ===================================================
        // CRIAR OFERTA COM DADOS VALIDOS
        // ===================================================

        Oferta::query()->create($request->validated());

        return redirect()
            ->route('admin.ofertas.index')
            ->with('success', 'OFERTA CRIADA COM SUCESSO.');
    }

    // ===================================================
    // FORM DE EDICAO
    // ===================================================

    public function edit(Oferta $oferta): View
    {
        return view('ofertas.edit', [
            'oferta' => $oferta,
            'lojas' => Loja::query()->select(['id_loja', 'nome'])->ordenadas()->get(),
        ]);
    }

    // ===================================================
    // ATUALIZAR
    // ===================================================

    public function update(UpdateOfertaRequest $request, Oferta $oferta): RedirectResponse
    {
        $oferta->update($request->validated());

        return redirect()
            ->route('admin.ofertas.index')
            ->with('success', 'OFERTA ATUALIZADA COM SUCESSO.');
    }

    // ===================================================
    // EXCLUIR
    // ===================================================

    public function destroy(Oferta $oferta): RedirectResponse
    {
        $oferta->delete();

        return redirect()
            ->route('admin.ofertas.index')
            ->with('success', 'OFERTA EXCLUIDA COM SUCESSO.');
    }
}