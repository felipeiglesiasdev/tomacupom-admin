<div class="space-y-6 mb-8">
    
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
                <option value="">Selecione uma loja...</option>
                @foreach($lojas as $lojaItem)
                    <option value="{{ $lojaItem->id_loja }}" {{ old('id_loja', $oferta->id_loja ?? '') == $lojaItem->id_loja ? 'selected' : '' }}>
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
                <option value="1" {{ old('status', $oferta->status ?? 1) == 1 ? 'selected' : '' }}>Ativa</option>
                <option value="0" {{ old('status', $oferta->status ?? 1) == 0 ? 'selected' : '' }}>Inativa</option>
            </select>
            @error('status') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Linha 2: Título da Oferta -->
    <div class="space-y-2">
        <label for="titulo" class="block text-sm font-bold text-[#222222]">
            Título da Oferta <span class="text-[#fe4b09]">*</span>
        </label>
        <input type="text" 
               name="titulo" 
               id="titulo" 
               value="{{ old('titulo', $oferta->titulo ?? '') }}" 
               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('titulo') border-red-500 @enderror" 
               placeholder="Ex: Smartphone Samsung Galaxy S23 com 30% OFF"
               required>
        @error('titulo') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Linha 3: Link e Imagem -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 pt-6">
        <div class="space-y-2">
            <label for="link_oferta" class="block text-sm font-bold text-[#222222]">
                Link de Destino (URL da Oferta) <span class="text-[#fe4b09]">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-link-45deg text-gray-400"></i>
                </div>
                <input type="url" 
                       name="link_oferta" 
                       id="link_oferta" 
                       value="{{ old('link_oferta', $oferta->link_oferta ?? '') }}" 
                       class="w-full pl-10 border border-gray-300 rounded-lg pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('link_oferta') border-red-500 @enderror" 
                       placeholder="https://loja.com/produto"
                       required>
            </div>
            @error('link_oferta') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label for="imagem_oferta" class="block text-sm font-bold text-[#222222]">
                Link da Imagem (Opcional)
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-image text-gray-400"></i>
                </div>
                <input type="url" 
                       name="imagem_oferta" 
                       id="imagem_oferta" 
                       value="{{ old('imagem_oferta', $oferta->imagem_oferta ?? '') }}" 
                       class="w-full pl-10 border border-gray-300 rounded-lg pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('imagem_oferta') border-red-500 @enderror" 
                       placeholder="https://site.com/imagem-produto.png">
            </div>
            @error('imagem_oferta') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Linha 4: Datas de Validade -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 pt-6">
        <div class="space-y-2">
            <label for="data_inicio" class="block text-sm font-bold text-[#222222]">
                Data de Início (Opcional)
            </label>
            <input type="date" 
                   name="data_inicio" 
                   id="data_inicio" 
                   value="{{ old('data_inicio', isset($oferta->data_inicio) ? \Carbon\Carbon::parse($oferta->data_inicio)->format('Y-m-d') : '') }}" 
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
                   value="{{ old('data_expiracao', isset($oferta->data_expiracao) ? \Carbon\Carbon::parse($oferta->data_expiracao)->format('Y-m-d') : '') }}" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('data_expiracao') border-red-500 @enderror">
            @error('data_expiracao') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Linha 5: Descrição -->
    <div class="space-y-2 border-t border-gray-100 pt-6">
        <label for="descricao" class="block text-sm font-bold text-[#222222]">
            Descrição da Oferta (Opcional)
        </label>
        <textarea name="descricao" 
                  id="descricao" 
                  rows="4" 
                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('descricao') border-red-500 @enderror" 
                  placeholder="Detalhes adicionais sobre as condições da oferta...">{{ old('descricao', $oferta->descricao ?? '') }}</textarea>
        @error('descricao') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
    </div>

</div>

<!-- Botões de Ação -->
<div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6 mt-2">
    <a href="{{ route('admin.ofertas.index') }}" class="cursor-pointer bg-white border border-gray-300 text-[#222222] hover:bg-gray-50 font-bold py-3 px-6 rounded-lg transition-colors">
        Cancelar
    </a>
    <button type="submit" class="cursor-pointer bg-[#fe4b09] hover:bg-[#e04308] text-white font-bold py-3 px-8 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg">
        <i class="bi bi-check-lg text-xl"></i> {{ isset($oferta) ? 'Salvar Alterações' : 'Criar Oferta' }}
    </button>
</div>