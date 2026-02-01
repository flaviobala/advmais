@auth
<x-layout title="O que é o ADV+CONECTA">
@else
<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>O que é o ADV+CONECTA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
<div class="min-h-full bg-gray-100">
    <nav class="bg-slate-900 shadow">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="/" class="text-xl font-bold text-white">ADV+CONECTA</a>
            <a href="{{ route('login') }}" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-colors">
                Entrar
            </a>
        </div>
    </nav>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
@endauth

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">O que é o ADV+CONECTA</h1>
        <p class="text-gray-600">Conheça mais sobre nossa plataforma, eventos e a equipe por trás do projeto.</p>
    </div>

    {{-- Introdução: vídeo + texto (público) --}}
    @if($settings->intro_video_url || $settings->intro_text)
        <div class="mb-10 bg-white rounded-lg shadow overflow-hidden">
            @if($settings->intro_video_embed_url)
                <div class="aspect-video bg-black">
                    <iframe class="w-full h-full" src="{{ $settings->intro_video_embed_url }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @endif
            @if($settings->intro_text)
                <div class="p-6">
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $settings->intro_text }}</p>
                </div>
            @endif
        </div>
    @endif

    {{-- Eventos (conteúdo exclusivo para autorizados) --}}
    @if($canViewEvents && $events->count() > 0)
        <div class="mb-10">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Nossos Eventos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        @if($event->video_embed_url)
                            <div class="aspect-video bg-black">
                                <iframe class="w-full h-full" src="{{ $event->video_embed_url }}" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @elseif($event->photo)
                            <img src="{{ Storage::url($event->photo) }}" alt="{{ $event->title }}" class="w-full aspect-video object-cover">
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900">{{ $event->title }}</h3>
                            @if($event->description)
                                <p class="text-sm text-gray-600 mt-1">{{ $event->description }}</p>
                            @endif
                            @if($event->video_url && !$event->video_embed_url)
                                <a href="{{ $event->video_url }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Assistir vídeo
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @elseif(!$canViewEvents)
        <div class="mb-10 bg-white rounded-lg shadow p-6 text-center">
            <svg class="mx-auto h-10 w-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Conteúdo Exclusivo</h3>
            <p class="text-sm text-gray-500">Os eventos são conteúdos exclusivos para membros autorizados.</p>
            @guest
                <a href="{{ route('login') }}" class="inline-block mt-3 text-sm font-medium text-blue-600 hover:text-blue-800">
                    Faça login para verificar seu acesso →
                </a>
            @endguest
        </div>
    @endif

    {{-- Idealizadores (público) --}}
    @if($founders->count() > 0)
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-4">Idealizadores</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($founders as $founder)
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        @if($founder->photo)
                            <img src="{{ Storage::url($founder->photo) }}" alt="{{ $founder->name }}"
                                 class="w-24 h-24 rounded-full object-cover mx-auto mb-4">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-white">{{ mb_substr($founder->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <h3 class="font-bold text-gray-900">{{ $founder->name }}</h3>
                        @if($founder->role)
                            <p class="text-sm text-blue-600 font-medium">{{ $founder->role }}</p>
                        @endif
                        @if($founder->bio)
                            <p class="text-sm text-gray-600 mt-3 text-left">{{ $founder->bio }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if((!$settings->intro_video_url && !$settings->intro_text) && !$canViewEvents && $founders->count() === 0)
        <div class="text-center py-12 bg-white rounded-lg border-2 border-dashed border-gray-300">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Em breve</h3>
            <p class="text-gray-500">As informações sobre o ADV+CONECTA serão publicadas em breve.</p>
        </div>
    @endif

@auth
</x-layout>
@else
    </div>
</div>
</body>
</html>
@endauth
