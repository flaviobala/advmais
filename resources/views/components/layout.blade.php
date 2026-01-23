<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'AdvMais System' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">

<div class="min-h-full">
    <div class="fixed inset-y-0 left-0 flex w-64 flex-col bg-slate-900 pt-5 pb-4 shadow-xl">
        <div class="flex flex-shrink-0 items-center px-4 mb-6">
            <h1 class="text-2xl font-bold text-white">AdvMais</h1>
        </div>
        
        <nav class="mt-5 flex-1 space-y-1 px-2">
            <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md bg-slate-800 text-white">
                <svg class="mr-3 h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Meus Cursos
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-4 border-t border-slate-700 pt-4">
                @csrf
                <button type="submit" class="w-full group flex items-center px-2 py-2 text-sm font-medium rounded-md text-slate-300 hover:bg-slate-800 hover:text-white">
                    <svg class="mr-3 h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Sair do Sistema
                </button>
            </form>
        </nav>
    </div>

    <div class="flex flex-1 flex-col pl-64">
        <main class="flex-1">
            <div class="py-6">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-6">{{ $title ?? 'Dashboard' }}</h1>
                    
                    {{ $slot }}
                    
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>