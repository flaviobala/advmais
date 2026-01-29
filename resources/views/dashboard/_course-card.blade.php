<div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <!-- Imagem do curso com fallback -->
    <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 relative overflow-hidden">
        @if($course->cover_image)
            <img src="{{ Storage::url($course->cover_image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        @endif

        <!-- Badge de Status -->
        @if($course->progress >= 100)
            <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                Concluído
            </span>
        @elseif($course->progress > 0)
            <span class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                Em andamento
            </span>
        @else
            <span class="absolute top-3 right-3 bg-gray-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                Novo
            </span>
        @endif

        <!-- Badge de Acesso Parcial -->
        @if(($course->access_type ?? 'full') === 'partial')
            <span class="absolute top-3 left-3 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                Acesso Parcial
            </span>
        @endif
    </div>

    <div class="p-5">
        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
            {{ $course->title }}
        </h3>
        <p class="text-sm text-gray-600 line-clamp-2 mb-4">
            {{ $course->description ?? 'Descrição não disponível.' }}
        </p>

        <!-- Barra de Progresso -->
        @if($course->progress > 0)
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs font-medium text-gray-700">Progresso</span>
                    <span class="text-xs font-bold text-blue-600">{{ $course->progress }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $course->progress }}%"></div>
                </div>
            </div>
        @endif

        <!-- Informações do Curso -->
        <div class="flex items-center gap-4 mb-4 text-xs text-gray-500">
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                {{ $course->lessons_count }} aulas
            </span>
            @if($course->total_duration_minutes > 0)
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ round($course->total_duration_minutes) }} min
                </span>
            @endif
        </div>

        <!-- Botão de Ação -->
        <a href="{{ route('courses.show', $course->id) }}" class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
            @if($course->progress >= 100)
                Revisar Curso
            @elseif($course->progress > 0)
                Continuar Assistindo
            @else
                Começar Agora
            @endif
        </a>
    </div>
</div>
