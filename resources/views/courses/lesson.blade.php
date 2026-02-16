<x-layout :title="$lesson->title">

    {{-- Voltar para o curso --}}
    <div class="mb-6">
        <a href="{{ route('courses.show', $course->id) }}"
           class="text-blue-600 hover:text-blue-800 font-medium">
            ← Voltar para o curso
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">

        {{-- Título da aula --}}
        <h1 class="text-2xl font-bold text-gray-900 mb-4">
            {{ $lesson->title }}
        </h1>

        {{-- Player --}}
        <div class="w-full aspect-video bg-black rounded-lg overflow-hidden">

            @if(($lesson->video_provider->value ?? $lesson->video_provider) === 'youtube')
                <iframe
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/{{ $lesson->video_ref_id }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>

            @elseif(($lesson->video_provider->value ?? $lesson->video_provider) === 'vimeo')
                <iframe
                    class="w-full h-full"
                    src="https://player.vimeo.com/video/{{ $lesson->video_ref_id }}"
                    frameborder="0"
                    allow="autoplay; fullscreen; picture-in-picture"
                    allowfullscreen>
                </iframe>

            @else
                <div class="flex items-center justify-center h-full text-white">
                    Vídeo não disponível
                </div>
            @endif

        </div>

        {{-- Duração --}}
        @if($lesson->duration_seconds)
            <p class="mt-4 text-sm text-gray-500">
                Duração: {{ gmdate('i:s', $lesson->duration_seconds) }} minutos
            </p>
        @endif

        {{-- Material Complementar da Aula --}}
        @if($lesson->materials->count() > 0)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    Material Complementar
                </h3>
                <div class="space-y-2">
                    @foreach($lesson->materials as $material)
                        <a href="{{ $material->type === 'link' ? $material->url : Storage::url($material->filepath) }}"
                           target="_blank"
                           class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                            @if($material->cover_image)
                                <img src="{{ Storage::url($material->cover_image) }}" alt="" class="w-12 h-12 rounded object-cover flex-shrink-0">
                            @else
                                {!! $material->icon !!}
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $material->title ?? $material->filename }}</p>
                                @if($material->description)
                                    <p class="text-xs text-gray-600">{{ $material->description }}</p>
                                @endif
                                @if($material->type === 'file')
                                    <p class="text-xs text-gray-400">{{ $material->formatted_size }} &bull; {{ strtoupper($material->filetype) }}</p>
                                @else
                                    <p class="text-xs text-gray-400">{{ $material->url }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</x-layout>
