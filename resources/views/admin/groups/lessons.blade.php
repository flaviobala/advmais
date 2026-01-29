<x-admin-layout title="Aulas do Grupo: {{ $group->name }}">
    <div class="mb-6">
        <a href="{{ route('admin.groups.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para lista de grupos
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Aulas Individuais</h2>
            <p class="text-sm text-gray-500 mt-1">Selecione aulas específicas para liberar ao grupo <strong>{{ $group->name }}</strong>. Aulas de cursos já vinculados ao grupo são automaticamente acessíveis.</p>
        </div>

        <form action="{{ route('admin.groups.lessons.sync', $group) }}" method="POST" class="p-6">
            @csrf

            @forelse($courses as $course)
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <h3 class="font-medium text-gray-900">{{ $course->title }}</h3>
                        @if(in_array($course->id, $groupCourseIds))
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Curso completo vinculado</span>
                        @endif
                    </div>

                    @if($course->lessons->isEmpty())
                        <p class="text-sm text-gray-400 ml-6">Nenhuma aula cadastrada.</p>
                    @else
                        <div class="space-y-2 ml-6">
                            @foreach($course->lessons as $lesson)
                                <label class="flex items-center gap-3 {{ in_array($course->id, $groupCourseIds) ? 'opacity-50' : '' }}">
                                    <input type="checkbox"
                                           name="lessons[]"
                                           value="{{ $lesson->id }}"
                                           {{ in_array($lesson->id, $groupLessonIds) ? 'checked' : '' }}
                                           {{ in_array($course->id, $groupCourseIds) ? 'disabled' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="text-sm text-gray-700">
                                        {{ $lesson->order }}. {{ $lesson->title }}
                                        @if($lesson->duration_seconds)
                                            <span class="text-gray-400">({{ gmdate('i:s', $lesson->duration_seconds) }})</span>
                                        @endif
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">Nenhum curso ativo encontrado.</p>
            @endforelse

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.groups.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Salvar Aulas
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
