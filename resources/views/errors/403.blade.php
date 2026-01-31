<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acesso Negado - AdvMais</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full bg-gray-100">
    <div class="min-h-full flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full text-center">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="mx-auto h-20 w-20 rounded-full bg-red-100 flex items-center justify-center mb-6">
                    <svg class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-2">Acesso Negado</h1>

                <p class="text-gray-600 mb-6">
                    {{ $exception->getMessage() ?: 'Você não tem permissão para acessar esta área. Caso acredite que isso seja um erro, entre em contato com o administrador.' }}
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="javascript:history.back()"
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                        Voltar
                    </a>
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Ir para o Início
                    </a>
                </div>
            </div>

            <p class="mt-6 text-sm text-gray-400">AdvMais</p>
        </div>
    </div>
</body>
</html>
