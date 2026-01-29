<x-admin-layout title="{{ $course->title }}">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.courses.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para lista de cursos
        </a>
        <div class="flex gap-2">
            <a href="{{ route('admin.courses.edit', $course) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                Editar Curso
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                @if($course->course_video)
                    <div class="w-full aspect-video bg-black rounded-lg overflow-hidden mb-4">
                        <video class="w-full h-full" controls>
                            <source src="{{ Storage::url($course->course_video) }}" type="video/mp4">
                            Seu navegador não suporta vídeo.
                        </video>
                    </div>
                @elseif($course->cover_image)
                    <img src="{{ Storage::url($course->cover_image) }}" alt="{{ $course->title }}" class="w-full rounded-lg mb-4">
                @else
                    <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center mb-4">
                        <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                @endif

                <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $course->title }}</h2>

                @if($course->is_active)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mb-4">
                        Ativo
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mb-4">
                        Inativo
                    </span>
                @endif

                @if($course->description)
                    <p class="text-gray-600 text-sm mb-4">{{ $course->description }}</p>
                @endif

                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="grid grid-cols-1 gap-4 text-center">
                        <div>
                            <p class="text-2xl font-bold text-blue-600">{{ $course->lessons->count() }}</p>
                            <p class="text-sm text-gray-500">Aulas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Aulas do Curso</h2>
                        <p class="text-sm text-gray-500">Gerencie as aulas deste curso</p>
                    </div>
                    <a href="{{ route('admin.courses.lessons.create', $course) }}"
                       class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                        + Nova Aula
                    </a>
                </div>

                <div class="divide-y divide-gray-200" id="lessons-list">
                    @forelse($course->lessons as $lesson)
                        <div class="p-4 flex items-center justify-between hover:bg-gray-50" data-lesson-id="{{ $lesson->id }}">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-blue-600 font-medium">{{ $lesson->order }}</span>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">{{ $lesson->title }}</h3>
                                    <p class="text-xs text-gray-500">
                                        {{ strtoupper($lesson->video_provider->value ?? $lesson->video_provider) }} -
                                        ID: {{ $lesson->video_ref_id }}
                                        @if($lesson->duration_seconds)
                                            - {{ floor($lesson->duration_seconds / 60) }}min
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.lessons.edit', $lesson) }}"
                                   class="text-yellow-600 hover:text-yellow-900 text-sm">
                                    Editar
                                </a>
                                <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta aula?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Excluir</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-4">Nenhuma aula cadastrada.</p>
                            <a href="{{ route('admin.courses.lessons.create', $course) }}"
                               class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                                Adicionar primeira aula
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
