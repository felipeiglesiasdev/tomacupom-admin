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
        // QUERY BASE
        // ===================================================

        $query = Cupom::query()
            ->select(['id_cupom', 'id_loja', 'titulo', 'codigo', 'status', 'data_expiracao', 'tipo', 'descricao', 'regras', 'link_redirecionamento', 'data_inicio'])
            ->with([
                'loja' => function (Builder $lojaQuery): void {
                    $lojaQuery->select(['id_loja', 'nome']);
                },
            ])
            ->ordenadas();

        // ===================================================
        // FILTRO: LOJA
        // ===================================================

        if ($request->filled('id_loja')) {
            $query->where('id_loja', (int) $request->input('id_loja'));
        }

        // ===================================================
        // FILTRO: STATUS
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
            'lojas' => Loja::query()->select(['id_loja', 'nome'])->ordenadas()->get(),
        ]);
    }

    // ===================================================
    // CRIAR
    // ===================================================

    public function store(StoreCupomRequest $request): RedirectResponse
    {
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
            'lojas' => Loja::query()->select(['id_loja', 'nome'])->ordenadas()->get(),
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
        DB::connection('mysql_dados')->transaction(function () use ($cupom): void {
            $copy = $cupom->replicate();

            // ===================================================
            // AJUSTES DO CLONE
            // ===================================================

            $copy->titulo = $cupom->titulo . ' (copia)';

            // ===================================================
            // GARANTIR TIMESTAMPS
            // ===================================================

            $copy->created_at = now();
            $copy->updated_at = now();

            $copy->save();
        });

        return redirect()
            ->route('admin.cupons.index')
            ->with('success', 'CUPOM DUPLICADO COM SUCESSO.');
    }
}