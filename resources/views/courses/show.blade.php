<x-layout :title="$course->title">

    <!-- Cabeçalho do Curso -->
    <div class="mb-8 bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Imagem do Curso -->
            <div class="md:w-1/3 bg-gradient-to-br from-blue-400 to-blue-600">
                @if($course->cover_image)
                    <img src="{{ $course->cover_image }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-64 flex items-center justify-center">
                        <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Informações do Curso -->
            <div class="md:w-2/3 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $course->title }}</h1>
                    @if($course->progress >= 100)
                        <span class="bg-green-500 text-white text-sm font-bold px-4 py-2 rounded-full">
                            Concluído
                        </span>
                    @elseif($course->progress > 0)
                        <span class="bg-yellow-500 text-white text-sm font-bold px-4 py-2 rounded-full">
                            Em andamento
                        </span>
                    @endif
                </div>

                <p class="text-gray-600 mb-6">{{ $course->description ?? 'Sem descrição disponível.' }}</p>

                <!-- Estatísticas do Curso -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center gap-2 text-gray-600 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-medium">Total de Aulas</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $course->lessons->count() }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center gap-2 text-gray-600 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium">Aulas Concluídas</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $course->lessons->where('is_completed', true)->count() }}
                        </p>
                    </div>
                </div>

                <!-- Barra de Progresso -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Seu Progresso</span>
                        <span class="text-sm font-bold text-blue-600">{{ $course->progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ $course->progress }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Aulas -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Conteúdo do Curso</h2>

        <div class="space-y-3">
            @forelse($course->lessons as $index => $lesson)
                <div class="border border-gray-200 rounded-lg hover:border-blue-300 transition-colors duration-200">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-4 flex-1">
                            <!-- Número da Aula -->
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">{{ $index + 1 }}</span>
                                </div>
                            </div>

                            <!-- Info da Aula -->
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $lesson->title }}</h3>
                                @if($lesson->duration_seconds)
                                    <p class="text-sm text-gray-500">
                                        Duração: {{ gmdate('i:s', $lesson->duration_seconds) }} minutos
                                    </p>
                                @endif
                            </div>

                            <!-- Status da Aula -->
                            <div class="flex items-center gap-3">
                                @if($lesson->is_completed)
                                    <span class="flex items-center gap-2 text-green-600 font-medium text-sm">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Concluída
                                    </span>
                                @elseif($lesson->progress_percentage > 0)
                                    <span class="flex items-center gap-2 text-yellow-600 font-medium text-sm">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $lesson->progress_percentage }}%
                                    </span>
                                @endif

                                <!-- Botão Assistir -->
                                <a href="#" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                                    @if($lesson->is_completed)
                                        Rever
                                    @elseif($lesson->progress_percentage > 0)
                                        Continuar
                                    @else
                                        Assistir
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <p>Nenhuma aula disponível neste curso.</p>
                </div>
            @endforelse
        </div>

        <!-- Botão Voltar -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar ao Dashboard
            </a>
        </div>
    </div>

</x-layout>
