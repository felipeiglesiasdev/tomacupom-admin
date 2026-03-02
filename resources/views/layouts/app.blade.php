<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ADMIN TOMA CUPOM' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">
<div class="min-h-screen md:flex">
    <aside class="bg-slate-900 text-white md:w-64 p-4">
        <h1 class="font-bold text-lg">TOMA CUPOM ADMIN</h1>
        <nav class="mt-4 space-y-2 text-sm">
            <a class="block hover:text-cyan-300" href="{{ route('admin.dashboard') }}">DASHBOARD</a>
            <a class="block hover:text-cyan-300" href="{{ route('admin.lojas.index') }}">LOJAS</a>
            <a class="block hover:text-cyan-300" href="{{ route('admin.cupons.index') }}">CUPONS</a>
            <a class="block hover:text-cyan-300" href="{{ route('admin.ofertas.index') }}">OFERTAS</a>
            <a class="block hover:text-cyan-300" href="{{ route('admin.categorias.index') }}">CATEGORIAS</a>
        </nav>
    </aside>
    <main class="flex-1">
        <header class="bg-white border-b p-4 flex justify-between items-center">
            <h2 class="font-semibold">{{ $header ?? 'PAINEL ADMINISTRATIVO' }}</h2>
            <div class="flex items-center gap-3 text-sm">
                <span>{{ auth()->user()->name ?? '' }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-red-600">SAIR</button></form>
            </div>
        </header>
        <section class="p-4 md:p-6">
            @if(session('success'))
                <x-admin.alert type="success" :message="session('success')" />
            @endif
            @if($errors->any())
                <x-admin.alert type="error" :message="$errors->first()" />
            @endif
            {{ $slot }}
        </section>
    </main>
</div>
</body>
</html>
