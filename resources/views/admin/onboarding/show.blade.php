<x-admin-layout title="Detalhes do Membro">

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.onboarding.index') }}"
               class="text-sm text-blue-600 hover:underline flex items-center gap-1 mb-1">
                ← Voltar à lista
            </a>
            <h2 class="text-xl font-bold text-gray-800">{{ $onboarding->user->name }}</h2>
            <p class="text-sm text-gray-500">{{ $onboarding->user->email }}</p>
        </div>
        <div class="flex items-center gap-3">
            @php $color = $onboarding->statusColor(); @endphp
            <span class="px-3 py-1 rounded-full text-sm font-semibold
                bg-{{ $color }}-100 text-{{ $color }}-700">
                {{ $onboarding->statusLabel() }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        {{-- Info card --}}
        <div class="md:col-span-2 bg-white rounded-xl border border-gray-200 p-6 space-y-5">
            <h3 class="font-semibold text-gray-700 border-b pb-2">Documentos recebidos</h3>

            {{-- Foto --}}
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Foto profissional</p>
                @if ($onboarding->photo)
                    <img src="{{ Storage::url($onboarding->photo) }}"
                         alt="Foto de {{ $onboarding->user->name }}"
                         class="w-32 h-32 object-cover rounded-xl border border-gray-200">
                @else
                    <p class="text-gray-400 text-sm italic">Não enviada ainda</p>
                @endif
            </div>

            {{-- Mini currículo --}}
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Mini currículo</p>
                @if ($onboarding->mini_bio)
                    <p class="text-gray-700 text-sm bg-gray-50 rounded-lg p-3 border border-gray-100 whitespace-pre-line">
                        {{ $onboarding->mini_bio }}
                    </p>
                @else
                    <p class="text-gray-400 text-sm italic">Não enviado ainda</p>
                @endif
            </div>

            {{-- OAB --}}
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Número da OAB</p>
                @if ($onboarding->oab_number)
                    <p class="text-gray-800 font-semibold">{{ $onboarding->oab_number }}</p>
                @else
                    <p class="text-gray-400 text-sm italic">Não informado ainda</p>
                @endif
            </div>

            {{-- Termo assinado --}}
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Termo de Adesão</p>
                @if ($onboarding->signed_term)
                    <a href="{{ Storage::url($onboarding->signed_term) }}" target="_blank"
                       class="inline-flex items-center gap-2 text-blue-600 hover:underline text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Abrir PDF assinado
                    </a>
                @elseif ($onboarding->term_accepted_at)
                    <p class="text-green-700 text-sm">
                        ✓ Aceite digital em {{ $onboarding->term_accepted_at->format('d/m/Y H:i') }}
                    </p>
                @else
                    <p class="text-gray-400 text-sm italic">Não enviado ainda</p>
                @endif

                {{-- Preview do termo enviado por email --}}
                <a href="{{ route('admin.onboarding.preview-pdf', $onboarding) }}" target="_blank"
                   class="mt-2 inline-flex items-center gap-1 text-xs text-gray-500 hover:text-blue-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Visualizar termo enviado por email
                </a>
            </div>
        </div>

        {{-- Ações --}}
        <div class="space-y-4">
            {{-- Aprovar --}}
            @if ($onboarding->status !== 'approved')
                <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                    <p class="text-sm font-semibold text-green-800 mb-2">Aprovar membro</p>
                    <p class="text-xs text-green-700 mb-3">
                        Após aprovação o status muda para "Aprovado".
                    </p>
                    <form action="{{ route('admin.onboarding.approve', $onboarding) }}" method="POST"
                          onsubmit="return confirm('Aprovar {{ addslashes($onboarding->user->name) }}?')">
                        @csrf
                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 px-4 rounded-lg transition">
                            ✓ Aprovar membro
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                    <p class="text-sm font-semibold text-green-800 mb-1">✓ Aprovado</p>
                    <p class="text-xs text-green-700">
                        Por: {{ $onboarding->approvedBy?->name ?? 'sistema' }}<br>
                        Em: {{ $onboarding->approved_at?->format('d/m/Y H:i') }}
                    </p>
                </div>
            @endif

            {{-- Reenviar email --}}
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm font-semibold text-gray-700 mb-2">Reenviar email de boas-vindas</p>
                <p class="text-xs text-gray-500 mb-3">
                    Envia novamente o email com o PDF do termo em anexo.
                    @if ($onboarding->welcome_sent_at)
                        <br>Último envio: {{ $onboarding->welcome_sent_at->format('d/m/Y H:i') }}
                    @endif
                </p>
                <form action="{{ route('admin.onboarding.resend', $onboarding) }}" method="POST"
                      onsubmit="return confirm('Reenviar email para {{ addslashes($onboarding->user->email) }}?')">
                    @csrf
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded-lg transition">
                        Reenviar email
                    </button>
                </form>
            </div>

            {{-- Timeline --}}
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm font-semibold text-gray-700 mb-3">Linha do tempo</p>
                <ul class="space-y-2 text-xs text-gray-500">
                    <li>
                        <span class="font-medium text-gray-700">Cadastro:</span>
                        {{ $onboarding->created_at->format('d/m/Y H:i') }}
                    </li>
                    @if ($onboarding->welcome_sent_at)
                        <li>
                            <span class="font-medium text-gray-700">Email enviado:</span>
                            {{ $onboarding->welcome_sent_at->format('d/m/Y H:i') }}
                        </li>
                    @endif
                    @if ($onboarding->docs_submitted_at)
                        <li>
                            <span class="font-medium text-gray-700">Docs enviados:</span>
                            {{ $onboarding->docs_submitted_at->format('d/m/Y H:i') }}
                        </li>
                    @endif
                    @if ($onboarding->approved_at)
                        <li>
                            <span class="font-medium text-gray-700">Aprovado:</span>
                            {{ $onboarding->approved_at->format('d/m/Y H:i') }}
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

</x-admin-layout>
