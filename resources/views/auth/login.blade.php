<!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-slate-100 min-h-screen grid place-items-center p-4">
<form method="POST" action="{{ url('/login') }}" class="bg-white border rounded-lg p-6 w-full max-w-md space-y-4">
    @csrf
    <h1 class="font-bold text-xl">ACESSAR ADMIN</h1>
    <input name="email" type="email" placeholder="EMAIL" class="w-full border rounded px-3 py-2" required>
    <input name="password" type="password" placeholder="SENHA" class="w-full border rounded px-3 py-2" required>
    <label class="text-sm flex items-center gap-2"><input type="checkbox" name="remember"> LEMBRAR</label>
    <button class="w-full bg-slate-900 text-white rounded px-4 py-2">ENTRAR</button>
</form>
</body></html>
