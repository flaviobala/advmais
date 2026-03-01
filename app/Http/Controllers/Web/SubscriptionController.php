<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subscription;
use App\Services\AsaasService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(private AsaasService $asaas) {}

    public function show(Category $category)
    {
        if (!$category->price) {
            abort(404, 'Esta trilha não está disponível para assinatura.');
        }

        $user = auth()->user();

        $activeSubscription = $user->subscriptions()
            ->where('category_id', $category->id)
            ->where('status', 'active')
            ->first();

        return view('checkout.subscription', compact('category', 'activeSubscription'));
    }

    public function subscribe(Request $request, Category $category)
    {
        $user = auth()->user();

        $request->validate([
            'billing_type' => 'required|in:PIX,CREDIT_CARD,BOLETO',
            'cpf_cnpj'     => ($user->cpf_cnpj ? 'nullable' : 'required') . '|string|min:11',
        ]);

        if (!$category->price) {
            abort(404);
        }

        if ($user->hasActiveSubscription($category->id)) {
            return redirect()->route('subscription.show', $category)
                ->with('info', 'Você já possui uma assinatura ativa para esta trilha.');
        }

        try {
            $asaasData = $this->asaas->createSubscription($user, $category, $request->billing_type, $request->cpf_cnpj);

            Subscription::create([
                'user_id'               => $user->id,
                'category_id'           => $category->id,
                'asaas_subscription_id' => $asaasData['id'],
                'status'                => 'active',
                'amount'                => $category->price,
                'billing_type'          => $request->billing_type,
                'next_due_date'         => $asaasData['nextDueDate'] ?? now()->addMonth()->toDateString(),
            ]);

            return redirect()->route('dashboard')
                ->with('success', "Assinatura da trilha \"{$category->name}\" realizada com sucesso!");

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao criar assinatura: ' . $e->getMessage()]);
        }
    }

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
