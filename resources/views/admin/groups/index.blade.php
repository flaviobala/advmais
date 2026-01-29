<x-admin-layout title="Grupos">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Grupos</h2>
            <p class="text-sm text-gray-500">Lista de todos os grupos/turmas cadastrados</p>
        </div>
        <a href="{{ route('admin.groups.create') }}"
           class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
            + Novo Grupo
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b border-gray-200">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Buscar por nome..."
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Buscar
                </button>
            </form>
        </div>

        <!-- Versao mobile: cards -->
        <div class="block md:hidden">
            @forelse($groups as $group)
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $group->name }}</p>
                            <p class="text-xs text-gray-500">{{ $group->slug }}</p>
                        </div>
                        @if($group->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Ativo
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Inativo
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 mb-3 text-xs text-gray-500">
                        <span>{{ $group->users_count }} usuários</span>
                        <span>{{ $group->courses_count }} cursos</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.groups.courses', $group) }}" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Cursos</a>
                        <a href="{{ route('admin.groups.lessons', $group) }}" class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded">Aulas</a>
                        <a href="{{ route('admin.groups.edit', $group) }}" class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Editar</a>
                        <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este grupo?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Excluir</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    Nenhum grupo encontrado.
                </div>
            @endforelse
        </div>

        <!-- Versao desktop: tabela -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grupo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuários</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cursos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($groups as $group)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $group->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $group->slug }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $group->users_count }} usuários
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $group->courses_count }} cursos
                            </td>
                            <td class="px-6 py-4">
                                @if($group->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Ativo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inativo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('admin.groups.courses', $group) }}" class="text-blue-600 hover:text-blue-900 mr-3">Cursos</a>
                                <a href="{{ route('admin.groups.lessons', $group) }}" class="text-purple-600 hover:text-purple-900 mr-3">Aulas</a>
                                <a href="{{ route('admin.groups.edit', $group) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                                <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este grupo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Nenhum grupo encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($groups->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $groups->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
