<x-layout title="Pagamento gerado - AdvMais">
    <div class="max-w-2xl mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow p-6 text-center">

            @if($payment->billing_type === 'PIX' && $payment->pix_qr_code)
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Pague via PIX</h1>
                <p class="text-gray-500 text-sm mb-6">Escaneie o QR Code abaixo ou copie o código PIX</p>

                <div class="flex justify-center mb-4">
                    <img src="data:image/png;base64,{{ $payment->pix_qr_code }}" alt="QR Code PIX" class="w-52 h-52 rounded-lg border">
                </div>

                @if($payment->pix_copy_paste)
                    <div class="bg-gray-50 rounded-lg p-3 mb-4 text-left">
                        <p class="text-xs text-gray-500 mb-1">PIX Copia e Cola</p>
                        <p class="text-xs font-mono text-gray-700 break-all">{{ $payment->pix_copy_paste }}</p>
                        <button onclick="navigator.clipboard.writeText('{{ $payment->pix_copy_paste }}').then(() => this.textContent = 'Copiado!')"
                                class="mt-2 text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                            Copiar código
                        </button>
                    </div>
                @endif

                <p class="text-sm text-yellow-600 bg-yellow-50 rounded-lg p-3 mb-4">
                    Após o pagamento, seu acesso será liberado automaticamente em instantes.
                </p>

            @elseif($payment->payment_url)
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Pagamento gerado!</h1>
                <p class="text-gray-500 text-sm mb-6">
                    @if($payment->billing_type === 'BOLETO')
                        Seu boleto foi gerado. Após o pagamento, o acesso será liberado em até 3 dias úteis.
                    @else
                        Clique no botão abaixo para finalizar o pagamento.
                    @endif
                </p>

                <a href="{{ $payment->payment_url }}" target="_blank"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition mb-4">
                    @if($payment->billing_type === 'BOLETO')
                        Visualizar / Imprimir Boleto
                    @else
                        Finalizar pagamento
                    @endif
                </a>
            @else
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Pagamento em processamento</h1>
                <p class="text-gray-500 text-sm mb-6">Assim que confirmado, seu acesso será liberado automaticamente.</p>
            @endif

            <div class="border-t border-gray-100 pt-4">
                <p class="text-xs text-gray-400">
                    Valor: <strong>R$ {{ number_format($payment->amount, 2, ',', '.') }}</strong>
                    &bull; Vencimento: <strong>{{ $payment->due_date->format('d/m/Y') }}</strong>
                </p>
            </div>

            <a href="{{ route('dashboard') }}" class="block text-sm text-gray-400 hover:text-gray-600 mt-4">
                Ir para o dashboard
            </a>
        </div>
    </div>
</x-layout>
