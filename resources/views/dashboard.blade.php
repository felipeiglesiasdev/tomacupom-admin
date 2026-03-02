@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500 mt-1">Resumo do painel administrativo de cupons.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Lojas Ativas</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalLojasAtivas }}</h2>
        </div>
        <div class="bg-blue-100 p-3 rounded-lg text-blue-600">
            <i class="bi bi-shop text-2xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Cupons Ativos</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalCuponsAtivos }}</h2>
        </div>
        <div class="bg-green-100 p-3 rounded-lg text-green-600">
            <i class="bi bi-ticket-perforated text-2xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Ofertas Ativas</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalOfertasAtivas }}</h2>
        </div>
        <div class="bg-yellow-100 p-3 rounded-lg text-yellow-600">
            <i class="bi bi-tags text-2xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Categorias</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalCategorias }}</h2>
        </div>
        <div class="bg-purple-100 p-3 rounded-lg text-purple-600">
            <i class="bi bi-grid text-2xl"></i>
        </div>
    </div>
</div>
@endsection