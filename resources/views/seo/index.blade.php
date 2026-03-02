@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-[#222222]">SEO & Meta Tags</h1>
        <p class="text-gray-500 text-sm mt-1">Gerencie a otimização de busca (Google) de todas as Lojas Parceiras.</p>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-sm mb-8 flex items-center gap-3">
        <i class="bi bi-check-circle-fill text-xl text-green-500"></i>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Barra de Busca (Apenas Input Tempo Real e Limpar) -->
    <div class="p-5 border-b border-gray-100 bg-white flex flex-col md:flex-row justify-between items-center gap-4">
        <form action="{{ route('admin.seo.index') }}" method="GET" class="flex flex-col md:flex-row w-full md:max-w-lg gap-3">
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
                    <a href="{{ route('admin.seo.index') }}" class="cursor-pointer bg-gray-100 text-[#222222] hover:bg-gray-200 px-4 py-2.5 rounded-lg font-medium transition-colors flex items-center justify-center" title="Limpar Busca">
                        <i class="bi bi-x-lg md:hidden"></i>
                        <span class="hidden md:inline">Limpar</span>
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Tabela -->
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider">Loja Parceira</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider">URL Pública</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider text-center">Saúde do SEO</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider text-right w-32">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($lojas as $loja)
                    @php
                        $seo = $loja->seo;
                        $temPendencias = !$seo || empty($seo->title_seo) || empty($seo->description_seo) || empty($seo->keywords_seo);
                    @endphp
                    
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <!-- Coluna: Logo e Nome (Logo pura w-14 h-14 com border-radius) -->
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center gap-4">
                                @if($loja->logo_image_link)
                                    <img src="{{ $loja->logo_image_link }}" alt="Logo {{ $loja->nome }}" class="w-15 h-15 object-contain rounded-xl flex-shrink-0">
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

                        <!-- Coluna: Status do SEO -->
                        <td class="px-6 py-4 text-sm text-center align-middle">
                            @if($temPendencias)
                                <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200" title="Faltam preencher os campos Title, Description ou Keywords">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Incompleto
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                    <i class="bi bi-check-circle-fill"></i> Otimizado
                                </span>
                            @endif
                        </td>

                        <!-- Coluna: Ações (Botão alinhado ao centro verticalmente) -->
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Editar SEO -->
                                <a href="{{ route('admin.seo.edit', $loja->id_loja) }}" 
                                   class="cursor-pointer text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 px-4 py-2 flex items-center gap-2 rounded-md transition-all font-medium text-sm shadow-sm" 
                                   title="Configurar Meta Tags">
                                    <i class="bi bi-google"></i> Configurar
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="bi bi-google text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-bold text-[#222222] mb-1">Nenhuma loja encontrada</h3>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginação -->
    @if(method_exists($lojas, 'hasPages') && $lojas->hasPages())
        <div class="p-5 border-t border-gray-100 bg-white">
            {{ $lojas->links() }}
        </div>
    @endif
</div>
@endsection