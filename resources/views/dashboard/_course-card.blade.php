<div class="w-72 flex-shrink-0 snap-start bg-white overflow-hidden shadow rounded-lg transition-all duration-300 {{ $course->is_locked ? 'opacity-90' : 'hover:shadow-xl hover:-translate-y-1' }} transform">
    <!-- Imagem do curso -->
    <div class="h-44 bg-gradient-to-br from-blue-400 to-blue-600 relative overflow-hidden">
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
            {{-- Overlay de bloqueio --}}
            <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col items-center justify-center">
                <svg class="w-12 h-12 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span class="text-white text-sm font-semibold">Curso Bloqueado</span>
            </div>
        @else
            {{-- Badges de status --}}
            @if($course->progress >= 100)
                <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
                    Concluido
                </span>
            @elseif($course->progress > 0)
                <span class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
                    Em andamento
                </span>
            @endif

            @if(($course->access_type ?? 'full') === 'partial')
                <span class="absolute top-3 left-3 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
                    Acesso Parcial
                </span>
            @endif
        @endif
    </div>

    <div class="p-4">
        <h3 class="text-sm font-bold text-gray-900 mb-1 line-clamp-2 leading-tight">
            {{ $course->title }}
        </h3>

        @if(!$course->is_locked)
            {{-- Barra de progresso --}}
            @if($course->progress > 0)
                <div class="mb-3 mt-2">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs text-gray-500">{{ $course->progress }}%</span>
                        <span class="text-xs text-gray-400">{{ $course->lessons_count }} aulas</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $course->progress }}%"></div>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-3 mt-2 mb-3 text-xs text-gray-400">
                    <span>{{ $course->lessons_count }} aulas</span>
                    @if($course->total_duration_minutes > 0)
                        <span>{{ round($course->total_duration_minutes) }} min</span>
                    @endif
                </div>
            @endif

            <a href="{{ route('courses.show', $course->id) }}" class="block w-full text-center bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-2 rounded-lg transition-colors">
                @if($course->progress >= 100)
                    Revisar
                @elseif($course->progress > 0)
                    Continuar
                @else
                    Acessar
                @endif
            </a>
        @else
            <p class="text-xs text-gray-400 mt-2 mb-3">{{ $course->lessons_count }} aulas</p>
            <span class="block w-full text-center bg-gray-300 text-gray-500 text-sm font-semibold py-2 rounded-lg cursor-not-allowed">
                Sem Acesso
            </span>
        @endif
    </div>
</div>
