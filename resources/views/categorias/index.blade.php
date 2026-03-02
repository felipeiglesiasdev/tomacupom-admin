@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-[#222222]">Categorias</h1>
        <p class="text-gray-500 text-sm mt-1">Gerencie as categorias de lojas e ofertas do <span class="font-semibold text-[#fe4b09]">Toma Cupom</span>.</p>
    </div>
    <a href="{{ route('admin.categorias.create') }}" class="cursor-pointer bg-[#fe4b09] hover:bg-[#e04308] text-white font-semibold py-2.5 px-5 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg w-full md:w-auto justify-center">
        <i class="bi bi-plus-circle text-lg"></i> Nova Categoria
    </a>
</div>

<!-- Alertas de Feedback -->
@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-sm mb-8 flex items-center gap-3">
        <i class="bi bi-check-circle-fill text-xl text-green-500"></i>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Barra de Busca -->
    <div class="p-5 border-b border-gray-100 bg-white flex flex-col md:flex-row justify-between items-center gap-4">
        <form action="{{ route('admin.categorias.index') }}" method="GET" class="flex flex-col md:flex-row w-full md:max-w-lg gap-3">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-search text-gray-400"></i>
                </div>
                <input type="text" 
                       name="busca" 
                       value="{{ request('busca') }}" 
                       placeholder="Buscar por nome ou slug..." 
                       class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg focus:ring-[#fe4b09] focus:border-[#fe4b09] sm:text-sm transition-colors text-[#222222]">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="cursor-pointer bg-[#222222] hover:bg-black text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex-1 md:flex-none text-center">
                    Buscar
                </button>
                @if(request('busca'))
                    <a href="{{ route('admin.categorias.index') }}" class="cursor-pointer bg-gray-100 text-[#222222] hover:bg-gray-200 px-4 py-2.5 rounded-lg font-medium transition-colors flex items-center justify-center">
                        <i class="bi bi-x-lg md:hidden"></i>
                        <span class="hidden md:inline">Limpar</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabela de Categorias -->
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider">Nome da Categoria</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider">Slug (URL)</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider text-right w-32">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categorias as $categoria)
                    <tr class="hover:bg-orange-50/30 transition-colors group">
                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $categoria->id_categoria }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-[#222222]">{{ $categoria->nome }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-md text-xs border border-gray-200 font-mono">{{ $categoria->slug }}</span>
                        </td>
                        <td class="px-6 py-4 flex justify-end gap-2">
                            <a href="{{ route('admin.categorias.edit', $categoria->id_categoria) }}" 
                               class="cursor-pointer text-[#fe4b09] hover:text-white bg-[#fe4b09]/10 hover:bg-[#fe4b09] h-9 w-9 flex items-center justify-center rounded-md transition-all" 
                               title="Editar">
                                <i class="bi bi-pencil-square text-lg"></i>
                            </a>
                            <form action="{{ route('admin.categorias.destroy', $categoria->id_categoria) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir a categoria {{ $categoria->nome }}?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="cursor-pointer text-red-500 hover:text-white bg-red-50 hover:bg-red-500 h-9 w-9 flex items-center justify-center rounded-md transition-all" 
                                        title="Excluir">
                                    <i class="bi bi-trash text-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="bi bi-grid text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-bold text-[#222222] mb-1">Nenhuma categoria encontrada</h3>
                            @if(request('busca'))
                                <p class="text-gray-500 text-sm">Não encontramos resultados para a sua busca. Tente palavras diferentes.</p>
                            @else
                                <p class="text-gray-500 text-sm">Você ainda não cadastrou nenhuma categoria no Toma Cupom.</p>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginação -->
    @if($categorias->hasPages())
        <div class="p-5 border-t border-gray-100 bg-white">
            {{ $categorias->links() }}
        </div>
    @endif
</div>
@endsection