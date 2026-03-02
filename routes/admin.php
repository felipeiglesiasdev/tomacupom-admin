<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\CupomController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LojaCategoriaController;
use App\Http\Controllers\Admin\LojaController;
use App\Http\Controllers\Admin\LojaSeoController;
use App\Http\Controllers\Admin\OfertaController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('lojas', LojaController::class)->except(['show']);
    // CRUD DE SEO (Novo)
    Route::get('seo', [LojaSeoController::class, 'index'])->name('seo.index');
    Route::get('seo/{loja}/edit', [LojaSeoController::class, 'edit'])->name('seo.edit');
    Route::put('seo/{loja}', [LojaSeoController::class, 'update'])->name('seo.update');

    Route::get('lojas/{loja}/categorias', [LojaCategoriaController::class, 'edit'])->name('lojas.categorias.edit');
    Route::put('lojas/{loja}/categorias', [LojaCategoriaController::class, 'update'])->name('lojas.categorias.update');
    
    Route::post('cupons/{cupom}/duplicate', [CupomController::class, 'duplicate'])->name('cupons.duplicate');
    Route::resource('cupons', CupomController::class)->except(['show']);
    Route::resource('ofertas', OfertaController::class)->except(['show']);
    Route::resource('categorias', CategoriaController::class)->except(['show']);
});
