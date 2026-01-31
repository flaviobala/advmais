<div class="p-4 flex items-center justify-between {{ $lesson->is_accessible ? 'hover:bg-gray-50' : 'opacity-60 bg-gray-50' }} transition-colors duration-200">
    <div class="flex items-center gap-4 flex-1">
        <div class="flex-shrink-0">
            @if($lesson->is_accessible)
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-blue-600 font-bold text-sm">{{ $number }}</span>
                </div>
            @else
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </div>
            @endif
        </div>

        <div class="flex-1">
            <h3 class="font-semibold {{ $lesson->is_accessible ? 'text-gray-900' : 'text-gray-400' }} mb-1">{{ $lesson->title }}</h3>
            @if($lesson->description)
                <p class="text-sm {{ $lesson->is_accessible ? 'text-gray-600' : 'text-gray-400' }} line-clamp-2">{{ $lesson->description }}</p>
            @endif
            @if($lesson->duration_seconds)
                <p class="text-xs text-gray-500 mt-1">
                    Dura&ccedil;&atilde;o: {{ gmdate('i:s', $lesson->duration_seconds) }} minutos
                </p>
            @endif
        </div>

        <div class="flex items-center gap-3">
            @if(!$lesson->is_accessible)
                <span class="flex items-center gap-2 text-gray-400 font-medium text-sm">Bloqueada</span>
            @elseif($lesson->is_completed)
                <span class="flex items-center gap-2 text-green-600 font-medium text-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Conclu&iacute;da
                </span>
            @elseif($lesson->progress_percentage > 0)
                <span class="flex items-center gap-2 text-yellow-600 font-medium text-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    {{ $lesson->progress_percentage }}%
                </span>
            @endif

            @if($lesson->is_accessible)
                <a href="{{ route('courses.lesson', [$course->id, $lesson->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                    @if($lesson->is_completed)
                        Rever
                    @elseif($lesson->progress_percentage > 0)
                        Continuar
                    @else
                        Assistir
                    @endif
                </a>
            @endif
        </div>
    </div>
</div>
