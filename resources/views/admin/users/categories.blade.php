<x-admin-layout title="Categorias do Usuário: {{ $user->name }}">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">&larr; Voltar para lista de usuários</a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Categorias</h2>
            <p class="text-sm text-gray-500 mt-1">Selecione as categorias para liberar ao usuário <strong>{{ $user->name }}</strong>.</p>
        </div>

        <form action="{{ route('admin.users.categories.sync', $user) }}" method="POST" class="p-6">
            @csrf

            @if($categories->isEmpty())
                <p class="text-gray-500 text-center py-8">Nenhuma categoria ativa encontrada.</p>
            @else
                <div class="space-y-3">
                    @foreach($categories as $category)
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-3 flex-1">
                                <input type="checkbox"
                                       name="categories[]"
                                       value="{{ $category->id }}"
                                       {{ in_array($category->id, $userCategoryIds) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <div>
                                    <span class="text-sm text-gray-700 font-medium">{{ $category->name }}</span>
                                    @if($category->description)
                                        <p class="text-xs text-gray-500">{{ $category->description }}</p>
                                    @endif
                                </div>
                            </label>
                            <button type="button" data-category-id="{{ $category->id }}" class="text-xs inline-flex items-center px-2 py-1 rounded {{ $category->is_active ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }} toggle-category">
                                {{ $category->is_active ? 'Desativar Categoria' : 'Ativar Categoria' }}
                            </button>
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
                    Salvar Categorias
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

        document.querySelectorAll('.toggle-category').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.categoryId;
                patch(`/admin/categories/${id}/toggle-active`);
            });
        });
    })();
</script>
