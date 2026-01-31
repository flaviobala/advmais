<x-admin-layout title="Cursos do Usuário: {{ $user->name }}">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">&larr; Voltar para lista de usuários</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Cursos</h2>
            <p class="text-sm text-gray-500 mt-1">Selecione os cursos para liberar ao usuário <strong>{{ $user->name }}</strong>.</p>
        </div>

        <form action="{{ route('admin.users.courses.sync', $user) }}" method="POST" class="p-6">
            @csrf

            @if($courses->isEmpty())
                <p class="text-gray-500 text-center py-8">Nenhum curso encontrado.</p>
            @else
                <div class="space-y-3">
                    @foreach($courses as $course)
                        <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <label class="flex items-center gap-3 flex-1">
                                <input type="checkbox"
                                       name="courses[]"
                                       value="{{ $course->id }}"
                                       {{ in_array($course->id, $userCourseIds) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <div class="flex-1">
                                    <span class="text-sm text-gray-900 font-medium">{{ $course->title }}</span>
                                    <p class="text-xs text-gray-500">{{ $course->category->name ?? 'Sem trilha' }}</p>
                                </div>
                            </label>
                            <div class="flex items-center gap-2">
                                @if($course->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativo</span>
                                    <button type="button" 
                                            data-course-id="{{ $course->id }}" 
                                            class="toggle-course inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-orange-500 rounded-md shadow-sm hover:bg-orange-600 hover:shadow-md active:bg-orange-700 active:scale-95 transition-all duration-150 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                        </svg>
                                        Desativar
                                    </button>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inativo</span>
                                    <button type="button" 
                                            data-course-id="{{ $course->id }}" 
                                            class="toggle-course inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-green-500 rounded-md shadow-sm hover:bg-green-600 hover:shadow-md active:bg-green-700 active:scale-95 transition-all duration-150 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Ativar
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex justify-end gap-4 pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('admin.users.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Salvar Cursos
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
    })();
</script>
