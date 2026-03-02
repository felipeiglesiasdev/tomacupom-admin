<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCupomRequest;
use App\Http\Requests\Admin\UpdateCupomRequest;
use App\Models\Cupom;
use App\Models\Loja;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CupomController extends Controller
{
    // ===================================================
    // LISTAGEM + FILTROS
    // ===================================================

    public function index(Request $request): View
    {
        // ===================================================
        // QUERY BASE (COLUNAS EM MAIUSCULO POR CAUSA DO BANCO)
        // ===================================================

        $query = Cupom::query()
            ->select(['ID_CUPOM', 'ID_LOJA', 'TITULO', 'CODIGO', 'STATUS', 'DATA_EXPIRACAO'])
            ->with([
                'loja' => function (Builder $lojaQuery): void {
                    $lojaQuery->select(['ID_LOJA', 'NOME']);
                },
            ])
            ->ordenadas();

        // ===================================================
        // FILTRO: LOJA
        // ===================================================

        if ($request->filled('id_loja')) {
            $query->where('ID_LOJA', (int) $request->input('id_loja'));
        }

        // ===================================================
        // FILTRO: STATUS
        // ===================================================

        if ($request->filled('status')) {
            $query->where('STATUS', (int) $request->input('status'));
        }

        // ===================================================
        // FILTRO: EXPIRACAO (HOJE / 7 DIAS)
        // ===================================================

        $expiracao = (string) $request->input('expiracao', '');

        if ($expiracao === 'hoje') {
            $query->whereDate('DATA_EXPIRACAO', now()->toDateString());
        }

        if ($expiracao === '7dias') {
            $query->whereBetween('DATA_EXPIRACAO', [
                now()->toDateString(),
                now()->addDays(7)->toDateString(),
            ]);
        }

        // ===================================================
        // LISTA DE LOJAS PARA O SELECT DE FILTRO
        // ===================================================

        $lojas = Loja::query()
            ->select(['ID_LOJA', 'NOME'])
            ->ordenadas()
            ->get();

        return view('cupons.index', [
            'cupons' => $query->paginate(15)->withQueryString(),
            'lojas' => $lojas,
        ]);
    }

    // ===================================================
    // FORM DE CRIACAO
    // ===================================================

    public function create(): View
    {
        return view('cupons.create', [
            'lojas' => Loja::query()->select(['ID_LOJA', 'NOME'])->ordenadas()->get(),
        ]);
    }

    // ===================================================
    // CRIAR
    // ===================================================

    public function store(StoreCupomRequest $request): RedirectResponse
    {
        // ===================================================
        // REQUEST DEVE RETORNAR CHAVES EM MAIUSCULO (EX.: ID_LOJA, TITULO, ETC.)
        // ===================================================

        Cupom::query()->create($request->validated());

        return redirect()
            ->route('admin.cupons.index')
            ->with('success', 'CUPOM CRIADO COM SUCESSO.');
    }

    // ===================================================
    // FORM DE EDICAO
    // ===================================================

    public function edit(Cupom $cupom): View
    {
        return view('cupons.edit', [
            'cupom' => $cupom,
            'lojas' => Loja::query()->select(['ID_LOJA', 'NOME'])->ordenadas()->get(),
        ]);
    }

    // ===================================================
    // ATUALIZAR
    // ===================================================

    public function update(UpdateCupomRequest $request, Cupom $cupom): RedirectResponse
    {
        $cupom->update($request->validated());

        return redirect()
            ->route('admin.cupons.index')
            ->with('success', 'CUPOM ATUALIZADO COM SUCESSO.');
    }

    // ===================================================
    // EXCLUIR
    // ===================================================

    public function destroy(Cupom $cupom): RedirectResponse
    {
        $cupom->delete();

        return redirect()
            ->route('admin.cupons.index')
            ->with('success', 'CUPOM EXCLUIDO COM SUCESSO.');
    }

    // ===================================================
    // DUPLICAR CUPOM
    // ===================================================

    public function duplicate(Cupom $cupom): RedirectResponse
    {
        // ===================================================
        // TRANSACAO NA CONEXAO CORRETA (MYSQL_DADOS)
        // ===================================================

        DB::connection('mysql_dados')->transaction(function () use ($cupom): void {
            // ===================================================
            // CLONAR REGISTRO
            // ===================================================

            $copy = $cupom->replicate();

            // ===================================================
            // AJUSTES DO CLONE
            // ===================================================

            $copy->TITULO = $cupom->TITULO . ' (COPIA)';
            $copy->CLIQUES = 0;

            // ===================================================
            // GARANTIR TIMESTAMPS (COLUNAS EM MAIUSCULO)
            // ===================================================

            $copy->CREATED_AT = now();
            $copy->UPDATED_AT = now();

            $copy->save();
        });

        return redirect()
            ->route('admin.cupons.index')
            ->with('success', 'CUPOM DUPLICADO COM SUCESSO.');
    }
}