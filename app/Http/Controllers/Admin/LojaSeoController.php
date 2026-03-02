<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateLojaSeoRequest;
use App\Models\Loja;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LojaSeoController extends Controller
{
    public function edit(Loja $loja): View
    {
        $seo = $loja->seo()->firstOrCreate(['id_loja' => $loja->id_loja]);

        return view('lojas.seo-edit', compact('loja', 'seo'));
    }

    public function update(UpdateLojaSeoRequest $request, Loja $loja): RedirectResponse
    {
        $loja->seo()->updateOrCreate(['id_loja' => $loja->id_loja], $request->validated());

        return redirect()->route('admin.lojas.index')->with('success', 'SEO DA LOJA ATUALIZADO.');
    }
}
