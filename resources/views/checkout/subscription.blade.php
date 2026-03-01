<x-layout title="Assinar - {{ $category->name }}">
    <div class="max-w-2xl mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow p-6">

            @if ($activeSubscription)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-green-700 font-medium">Você já possui uma assinatura ativa para esta trilha.</p>
                    <p class="text-green-600 text-sm mt-1">Próximo vencimento: {{ $activeSubscription->next_due_date?->format('d/m/Y') ?? 'N/A' }}</p>
                </div>

                <form action="{{ route('subscription.cancel', $activeSubscription) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja cancelar sua assinatura?')">
                    @csrf
                    <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition">
                        Cancelar assinatura
                    </button>
                </form>
            @else
                <h1 class="text-2xl font-bold text-gray-800 mb-1">Assinar trilha</h1>
                <p class="text-gray-500 text-sm mb-6">{{ $category->name }}</p>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4 mb-2">
                    <span class="text-gray-600">Valor mensal</span>
                    <span class="text-2xl font-bold text-green-600">R$ {{ number_format($category->price, 2, ',', '.') }}</span>
                </div>
                <p class="text-xs text-gray-400 mb-6">Cobrança recorrente todo mês. Cancele quando quiser.</p>

                @if(session('info'))
                    <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-lg px-4 py-3 mb-4 text-sm">
                        {{ session('info') }}
                    </div>
                @endif

                <form action="{{ route('subscription.subscribe', $category) }}" method="POST">
                    @csrf

                    @if(!auth()->user()->cpf_cnpj)
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1">CPF ou CNPJ</label>
                            <input type="text" name="cpf_cnpj" value="{{ old('cpf_cnpj') }}"
                                   placeholder="000.000.000-00 ou 00.000.000/0001-00"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                            <p class="text-xs text-gray-400 mt-1">Necessário para emissão da cobrança.</p>
                        </div>
                    @endif

                    <p class="text-sm font-medium text-gray-700 mb-3">Forma de pagamento</p>
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <label class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition">
                            <input type="radio" name="billing_type" value="PIX" class="sr-only" required>
                            <span class="text-lg font-bold text-green-600">PIX</span>
                            <span class="text-xs text-gray-500 mt-1">Mensal</span>
                        </label>
                        <label class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition">
                            <input type="radio" name="billing_type" value="CREDIT_CARD" class="sr-only">
                            <span class="text-lg font-bold text-blue-600">Cartão</span>
                            <span class="text-xs text-gray-500 mt-1">Crédito</span>
                        </label>
                        <label class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition">
                            <input type="radio" name="billing_type" value="BOLETO" class="sr-only">
                            <span class="text-lg font-bold text-gray-600">Boleto</span>
                            <span class="text-xs text-gray-500 mt-1">Mensal</span>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
                        Assinar agora
                    </button>
                </form>
            @endif

            <a href="{{ route('trilhas.show', $category->id) }}" class="block text-center text-sm text-gray-400 hover:text-gray-600 mt-4">
                Voltar à trilha
            </a>
        </div>
    </div>
</x-layout>
