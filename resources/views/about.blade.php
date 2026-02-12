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

    @guest
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">O que é o ADV+CONECTA</h1>
        </div>
    @endguest

    {{-- Texto de introdução (público) --}}
    @if($settings->intro_text)
        <div class="mb-8">
            <p class="text-gray-700 whitespace-pre-line leading-relaxed text-justify">{!! preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', e($settings->intro_text)) !!}</p>
        </div>
    @endif

    {{-- Vídeo de apresentação (público) --}}
    @if($settings->intro_video_embed_url)
        <div class="mb-10">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                <div class="col-span-2 sm:col-span-2">
                    <button onclick="openVideoModal('{{ $settings->intro_video_embed_url }}')" class="group block bg-white rounded-lg shadow hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1 w-full text-left">
                        <div class="aspect-video bg-black relative overflow-hidden">
                            @php
                                $introThumb = null;
                                if (preg_match('/(?:youtube\.com\/embed\/|youtu\.be\/)([^?&]+)/', $settings->intro_video_embed_url, $m)) {
                                    $introThumb = 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
                                }
                            @endphp
                            @if($introThumb)
                                <img src="{{ $introThumb }}" alt="Vídeo de apresentação" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-purple-500 to-blue-600 group-hover:scale-105 transition-transform duration-300"></div>
                            @endif
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-14 h-14 bg-black/60 rounded-full flex items-center justify-center group-hover:bg-red-600 transition-colors duration-300">
                                    <svg class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-tight">Apresentação ADV+CONECTA</h3>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Eventos (conteúdo exclusivo para autorizados) --}}
    @if($canViewEvents && $events->count() > 0)
        <div class="mb-10">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Nossos Eventos</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @foreach($events as $event)
                    <div class="group block bg-white rounded-lg shadow hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                        @if($event->video_embed_url)
                            <button onclick="openVideoModal('{{ $event->video_embed_url }}')" class="w-full text-left">
                                <div class="aspect-video bg-black relative overflow-hidden">
                                    @php
                                        $eventThumb = null;
                                        if (preg_match('/(?:youtube\.com\/embed\/|youtu\.be\/)([^?&]+)/', $event->video_embed_url, $m)) {
                                            $eventThumb = 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
                                        }
                                    @endphp
                                    @if($eventThumb)
                                        <img src="{{ $eventThumb }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 group-hover:scale-105 transition-transform duration-300"></div>
                                    @endif
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-10 h-10 bg-black/60 rounded-full flex items-center justify-center group-hover:bg-red-600 transition-colors duration-300">
                                            <svg class="w-5 h-5 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        @elseif($event->photo)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ Storage::url($event->photo) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @endif
                        <div class="p-3">
                            <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-tight">{{ $event->title }}</h3>
                            @if($event->description)
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $event->description }}</p>
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
                            <p class="text-sm text-gray-600 mt-3 text-justify whitespace-pre-line">{{ $founder->bio }}</p>
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

{{-- Modal de vídeo --}}
<div id="videoModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 p-4" onclick="closeVideoModal(event)">
    <div class="relative w-full max-w-4xl mx-auto" onclick="event.stopPropagation()">
        <button onclick="closeVideoModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="aspect-video bg-black rounded-lg overflow-hidden shadow-2xl">
            <iframe id="videoIframe" class="w-full h-full" src="" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>

<script>
    function openVideoModal(url) {
        const modal = document.getElementById('videoModal');
        const iframe = document.getElementById('videoIframe');
        iframe.src = url + (url.includes('?') ? '&' : '?') + 'autoplay=1';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeVideoModal(event) {
        if (event && event.target !== document.getElementById('videoModal')) return;
        const modal = document.getElementById('videoModal');
        const iframe = document.getElementById('videoIframe');
        iframe.src = '';
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeVideoModal();
    });
</script>

@auth
</x-layout>
@else
    </div>
</div>
</body>
</html>
@endauth
