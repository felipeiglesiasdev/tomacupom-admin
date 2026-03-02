@extends('layouts.app')

@section('content')
<!-- O x-data inicia as variáveis do AlpineJS com os dados do banco atualizados para o Request -->
<div class="max-w-7xl mx-auto" 
     x-data="{ 
        titleSeo: '{{ addslashes(old('title_seo', $seo->title_seo ?? '')) }}', 
        descriptionSeo: '{{ addslashes(old('description_seo', $seo->description_seo ?? '')) }}',
        keywordsSeo: '{{ addslashes(old('keywords_seo', $seo->keywords_seo ?? '')) }}',
        viewMode: 'mobile' 
     }">
     
    <!-- Cabeçalho -->
    <div class="mb-8">
        <a href="{{ route('admin.seo.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-blue-600 mb-3 transition-colors cursor-pointer">
            <i class="bi bi-arrow-left"></i> Voltar para Lista de SEO
        </a>
        <h1 class="text-3xl md:text-4xl font-bold text-[#222222]">
            Otimização Google: <span class="text-[#fe4b09]">{{ $loja->nome }}</span>
        </h1>
        <p class="text-gray-500 mt-2">Configure o SEO e o conteúdo HTML da página desta loja.</p>
    </div>

    <!-- ALERTA DE SEO INCOMPLETO -->
    @if(empty($seo->title_seo) || empty($seo->description_seo) || empty($seo->keywords_seo))
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-5 rounded-r-lg shadow-sm mb-8 flex items-start gap-4 animate-pulse">
            <div class="bg-yellow-100 p-2 rounded-full flex-shrink-0">
                <i class="bi bi-exclamation-triangle-fill text-yellow-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-yellow-800 text-lg">Atenção! Faltam informações de SEO nesta loja.</h3>
                <p class="text-sm text-yellow-700 mt-1">Lojas sem meta tags configuradas perdem posições valiosas. Preencha os campos obrigatórios abaixo para melhorar o ranqueamento.</p>
                <ul class="mt-3 space-y-1 text-sm text-yellow-800 font-medium">
                    @if(empty($seo->title_seo)) <li><i class="bi bi-dot text-yellow-500"></i> Falta: Title SEO</li> @endif
                    @if(empty($seo->description_seo)) <li><i class="bi bi-dot text-yellow-500"></i> Falta: Description SEO</li> @endif
                    @if(empty($seo->keywords_seo)) <li><i class="bi bi-dot text-yellow-500"></i> Falta: Palavras-chave (Keywords)</li> @endif
                </ul>
            </div>
        </div>
    @endif

    <!-- Formulário engloba toda a página -->
    <form action="{{ route('admin.seo.update', $loja->id_loja) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Grid Principal (Meta Tags na Esquerda / Preview na Direita) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
            
            <!-- COLUNA ESQUERDA: Formulário Meta Tags -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 h-full">
                    <h2 class="text-xl font-bold text-[#222222] mb-6 border-b border-gray-100 pb-4">Meta Tags (Cabeçalho)</h2>
                    
                    <div class="space-y-6">
                        <!-- Meta Title -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-end">
                                <label for="title_seo" class="block text-sm font-bold text-[#222222]">
                                    Title SEO (Título)
                                </label>
                                <!-- Contador de Caracteres -->
                                <span class="text-xs font-mono font-bold" 
                                      :class="titleSeo.length > 60 ? 'text-red-500' : (titleSeo.length > 40 ? 'text-green-600' : 'text-gray-400')">
                                    <span x-text="titleSeo.length"></span> / 60
                                </span>
                            </div>
                            <input type="text" 
                                   name="title_seo" 
                                   id="title_seo" 
                                   x-model="titleSeo"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-colors text-[#222222] @error('title_seo') border-red-500 @enderror" 
                                   placeholder="Ex: Cupom de Desconto {{ $loja->nome }} - Ofertas Hoje">
                            @error('title_seo') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Meta Description -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-end">
                                <label for="description_seo" class="block text-sm font-bold text-[#222222]">
                                    Description SEO (Descrição)
                                </label>
                                <!-- Contador de Caracteres -->
                                <span class="text-xs font-mono font-bold" 
                                      :class="descriptionSeo.length > 160 ? 'text-red-500' : (descriptionSeo.length > 120 ? 'text-green-600' : 'text-gray-400')">
                                    <span x-text="descriptionSeo.length"></span> / 160
                                </span>
                            </div>
                            <textarea name="description_seo" 
                                      id="description_seo" 
                                      x-model="descriptionSeo"
                                      rows="4" 
                                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-colors text-[#222222] @error('description_seo') border-red-500 @enderror" 
                                      placeholder="Ex: Pegue aqui o melhor cupom de desconto {{ $loja->nome }} válido."></textarea>
                            @error('description_seo') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Keywords -->
                        <div class="space-y-2 border-t border-gray-100 pt-6 mt-4">
                            <label for="keywords_seo" class="block text-sm font-bold text-[#222222]">
                                Palavras-chave (Keywords SEO)
                            </label>
                            <input type="text" 
                                   name="keywords_seo" 
                                   id="keywords_seo" 
                                   x-model="keywordsSeo"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-colors text-[#222222] @error('keywords_seo') border-red-500 @enderror" 
                                   placeholder="Ex: cupom {{ strtolower($loja->nome) }}, desconto {{ strtolower($loja->nome) }}">
                            <p class="text-gray-400 text-xs mt-1">A primeira palavra (antes da vírgula) será usada como texto alternativo da logo.</p>
                            @error('keywords_seo') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUNA DIREITA: Preview do Google (Aprimorado) -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                    
                    <!-- Abas Desktop / Mobile -->
                    <div class="flex items-center border-b border-gray-100 bg-gray-50">
                        <button @click="viewMode = 'mobile'" type="button" 
                                class="flex-1 py-3 text-sm font-bold flex items-center justify-center gap-2 cursor-pointer transition-colors"
                                :class="viewMode === 'mobile' ? 'text-blue-600 border-b-2 border-blue-600 bg-white' : 'text-gray-500 hover:text-gray-700'">
                            <i class="bi bi-phone"></i> Mobile
                        </button>
                        <button @click="viewMode = 'desktop'" type="button" 
                                class="flex-1 py-3 text-sm font-bold flex items-center justify-center gap-2 cursor-pointer transition-colors"
                                :class="viewMode === 'desktop' ? 'text-blue-600 border-b-2 border-blue-600 bg-white' : 'text-gray-500 hover:text-gray-700'">
                            <i class="bi bi-display"></i> Desktop
                        </button>
                    </div>

                    <!-- Container do Preview -->
                    <div class="p-6 bg-[#f8f9fa] flex justify-center min-h-[250px] h-full items-start">
                        
                        <!-- PREVIEW MOBILE -->
                        <div x-show="viewMode === 'mobile'" class="w-full max-w-[375px] bg-white rounded-xl shadow-sm p-4 font-sans border border-gray-200" x-cloak>
                            <div class="flex items-center gap-3 mb-3">
                                <!-- Favicon SVG Sem Borda/Fundo -->
                                <div class="w-7 h-7 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ asset('tomacupom.svg') }}" class="w-full h-full object-contain" alt="Toma Cupom Favicon">
                                </div>
                                <div class="leading-tight">
                                    <div class="text-[14px] text-[#202124] font-normal">Toma Cupom</div>
                                    <div class="text-[12px] text-[#4d5156] truncate w-60">tomacupom.com.br › cupons › {{ $loja->slug }}</div>
                                </div>
                                <i class="bi bi-three-dots-vertical text-gray-500 ml-auto"></i>
                            </div>
                            
                            <!-- Título mais pesado (font-semibold) -->
                            <div class="text-[20px] text-[#1a0dab] leading-[1.3] mb-1 font-semibold break-words" 
                                 x-text="titleSeo || 'Título da página aparecerá aqui'"></div>
                                 
                            <!-- Description + Imagem da Loja -->
                            <div class="flex gap-4 mt-2">
                                <div class="flex-1">
                                    <div class="text-[14px] text-[#4d5156] leading-snug line-clamp-3 break-words" 
                                         x-text="descriptionSeo || 'Forneça uma descrição preenchendo o campo ao lado.'"></div>
                                </div>
                                
                                @if($loja->logo_image_link)
                                    <!-- Thumbnail da Loja: Sem padding/borda, apenas o border-radius na imagem -->
                                    <img src="{{ $loja->logo_image_link }}" 
                                         :alt="keywordsSeo ? keywordsSeo.split(',')[0].trim() : '{{ $loja->nome }}'" 
                                         class="w-[90px] h-[90px] flex-shrink-0 object-cover rounded-xl shadow-sm">
                                @endif
                            </div>
                        </div>

                        <!-- PREVIEW DESKTOP -->
                        <!-- Ajuste: max-w-[650px] simula a largura máxima real do Google no PC -->
                        <div x-show="viewMode === 'desktop'" class="w-full max-w-[650px] bg-white rounded-xl shadow-sm p-5 font-sans border border-gray-200" x-cloak>
                            <div class="flex items-center gap-2 mb-1">
                                <!-- Favicon SVG Oficial -->
                                <img src="{{ asset('tomacupom.svg') }}" class="w-5 h-5 object-contain flex-shrink-0" alt="Toma Cupom Favicon">
                                
                                <span class="text-[14px] text-[#202124] font-normal">Toma Cupom</span>
                                <span class="text-[14px] text-[#4d5156] ml-2">https://tomacupom.com.br › cupons › {{ $loja->slug }}</span>
                                <i class="bi bi-three-dots-vertical text-gray-500 ml-1 text-xs"></i>
                            </div>
                            
                            <!-- Título mais pesado (font-semibold) -->
                            <div class="text-[20px] text-[#1a0dab] leading-normal mb-1 font-semibold cursor-pointer hover:underline break-words" 
                                 x-text="titleSeo || 'Título da página aparecerá aqui'"></div>
                            
                            <!-- Description + Imagem -->
                            <div class="flex gap-4 mt-2">
                                <div class="flex-1">
                                    <div class="text-[14px] text-[#4d5156] leading-[1.58] line-clamp-2 break-words" 
                                         x-text="descriptionSeo || 'Forneça uma descrição preenchendo o campo ao lado.'"></div>
                                </div>
                                @if($loja->logo_image_link)
                                    <img src="{{ $loja->logo_image_link }}" 
                                         :alt="keywordsSeo ? keywordsSeo.split(',')[0].trim() : '{{ $loja->nome }}'" 
                                         class="w-24 h-24 flex-shrink-0 object-cover rounded-xl shadow-sm">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SESSÃO INFERIOR: Editor de Texto Rico HTML (Quill) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8" 
             x-init="
                const quill = new Quill($refs.quillEditor, {
                    theme: 'snow',
                    placeholder: 'Escreva o texto descritivo e otimizado da página utilizando as ferramentas HTML...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, 4, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            ['link', 'image', 'video'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'align': [] }],
                            ['clean']
                        ]
                    }
                });
                
                quill.on('text-change', () => {
                    $refs.hiddenContent.value = quill.root.innerHTML;
                });
                
                $refs.hiddenContent.value = quill.root.innerHTML;
             ">
            
            <h2 class="text-xl font-bold text-[#222222] mb-2">Conteúdo da Página (Text Content SEO)</h2>
            <p class="text-gray-500 text-sm mb-6">Utilize este editor para estruturar o texto visível da página com cabeçalhos H1, H2, imagens e parágrafos focados na palavra-chave.</p>

            <input type="hidden" name="text_content_seo" id="text_content_seo" x-ref="hiddenContent">
            
            <div class="border border-gray-300 rounded-b-lg overflow-hidden bg-white">
                <div x-ref="quillEditor" style="min-height: 400px; font-family: 'Montserrat', sans-serif; font-size: 15px;">{!! old('text_content_seo', $seo->text_content_seo ?? '') !!}</div>
            </div>
            @error('text_content_seo') <p class="text-red-500 text-xs font-medium mt-2">{{ $message }}</p> @enderror
        </div>

        <!-- Botões de Ação -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.seo.index') }}" class="cursor-pointer bg-white border border-gray-300 text-[#222222] hover:bg-gray-50 font-bold py-3 px-6 rounded-lg transition-colors">
                Cancelar
            </a>
            <button type="submit" class="cursor-pointer bg-[#fe4b09] hover:bg-[#e04308] text-white font-bold py-3 px-8 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg">
                <i class="bi bi-check-lg text-xl"></i> Salvar Otimização
            </button>
        </div>
        
    </form>
</div>
@endsection