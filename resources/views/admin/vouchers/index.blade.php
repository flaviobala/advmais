<x-admin-layout title="Vouchers / Cupons">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Vouchers / Cupons</h1>
            <p class="text-sm text-gray-500 mt-1">Desconto no Plano Anual da plataforma</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    {{-- Formulário de criação --}}
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Criar novo voucher</h2>

        <form action="{{ route('admin.vouchers.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Código *</label>
                    <input type="text" name="code" value="{{ old('code') }}"
                           placeholder="Ex: LIVE2026"
                           class="w-full border rounded-lg px-3 py-2 text-sm uppercase tracking-widest {{ $errors->has('code') ? 'border-red-400' : 'border-gray-300' }}"
                           required>
                    @error('code')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                    <input type="text" name="description" value="{{ old('description') }}"
                           placeholder="Ex: Voucher da live de março"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Desconto (%) *</label>
                    <input type="number" name="discount_percent" value="{{ old('discount_percent') }}"
                           min="1" max="100" placeholder="Ex: 20"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Limite de usos <span class="text-gray-400">(0 = ilimitado)</span></label>
                    <input type="number" name="max_uses" value="{{ old('max_uses', 0) }}"
                           min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Validade</label>
                    <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Deixe em branco para sem validade.</p>
                </div>

            </div>

            <div class="mt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition text-sm">
                    Criar Voucher
                </button>
            </div>
        </form>
    </div>

    {{-- Listagem --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Código</th>
                    <th class="px-4 py-3 text-left">Desconto</th>
                    <th class="px-4 py-3 text-left">Descrição</th>
                    <th class="px-4 py-3 text-left">Usos</th>
                    <th class="px-4 py-3 text-left">Validade</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($vouchers as $voucher)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-mono font-bold text-gray-900">{{ $voucher->code }}</td>
                        <td class="px-4 py-3 text-green-600 font-bold text-base">{{ $voucher->discount_percent }}%</td>
                        <td class="px-4 py-3 text-gray-500">{{ $voucher->description ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $voucher->used_count }}{{ $voucher->max_uses > 0 ? ' / ' . $voucher->max_uses : '' }}
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $voucher->expires_at ? $voucher->expires_at->format('d/m/Y H:i') : 'Sem validade' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($voucher->is_active)
                                <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">Ativo</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-1 rounded-full">Inativo</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 flex gap-2">
                            <form action="{{ route('admin.vouchers.toggle', $voucher) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="text-xs text-blue-600 hover:underline">
                                    {{ $voucher->is_active ? 'Desativar' : 'Ativar' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST"
                                  onsubmit="return confirm('Remover este voucher?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-gray-400">Nenhum voucher cadastrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-admin-layout>
