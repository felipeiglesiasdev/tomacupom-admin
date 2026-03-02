<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateLojaSeoRequest;
use App\Models\Loja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LojaSeoController extends Controller
{
    // ===================================================
    // LISTAGEM DAS LOJAS PARA GERENCIAMENTO DE SEO
    // ===================================================

    public function index(Request $request): View
    {
        // Puxa as lojas e traz as informações do relacionamento seo()
        $query = Loja::query()->with('seo')->ordenadas();

        if ($request->filled('busca')) {
            $term = '%' . $request->string('busca') . '%';
            $query->where(function ($inner) use ($term): void {
                $inner->where('nome', 'like', $term)
                      ->orWhere('slug', 'like', $term);
            });
        }

        return view('seo.index', [
            'lojas' => $query->paginate(15)->withQueryString(),
        ]);
    }

    // ===================================================
    // FORM DE EDICAO DO SEO DA LOJA
    // ===================================================

    public function edit(Loja $loja): View
    {
        // ===================================================
        // GARANTIR QUE EXISTA UM REGISTRO SEO PARA ESTA LOJA
        // SE NAO EXISTIR, CRIA AUTOMATICAMENTE
        // ===================================================
        $seo = $loja->seo()->firstOrCreate([
            'id_loja' => $loja->id_loja,
        ]);

        return view('seo.edit', compact('loja', 'seo'));
    }

    // ===================================================
    // ATUALIZAR SEO DA LOJA
    // ===================================================

    public function update(UpdateLojaSeoRequest $request, Loja $loja): RedirectResponse
    {
        $loja->seo()->updateOrCreate(
            ['id_loja' => $loja->id_loja],
            $request->validated()
        );

        return redirect()
            ->route('admin.seo.index')
            ->with('success', "SEO da loja {$loja->nome} atualizado com sucesso!");
    }
}