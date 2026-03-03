@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-[#222222]">Ofertas Cadastradas</h1>
        <p class="text-gray-500 text-sm mt-1">Gerencie produtos e promoções diretas vinculadas às lojas.</p>
    </div>
    <a href="{{ route('admin.ofertas.create') }}" class="cursor-pointer bg-[#fe4b09] hover:bg-[#e04308] text-white font-semibold py-2.5 px-5 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg w-full md:w-auto justify-center">
        <i class="bi bi-plus-circle text-lg"></i> Nova Oferta
    </a>
</div>

@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-sm mb-8 flex items-center gap-3">
        <i class="bi bi-check-circle-fill text-xl text-green-500"></i>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Barra de Filtros (Selects Inteligentes com Alpine) -->
    <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row gap-4">
        <form action="{{ route('admin.ofertas.index') }}" method="GET" class="w-full flex flex-col md:flex-row gap-4" x-data>
            
            <!-- Filtro: Loja -->
            <div class="flex-1">
                <select name="id_loja" @change="$el.form.submit()" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-sm text-[#222222] bg-white cursor-pointer">
                    <option value="">Todas as Lojas</option>
                    @foreach($lojas as $lojaFiltro)
                        <option value="{{ $lojaFiltro->id_loja }}" {{ request('id_loja') == $lojaFiltro->id_loja ? 'selected' : '' }}>
                            {{ $lojaFiltro->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro: Status -->
            <div class="w-full md:w-48">
                <select name="status" @change="$el.form.submit()" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-sm text-[#222222] bg-white cursor-pointer">
                    <option value="">Status (Todos)</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativa</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativa</option>
                </select>
            </div>

            <!-- Filtro: Expiração -->
            <div class="w-full md:w-56">
                <select name="expiracao" @change="$el.form.submit()" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-sm text-[#222222] bg-white cursor-pointer">
                    <option value="">Expiração (Qualquer data)</option>
                    <option value="hoje" {{ request('expiracao') === 'hoje' ? 'selected' : '' }}>Vence Hoje</option>
                    <option value="7dias" {{ request('expiracao') === '7dias' ? 'selected' : '' }}>Vence em até 7 dias</option>
                </select>
            </div>

            <!-- Botão Limpar -->
            @if(request()->hasAny(['id_loja', 'status', 'expiracao']) && (request('id_loja') != '' || request('status') != '' || request('expiracao') != ''))
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.ofertas.index') }}" class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-700 w-full md:w-auto px-4 py-2.5 rounded-lg font-medium transition-colors flex items-center justify-center gap-2 text-sm">
                        <i class="bi bi-x-lg"></i> Limpar
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Tabela de Ofertas -->
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider">Oferta</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider">Loja</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider text-center">Validade</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-[#222222] text-xs uppercase tracking-wider text-right w-32">Ações</th>
                </tr>
            </thead>
            
            @forelse($ofertas as $oferta)
                <tbody x-data="{ expanded: false }" class="border-b border-gray-100 last:border-0">
                    <tr class="hover:bg-orange-50/30 transition-colors group">
                        
                        <!-- Coluna: Título da Oferta -->
                        <td class="px-6 py-4 align-middle">
                            <span class="text-sm font-bold text-[#222222] whitespace-normal line-clamp-2" title="{{ $oferta->titulo }}">
                                {{ $oferta->titulo }}
                            </span>
                        </td>

                        <!-- Coluna: Loja -->
                        <td class="px-6 py-4 text-sm align-middle text-gray-600 font-medium">
                            {{ $oferta->loja ? $oferta->loja->nome : 'Loja não encontrada' }}
                        </td>

                        <!-- Coluna: Expiração -->
                        <td class="px-6 py-4 text-sm text-center align-middle">
                            @if($oferta->data_expiracao)
                                @php
                                    $isExpired = \Carbon\Carbon::parse($oferta->data_expiracao)->isPast();
                                @endphp
                                <span class="{{ $isExpired ? 'text-red-500 font-bold' : 'text-gray-600' }}">
                                    {{ \Carbon\Carbon::parse($oferta->data_expiracao)->format('d/m/Y') }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs italic">Ilimitado</span>
                            @endif
                        </td>

                        <!-- Coluna: Status -->
                        <td class="px-6 py-4 text-sm text-center align-middle">
                            @if($oferta->status == 1)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Ativa</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Inativa</span>
                            @endif
                        </td>

                        <!-- Coluna: Ações -->
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Expandir -->
                                <button @click="expanded = !expanded" 
                                        class="cursor-pointer text-gray-600 hover:text-[#fe4b09] bg-gray-100 hover:bg-[#fe4b09]/10 h-9 w-9 flex items-center justify-center rounded-md transition-all" 
                                        title="Ver Detalhes">
                                    <i class="bi transition-transform duration-300" :class="expanded ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                                </button>
                                
                                <!-- Editar -->
                                <a href="{{ route('admin.ofertas.edit', $oferta->id_oferta) }}" 
                                   class="cursor-pointer text-[#fe4b09] hover:text-white bg-[#fe4b09]/10 hover:bg-[#fe4b09] h-9 w-9 flex items-center justify-center rounded-md transition-all" 
                                   title="Editar">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>

                                <!-- Excluir -->
                                <form action="{{ route('admin.ofertas.destroy', $oferta->id_oferta) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta oferta?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cursor-pointer text-red-500 hover:text-white bg-red-50 hover:bg-red-500 h-9 w-9 flex items-center justify-center rounded-md transition-all" title="Excluir">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Aba Expansível -->
                    <tr x-show="expanded" x-transition.opacity x-cloak class="bg-gray-50/50">
                        <td colspan="5" class="px-6 py-6 whitespace-normal border-t border-gray-100">
                            <div class="flex flex-col md:flex-row gap-6">
                                
                                <!-- Preview da Imagem -->
                                <div class="w-full md:w-32 h-32 bg-white rounded-xl border border-gray-200 flex items-center justify-center flex-shrink-0 p-2 shadow-sm overflow-hidden">
                                    @if(!empty($oferta->imagem_oferta))
                                        <img src="{{ $oferta->imagem_oferta }}" alt="Imagem" class="max-w-full max-h-full object-cover rounded">
                                    @else
                                        <div class="text-center text-gray-400">
                                            <i class="bi bi-image text-3xl"></i>
                                            <p class="text-[10px] uppercase mt-1">Sem imagem</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Detalhes -->
                                <div class="flex-1 space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Data de Início</p>
                                            <p class="text-sm text-[#222222] font-medium">
                                                {{ $oferta->data_inicio ? \Carbon\Carbon::parse($oferta->data_inicio)->format('d/m/Y') : 'Não estipulado' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Link de Destino</p>
                                            @if($oferta->link_oferta)
                                                <a href="{{ $oferta->link_oferta }}" target="_blank" rel="nofollow" class="cursor-pointer text-sm text-blue-600 hover:underline flex items-center gap-1 w-max break-all">
                                                    Abrir Oferta <i class="bi bi-box-arrow-up-right text-xs"></i>
                                                </a>
                                            @else
                                                <p class="text-sm text-gray-500">Sem link associado</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="border-t border-gray-200 pt-3">
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Descrição</p>
                                        <p class="text-sm text-gray-600 leading-relaxed bg-white p-3 rounded-lg border border-gray-100">
                                            {{ $oferta->descricao ?: 'Nenhuma descrição detalhada informada para esta oferta.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            @empty
                <tbody>
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="bi bi-lightning-charge text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-bold text-[#222222] mb-1">Nenhuma oferta encontrada</h3>
                            <p class="text-gray-500 text-sm">Cadastre novas ofertas ou altere os filtros de busca acima.</p>
                        </td>
                    </tr>
                </tbody>
            @endforelse
        </table>
    </div>
    
    <!-- Paginação -->
    @if(method_exists($ofertas, 'hasPages') && $ofertas->hasPages())
        <div class="p-5 border-t border-gray-100 bg-white">
            {{ $ofertas->links() }}
        </div>
    @endif
</div>
@endsection