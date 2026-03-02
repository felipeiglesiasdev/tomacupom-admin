@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-[#222222]">Lojas Parceiras</h1>
        <p class="text-gray-500 text-sm mt-1">Gerencie as lojas e e-commerces integrados ao <span class="font-semibold text-[#fe4b09]">Toma Cupom</span>.</p>
    </div>
    <a href="{{ route('admin.lojas.create') }}" class="cursor-pointer bg-[#fe4b09] hover:bg-[#e04308] text-white font-semibold py-2.5 px-5 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg w-full md:w-auto justify-center">
        <i class="bi bi-plus-circle text-lg"></i> Nova Loja
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
    <!-- Barra de Busca (Apenas Input Tempo Real e Limpar) -->
    <div class="p-5 border-b border-gray-100 bg-white flex flex-col md:flex-row justify-between items-center gap-4">
        <form action="{{ route('admin.lojas.index') }}" method="GET" class="flex flex-col md:flex-row w-full md:max-w-lg gap-3">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-search text-gray-400"></i>
                </div>
                <input type="text" 
                       name="busca" 
                       value="{{ request('busca') }}" 
                       x-data
                       x-init="if ($el.value !== '') { setTimeout(() => { $el.focus(); $el.setSelectionRange($el.value.length, $el.value.length); }, 50); }"
                       @input.debounce.500ms="$el.form.submit()"
                       placeholder="Buscar por nome ou slug da loja..." 
                       class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg focus:ring-[#fe4b09] focus:border-[#fe4b09] sm:text-sm transition-colors text-[#222222]">
            </div>
            
            @if(request('busca'))
                <div class="flex gap-2">
                    <a href="{{ route('admin.lojas.index') }}" class="cursor-pointer bg-gray-100 text-[#222222] hover:bg-gray-200 px-4 py-2.5 rounded-lg font-medium transition-colors flex items-center justify-center" title="Limpar Busca">
                        <i class="bi bi-x-lg md:hidden"></i>
                        <span class="hidden md:inline">Limpar</span>
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Tabela de Lojas -->
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider">URL Pública</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider text-right w-48">Ações</th>
                </tr>
            </thead>
            <!-- Alpine.js loop wrapper para isolar o estado expansível de cada linha -->
            @forelse($lojas as $loja)
                <tbody x-data="{ expanded: false }" class="border-b border-gray-100 last:border-0">
                    <tr class="hover:bg-orange-50/30 transition-colors group">
                        
                        <!-- Coluna: Nome (Imagem pura + Nome) -->
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center gap-4">
                                @if($loja->logo_image_link)
                                    <img src="{{ $loja->logo_image_link }}" alt="Logo {{ $loja->nome }}" class="w-14 h-14 object-contain rounded-xl flex-shrink-0">
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-shop text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                                <span class="text-base font-bold text-[#222222]">{{ $loja->nome }}</span>
                            </div>
                        </td>

                        <!-- Coluna: URL -->
                        <td class="px-6 py-4 text-sm align-middle">
                            <a href="https://tomacupom.com.br/cupons/{{ $loja->slug }}" 
                               target="_blank" 
                               rel="nofollow" 
                               class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 hover:underline transition-colors font-mono text-xs bg-blue-50 px-2.5 py-1 rounded border border-blue-100">
                                tomacupom.com.br/cupons/{{ $loja->slug }}
                                <i class="bi bi-box-arrow-up-right text-[10px]"></i>
                            </a>
                        </td>

                        <!-- Coluna: Status -->
                        <td class="px-6 py-4 text-sm text-center align-middle">
                            @if($loja->status == 'ativa' || $loja->status == 1)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Ativa</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Inativa</span>
                            @endif
                        </td>

                        <!-- Coluna: Ações -->
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Botão Expandir Aba -->
                                <button @click="expanded = !expanded" 
                                        class="cursor-pointer text-gray-600 hover:text-[#fe4b09] bg-gray-100 hover:bg-[#fe4b09]/10 h-9 w-9 flex items-center justify-center rounded-md transition-all" 
                                        title="Ver Detalhes">
                                    <i class="bi transition-transform duration-300" :class="expanded ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                                </button>

                                <!-- SEO -->
                                <a href="{{ route('admin.seo.edit', $loja->id_loja) }}" 
                                   class="cursor-pointer text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 h-9 w-9 flex items-center justify-center rounded-md transition-all" 
                                   title="Configurações de SEO">
                                    <i class="bi bi-google text-lg"></i>
                                </a>
                                
                                <!-- Editar -->
                                <a href="{{ route('admin.lojas.edit', $loja->id_loja) }}" 
                                   class="cursor-pointer text-[#fe4b09] hover:text-white bg-[#fe4b09]/10 hover:bg-[#fe4b09] h-9 w-9 flex items-center justify-center rounded-md transition-all" 
                                   title="Editar Loja">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>

                                <!-- Excluir -->
                                <form action="{{ route('admin.lojas.destroy', $loja->id_loja) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir a loja {{ $loja->nome }}?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="cursor-pointer text-red-500 hover:text-white bg-red-50 hover:bg-red-500 h-9 w-9 flex items-center justify-center rounded-md transition-all" 
                                            title="Excluir">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Aba Expansível (Detalhes da Loja) Restaurada Completa -->
                    <tr x-show="expanded" x-transition.opacity x-cloak class="bg-gray-50/50">
                        <td colspan="4" class="px-6 py-6 whitespace-normal border-t border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Coluna 1 do Grid Expansível -->
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Título da Página</p>
                                        <p class="text-sm text-[#222222] font-medium">{{ $loja->titulo_pagina ?: 'Não informado' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Descrição da Página</p>
                                        <p class="text-sm text-gray-600">{{ $loja->descricao_pagina ?: 'Nenhuma descrição informada.' }}</p>
                                    </div>
                                </div>

                                <!-- Coluna 2 do Grid Expansível -->
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">URL Oficial</p>
                                        @if($loja->url_site)
                                            <a href="{{ $loja->url_site }}" target="_blank" rel="nofollow" class="cursor-pointer text-sm text-blue-600 hover:underline flex items-center gap-1 w-max">
                                                {{ $loja->url_site }} <i class="bi bi-box-arrow-up-right text-xs"></i>
                                            </a>
                                        @else
                                            <p class="text-sm text-gray-500 font-medium">Não informado</p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">URL Base Afiliado</p>
                                        <p class="text-sm text-[#222222] font-mono bg-white p-2 border border-gray-200 rounded break-all">
                                            {{ $loja->url_base_afiliado ?: 'Não informado' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Detalhes da Logo (Restaurado) -->
                                <div class="col-span-1 md:col-span-2 border-t border-gray-200 pt-4 mt-2">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Identidade Visual da Loja</p>
                                    <div class="flex items-start md:items-center gap-4 flex-col md:flex-row">
                                        @if($loja->logo_image_link)
                                            <div class="w-16 h-16 rounded-lg border border-gray-200 bg-white shadow-sm flex-shrink-0 p-1 flex items-center justify-center">
                                                <img src="{{ $loja->logo_image_link }}" alt="{{ $loja->alt_text_logo }}" class="max-w-full max-h-full object-contain">
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-xs font-semibold text-gray-500 uppercase">Link da Imagem</p>
                                                <a href="{{ $loja->logo_image_link }}" target="_blank" rel="nofollow" class="text-sm text-blue-600 hover:underline break-all inline-block cursor-pointer">
                                                    {{ $loja->logo_image_link }}
                                                </a>
                                                <p class="text-xs text-gray-500 mt-1"><span class="font-semibold text-gray-700">Alt Text:</span> {{ $loja->alt_text_logo ?: 'Não informado' }}</p>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 font-medium bg-white px-4 py-2 rounded border border-gray-200">Nenhuma imagem de logo cadastrada.</p>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                        </td>
                    </tr>
                </tbody>
            @empty
                <tbody>
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="bi bi-shop text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-bold text-[#222222] mb-1">Nenhuma loja encontrada</h3>
                            <p class="text-gray-500 text-sm">Não encontramos resultados. Tente palavras diferentes ou cadastre uma nova loja.</p>
                        </td>
                    </tr>
                </tbody>
            @endforelse
        </table>
    </div>
    
    <!-- Paginação -->
    @if(method_exists($lojas, 'hasPages') && $lojas->hasPages())
        <div class="p-5 border-t border-gray-100 bg-white">
            {{ $lojas->links() }}
        </div>
    @endif
</div>

<!-- Estilo extra para o AlpineJS não piscar a tela ao carregar a aba de expansão -->
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection