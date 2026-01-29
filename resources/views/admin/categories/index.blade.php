<x-admin-layout title="Categorias">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Categorias</h2>
            <p class="text-sm text-gray-500">Organize seus cursos em categorias</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
            + Nova Categoria
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
                    Filtrar
                </button>
            </form>
        </div>

        <!-- Mobile cards -->
        <div class="block md:hidden">
            @forelse($categories as $category)
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium text-gray-900">{{ $category->name }}</h3>
                        @if($category->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativa</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inativa</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 mb-2">{{ $category->courses_count }} cursos | Ordem: {{ $category->order }}</p>
                    @if($category->description)
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($category->description, 80) }}</p>
                    @endif
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Editar</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Excluir esta categoria? Os cursos serão mantidos sem categoria.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Excluir</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">Nenhuma categoria encontrada.</div>
            @endforelse
        </div>

        <!-- Desktop table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cursos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $category->order }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                @if($category->description)
                                    <div class="text-sm text-gray-500">{{ Str::limit($category->description, 60) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $category->courses_count }} cursos</td>
                            <td class="px-6 py-4">
                                @if($category->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativa</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inativa</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Excluir esta categoria? Os cursos serão mantidos sem categoria.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Nenhuma categoria encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
