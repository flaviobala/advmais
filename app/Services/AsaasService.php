<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasService
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.asaas.base_url');
        $this->apiKey  = config('services.asaas.key');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function http()
    {
        return Http::withHeaders([
            'access_token' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->baseUrl($this->baseUrl);
    }

    // ─── Clientes ─────────────────────────────────────────────────────────────

    /**
     * Cria um cliente no Asaas e retorna o asaas_customer_id.
     * Se o usuário já tiver asaas_customer_id, retorna ele direto.
     */
    public function getOrCreateCustomer(User $user): string
    {
        if ($user->asaas_customer_id) {
            return $user->asaas_customer_id;
        }

        $response = $this->http()->post('/customers', [
            'name'  => $user->name,
            'email' => $user->email,
        ]);

        if ($response->failed()) {
            Log::error('Asaas: falha ao criar cliente', [
                'user_id' => $user->id,
                'response' => $response->json(),
            ]);
            throw new \Exception('Falha ao criar cliente no Asaas: ' . $response->body());
        }

        $customerId = $response->json('id');

        $user->update(['asaas_customer_id' => $customerId]);

        return $customerId;
    }

    // ─── Cobranças Avulsas ────────────────────────────────────────────────────

    /**
     * Cria uma cobrança avulsa (curso ou aula).
     * Retorna o array completo da resposta do Asaas.
     */
    public function createPayment(User $user, float $amount, string $billingType, string $description): array
    {
        $customerId = $this->getOrCreateCustomer($user);

        $payload = [
            'customer'    => $customerId,
            'billingType' => $billingType,
            'value'       => $amount,
            'dueDate'     => now()->addDays(3)->format('Y-m-d'),
            'description' => $description,
        ];

        $response = $this->http()->post('/payments', $payload);

        if ($response->failed()) {
            Log::error('Asaas: falha ao criar cobrança', [
                'user_id'  => $user->id,
                'payload'  => $payload,
                'response' => $response->json(),
            ]);
            throw new \Exception('Falha ao criar cobrança no Asaas: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Busca dados de uma cobrança pelo ID do Asaas.
     */
    public function getPayment(string $asaasPaymentId): array
    {
        $response = $this->http()->get("/payments/{$asaasPaymentId}");

        if ($response->failed()) {
            throw new \Exception('Falha ao buscar cobrança no Asaas.');
        }

        return $response->json();
    }

    /**
     * Busca QR Code PIX de uma cobrança.
     */
    public function getPixQrCode(string $asaasPaymentId): array
    {
        $response = $this->http()->get("/payments/{$asaasPaymentId}/pixQrCode");

        if ($response->failed()) {
            return [];
        }

        return $response->json();
    }

    // ─── Assinaturas ──────────────────────────────────────────────────────────

    /**
     * Cria uma assinatura recorrente mensal para uma categoria.
     * Retorna o array completo da resposta do Asaas.
     */
    public function createSubscription(User $user, Category $category, string $billingType): array
    {
        $customerId = $this->getOrCreateCustomer($user);

        $payload = [
            'customer'    => $customerId,
            'billingType' => $billingType,
            'value'       => $category->price,
            'nextDueDate' => now()->addDays(1)->format('Y-m-d'),
            'cycle'       => 'MONTHLY',
            'description' => "Assinatura mensal - {$category->name}",
        ];

        $response = $this->http()->post('/subscriptions', $payload);

        if ($response->failed()) {
            Log::error('Asaas: falha ao criar assinatura', [
                'user_id'     => $user->id,
                'category_id' => $category->id,
                'response'    => $response->json(),
            ]);
            throw new \Exception('Falha ao criar assinatura no Asaas: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Cancela uma assinatura pelo ID do Asaas.
     */
    public function cancelSubscription(string $asaasSubscriptionId): void
    {
        $response = $this->http()->delete("/subscriptions/{$asaasSubscriptionId}");

        if ($response->failed()) {
            Log::error('Asaas: falha ao cancelar assinatura', [
                'asaas_subscription_id' => $asaasSubscriptionId,
                'response' => $response->json(),
            ]);
            throw new \Exception('Falha ao cancelar assinatura no Asaas.');
        }
    }

    // ─── Webhook ──────────────────────────────────────────────────────────────

    /**
     * Valida o token do webhook recebido no header.
     */
    public function validateWebhookToken(Request $request): bool
    {
        $expectedToken = config('services.asaas.webhook_token');

        if (empty($expectedToken)) {
            return true; // sem token configurado, aceita tudo (só em sandbox)
        }

        return $request->header('asaas-access-token') === $expectedToken;
    }
}
