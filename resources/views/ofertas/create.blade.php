@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Cabeçalho -->
    <div class="mb-8">
        <a href="{{ route('admin.ofertas.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#fe4b09] mb-3 transition-colors cursor-pointer">
            <i class="bi bi-arrow-left"></i> Voltar para Lista
        </a>
        <h1 class="text-3xl md:text-4xl font-bold text-[#222222]">Cadastrar Nova Oferta</h1>
        <p class="text-gray-500 mt-2">Preencha as informações para divulgar uma nova oferta de um parceiro.</p>
    </div>

    <!-- Formulário Wrapper -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10">
        <form action="{{ route('admin.ofertas.store') }}" method="POST">
            @csrf
            @include('ofertas._form')
        </form>
    </div>
</div>
@endsection