<x-admin-layout title="Integração de Membros">

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Cabeçalho --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Integração de Membros</h2>
            <p class="text-sm text-gray-500 mt-1">Acompanhe o envio de documentos e aprovação de membros</p>
        </div>
        <a href="{{ route('admin.onboarding.settings') }}"
           class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 text-sm px-4 py-2 rounded-lg hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Configurações / Editar Termo
        </a>
    </div>

    {{-- Cards de status --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('admin.onboarding.index') }}"
           class="bg-white rounded-xl border border-gray-200 p-4 text-center hover:shadow-md transition">
            <p class="text-2xl font-bold text-gray-800">{{ $counts['total'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Total</p>
        </a>
        <a href="{{ route('admin.onboarding.index', ['status' => 'pending']) }}"
           class="bg-yellow-50 rounded-xl border border-yellow-200 p-4 text-center hover:shadow-md transition">
            <p class="text-2xl font-bold text-yellow-700">{{ $counts['pending'] }}</p>
            <p class="text-xs text-yellow-600 mt-1">Aguardando docs</p>
        </a>
        <a href="{{ route('admin.onboarding.index', ['status' => 'received']) }}"
           class="bg-blue-50 rounded-xl border border-blue-200 p-4 text-center hover:shadow-md transition">
            <p class="text-2xl font-bold text-blue-700">{{ $counts['received'] }}</p>
            <p class="text-xs text-blue-600 mt-1">Docs recebidos</p>
        </a>
        <a href="{{ route('admin.onboarding.index', ['status' => 'approved']) }}"
           class="bg-green-50 rounded-xl border border-green-200 p-4 text-center hover:shadow-md transition">
            <p class="text-2xl font-bold text-green-700">{{ $counts['approved'] }}</p>
            <p class="text-xs text-green-600 mt-1">Aprovados</p>
        </a>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('admin.onboarding.index') }}"
          class="flex flex-col sm:flex-row gap-3 mb-5">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Buscar por nome ou email..."
               class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
        <select name="status"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            <option value="">Todos os status</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Aguardando documentos</option>
            <option value="received" {{ request('status') === 'received' ? 'selected' : '' }}>Documentos recebidos</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprovados</option>
        </select>
        <button type="submit"
                class="bg-blue-700 text-white text-sm px-5 py-2 rounded-lg hover:bg-blue-800 transition">
            Filtrar
        </button>
    </form>

    {{-- Tabela --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Membro</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Email enviado</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Docs enviados</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($onboardings as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-800">{{ $item->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $item->user->email }}</p>
                        </td>
                        <td class="px-4 py-3">
                            @php $color = $item->statusColor(); @endphp
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                bg-{{ $color }}-100 text-{{ $color }}-700">
                                {{ $item->statusLabel() }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">
                            {{ $item->welcome_sent_at?->format('d/m/Y H:i') ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">
                            {{ $item->docs_submitted_at?->format('d/m/Y H:i') ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.onboarding.show', $item) }}"
                                   class="text-blue-600 hover:underline text-xs font-medium">Ver</a>
                                <form action="{{ route('admin.onboarding.resend', $item) }}" method="POST"
                                      onsubmit="return confirm('Reenviar email de boas-vindas para {{ addslashes($item->user->name) }}?')">
                                    @csrf
                                    <button type="submit"
                                            class="text-gray-500 hover:text-blue-600 text-xs font-medium">
                                        Reenviar email
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-400 text-sm">
                            Nenhum registro encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    @if ($onboardings->hasPages())
        <div class="mt-4">
            {{ $onboardings->links() }}
        </div>
    @endif

</x-admin-layout>
