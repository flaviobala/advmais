<div class="group bg-white rounded-lg shadow hover:shadow-xl transition-all duration-300 overflow-hidden transform {{ $course->is_locked ? 'opacity-90' : 'hover:-translate-y-1' }}">
    {{-- Capa do curso --}}
    <div class="aspect-video bg-gradient-to-br from-blue-400 to-blue-600 relative overflow-hidden">
        @if($course->cover_image)
            <img src="{{ Storage::url($course->cover_image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        @endif

        @if($course->is_locked)
            <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col items-center justify-center">
                <svg class="w-12 h-12 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span class="text-white text-sm font-semibold">Bloqueado</span>
            </div>
        @else
            @if($course->progress >= 100)
                <span class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">Concluido</span>
            @elseif($course->progress > 0)
                <span class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">{{ $course->progress }}%</span>
            @endif

            @if(($course->access_type ?? 'full') === 'partial')
                <span class="absolute top-2 left-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">Parcial</span>
            @endif
        @endif
    </div>

    <div class="p-3">
        <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-tight">{{ $course->title }}</h3>
        <p class="text-xs text-gray-400 mt-1">{{ $course->lessons_count }} aulas</p>

        @if(!$course->is_locked)
            @if($course->progress > 0)
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $course->progress }}%"></div>
                    </div>
                </div>
            @endif
            <a href="{{ route('courses.show', $course->id) }}" class="block w-full text-center bg-green-500 hover:bg-green-600 text-white text-xs font-semibold py-2 rounded-lg transition-colors mt-3">
                @if($course->progress >= 100)
                    Revisar
                @elseif($course->progress > 0)
                    Continuar
                @else
                    Acessar
                @endif
            </a>
        @else
            <span class="block w-full text-center bg-gray-300 text-gray-500 text-xs font-semibold py-2 rounded-lg cursor-not-allowed mt-3">
                Sem Acesso
            </span>
        @endif
    </div>
</div>
