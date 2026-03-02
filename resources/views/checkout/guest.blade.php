<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar conta — ADV+ CONECTA</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy:  #0b1628;
            --navy2: #0f1e38;
            --gold:  #c8a84b;
            --gold2: #a8893c;
            --white: #f5f5f0;
            --muted: #8a9ab5;
        }
        body {
            background-color: var(--navy);
            color: var(--white);
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            min-height: 100vh;
        }
        .card {
            background-color: #0f1e38;
            border: 1px solid #1e3155;
            border-radius: 8px;
        }
        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.4rem;
        }
        .form-input {
            width: 100%;
            background-color: #0b1628;
            border: 1px solid #1e3155;
            border-radius: 4px;
            color: var(--white);
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
            outline: none;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .form-input::placeholder { color: #3a5070; }
        .form-input:focus { border-color: var(--gold); }
        .form-input.is-error { border-color: #e05353; }
        .error-msg {
            font-size: 0.78rem;
            color: #e05353;
            margin-top: 0.3rem;
        }
        .payment-card {
            background-color: #0b1628;
            border: 2px solid #1e3155;
            border-radius: 6px;
            padding: 1rem;
            cursor: pointer;
            text-align: center;
            transition: border-color 0.2s, background-color 0.2s;
        }
        .payment-card:has(input:checked) {
            border-color: var(--gold);
            background-color: rgba(200,168,75,0.08);
        }
        .btn-submit {
            width: 100%;
            background-color: var(--gold);
            color: #0b1628;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.04em;
            padding: 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.15s;
        }
        .btn-submit:hover {
            background-color: var(--gold2);
            transform: translateY(-1px);
        }
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .gold-divider {
            width: 40px;
            height: 2px;
            background-color: var(--gold);
            margin: 0 auto 1.5rem;
        }
        .section-tag {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gold);
        }
        .alert-error {
            background-color: rgba(224,83,83,0.1);
            border: 1px solid rgba(224,83,83,0.4);
            border-radius: 4px;
            color: #f87171;
            font-size: 0.875rem;
            padding: 0.75rem 1rem;
        }
    </style>
</head>
<body>

    {{-- TOPO --}}
    <header class="py-6 px-6 text-center border-b border-slate-800">
        <a href="{{ url('/') }}">
            <img src="/Logo adv mais.png" alt="ADV+ CONECTA" class="h-14 w-auto opacity-90 mx-auto">
        </a>
    </header>

    <main class="max-w-lg mx-auto px-4 py-12">

        {{-- Título --}}
        <div class="text-center mb-8">
            <span class="section-tag">Assinatura anual</span>
            <h1 class="text-2xl md:text-3xl font-bold mt-2 mb-1" style="font-family:'Playfair Display',serif;">
                Criar conta e entrar na comunidade
            </h1>
            <p class="text-sm mt-2" style="color:var(--muted);">
                Preencha os dados abaixo para criar seu acesso e concluir o pagamento.
            </p>
        </div>

        {{-- Erro geral --}}
        @if ($errors->has('error'))
            <div class="alert-error mb-6">{{ $errors->first('error') }}</div>
        @endif

        <form action="{{ route('guest.checkout') }}" method="POST" id="guest-form">
            @csrf

            <div class="card p-6 mb-4">
                <p class="section-tag mb-5">Seus dados de acesso</p>

                {{-- Nome --}}
                <div class="mb-4">
                    <label class="form-label">Nome completo</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Seu nome completo"
                           class="form-input {{ $errors->has('name') ? 'is-error' : '' }}">
                    @error('name') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                {{-- E-mail --}}
                <div class="mb-4">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="seu@email.com.br"
                           class="form-input {{ $errors->has('email') ? 'is-error' : '' }}">
                    @error('email')
                        <p class="error-msg">
                            {{ $message }}
                            @if(str_contains($message, 'já está cadastrado'))
                                <a href="{{ route('login') }}" class="underline ml-1">Entrar</a>
                            @endif
                        </p>
                    @enderror
                </div>

                {{-- Senha --}}
                <div class="mb-4">
                    <label class="form-label">Senha</label>
                    <input type="password" name="password"
                           placeholder="Mínimo 6 caracteres"
                           class="form-input {{ $errors->has('password') ? 'is-error' : '' }}">
                    @error('password') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                {{-- Confirmar senha --}}
                <div class="mb-0">
                    <label class="form-label">Confirmar senha</label>
                    <input type="password" name="password_confirmation"
                           placeholder="Repita a senha"
                           class="form-input {{ $errors->has('password') ? 'is-error' : '' }}">
                </div>
            </div>

            <div class="card p-6 mb-4">
                <p class="section-tag mb-5">Pagamento</p>

                {{-- Resumo do plano --}}
                <div class="flex justify-between items-center mb-5 pb-5 border-b border-slate-700">
                    <div>
                        <p class="font-semibold text-sm">Plano Anual ADV+ CONECTA</p>
                        <p class="text-xs mt-0.5" style="color:var(--muted);">12 meses de acesso completo</p>
                    </div>
                    <div class="text-right">
                        <span id="price-original" class="hidden text-xs line-through block" style="color:var(--muted);"></span>
                        <span id="price-display" class="text-xl font-bold" style="color:var(--gold);">
                            R$ {{ number_format($price, 2, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Cupom --}}
                <div class="mb-5">
                    <label class="form-label">Cupom de desconto <span style="color:#3a5070;font-weight:400;">(opcional)</span></label>
                    <div class="flex gap-2">
                        <input type="text" id="voucher-input" name="voucher_code"
                               value="{{ old('voucher_code') }}"
                               placeholder="CUPOM"
                               style="text-transform:uppercase;letter-spacing:0.1em;flex:1;"
                               class="form-input {{ $errors->has('voucher_code') ? 'is-error' : '' }}">
                        <button type="button" onclick="validateVoucher()"
                                style="background:#1e3155;color:var(--white);border:none;border-radius:4px;padding:0 1.25rem;font-size:0.85rem;font-weight:600;cursor:pointer;white-space:nowrap;transition:background 0.2s;"
                                onmouseover="this.style.background='#2a4570'" onmouseout="this.style.background='#1e3155'">
                            Aplicar
                        </button>
                    </div>
                    @error('voucher_code') <p class="error-msg">{{ $message }}</p> @enderror
                    <p id="voucher-msg" class="hidden text-xs mt-1"></p>
                </div>

                {{-- CPF/CNPJ --}}
                <div id="cpf-section" class="mb-5">
                    <label class="form-label">CPF ou CNPJ</label>
                    <input type="text" name="cpf_cnpj" value="{{ old('cpf_cnpj') }}"
                           placeholder="000.000.000-00"
                           class="form-input {{ $errors->has('cpf_cnpj') ? 'is-error' : '' }}">
                    <p class="text-xs mt-1" style="color:var(--muted);">Necessário para emissão da cobrança.</p>
                    @error('cpf_cnpj') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                {{-- Forma de pagamento --}}
                <div id="payment-section">
                    <label class="form-label mb-3">Forma de pagamento</label>
                    @error('billing_type')
                        <p class="error-msg mb-2">{{ $message }}</p>
                    @enderror
                    <div class="grid grid-cols-3 gap-3">
                        <label class="payment-card">
                            <input type="radio" name="billing_type" value="PIX" class="sr-only"
                                   {{ old('billing_type') === 'PIX' ? 'checked' : '' }}>
                            <span class="block font-bold text-sm" style="color:#4ade80;">PIX</span>
                            <span class="block text-xs mt-1" style="color:var(--muted);">Imediato</span>
                        </label>
                        <label class="payment-card">
                            <input type="radio" name="billing_type" value="CREDIT_CARD" class="sr-only"
                                   {{ old('billing_type') === 'CREDIT_CARD' ? 'checked' : '' }}>
                            <span class="block font-bold text-sm" style="color:#60a5fa;">Cartão</span>
                            <span class="block text-xs mt-1" style="color:var(--muted);">Crédito</span>
                        </label>
                        <label class="payment-card">
                            <input type="radio" name="billing_type" value="BOLETO" class="sr-only"
                                   {{ old('billing_type') === 'BOLETO' ? 'checked' : '' }}>
                            <span class="block font-bold text-sm" style="color:#e2e8f0;">Boleto</span>
                            <span class="block text-xs mt-1" style="color:var(--muted);">1–3 dias</span>
                        </label>
                    </div>
                </div>

            </div>

            {{-- Botão de envio --}}
            <button type="submit" id="submit-btn" class="btn-submit">
                Criar conta e ir para o pagamento →
            </button>

            <p id="payment-note" class="text-center text-xs mt-3" style="color:var(--muted);">
                Após a confirmação do pagamento, seu acesso é liberado automaticamente.
            </p>

        </form>

        {{-- Link para login --}}
        <p class="text-center text-xs mt-8" style="color:var(--muted);">
            Já tem conta?
            <a href="{{ route('login') }}" class="underline" style="color:var(--gold);">Fazer login</a>
        </p>

    </main>

    <footer class="py-6 text-center text-xs border-t border-slate-800" style="color:var(--muted);">
        &copy; {{ date('Y') }} ADV+ CONECTA. Todos os direitos reservados.
    </footer>

    <script>
        const basePrice   = {{ (float) $price }};
        const validateUrl = "{{ route('guest.validate-voucher') }}";
        const csrfToken   = "{{ csrf_token() }}";

        function setFreeMode(isFree) {
            const paySection = document.getElementById('payment-section');
            const cpfSection = document.getElementById('cpf-section');
            const submitBtn  = document.getElementById('submit-btn');
            const payNote    = document.getElementById('payment-note');

            if (isFree) {
                paySection.classList.add('hidden');
                cpfSection.classList.add('hidden');
                submitBtn.textContent = '🎉 Criar conta com acesso gratuito';
                submitBtn.style.backgroundColor = '#16a34a';
                payNote.classList.add('hidden');
            } else {
                paySection.classList.remove('hidden');
                cpfSection.classList.remove('hidden');
                submitBtn.textContent = 'Criar conta e ir para o pagamento →';
                submitBtn.style.backgroundColor = 'var(--gold)';
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
                    msg.textContent  = data.message;
                    msg.style.color  = '#4ade80';
                    const isFree     = data.discount_percent >= 100;
                    const origEl     = document.getElementById('price-original');
                    const dispEl     = document.getElementById('price-display');
                    origEl.textContent = 'R$ ' + data.original;
                    origEl.classList.remove('hidden');
                    dispEl.textContent = isFree ? 'GRÁTIS' : 'R$ ' + data.final;
                    setFreeMode(isFree);
                } else {
                    msg.textContent = data.message;
                    msg.style.color = '#e05353';
                    document.getElementById('price-original').classList.add('hidden');
                    document.getElementById('price-display').textContent =
                        'R$ ' + basePrice.toFixed(2).replace('.', ',');
                    setFreeMode(false);
                }
            })
            .catch(() => {
                msg.textContent = 'Erro ao validar cupom.';
                msg.style.color = '#e05353';
                msg.classList.remove('hidden');
            });
        }

        document.getElementById('voucher-input').addEventListener('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); validateVoucher(); }
        });

        document.getElementById('guest-form').addEventListener('submit', function () {
            const btn = document.getElementById('submit-btn');
            btn.disabled    = true;
            btn.textContent = 'Processando...';
        });
    </script>
</body>
</html>
