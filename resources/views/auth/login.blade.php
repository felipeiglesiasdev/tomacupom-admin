<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Painel Administrativo Toma Cupom</title>
    
    <!-- Google Fonts: Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Alpine.js (Para o toggle de mostrar/ocultar senha) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-[#171717] text-[#222222] min-h-screen flex items-center justify-center p-4 md:p-0 relative overflow-hidden">

    <!-- Elementos Decorativos de Fundo (Bolinhas Desfocadas) -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-[#fe4b09] rounded-full mix-blend-multiply filter blur-[128px] opacity-20 pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-[#222222] rounded-full mix-blend-multiply filter blur-[128px] opacity-10 pointer-events-none"></div>

    <!-- Container Principal do Login -->
    <div class="w-full max-w-md relative z-10">
        
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="{{ asset('tomacupom.png') }}" alt="Toma Cupom" class="h-16 w-auto mx-auto object-contain drop-shadow-sm">
        </div>

        <!-- Cartão do Formulário -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            
            <!-- Barra de Destaque no Topo -->
            <div class="h-2 w-full bg-[#fe4b09]"></div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-[#222222]">Acesso Restrito</h1>
                    <p class="text-gray-500 text-sm mt-1">Insira suas credenciais para gerenciar o painel.</p>
                </div>

                <!-- Exibição de Erros do Laravel -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6 text-sm font-medium animate-pulse">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <span>Acesso Negado</span>
                        </div>
                        <ul class="list-disc list-inside text-xs text-red-600 ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulário de Autenticação -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Campo: E-mail -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-bold text-[#222222]">E-mail</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-envelope text-gray-400"></i>
                            </div>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username"
                                   placeholder="admin@tomacupom.com.br"
                                   class="block w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] bg-gray-50 focus:bg-white">
                        </div>
                    </div>

                    <!-- Campo: Senha (com Alpine.js para o Olhinho) -->
                    <div class="space-y-2" x-data="{ showPassword: false }">
                        <div class="flex justify-between items-center">
                            <label for="password" class="block text-sm font-bold text-[#222222]">Senha</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#fe4b09] hover:text-[#e04308] hover:underline transition-colors">
                                    Esqueceu a senha?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-lock text-gray-400"></i>
                            </div>
                            
                            <!-- Input dinâmico (text/password) -->
                            <input id="password" 
                                   :type="showPassword ? 'text' : 'password'" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="block w-full pl-11 pr-12 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#fe4b09]/50 focus:border-[#fe4b09] transition-colors text-[#222222] bg-gray-50 focus:bg-white">
                            
                            <!-- Botão de mostrar/ocultar senha -->
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#fe4b09] cursor-pointer focus:outline-none transition-colors">
                                <i class="bi text-lg" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Lembrar de mim -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-[#fe4b09] border-gray-300 rounded focus:ring-[#fe4b09] cursor-pointer">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer">
                            Manter conectado
                        </label>
                    </div>

                    <!-- Botão Entrar -->
                    <button type="submit" class="w-full cursor-pointer bg-[#fe4b09] hover:bg-[#e04308] text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        Entrar no Painel <i class="bi bi-box-arrow-in-right text-lg"></i>
                    </button>
                </form>
            </div>
            
            <!-- Rodapé do Cartão -->
            <div class="bg-gray-50 border-t border-gray-100 p-4 text-center">
                <p class="text-xs text-gray-400 font-medium">
                    &copy; {{ date('Y') }} Toma Cupom. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </div>

</body>
</html>