<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdvMais Conecta - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes slideshow {
            0%, 33.33% { opacity: 1; }
            33.34%, 100% { opacity: 0; }
        }
        .slide-1 { animation: slideshow 15s infinite; }
        .slide-2 { animation: slideshow 15s infinite 5s; }
        .slide-3 { animation: slideshow 15s infinite 10s; }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">

    <div class="min-h-full flex">

        <!-- Lado Esquerdo - Imagens com Slideshow -->
        <div class="hidden lg:flex lg:flex-1 relative overflow-hidden">
            <!-- Overlay escuro sutil -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/40 via-slate-900/60 to-slate-900/80 z-10"></div>

            <!-- Slideshow de Imagens -->
            <div class="absolute inset-0">
                <div class="slide-1 absolute inset-0 bg-cover bg-center" style="background-image: url('/foto geral.png');"></div>
                <div class="slide-2 absolute inset-0 bg-cover bg-center opacity-0" style="background-image: url('/foto palestra.jpg');"></div>
                <div class="slide-3 absolute inset-0 bg-cover bg-center opacity-0" style="background-image: url('/foto geral.png');"></div>
            </div>

            <!-- Conteúdo sobre as imagens -->
            <div class="relative z-20 flex flex-col justify-end p-12 text-white">
                <div class="space-y-4">
                    <h2 class="text-4xl font-bold leading-tight">
                        Transformando a<br>
                        advocacia com<br>
                        <span class="text-blue-400">tecnologia</span>
                    </h2>
                    <p class="text-lg text-slate-300 max-w-md">
                        Plataforma completa de gestão e capacitação para advogados modernos.
                    </p>
                </div>

                <!-- Indicadores de slides discretos -->
                <div class="flex gap-2 mt-8">
                    <div class="h-1 w-12 bg-blue-400 rounded-full"></div>
                    <div class="h-1 w-12 bg-white/30 rounded-full"></div>
                    <div class="h-1 w-12 bg-white/30 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Lado Direito - Formulário de Login -->
        <div class="flex-1 flex flex-col justify-center px-6 py-12 lg:px-20 xl:px-24 bg-white">
            <div class="mx-auto w-full max-w-md">

                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <img src="/Logo adv mais.jpg" alt="AdvMais Conecta" class="h-20 w-auto object-contain">
                </div>

                <!-- Título -->
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Bem-vindo de volta
                    </h1>
                    <p class="mt-2 text-sm text-slate-600">
                        Acesse sua conta para continuar
                    </p>
                </div>

                <!-- Formulário -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                            Endereço de e-mail
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            autocomplete="email"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   transition duration-200"
                            placeholder="seu.email@exemplo.com"
                            value="{{ old('email') }}"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Senha -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                            Senha
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   transition duration-200"
                            placeholder="••••••••••"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Lembrar-me e Esqueci senha -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                            >
                            <label for="remember" class="ml-2 block text-sm text-slate-700">
                                Lembrar-me
                            </label>
                        </div>

                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500 transition">
                            Esqueceu a senha?
                        </a>
                    </div>

                    <!-- Botão de Login -->
                    <button
                        type="submit"
                        class="w-full flex justify-center items-center gap-2 px-4 py-3
                               bg-gradient-to-r from-blue-600 to-blue-700
                               hover:from-blue-700 hover:to-blue-800
                               text-white font-semibold rounded-lg
                               shadow-lg shadow-blue-500/30
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transform hover:scale-[1.02]
                               transition duration-200"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Entrar na plataforma
                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-8 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-slate-500">
                            Plataforma segura e certificada
                        </span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-slate-500">
                        &copy; {{ date('Y') }} AdvMais Conecta. Todos os direitos reservados.
                    </p>
                    <div class="flex justify-center gap-4 mt-3">
                        <a href="#" class="text-xs text-slate-400 hover:text-slate-600 transition">Termos de Uso</a>
                        <span class="text-slate-300">•</span>
                        <a href="#" class="text-xs text-slate-400 hover:text-slate-600 transition">Privacidade</a>
                        <span class="text-slate-300">•</span>
                        <a href="#" class="text-xs text-slate-400 hover:text-slate-600 transition">Suporte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>