<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Subscription;
use App\Services\AsaasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct(private AsaasService $asaas) {}

    public function handle(Request $request)
    {
        if (!$this->asaas->validateWebhookToken($request)) {
            Log::warning('Asaas Webhook: token inválido', ['ip' => $request->ip()]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $event        = $request->input('event');
        $paymentData  = $request->input('payment');
        $subscription = $request->input('subscription');

        Log::info('Asaas Webhook recebido', ['event' => $event]);

        match ($event) {
            'PAYMENT_CONFIRMED', 'PAYMENT_RECEIVED' => $this->handlePaymentConfirmed($paymentData),
            'PAYMENT_OVERDUE'                        => $this->handlePaymentOverdue($paymentData),
            'PAYMENT_DELETED'                        => $this->handlePaymentDeleted($paymentData),
            'SUBSCRIPTION_INACTIVATED',
            'SUBSCRIPTION_CANCELLED',
            'SUBSCRIPTION_DELETED'                   => $this->handleSubscriptionCancelled($subscription),
            default => null,
        };

        return response()->json(['ok' => true]);
    }

    private function handlePaymentConfirmed(array $paymentData): void
    {
        $payment = Payment::where('asaas_payment_id', $paymentData['id'])->first();

        if ($payment) {
            $payment->update([
                'status'  => 'confirmed',
                'paid_at' => now(),
            ]);

            $payable = $payment->payable;
            $user    = $payment->user;

            if (!$payable || !$user) {
                return;
            }

            // Pagamento de curso avulso
            if ($payment->payable_type === \App\Models\Course::class) {
                $user->courses()->syncWithoutDetaching([$payable->id]);

            // Pagamento de aula avulsa
            } elseif ($payment->payable_type === Lesson::class) {
                $user->accessibleLessons()->syncWithoutDetaching([$payable->id]);

            // Pagamento do plano anual (payable = Subscription)
            } elseif ($payment->payable_type === Subscription::class) {
                $payable->update([
                    'status'     => 'active',
                    'expires_at' => now()->addYear(),
                ]);
            }

            Log::info('Asaas Webhook: acesso liberado', [
                'user_id'      => $user->id,
                'payable_type' => $payment->payable_type,
                'payable_id'   => $payment->payable_id,
            ]);

            return;
        }

        // Renovação anual (não tem Payment no banco — busca pela subscription)
        if (!empty($paymentData['subscription'])) {
            $subscription = Subscription::where('asaas_subscription_id', $paymentData['subscription'])->first();

            if ($subscription) {
                $subscription->update([
                    'status'     => 'active',
                    'expires_at' => now()->addYear(),
                ]);

                Log::info('Asaas Webhook: renovação de assinatura confirmada', [
                    'subscription_id' => $subscription->id,
                    'user_id'         => $subscription->user_id,
                ]);
            }
        }
    }

    private function handlePaymentOverdue(array $paymentData): void
    {
        $payment = Payment::where('asaas_payment_id', $paymentData['id'])->first();

        if ($payment) {
            $payment->update(['status' => 'overdue']);

            // Se for pagamento de assinatura, marca a assinatura como overdue
            if ($payment->payable_type === Subscription::class && $payment->payable) {
                $payment->payable->update(['status' => 'overdue']);
            }
        }
    }

    private function handlePaymentDeleted(array $paymentData): void
    {
        $payment = Payment::where('asaas_payment_id', $paymentData['id'])->first();

        if ($payment) {
            $payment->update(['status' => 'cancelled']);
        }
    }

    private function handleSubscriptionCancelled(?array $subscriptionData): void
    {
        if (!$subscriptionData) {
            return;
        }

        $subscription = Subscription::where('asaas_subscription_id', $subscriptionData['id'])->first();

        if (!$subscription) {
            Log::warning('Asaas Webhook: subscription não encontrada', ['asaas_id' => $subscriptionData['id']]);
            return;
        }

        $subscription->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);

        Log::info('Asaas Webhook: assinatura cancelada', [
            'subscription_id' => $subscription->id,
            'user_id'         => $subscription->user_id,
        ]);
    }
}
