<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Voucher;
use App\Services\AsaasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestCheckoutController extends Controller
{
    public function __construct(private AsaasService $asaas) {}

    /**
     * Exibe o formulário público de criação de conta + checkout do plano anual.
     * Se o visitante já estiver logado, redireciona para o fluxo normal.
     */
    public function show()
    {
        if (auth()->check()) {
            return redirect()->route('subscription.show');
        }

        $price = (float) config('services.platform.annual_price');

        return view('checkout.guest', compact('price'));
    }

    /**
     * Processa o registro + assinatura em um único passo.
     */
    public function checkout(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('subscription.show');
        }

        $price = (float) config('services.platform.annual_price');

        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users,email',
            'password'              => 'required|string|min:6|confirmed',
            'cpf_cnpj'              => 'nullable|string|min:11|max:18',
            'billing_type'          => 'nullable|in:PIX,CREDIT_CARD,BOLETO',
            'voucher_code'          => 'nullable|string|max:50',
        ], [
            'name.required'         => 'Informe seu nome completo.',
            'email.required'        => 'Informe seu e-mail.',
            'email.email'           => 'E-mail inválido.',
            'email.unique'          => 'Este e-mail já está cadastrado. Faça login para assinar.',
            'password.required'     => 'Crie uma senha.',
            'password.min'          => 'A senha deve ter no mínimo 6 caracteres.',
            'password.confirmed'    => 'As senhas não conferem.',
        ]);

        // ─── Voucher ─────────────────────────────────────────────────────────────
        $amount  = $price;
        $voucher = null;

        if ($request->filled('voucher_code')) {
            $voucher = Voucher::where('code', strtoupper($request->voucher_code))->first();

            if (!$voucher || !$voucher->isValidFor('annual')) {
                return back()->withInput()
                    ->withErrors(['voucher_code' => 'Cupom inválido, expirado ou não aplicável ao plano anual.']);
            }

            $amount = $voucher->applyTo($amount);
        }

        // ─── Validações de pagamento (somente se não for gratuito) ───────────────
        if ($amount > 0) {
            if (!$request->filled('billing_type')) {
                return back()->withInput()
                    ->withErrors(['billing_type' => 'Selecione a forma de pagamento.']);
            }

            if (!$request->filled('cpf_cnpj')) {
                return back()->withInput()
                    ->withErrors(['cpf_cnpj' => 'Informe seu CPF ou CNPJ para emissão da cobrança.']);
            }
        }

        // ─── Cria a conta do usuário ─────────────────────────────────────────────
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password, // hashed pelo cast 'hashed'
            'role'      => 'membro',
            'is_active' => true,
        ]);

        // ─── Acesso gratuito (cupom 100%) ────────────────────────────────────────
        if ($amount <= 0) {
            Subscription::create([
                'user_id'               => $user->id,
                'category_id'           => null,
                'asaas_subscription_id' => 'FREE-' . strtoupper(uniqid()),
                'status'                => 'active',
                'amount'                => 0,
                'billing_type'          => 'PIX',
                'cycle'                 => 'YEARLY',
                'next_due_date'         => now()->addYear()->toDateString(),
                'expires_at'            => now()->addYear(),
            ]);

            $voucher?->incrementUsage();

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('dashboard')
                ->with('success', 'Conta criada e acesso liberado! Bem-vindo à comunidade ADV+ CONECTA.');
        }

        // ─── Fluxo pago via Asaas ─────────────────────────────────────────────────
        try {
            $asaasData = $this->asaas->createSubscription(
                $user,
                null,
                $request->billing_type,
                $request->cpf_cnpj,
                'YEARLY',
                $amount
            );

            $subscription = Subscription::create([
                'user_id'               => $user->id,
                'category_id'           => null,
                'asaas_subscription_id' => $asaasData['id'],
                'status'                => 'pending',
                'amount'                => $amount,
                'billing_type'          => $request->billing_type,
                'cycle'                 => 'YEARLY',
                'next_due_date'         => $asaasData['nextDueDate'] ?? now()->addYear()->toDateString(),
            ]);

            $voucher?->incrementUsage();

            $firstPayment = $this->asaas->getSubscriptionFirstPayment($asaasData['id']);

            $pixData = [];
            if ($request->billing_type === 'PIX' && $firstPayment) {
                $pixData = $this->asaas->getPixQrCode($firstPayment['id']);
            }

            $payment = Payment::create([
                'user_id'          => $user->id,
                'payable_type'     => Subscription::class,
                'payable_id'       => $subscription->id,
                'asaas_payment_id' => $firstPayment['id'] ?? null,
                'status'           => 'pending',
                'amount'           => $amount,
                'billing_type'     => $request->billing_type,
                'payment_url'      => $firstPayment['invoiceUrl'] ?? $firstPayment['bankSlipUrl'] ?? null,
                'pix_qr_code'      => $pixData['encodedImage'] ?? null,
                'pix_copy_paste'   => $pixData['payload'] ?? null,
                'due_date'         => now()->addDays(1)->toDateString(),
            ]);

            // Loga o usuário antes de mostrar a tela de pagamento
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('checkout.success', $payment);

        } catch (\Exception $e) {
            // Se o Asaas falhar após criar o usuário, remove a conta para evitar duplicatas
            $user->forceDelete();

            return back()->withInput()
                ->withErrors(['error' => 'Erro ao processar pagamento: ' . $e->getMessage()]);
        }
    }

    /**
     * Valida voucher via AJAX na página pública de checkout.
     */
    public function validateVoucher(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $voucher = Voucher::where('code', strtoupper($request->code))->first();

        if (!$voucher || !$voucher->isValidFor('annual')) {
            return response()->json(['valid' => false, 'message' => 'Cupom inválido ou expirado.']);
        }

        $base  = (float) config('services.platform.annual_price');
        $final = $voucher->applyTo($base);

        return response()->json([
            'valid'            => true,
            'discount_percent' => $voucher->discount_percent,
            'original'         => number_format($base, 2, ',', '.'),
            'final'            => number_format($final, 2, ',', '.'),
            'message'          => "Cupom aplicado! {$voucher->discount_percent}% de desconto.",
        ]);
    }
}
