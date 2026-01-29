<x-admin-layout title="Aulas do Usuário: {{ $user->name }}">
    <div class="mb-6">
        <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para o usuário
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Aulas Individuais</h2>
            <p class="text-sm text-gray-500 mt-1">Selecione aulas específicas para liberar ao usuário <strong>{{ $user->name }}</strong>. Aulas de cursos já acessíveis via grupo são indicadas.</p>
        </div>

        <form action="{{ route('admin.users.lessons.sync', $user) }}" method="POST" class="p-6">
            @csrf

            @forelse($courses as $course)
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <h3 class="font-medium text-gray-900">{{ $course->title }}</h3>
                        @if(in_array($course->id, $fullAccessCourseIds))
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Acesso via grupo</span>
                        @endif
                        <button type="button" data-course-id="{{ $course->id }}" class="ml-4 text-xs inline-flex items-center px-2 py-1 rounded {{ $course->is_active ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }} toggle-course">
                            {{ $course->is_active ? 'Desativar Curso' : 'Ativar Curso' }}
                        </button>
                    </div>

                    @if($course->lessons->isEmpty())
                        <p class="text-sm text-gray-400 ml-6">Nenhuma aula cadastrada.</p>
                    @else
                        <div class="space-y-2 ml-6">
                            @foreach($course->lessons as $lesson)
                                <div class="flex items-center gap-3 {{ in_array($course->id, $fullAccessCourseIds) ? 'opacity-50' : '' }}">
                                    <label class="flex items-center gap-3 flex-1">
                                        <input type="checkbox"
                                               name="lessons[]"
                                               value="{{ $lesson->id }}"
                                               {{ in_array($lesson->id, $userLessonIds) ? 'checked' : '' }}
                                               {{ in_array($course->id, $fullAccessCourseIds) ? 'disabled' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="text-sm text-gray-700">
                                            {{ $lesson->order }}. {{ $lesson->title }}
                                            @if($lesson->duration_seconds)
                                                <span class="text-gray-400">({{ gmdate('i:s', $lesson->duration_seconds) }})</span>
                                            @endif
                                        </span>
                                    </label>
                                    <button type="button" data-lesson-id="{{ $lesson->id }}" class="text-xs inline-flex items-center px-2 py-1 rounded {{ $lesson->is_active ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }} toggle-lesson">
                                        {{ $lesson->is_active ? 'Desativar Aula' : 'Ativar Aula' }}
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">Nenhum curso ativo encontrado.</p>
            @endforelse

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users.show', $user) }}"
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

<script>
    (function(){
        const csrf = '{{ csrf_token() }}';

        async function patch(url){
            await fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            });
            location.reload();
        }

        document.querySelectorAll('.toggle-course').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.courseId;
                patch(`/admin/courses/${id}/toggle-active`);
            });
        });

        document.querySelectorAll('.toggle-lesson').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.lessonId;
                patch(`/admin/lessons/${id}/toggle-active`);
            });
        });
    })();
</script>
