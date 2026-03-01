<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Payment;
use App\Services\AsaasService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private AsaasService $asaas) {}

    // ─── Checkout de Curso ────────────────────────────────────────────────────

    public function showCourseCheckout(Course $course)
    {
        if (!$course->price) {
            abort(404, 'Este curso não está disponível para compra avulsa.');
        }

        if (auth()->user()->hasAccessToCourse($course->id)) {
            return redirect()->route('courses.show', $course)->with('info', 'Você já tem acesso a este curso.');
        }

        return view('checkout.course', compact('course'));
    }

    public function processCoursePayment(Request $request, Course $course)
    {
        $request->validate([
            'billing_type' => 'required|in:PIX,CREDIT_CARD,BOLETO',
        ]);

        if (!$course->price) {
            abort(404);
        }

        $user = auth()->user();

        if ($user->hasAccessToCourse($course->id)) {
            return redirect()->route('courses.show', $course)->with('info', 'Você já tem acesso.');
        }

        try {
            $asaasData = $this->asaas->createPayment(
                $user,
                (float) $course->price,
                $request->billing_type,
                "Acesso ao curso: {$course->title}"
            );

            $pixData = [];
            if ($request->billing_type === 'PIX') {
                $pixData = $this->asaas->getPixQrCode($asaasData['id']);
            }

            $payment = Payment::create([
                'user_id'          => $user->id,
                'payable_type'     => Course::class,
                'payable_id'       => $course->id,
                'asaas_payment_id' => $asaasData['id'],
                'status'           => 'pending',
                'amount'           => $course->price,
                'billing_type'     => $request->billing_type,
                'payment_url'      => $asaasData['invoiceUrl'] ?? $asaasData['bankSlipUrl'] ?? null,
                'pix_qr_code'      => $pixData['encodedImage'] ?? null,
                'pix_copy_paste'   => $pixData['payload'] ?? null,
                'due_date'         => now()->addDays(3)->toDateString(),
            ]);

            return redirect()->route('checkout.success', $payment);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao processar pagamento: ' . $e->getMessage()]);
        }
    }

    // ─── Checkout de Aula ─────────────────────────────────────────────────────

    public function showLessonCheckout(Lesson $lesson)
    {
        if (!$lesson->price) {
            abort(404, 'Esta aula não está disponível para compra avulsa.');
        }

        if (auth()->user()->hasAccessToLesson($lesson->id)) {
            return redirect()->route('courses.lesson', [$lesson->course_id, $lesson->id])
                ->with('info', 'Você já tem acesso a esta aula.');
        }

        return view('checkout.lesson', compact('lesson'));
    }

    public function processLessonPayment(Request $request, Lesson $lesson)
    {
        $request->validate([
            'billing_type' => 'required|in:PIX,CREDIT_CARD,BOLETO',
        ]);

        if (!$lesson->price) {
            abort(404);
        }

        $user = auth()->user();

        if ($user->hasAccessToLesson($lesson->id)) {
            return redirect()->route('courses.lesson', [$lesson->course_id, $lesson->id])
                ->with('info', 'Você já tem acesso.');
        }

        try {
            $asaasData = $this->asaas->createPayment(
                $user,
                (float) $lesson->price,
                $request->billing_type,
                "Acesso à aula: {$lesson->title}"
            );

            $pixData = [];
            if ($request->billing_type === 'PIX') {
                $pixData = $this->asaas->getPixQrCode($asaasData['id']);
            }

            $payment = Payment::create([
                'user_id'          => $user->id,
                'payable_type'     => Lesson::class,
                'payable_id'       => $lesson->id,
                'asaas_payment_id' => $asaasData['id'],
                'status'           => 'pending',
                'amount'           => $lesson->price,
                'billing_type'     => $request->billing_type,
                'payment_url'      => $asaasData['invoiceUrl'] ?? $asaasData['bankSlipUrl'] ?? null,
                'pix_qr_code'      => $pixData['encodedImage'] ?? null,
                'pix_copy_paste'   => $pixData['payload'] ?? null,
                'due_date'         => now()->addDays(3)->toDateString(),
            ]);

            return redirect()->route('checkout.success', $payment);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao processar pagamento: ' . $e->getMessage()]);
        }
    }

    // ─── Sucesso ──────────────────────────────────────────────────────────────

    public function success(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('payment'));
    }
}
