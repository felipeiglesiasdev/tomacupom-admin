@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Cabeçalho -->
    <div class="mb-8">
        <a href="{{ route('admin.categorias.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#fe4b09] mb-3 transition-colors cursor-pointer">
            <i class="bi bi-arrow-left"></i> Voltar para categorias
        </a>
        <h1 class="text-3xl md:text-4xl font-bold text-[#222222]">
            Editar Categoria: <span class="text-[#fe4b09]">{{ $categoria->nome }}</span>
        </h1>
        <p class="text-gray-500 mt-2">Atualize as informações desta categoria.</p>
    </div>

    <!-- Formulário -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10">
        <form action="{{ route('admin.categorias.update', $categoria->id_categoria) }}" method="POST">
            @csrf
            @method('PUT')
            @include('categorias._form', ['categoria' => $categoria])
        </form>
    </div>
</div>
@endsection