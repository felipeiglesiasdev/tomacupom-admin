<!-- Envolvendo o formulário com AlpineJS para controlar o campo de código dinamicamente -->
<div x-data="{ tipoCupom: '{{ old('tipo', $cupom->tipo ?? 1) }}' }" class="space-y-6 mb-8">
    
    <!-- Linha 1: Loja e Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-2 md:col-span-2">
            <label for="id_loja" class="block text-sm font-bold text-[#222222]">
                Loja Parceira <span class="text-[#fe4b09]">*</span>
            </label>
            <select name="id_loja" 
                    id="id_loja" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] bg-white cursor-pointer @error('id_loja') border-red-500 @enderror" 
                    required>
                <option value="">Selecione a loja deste cupom...</option>
                @foreach($lojas as $lojaItem)
                    <option value="{{ $lojaItem->id_loja }}" {{ old('id_loja', $cupom->id_loja ?? '') == $lojaItem->id_loja ? 'selected' : '' }}>
                        {{ $lojaItem->nome }}
                    </option>
                @endforeach
            </select>
            @error('id_loja') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label for="status" class="block text-sm font-bold text-[#222222]">
                Status <span class="text-[#fe4b09]">*</span>
            </label>
            <select name="status" 
                    id="status" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] bg-white cursor-pointer">
                <option value="1" {{ old('status', $cupom->status ?? 1) == 1 ? 'selected' : '' }}>Ativo</option>
                <option value="0" {{ old('status', $cupom->status ?? 1) == 0 ? 'selected' : '' }}>Inativo</option>
            </select>
            @error('status') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Linha 2: Título do Cupom -->
    <div class="space-y-2">
        <label for="titulo" class="block text-sm font-bold text-[#222222]">
            Título do Cupom <span class="text-[#fe4b09]">*</span>
        </label>
        <input type="text" 
               name="titulo" 
               id="titulo" 
               value="{{ old('titulo', $cupom->titulo ?? '') }}" 
               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('titulo') border-red-500 @enderror" 
               placeholder="Ex: 15% OFF em todo o site na primeira compra"
               required>
        @error('titulo') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Linha 3: Tipo e Código (Interativo) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 pt-6">
        <div class="space-y-2">
            <label for="tipo" class="block text-sm font-bold text-[#222222]">
                Tipo de Desconto <span class="text-[#fe4b09]">*</span>
            </label>
            <select name="tipo" 
                    id="tipo" 
                    x-model="tipoCupom"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] bg-white cursor-pointer @error('tipo') border-red-500 @enderror"
                    required>
                <option value="1">Cupom com Código (Requer digitação)</option>
                <option value="2">Cupom sem Código (Oferta / Link Direto)</option>
            </select>
            @error('tipo') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>

        <!-- Campo Código (Só aparece se tipo == 1) -->
        <div class="space-y-2" x-show="tipoCupom == '1'" x-transition x-cloak>
            <label for="codigo" class="block text-sm font-bold text-[#222222]">
                Código do Cupom
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="bi bi-ticket-detailed text-[#fe4b09]"></i>
                </div>
                <input type="text" 
                       name="codigo" 
                       id="codigo" 
                       value="{{ old('codigo', $cupom->codigo ?? '') }}" 
                       class="w-full pl-11 border border-gray-300 rounded-lg pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] font-mono uppercase font-bold @error('codigo') border-red-500 @enderror" 
                       placeholder="Ex: TOMA15">
            </div>
            @error('codigo') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Linha 4: Link de Redirecionamento -->
    <div class="space-y-2 border-t border-gray-100 pt-6">
        <label for="link_redirecionamento" class="block text-sm font-bold text-[#222222]">
            Link de Redirecionamento (URL do Afiliado)
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="bi bi-link-45deg text-gray-400"></i>
            </div>
            <input type="url" 
                   name="link_redirecionamento" 
                   id="link_redirecionamento" 
                   value="{{ old('link_redirecionamento', $cupom->link_redirecionamento ?? '') }}" 
                   class="w-full pl-10 border border-gray-300 rounded-lg pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('link_redirecionamento') border-red-500 @enderror" 
                   placeholder="https://awin1.com/cread.php?...">
        </div>
        <p class="text-gray-400 text-xs mt-1">Se deixado em branco, o sistema utilizará o link padrão cadastrado na Loja.</p>
        @error('link_redirecionamento') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Linha 5: Datas de Validade -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 pt-6">
        <div class="space-y-2">
            <label for="data_inicio" class="block text-sm font-bold text-[#222222]">
                Data de Início (Opcional)
            </label>
            <input type="date" 
                   name="data_inicio" 
                   id="data_inicio" 
                   value="{{ old('data_inicio', isset($cupom->data_inicio) ? \Carbon\Carbon::parse($cupom->data_inicio)->format('Y-m-d') : '') }}" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('data_inicio') border-red-500 @enderror">
            @error('data_inicio') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label for="data_expiracao" class="block text-sm font-bold text-[#222222]">
                Data de Expiração (Opcional)
            </label>
            <input type="date" 
                   name="data_expiracao" 
                   id="data_expiracao" 
                   value="{{ old('data_expiracao', isset($cupom->data_expiracao) ? \Carbon\Carbon::parse($cupom->data_expiracao)->format('Y-m-d') : '') }}" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('data_expiracao') border-red-500 @enderror">
            <p class="text-gray-400 text-xs mt-1">Deixe em branco se o cupom não tiver validade definida.</p>
            @error('data_expiracao') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Linha 6: Textos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 pt-6">
        <div class="space-y-2">
            <label for="descricao" class="block text-sm font-bold text-[#222222]">
                Descrição do Cupom
            </label>
            <textarea name="descricao" 
                      id="descricao" 
                      rows="4" 
                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('descricao') border-red-500 @enderror" 
                      placeholder="Ex: Válido para produtos vendidos e entregues pela loja...">{{ old('descricao', $cupom->descricao ?? '') }}</textarea>
            @error('descricao') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label for="regras" class="block text-sm font-bold text-[#222222]">
                Regras e Restrições
            </label>
            <textarea name="regras" 
                      id="regras" 
                      rows="4" 
                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('regras') border-red-500 @enderror" 
                      placeholder="Ex: Não aplicável em lançamentos e iPhones...">{{ old('regras', $cupom->regras ?? '') }}</textarea>
            @error('regras') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

</div>

<!-- Botões de Ação -->
<div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6 mt-2">
    <a href="{{ route('admin.cupons.index') }}" class="cursor-pointer bg-white border border-gray-300 text-[#222222] hover:bg-gray-50 font-bold py-3 px-6 rounded-lg transition-colors">
        Cancelar
    </a>
    <button type="submit" class="cursor-pointer bg-[#fe4b09] hover:bg-[#e04308] text-white font-bold py-3 px-8 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg">
        <i class="bi bi-check-lg text-xl"></i> {{ isset($cupom) ? 'Salvar Alterações' : 'Criar Cupom' }}
    </button>
</div>