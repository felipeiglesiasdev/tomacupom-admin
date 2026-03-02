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
    <main class="p-6">
        @yield('content')
    </main>
</div>
</body>
</html>
