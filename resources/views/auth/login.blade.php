<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdvMais - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-lg shadow-xl overflow-hidden p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800">AdvMais</h1>
            <p class="text-slate-500 mt-2">Acesse sua conta jurídica</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    required 
                    class="w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border"
                    placeholder="seu@email.com"
                    value="{{ old('email') }}"
                >
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Senha</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    class="w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border"
                    placeholder="••••••••"
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition duration-200"
            >
                Entrar no Sistema
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-400">
            &copy; {{ date('Y') }} AdvMais System
        </div>
    </div>

</body>
</html>