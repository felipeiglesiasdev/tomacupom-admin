<div class="space-y-6 mb-8">
    <!-- Campo nome -->
    <div class="space-y-2">
        <label for="nome" class="block text-sm font-bold text-[#222222]">
            Nome da Categoria <span class="text-[#fe4b09]">*</span>
        </label>
        <input type="text" 
               name="nome" 
               id="nome" 
               value="{{ old('nome', $categoria->nome ?? '') }}" 
               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] @error('nome') border-red-500 ring-red-500/20 @enderror" 
               placeholder="Ex: Smartphones e Celulares"
               required>
        @error('nome')
            <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Campo slug -->
    <div class="space-y-2">
        <label for="slug" class="block text-sm font-bold text-[#222222]">
            Slug da URL <span class="text-[#fe4b09]">*</span>
        </label>
        <div class="flex rounded-lg shadow-sm">
            <span class="inline-flex items-center px-4 md:px-6 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-xs md:text-sm font-mono whitespace-nowrap overflow-hidden">
                tomacupom.com.br/categorias/
            </span>
            <input type="text" 
                   name="slug" 
                   id="slug" 
                   value="{{ old('slug', $categoria->slug ?? '') }}" 
                   class="flex-1 block w-full border border-gray-300 rounded-none rounded-r-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] font-mono @error('slug') border-red-500 @enderror" 
                   placeholder="smartphones-e-celulares"
                   required>
        </div>
        @error('slug')
            <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
        @enderror
        <p class="text-gray-400 text-xs mt-1">Evite acentos e use traços (-) no lugar de espaços.</p>
    </div>
</div>

<div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6 mt-2">
    <a href="{{ route('admin.categorias.index') }}" class="cursor-pointer bg-white border border-gray-300 text-[#222222] hover:bg-gray-50 font-bold py-3 px-6 rounded-lg transition-colors">
        Cancelar
    </a>
    <button type="submit" class="cursor-pointer bg-[#fe4b09] hover:bg-[#e04308] text-white font-bold py-3 px-8 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg">
        <i class="bi bi-check-lg text-xl"></i> Salvar Categoria
    </button>
</div>