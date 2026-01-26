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

    </div>

</x-layout>
