<x-admin-layout title="Trilhas">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Trilhas</h2>
            <p class="text-sm text-gray-500">Organize seus cursos em trilhas</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
            + Nova Trilha
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
                    <div class="flex items-center gap-3 mb-2">
                        @if($category->cover_image)
                            <img src="{{ asset('storage/' . $category->cover_image) }}" alt="{{ $category->name }}" class="w-14 h-8 rounded object-cover flex-shrink-0">
                        @endif
                        <h3 class="font-medium text-gray-900 flex-1">{{ $category->name }}</h3>
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
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Excluir esta trilha? Os cursos serão mantidos sem trilha.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Excluir</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">Nenhuma trilha encontrada.</div>
            @endforelse
        </div>

        <!-- Desktop table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trilha</th>
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
                                <div class="flex items-center gap-3">
                                    @if($category->cover_image)
                                        <img src="{{ asset('storage/' . $category->cover_image) }}" alt="{{ $category->name }}" class="w-16 h-9 rounded object-cover flex-shrink-0">
                                    @else
                                        <div class="w-16 h-9 rounded bg-gray-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.categories.show', $category) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">{{ $category->name }}</a>
                                        @if($category->description)
                                            <div class="text-sm text-gray-500">{{ Str::limit($category->description, 60) }}</div>
                                        @endif
                                    </div>
                                </div>
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
                                <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Excluir esta trilha? Os cursos serão mantidos sem trilha.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Nenhuma trilha encontrada.</td>
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
