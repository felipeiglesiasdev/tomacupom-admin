<div class="space-y-6 mb-8">
    <!-- Linha 1: Nome e Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-2 md:col-span-2">
            <label for="nome" class="block text-sm font-bold text-[#222222]">
                Nome da Loja <span class="text-[#fe4b09]">*</span>
            </label>
            <input type="text" 
                   name="nome" 
                   id="nome" 
                   value="{{ old('nome', $loja->nome ?? '') }}" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('nome') border-red-500 ring-red-500/20 @enderror" 
                   placeholder="Ex: Amazon Brasil"
                   required>
            @error('nome')
                <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="status" class="block text-sm font-bold text-[#222222]">
                Status <span class="text-[#fe4b09]">*</span>
            </label>
            <select name="status" 
                    id="status" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] cursor-pointer">
                <option value="1" {{ old('status', $loja->status ?? 1) == 1 ? 'selected' : '' }}>Ativa</option>
                <option value="0" {{ old('status', $loja->status ?? 1) == 0 ? 'selected' : '' }}>Inativa</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Linha 2: Slug -->
    <div class="space-y-2">
        <label for="slug" class="block text-sm font-bold text-[#222222]">
            Slug da URL <span class="text-[#fe4b09]">*</span>
        </label>
        <div class="flex rounded-lg shadow-sm">
            <span class="inline-flex items-center px-4 md:px-6 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-xs md:text-sm font-mono whitespace-nowrap overflow-hidden">
                tomacupom.com.br/loja/
            </span>
            <input type="text" 
                   name="slug" 
                   id="slug" 
                   value="{{ old('slug', $loja->slug ?? '') }}" 
                   class="flex-1 block w-full border border-gray-300 rounded-none rounded-r-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] font-mono @error('slug') border-red-500 @enderror" 
                   placeholder="amazon-brasil"
                   required>
        </div>
        @error('slug')
            <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Linha 3: Título e Descrição da Página -->
    <div class="space-y-4 border-t border-gray-100 pt-6">
        <div class="space-y-2">
            <label for="titulo_pagina" class="block text-sm font-bold text-[#222222]">
                Título da Página
            </label>
            <input type="text" 
                   name="titulo_pagina" 
                   id="titulo_pagina" 
                   value="{{ old('titulo_pagina', $loja->titulo_pagina ?? '') }}" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222]" 
                   placeholder="Ex: Cupons de Desconto Amazon">
            @error('titulo_pagina')
                <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="descricao_pagina" class="block text-sm font-bold text-[#222222]">
                Descrição da Página
            </label>
            <textarea name="descricao_pagina" 
                      id="descricao_pagina" 
                      rows="3" 
                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222]" 
                      placeholder="Ex: Encontre os melhores cupons e ofertas. Descontos verificados diariamente.">{{ old('descricao_pagina', $loja->descricao_pagina ?? '') }}</textarea>
            @error('descricao_pagina')
                <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Linha 4: URLs Oficiais e de Afiliado -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 pt-6">
        <div class="space-y-2">
            <label for="url_site" class="block text-sm font-bold text-[#222222]">
                URL Oficial do Site
            </label>
            <input type="url" 
                   name="url_site" 
                   id="url_site" 
                   value="{{ old('url_site', $loja->url_site ?? '') }}" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222]" 
                   placeholder="https://www.amazon.com.br">
            @error('url_site')
                <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="url_base_afiliado" class="block text-sm font-bold text-[#222222]">
                URL Base de Afiliado
            </label>
            <input type="url" 
                   name="url_base_afiliado" 
                   id="url_base_afiliado" 
                   value="{{ old('url_base_afiliado', $loja->url_base_afiliado ?? '') }}" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222]" 
                   placeholder="https://awin1.com/cread.php?...">
            @error('url_base_afiliado')
                <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Linha 5: Identidade Visual (Logo) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 pt-6">
        <div class="space-y-2">
            <label for="logo_image_link" class="block text-sm font-bold text-[#222222]">
                Link da Imagem da Logo
            </label>
            <input type="text" 
                   name="logo_image_link" 
                   id="logo_image_link" 
                   value="{{ old('logo_image_link', $loja->logo_image_link ?? '') }}" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222]" 
                   placeholder="https://site.com/logo-loja.png">
            @error('logo_image_link')
                <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="alt_text_logo" class="block text-sm font-bold text-[#222222]">
                Texto Alternativo da Logo (Alt Text)
            </label>
            <input type="text" 
                   name="alt_text_logo" 
                   id="alt_text_logo" 
                   value="{{ old('alt_text_logo', $loja->alt_text_logo ?? '') }}" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222]" 
                   placeholder="Ex: Logo da Amazon Brasil">
            @error('alt_text_logo')
                <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6 mt-2">
    <a href="{{ route('admin.lojas.index') }}" class="cursor-pointer bg-white border border-gray-300 text-[#222222] hover:bg-gray-50 font-bold py-3 px-6 rounded-lg transition-colors">
        Cancelar
    </a>
    <button type="submit" class="cursor-pointer bg-[#fe4b09] hover:bg-[#e04308] text-white font-bold py-3 px-8 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg">
        <i class="bi bi-check-lg text-xl"></i> Salvar Loja
    </button>
</div>