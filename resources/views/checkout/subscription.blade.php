<x-layout title="Plano Anual - AdvMais">
    <div class="max-w-2xl mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow p-6">

            @if ($activeSubscription)
                <div class="bg-green-50 border border-green-200 rounded-lg p-5 mb-6 text-center">
                    <div class="text-4xl mb-2">✓</div>
                    <p class="text-green-700 font-semibold text-lg">Você já tem acesso completo à plataforma!</p>
                    @if($activeSubscription->expires_at)
                        <p class="text-green-600 text-sm mt-1">
                            Acesso válido até: <strong>{{ $activeSubscription->expires_at->format('d/m/Y') }}</strong>
                        </p>
                    @endif
                </div>

                <form action="{{ route('subscription.cancel', $activeSubscription) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja cancelar sua assinatura? Você perderá o acesso à plataforma.')">
                    @csrf
                    <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition text-sm">
                        Cancelar assinatura
                    </button>
                </form>
            @else
                {{-- Cabeçalho --}}
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Plano Anual AdvMais</h1>
                    <p class="text-gray-500 text-sm mt-1">Acesso completo a todos os cursos e trilhas da plataforma por 1 ano</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-lg px-4 py-3 mb-4 text-sm">
                        {{ session('info') }}
                    </div>
                @endif

                {{-- Card do plano --}}
                <div class="border-2 border-blue-500 bg-blue-50 rounded-xl p-5 mb-5 text-center">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-100 px-3 py-1 rounded-full">Plano Anual</span>
                    <div class="mt-3">
                        <span id="price-original" class="text-sm text-gray-400 line-through hidden"></span>
                        <span id="price-display" class="block text-4xl font-bold text-gray-900">
                            R$ {{ number_format($price, 2, ',', '.') }}
                        </span>
                        <span class="text-gray-500 text-sm">/ano</span>
                    </div>
                    <ul class="mt-4 text-sm text-gray-600 space-y-1 text-left max-w-xs mx-auto">
                        <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Acesso a todos os cursos</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Todas as trilhas da plataforma</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Novos conteúdos incluídos</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">✓</span> 1 ano de acesso</li>
                    </ul>
                </div>

                <form action="{{ route('subscription.subscribe') }}" method="POST" id="subscription-form">
                    @csrf

                    {{-- Voucher/Cupom --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Cupom de desconto <span class="text-gray-400 font-normal">(opcional)</span>
                        </label>
                        <div class="flex gap-2">
                            <input type="text" id="voucher-input" name="voucher_code"
                                   value="{{ old('voucher_code') }}"
                                   placeholder="Ex: LIVE2026"
                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('voucher_code') ? 'border-red-400' : '' }}">
                            <button type="button" onclick="validateVoucher()"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
                                Aplicar
                            </button>
                        </div>
                        @error('voucher_code')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p id="voucher-msg" class="text-xs mt-1 hidden"></p>
                    </div>

                    {{-- CPF/CNPJ --}}
                    @if(!auth()->user()->cpf_cnpj)
                        <div id="cpf-section" class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1">CPF ou CNPJ</label>
                            <input type="text" name="cpf_cnpj" value="{{ old('cpf_cnpj') }}"
                                   placeholder="000.000.000-00 ou 00.000.000/0001-00"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                            <p class="text-xs text-gray-400 mt-1">Necessário para emissão da cobrança.</p>
                        </div>
                    @endif

                    {{-- Forma de pagamento (oculta quando cupom é 100%) --}}
                    <div id="payment-section">
                        <p class="text-sm font-medium text-gray-700 mb-3">Forma de pagamento</p>
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            <label class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 has-checked:border-blue-500 has-checked:bg-blue-50 transition">
                                <input type="radio" name="billing_type" value="PIX" class="sr-only">
                                <span class="text-lg font-bold text-green-600">PIX</span>
                                <span class="text-xs text-gray-500 mt-1">Imediato</span>
                            </label>
                            <label class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 has-checked:border-blue-500 has-checked:bg-blue-50 transition">
                                <input type="radio" name="billing_type" value="CREDIT_CARD" class="sr-only">
                                <span class="text-lg font-bold text-blue-600">Cartão</span>
                                <span class="text-xs text-gray-500 mt-1">Crédito</span>
                            </label>
                            <label class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 has-checked:border-blue-500 has-checked:bg-blue-50 transition">
                                <input type="radio" name="billing_type" value="BOLETO" class="sr-only">
                                <span class="text-lg font-bold text-gray-600">Boleto</span>
                                <span class="text-xs text-gray-500 mt-1">1-3 dias</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" id="submit-btn"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition text-lg">
                        Assinar agora →
                    </button>

                    <p id="payment-note" class="text-center text-xs text-gray-400 mt-3">
                        Após o pagamento, seu acesso é liberado automaticamente.
                    </p>
                </form>
            @endif

            <a href="{{ route('dashboard') }}" class="block text-center text-sm text-gray-400 hover:text-gray-600 mt-5">
                ← Voltar ao dashboard
            </a>
        </div>
    </div>

    <script>
        const basePrice    = {{ (float) $price }};
        const validateUrl  = "{{ route('subscription.validate-voucher') }}";
        const csrfToken    = "{{ csrf_token() }}";

        function setFreeMode(isFree) {
            const paySection  = document.getElementById('payment-section');
            const submitBtn   = document.getElementById('submit-btn');
            const payNote     = document.getElementById('payment-note');
            const cpfSection  = document.getElementById('cpf-section');

            if (isFree) {
                paySection.classList.add('hidden');
                if (cpfSection) cpfSection.classList.add('hidden');
                submitBtn.textContent = '🎉 Resgatar acesso gratuito';
                submitBtn.classList.replace('bg-blue-600', 'bg-green-600');
                submitBtn.classList.replace('hover:bg-blue-700', 'hover:bg-green-700');
                payNote.classList.add('hidden');
            } else {
                paySection.classList.remove('hidden');
                if (cpfSection) cpfSection.classList.remove('hidden');
                submitBtn.textContent = 'Assinar agora →';
                submitBtn.classList.replace('bg-green-600', 'bg-blue-600');
                submitBtn.classList.replace('hover:bg-green-700', 'hover:bg-blue-700');
                payNote.classList.remove('hidden');
            }
        }

        function validateVoucher() {
            const code = document.getElementById('voucher-input').value.trim();
            const msg  = document.getElementById('voucher-msg');
            if (!code) return;

            fetch(validateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ code }),
            })
            .then(r => r.json())
            .then(data => {
                msg.classList.remove('hidden');
                if (data.valid) {
                    msg.textContent = data.message;
                    msg.className   = 'text-xs mt-1 text-green-600 font-medium';
                    document.getElementById('price-original').textContent = 'R$ ' + data.original;
                    document.getElementById('price-original').classList.remove('hidden');

                    const isFree = data.discount_percent >= 100;
                    document.getElementById('price-display').textContent = isFree ? 'GRÁTIS' : 'R$ ' + data.final;
                    setFreeMode(isFree);
                } else {
                    msg.textContent = data.message;
                    msg.className   = 'text-xs mt-1 text-red-500';
                    document.getElementById('price-original').classList.add('hidden');
                    document.getElementById('price-display').textContent =
                        'R$ ' + basePrice.toFixed(2).replace('.', ',');
                    setFreeMode(false);
                }
            })
            .catch(() => {
                msg.textContent = 'Erro ao validar cupom.';
                msg.className   = 'text-xs mt-1 text-red-500';
                msg.classList.remove('hidden');
            });
        }

        // Aplicar ao pressionar Enter no campo voucher
        document.getElementById('voucher-input').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                validateVoucher();
            }
        });
    </script>
</x-layout>
