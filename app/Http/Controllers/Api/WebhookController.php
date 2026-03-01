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

        $event   = $request->input('event');
        $payment = $request->input('payment');
        $subscription = $request->input('subscription');

        Log::info('Asaas Webhook recebido', ['event' => $event]);

        match ($event) {
            'PAYMENT_CONFIRMED', 'PAYMENT_RECEIVED' => $this->handlePaymentConfirmed($payment),
            'PAYMENT_OVERDUE'                        => $this->handlePaymentOverdue($payment),
            'PAYMENT_DELETED'                        => $this->handlePaymentDeleted($payment),
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

        if (!$payment) {
            Log::warning('Asaas Webhook: payment não encontrado', ['asaas_id' => $paymentData['id']]);
            return;
        }

        $payment->update([
            'status'  => 'confirmed',
            'paid_at' => now(),
        ]);

        // Liberar acesso conforme o tipo de recurso comprado
        $payable = $payment->payable;
        $user    = $payment->user;

        if (!$payable || !$user) {
            return;
        }

        if ($payment->payable_type === \App\Models\Course::class) {
            $user->courses()->syncWithoutDetaching([$payable->id]);
        } elseif ($payment->payable_type === Lesson::class) {
            $user->accessibleLessons()->syncWithoutDetaching([$payable->id]);
        }

        Log::info('Asaas Webhook: acesso liberado', [
            'user_id'      => $user->id,
            'payable_type' => $payment->payable_type,
            'payable_id'   => $payment->payable_id,
        ]);
    }

    private function handlePaymentOverdue(array $paymentData): void
    {
        $payment = Payment::where('asaas_payment_id', $paymentData['id'])->first();

        if ($payment) {
            $payment->update(['status' => 'overdue']);
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
            'category_id'     => $subscription->category_id,
        ]);
    }
}
