<x-layout title="O que é o ADV+CONECTA">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">O que é o ADV+CONECTA</h1>
        <p class="text-gray-600">Conheça mais sobre nossa plataforma, eventos e a equipe por trás do projeto.</p>
    </div>

    {{-- Eventos --}}
    @if($events->count() > 0)
        <div class="mb-10">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Nossos Eventos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        @if($event->video_embed_url)
                            <div class="aspect-video">
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
    @endif

    {{-- Idealizadores --}}
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

    @if($events->count() === 0 && $founders->count() === 0)
        <div class="text-center py-12 bg-white rounded-lg border-2 border-dashed border-gray-300">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Em breve</h3>
            <p class="text-gray-500">As informações sobre o ADV+CONECTA serão publicadas em breve.</p>
        </div>
    @endif

</x-layout>
