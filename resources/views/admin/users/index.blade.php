<x-admin-layout title="Usuários">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Usuários</h2>
            <p class="text-sm text-gray-500">Lista de todos os usuários do sistema</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
            + Novo Usuário
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b border-gray-200">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Buscar por nome ou email..."
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="role" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos os papéis</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
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
            @forelse($users as $user)
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-slate-700 flex items-center justify-center mr-3">
                                <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        @if($user->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Ativo
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Inativo
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 mb-3">
                        @php
                            $roleColors = [
                                'admin' => 'bg-red-100 text-red-800',
                                'membro' => 'bg-blue-100 text-blue-800',
                                'aluno' => 'bg-green-100 text-green-800',
                                'professor' => 'bg-yellow-100 text-yellow-800',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        <!-- grupos removed -->
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <!-- grupos removed -->
                        <a href="{{ route('admin.users.courses', $user) }}" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Cursos</a>
                        <a href="{{ route('admin.users.categories', $user) }}" class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded">Trilhas</a>
                        <a href="{{ route('admin.users.lessons', $user) }}" class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded">Aulas</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Editar</a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs {{ $user->is_active ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }} px-2 py-1 rounded">
                                    {{ $user->is_active ? 'Desativar' : 'Ativar' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Excluir</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    Nenhum usuário encontrado.
                </div>
            @endforelse
        </div>

        <!-- Versao desktop: tabela -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Papel</th>
                        <!-- Grupos column removed -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-slate-700 flex items-center justify-center mr-3">
                                        <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-red-100 text-red-800',
                                        'membro' => 'bg-blue-100 text-blue-800',
                                        'aluno' => 'bg-green-100 text-green-800',
                                        'professor' => 'bg-yellow-100 text-yellow-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <!-- Grupos column removed -->
                            <td class="px-6 py-4">
                                @if($user->is_active)
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
                                <!-- Grupos action removed -->
                                <a href="{{ route('admin.users.courses', $user) }}" class="text-blue-600 hover:text-blue-900 mr-3">Cursos</a>
                                <a href="{{ route('admin.users.categories', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Trilhas</a>
                                <a href="{{ route('admin.users.lessons', $user) }}" class="text-purple-600 hover:text-purple-900 mr-3">Aulas</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="inline mr-3">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="{{ $user->is_active ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }}">
                                            {{ $user->is_active ? 'Desativar' : 'Ativar' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                    </form>
                                @else
                                    <span class="text-gray-400">(você)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Nenhum usuário encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
