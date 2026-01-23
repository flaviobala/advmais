<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADV+ CONECTA - Inteligência Jurídica</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes pulse-subtle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }
        .float-slow { animation: float 8s ease-in-out infinite; }
        .pulse-ring { animation: pulse-subtle 4s ease-in-out infinite; }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-slate-900 via-slate-800 to-gray-900 overflow-hidden">

    <!-- Elementos Gráficos Abstratos de Fundo -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Círculos abstratos -->
        <div class="absolute top-20 right-10 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl pulse-ring"></div>
        <div class="absolute bottom-20 left-10 w-80 h-80 bg-slate-500/5 rounded-full blur-3xl pulse-ring" style="animation-delay: 2s;"></div>

        <!-- Linhas sutis -->
        <svg class="absolute inset-0 w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgb(148, 163, 184)" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>

        <!-- Partículas geométricas -->
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-400/20 rounded-sm float-slow"></div>
        <div class="absolute top-1/3 right-1/3 w-3 h-3 bg-slate-400/20 rounded-sm float-slow" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/3 left-1/2 w-2 h-2 bg-blue-300/20 rounded-sm float-slow" style="animation-delay: 2.5s;"></div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="relative min-h-full flex flex-col justify-center items-center px-6 py-12">

        <div class="max-w-4xl mx-auto text-center space-y-12">

            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <img src="/Logo adv mais.png" alt="ADV+ CONECTA" class="h-40 w-auto opacity-90">
            </div>

            <!-- Headline -->
            <div class="space-y-6">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-tight">
                    Inteligência jurídica que conecta<br>
                    <span class="text-blue-400">estratégia, tecnologia e resultado</span>
                </h1>

                <!-- Subheadline -->
                <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto font-light leading-relaxed">
                    Uma plataforma desenvolvida para advogados que exigem eficiência,<br class="hidden md:block">
                    segurança e inovação no exercício da advocacia.
                </p>
            </div>

            <!-- Botão Principal -->
            <div class="pt-8">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-3 px-10 py-4
                          bg-slate-700 hover:bg-slate-600
                          text-white text-lg font-semibold
                          rounded-lg shadow-2xl hover:shadow-blue-500/20
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500
                          transition-all duration-300 transform hover:scale-105">
                    <span>Acessar Plataforma</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>

            <!-- Elementos de Confiança -->
            <div class="pt-16 border-t border-slate-700/50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <!-- Feature 1 -->
                    <div class="space-y-2">
                        <div class="flex justify-center">
                            <div class="w-12 h-12 rounded-lg bg-slate-800/50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-white">Segurança Avançada</h3>
                        <p class="text-xs text-gray-400">Proteção de dados em nível institucional</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="space-y-2">
                        <div class="flex justify-center">
                            <div class="w-12 h-12 rounded-lg bg-slate-800/50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-white">Performance Superior</h3>
                        <p class="text-xs text-gray-400">Tecnologia de ponta para máxima eficiência</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="space-y-2">
                        <div class="flex justify-center">
                            <div class="w-12 h-12 rounded-lg bg-slate-800/50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-white">Inovação Contínua</h3>
                        <p class="text-xs text-gray-400">Evolução constante da plataforma</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="absolute bottom-8 left-0 right-0">
            <p class="text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} ADV+ CONECTA. Todos os direitos reservados.
            </p>
        </div>

    </div>

</body>
</html>
