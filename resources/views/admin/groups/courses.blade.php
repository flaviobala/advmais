<x-admin-layout title="Cursos do Grupo">
    <div class="mb-6">
        <a href="{{ route('admin.groups.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para lista de grupos
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Cursos do Grupo: {{ $group->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Selecione quais cursos este grupo terá acesso.</p>
        </div>

        <form action="{{ route('admin.groups.courses.sync', $group) }}" method="POST" class="p-6">
            @csrf

            @if($allCourses->count() > 0)
                <div class="space-y-4 mb-6">
                    @foreach($allCourses as $course)
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <input type="checkbox"
                                   id="course_{{ $course->id }}"
                                   name="courses[]"
                                   value="{{ $course->id }}"
                                   {{ in_array($course->id, $groupCourseIds) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="course_{{ $course->id }}" class="ml-3 flex-1 cursor-pointer">
                                <p class="text-sm font-medium text-gray-900">{{ $course->title }}</p>
                                @if($course->description)
                                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit($course->description, 100) }}</p>
                                @endif
                            </label>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <p>Nenhum curso ativo cadastrado.</p>
                    <a href="{{ route('admin.courses.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                        Criar primeiro curso
                    </a>
                </div>
            @endif

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.groups.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Salvar Vinculações
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
