<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cupom;
use App\Models\Loja;
use App\Models\Oferta;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalLojasAtivas' => Loja::query()->ativas()->count(),
            'totalCuponsAtivos' => Cupom::query()->ativas()->count(),
            'totalOfertasAtivas' => Oferta::query()->ativas()->count(),
            'totalCategorias' => Categoria::query()->count(),
            'totalCliques' => Cupom::query()->sum('cliques') + Oferta::query()->sum('cliques'),
        ]);
    }
}
