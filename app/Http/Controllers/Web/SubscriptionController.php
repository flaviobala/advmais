<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Voucher;
use App\Services\AsaasService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(private AsaasService $asaas) {}

    /**
     * Exibe a página do plano anual da plataforma.
     */
    public function show()
    {
        $user  = auth()->user();
        $price = (float) config('services.platform.annual_price');

        $activeSubscription = $user->subscriptions()
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        return view('checkout.subscription', compact('activeSubscription', 'price'));
    }

    /**
     * Processa a assinatura do plano anual da plataforma.
     */
    public function subscribe(Request $request)
    {
        $user  = auth()->user();
        $price = (float) config('services.platform.annual_price');

        $request->validate([
            'billing_type' => 'nullable|in:PIX,CREDIT_CARD,BOLETO',
            'cpf_cnpj'     => ($user->cpf_cnpj ? 'nullable' : 'nullable') . '|string|min:11',
            'voucher_code' => 'nullable|string|max:50',
        ]);

        if ($user->hasActiveSubscription()) {
            return redirect()->route('subscription.show')
                ->with('info', 'Você já possui uma assinatura ativa.');
        }

        $amount = $price;

        // Validar e aplicar voucher
        $voucher = null;
        if ($request->filled('voucher_code')) {
            $voucher = Voucher::where('code', strtoupper($request->voucher_code))->first();

            if (!$voucher || !$voucher->isValidFor('annual')) {
                return back()
                    ->withInput()
                    ->withErrors(['voucher_code' => 'Cupom inválido, expirado ou não aplicável ao plano anual.']);
            }

            $amount = $voucher->applyTo($amount);
        }

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

            return redirect()->route('dashboard')
                ->with('success', 'Acesso liberado! Seu plano anual está ativo até ' . now()->addYear()->format('d/m/Y') . '.');
        }

        // ─── Fluxo pago via Asaas ─────────────────────────────────────────────
        if (!$request->filled('billing_type')) {
            return back()->withInput()->withErrors(['billing_type' => 'Selecione a forma de pagamento.']);
        }

        if (!$user->cpf_cnpj && !$request->filled('cpf_cnpj')) {
            return back()->withInput()->withErrors(['cpf_cnpj' => 'Informe seu CPF ou CNPJ.']);
        }

        try {
            // Cria assinatura YEARLY no Asaas
            $asaasData = $this->asaas->createSubscription(
                $user,
                null,
                $request->billing_type,
                $request->cpf_cnpj,
                'YEARLY',
                $amount
            );

            // Salva como pendente — só ativa via webhook ao confirmar pagamento
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

            // Busca o primeiro pagamento gerado
            $firstPayment = $this->asaas->getSubscriptionFirstPayment($asaasData['id']);

            $pixData = [];
            if ($request->billing_type === 'PIX' && $firstPayment) {
                $pixData = $this->asaas->getPixQrCode($firstPayment['id']);
            }

            // Cria Payment com payable = Subscription (para tela de checkout)
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

            return redirect()->route('checkout.success', $payment);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao criar assinatura: ' . $e->getMessage()]);
        }
    }

    /**
     * Valida um voucher via AJAX e retorna o valor com desconto.
     */
    public function validateVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

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

    /**
     * Cancela a assinatura do usuário.
     */
    public function cancel(Subscription $subscription)
    {
        if ($subscription->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $this->asaas->cancelSubscription($subscription->asaas_subscription_id);

            $subscription->update([
                'status'       => 'cancelled',
                'cancelled_at' => now(),
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Assinatura cancelada com sucesso.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao cancelar assinatura: ' . $e->getMessage()]);
        }
    }
}
