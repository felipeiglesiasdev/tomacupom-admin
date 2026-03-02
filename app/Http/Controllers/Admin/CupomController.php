<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCupomRequest;
use App\Http\Requests\Admin\UpdateCupomRequest;
use App\Models\Cupom;
use App\Models\Loja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CupomController extends Controller
{
    public function index(Request $request): View
    {
        $query = Cupom::query()->select(['id_cupom', 'id_loja', 'titulo', 'codigo', 'status', 'data_expiracao', 'cliques'])->with('loja:id_loja,nome')->ordenadas();

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

        return view('admin.cupons.index', [
            'cupons' => $query->paginate(15)->withQueryString(),
            'lojas' => Loja::query()->select(['id_loja', 'nome'])->ordenadas()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.cupons.create', ['lojas' => Loja::query()->select(['id_loja', 'nome'])->ordenadas()->get()]);
    }

    public function store(StoreCupomRequest $request): RedirectResponse
    {
        Cupom::query()->create($request->validated());

        return redirect()->route('admin.cupons.index')->with('success', 'CUPOM CRIADO COM SUCESSO.');
    }

    public function edit(Cupom $cupom): View
    {
        return view('admin.cupons.edit', ['cupom' => $cupom, 'lojas' => Loja::query()->select(['id_loja', 'nome'])->ordenadas()->get()]);
    }

    public function update(UpdateCupomRequest $request, Cupom $cupom): RedirectResponse
    {
        $cupom->update($request->validated());

        return redirect()->route('admin.cupons.index')->with('success', 'CUPOM ATUALIZADO COM SUCESSO.');
    }

    public function destroy(Cupom $cupom): RedirectResponse
    {
        $cupom->delete();

        return redirect()->route('admin.cupons.index')->with('success', 'CUPOM EXCLUIDO COM SUCESSO.');
    }

    public function duplicate(Cupom $cupom): RedirectResponse
    {
        DB::connection('mysql_app')->transaction(function () use ($cupom): void {
            $copy = $cupom->replicate();
            $copy->titulo = $cupom->titulo.' (COPIA)';
            $copy->cliques = 0;
            $copy->created_at = now();
            $copy->updated_at = now();
            $copy->save();
        });

        return redirect()->route('admin.cupons.index')->with('success', 'CUPOM DUPLICADO COM SUCESSO.');
    }
}
