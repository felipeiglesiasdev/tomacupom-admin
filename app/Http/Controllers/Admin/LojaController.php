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
    // ===================================================
    // LISTAGEM DE LOJAS + FILTROS (STATUS / BUSCA)
    // ===================================================

    public function index(Request $request): View
    {
        // ===================================================
        // QUERY BASE (SELECIONA APENAS COLUNAS NECESSARIAS)
        // ===================================================

        $query = Loja::query()->select(['id_loja','nome','slug','status','created_at','logo_image_link','titulo_pagina','descricao_pagina','url_site','url_base_afiliado','alt_text_logo'])
                              ->ordenadas();

        // ===================================================
        // FILTRO POR STATUS (EX.: 1 ATIVO / 0 INATIVO)
        // ===================================================

        if ($request->filled('status')) {
            $query->where('status', (int) $request->string('status'));
        }

        // ===================================================
        // BUSCA POR NOME OU SLUG (LIKE)
        // ===================================================

        if ($request->filled('busca')) {
            $term = '%' . $request->string('busca') . '%';

            $query->where(function ($inner) use ($term): void {
                $inner->where('nome', 'like', $term)
                      ->orWhere('slug', 'like', $term);
            });
        }

        // ===================================================
        // PAGINACAO + MANTER QUERYSTRING (FILTROS) NAS PAGINAS
        // ===================================================

        return view('lojas.index', [
            'lojas' => $query->paginate(15)->withQueryString(),
        ]);
    }

    // ===================================================
    // FORM DE CRIACAO
    // ===================================================

    public function create(): View
    {
        return view('lojas.create');
    }

    // ===================================================
    // CRIAR LOJA + CRIAR SEO 1:1 AUTOMATICAMENTE
    // ===================================================

    public function store(StoreLojaRequest $request): RedirectResponse
    {
        // ===================================================
        // CRIAR A LOJA COM DADOS VALIDOS DO REQUEST
        // ===================================================

        $loja = Loja::query()->create($request->validated());

        // ===================================================
        // CRIAR REGISTRO SEO 1:1 (ID_LOJA = PK/FK)
        // OBS: GARANTE QUE TODA LOJA TENHA UM REGISTRO SEO
        // ===================================================

        $loja->seo()->create([
            'id_loja' => $loja->id_loja,
        ]);

        // ===================================================
        // REDIRECIONAR COM MENSAGEM
        // ===================================================

        return redirect()
            ->route('admin.lojas.index')
            ->with('success', 'LOJA CRIADA COM SUCESSO.');
    }

    // ===================================================
    // FORM DE EDICAO
    // ===================================================

    public function edit(Loja $loja): View
    {
        return view('lojas.edit', compact('loja'));
    }

    // ===================================================
    // ATUALIZAR LOJA
    // ===================================================

    public function update(UpdateLojaRequest $request, Loja $loja): RedirectResponse
    {
        // ===================================================
        // ATUALIZAR COM DADOS VALIDOS DO REQUEST
        // ===================================================

        $loja->update($request->validated());

        // ===================================================
        // REDIRECIONAR COM MENSAGEM
        // ===================================================

        return redirect()
            ->route('admin.lojas.index')
            ->with('success', 'LOJA ATUALIZADA COM SUCESSO.');
    }

    // ===================================================
    // EXCLUIR LOJA
    // OBS: COMO EXISTE FK COM ON DELETE CASCADE,
    // CUPONS/OFERTAS/SEO/RELACOES NA PIVOT SOMEM JUNTO
    // ===================================================

    public function destroy(Loja $loja): RedirectResponse
    {
        $loja->delete();

        return redirect()
            ->route('admin.lojas.index')
            ->with('success', 'LOJA EXCLUIDA COM SUCESSO.');
    }
}