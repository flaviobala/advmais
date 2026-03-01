<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\TrilhaController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\SubscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página inicial institucional
Route::get('/', function () {
    // Se já estiver logado, vai direto para o dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    // Senão, mostra a tela institucional de entrada
    return view('welcome');
});

// --- VISITANTES (GUEST) ---
Route::middleware('guest')->group(function () {
    // Exibe o formulário (GET)
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // Processa o login (POST)
    Route::post('/login', [LoginController::class, 'login']);
});

// --- PÚBLICO ---
Route::get('/sobre', [AboutController::class, 'index'])->name('about');

// --- LOGADOS (AUTH) ---
Route::middleware('auth')->group(function () {

    // Dashboard (Agora usando o Controller correto)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Trilhas
    Route::get('/trilhas/{id}', [TrilhaController::class, 'show'])->name('trilhas.show');

    // Cursos
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{courseId}/lessons/{lessonId}', [CourseController::class, 'lesson'])->name('courses.lesson');

    // Checkout avulso (cursos e aulas)
    Route::get('/checkout/curso/{course}', [PaymentController::class, 'showCourseCheckout'])->name('checkout.course');
    Route::post('/checkout/curso/{course}', [PaymentController::class, 'processCoursePayment'])->name('checkout.course.process');
    Route::get('/checkout/aula/{lesson}', [PaymentController::class, 'showLessonCheckout'])->name('checkout.lesson');
    Route::post('/checkout/aula/{lesson}', [PaymentController::class, 'processLessonPayment'])->name('checkout.lesson.process');
    Route::get('/checkout/sucesso/{payment}', [PaymentController::class, 'success'])->name('checkout.success');

    // Plano Anual da Plataforma
    Route::get('/assinar', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::post('/assinar', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
    Route::post('/assinar/validar-voucher', [SubscriptionController::class, 'validateVoucher'])->name('subscription.validate-voucher');
    Route::post('/cancelar-assinatura/{subscription}', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});