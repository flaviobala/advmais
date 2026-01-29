<x-admin-layout title="Usuário: {{ $user->name }}">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">&larr; Voltar para lista de usuários</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-lg font-medium text-gray-900">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg text-sm">Editar</a>
                <a href="{{ route('admin.users.lessons', $user) }}" class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg text-sm">Aulas</a>
            </div>
        </div>

        <h3 class="text-sm font-medium text-gray-700 mb-3">Cursos</h3>
        <div class="divide-y divide-gray-200">
            @foreach($courses as $course)
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $course->title }}</p>
                        <p class="text-xs text-gray-500">{{ $course->category->name ?? 'Sem categoria' }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($course->access === 'full')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completo</span>
                        @elseif($course->access === 'partial')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Parcial</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Sem Acesso</span>
                        @endif

                        <a href="{{ route('admin.users.lessons', $user) }}" class="text-sm text-blue-600 hover:text-blue-800">Ver Aulas</a>
                        <button type="button" data-course-id="{{ $course->id }}" class="ml-3 text-sm inline-flex items-center px-2 py-1 rounded {{ $course->is_active ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }} toggle-course">
                            {{ $course->is_active ? 'Desativar Curso' : 'Ativar Curso' }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
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
