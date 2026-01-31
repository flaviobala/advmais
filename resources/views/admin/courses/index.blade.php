<x-admin-layout title="Cursos">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Cursos</h2>
            <p class="text-sm text-gray-500">Lista de todos os cursos cadastrados</p>
        </div>
        <a href="{{ route('admin.courses.create') }}"
           class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
            + Novo Curso
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b border-gray-200">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Buscar por título..."
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <div class="flex gap-3">
                    <select name="status" class="flex-1 sm:flex-none border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos os status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativos</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inativos</option>
                    </select>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Versao mobile: cards -->
        <div class="block md:hidden">
            @forelse($courses as $course)
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-start gap-3 mb-3">
                        @if($course->cover_image)
                            <img src="{{ Storage::url($course->cover_image) }}" alt="" class="h-16 w-16 rounded object-cover flex-shrink-0">
                        @else
                            <div class="h-16 w-16 rounded bg-gray-200 flex items-center justify-center flex-shrink-0">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('admin.courses.show', $course) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 block truncate">
                                {{ $course->title }}
                            </a>
                            <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                                <span>{{ $course->lessons_count }} aulas</span>
                                <span>{{ $course->groups_count }} grupos</span>
                            </div>
                            <div class="mt-2 flex flex-wrap gap-1">
                                @if($course->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativo</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inativo</span>
                                @endif
                                @if(!$course->is_approved)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendente</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.courses.show', $course) }}" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Ver</a>
                        <a href="{{ route('admin.courses.edit', $course) }}" class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Editar</a>
                        @if(auth()->user()->isAdmin() && !$course->is_approved)
                            <form action="{{ route('admin.courses.approve', $course) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Aprovar</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este curso?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Excluir</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    Nenhum curso encontrado.
                </div>
            @endforelse
        </div>

        <!-- Versao desktop: tabela -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Curso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aulas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grupos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($courses as $course)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($course->cover_image)
                                        <img src="{{ Storage::url($course->cover_image) }}" alt="" class="h-10 w-10 rounded object-cover mr-3">
                                    @else
                                        <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center mr-3">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.courses.show', $course) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                            {{ $course->title }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $course->lessons_count }} aulas
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $course->groups_count }} grupos
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if($course->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativo</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inativo</span>
                                    @endif
                                    @if(!$course->is_approved)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendente</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('admin.courses.show', $course) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                <a href="{{ route('admin.courses.edit', $course) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                                @if(auth()->user()->isAdmin() && !$course->is_approved)
                                    <form action="{{ route('admin.courses.approve', $course) }}" method="POST" class="inline mr-3">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-900">Aprovar</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este curso?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Nenhum curso encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($courses->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $courses->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
