<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADV+ CONECTA - Recuperar Senha</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gradient-to-br from-slate-900 via-slate-800 to-gray-900">

    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">

            <div class="bg-gradient-to-br from-slate-800 to-slate-900 shadow-2xl sm:rounded-xl overflow-hidden">

                <!-- Logo -->
                <div class="px-8 py-10 text-center relative">
                    <a href="{{ route('login') }}" class="absolute left-4 top-4 flex items-center gap-2 text-gray-400 hover:text-white transition-colors group">
                        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="text-sm">Voltar</span>
                    </a>
                    <div class="flex justify-center">
                        <img src="/Logo adv mais.png" alt="ADV+ CONECTA" class="h-32 w-auto">
                    </div>
                </div>

                <!-- Formulário -->
                <div class="px-8 py-8 bg-slate-900/50 border-t border-slate-700/50">

                    <h2 class="text-center text-lg font-semibold text-white mb-1">Recuperar senha</h2>
                    <p class="text-center text-sm text-gray-400 mb-6">
                        Informe seu e-mail e enviaremos um link para redefinir sua senha.
                    </p>

                    @if (session('success'))
                        <div class="mb-5 bg-green-500/10 border border-green-500/30 text-green-400 rounded-lg px-4 py-3 text-sm text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.send') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-200 mb-1.5">
                                E-mail
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                required
                                autocomplete="email"
                                value="{{ old('email') }}"
                                placeholder="seu@email.com"
                                class="appearance-none block w-full px-4 py-2.5 border border-slate-600 rounded-lg
                                       placeholder-gray-500 text-white bg-slate-800/50
                                       focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-transparent
                                       transition-all sm:text-sm">
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg
                                       text-sm font-semibold text-white
                                       bg-slate-700 hover:bg-slate-600
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500
                                       shadow-lg hover:shadow-xl transition-all duration-200">
                                Enviar link de recuperação
                            </button>
                        </div>
                    </form>
                </div>

                <div class="px-8 py-4 bg-slate-950/50 border-t border-slate-700/50">
                    <p class="text-xs text-center text-gray-400">
                        Lembrou a senha?
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors">
                            Fazer login
                        </a>
                    </p>
                </div>
            </div>

            <p class="mt-6 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} ADV+ CONECTA. Todos os direitos reservados.
            </p>
            <p class="mt-2 text-center text-xs text-gray-600">
                Desenvolvido por
                <a href="https://wa.me/5582993678371" target="_blank" rel="noopener"
                   class="text-gray-500 hover:text-yellow-500 transition-colors duration-200">
                    Flávio Henrique
                </a>
            </p>
        </div>
    </div>

</body>
</html>
