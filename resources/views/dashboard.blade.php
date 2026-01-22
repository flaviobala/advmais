<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Bem-vindo ao AdvMais, {{ Auth::user()->name }}!</h1>
        <p class="mb-4">Você está logado como: <span class="font-bold text-blue-600">{{ Auth::user()->role }}</span></p>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-600 hover:underline">Sair do Sistema</button>
        </form>
    </div>
</body>
</html>