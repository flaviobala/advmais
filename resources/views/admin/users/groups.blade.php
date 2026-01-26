<x-admin-layout title="Grupos do Usuário">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para lista de usuários
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Gerenciar Grupos de: {{ $user->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Selecione a quais grupos este usuário pertence.</p>
        </div>

        <form action="{{ route('admin.users.groups.sync', $user) }}" method="POST" class="p-6">
            @csrf

            @if($allGroups->count() > 0)
                <div class="space-y-4 mb-6">
                    @foreach($allGroups as $group)
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <input type="checkbox"
                                   id="group_{{ $group->id }}"
                                   name="groups[]"
                                   value="{{ $group->id }}"
                                   {{ in_array($group->id, $userGroupIds) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="group_{{ $group->id }}" class="ml-3 flex-1 cursor-pointer">
                                <p class="text-sm font-medium text-gray-900">{{ $group->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">Slug: {{ $group->slug }}</p>
                            </label>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <p>Nenhum grupo ativo cadastrado.</p>
                    <a href="{{ route('admin.groups.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                        Criar primeiro grupo
                    </a>
                </div>
            @endif

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}"
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
