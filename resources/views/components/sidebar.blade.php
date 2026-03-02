<!-- Alterei as classes aqui: removi absolute e coloquei sticky top-0 h-screen no desktop -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-50 w-72 bg-[#222222] text-white flex flex-col shadow-2xl transition-transform duration-300 ease-in-out md:sticky md:top-0 h-screen overflow-hidden">
    
    <!-- Botão de Fechar no Mobile -->
    <button @click="sidebarOpen = false" class="md:hidden absolute top-4 right-4 text-gray-400 hover:text-white cursor-pointer p-2">
        <i class="bi bi-x-lg text-xl"></i>
    </button>

    <!-- Logótipo -->
    <div class="p-6 border-b border-gray-700/50 flex items-center justify-center min-h-[5rem]">
        <a href="{{ route('admin.dashboard') }}" class="block">
            <img src="{{ asset('tomacupom.png') }}" alt="Toma Cupom" class="h-10 w-auto object-contain">
        </a>
    </div>
    
    <!-- Navegação (Scrolável individualmente) -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#fe4b09] text-white shadow-md' : 'text-gray-300 hover:bg-[#fe4b09]/20 hover:text-white' }}">
            <i class="bi bi-speedometer2 text-lg"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('admin.lojas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.lojas.*') && !request()->routeIs('admin.seo.*') ? 'bg-[#fe4b09] text-white shadow-md' : 'text-gray-300 hover:bg-[#fe4b09]/20 hover:text-white' }}">
            <i class="bi bi-shop text-lg"></i>
            <span class="font-medium">Lojas</span>
        </a>

        <!-- NOVO: Link para o CRUD de SEO -->
        <a href="{{ route('admin.seo.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.seo.*') ? 'bg-[#fe4b09] text-white shadow-md' : 'text-gray-300 hover:bg-[#fe4b09]/20 hover:text-white' }}">
            <i class="bi bi-google text-lg"></i>
            <span class="font-medium">SEO & Meta Tags</span>
        </a>

        <a href="{{ route('admin.cupons.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.cupons.*') ? 'bg-[#fe4b09] text-white shadow-md' : 'text-gray-300 hover:bg-[#fe4b09]/20 hover:text-white' }}">
            <i class="bi bi-ticket-perforated text-lg"></i>
            <span class="font-medium">Cupons</span>
        </a>

        <a href="{{ route('admin.ofertas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.ofertas.*') ? 'bg-[#fe4b09] text-white shadow-md' : 'text-gray-300 hover:bg-[#fe4b09]/20 hover:text-white' }}">
            <i class="bi bi-lightning-charge text-lg"></i>
            <span class="font-medium">Ofertas</span>
        </a>

        <a href="{{ route('admin.categorias.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.categorias.*') ? 'bg-[#fe4b09] text-white shadow-md' : 'text-gray-300 hover:bg-[#fe4b09]/20 hover:text-white' }}">
            <i class="bi bi-grid text-lg"></i>
            <span class="font-medium">Categorias</span>
        </a>
    </nav>

    <!-- Rodapé -->
    <div class="p-4 border-t border-gray-700/50 bg-[#1a1a1a]">
        @auth
        <div class="px-4 mb-4">
            <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
        </div>
        @endauth
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="cursor-pointer flex items-center gap-3 px-4 py-2 w-full text-left text-gray-400 hover:text-white transition-colors rounded-lg hover:bg-[#fe4b09]/20">
                <i class="bi bi-box-arrow-right text-lg"></i>
                <span class="font-medium">Sair do Painel</span>
            </button>
        </form>
    </div>
</aside>