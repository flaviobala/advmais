<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\TrilhaController;
use App\Http\Controllers\Web\AboutController;

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

// --- LOGADOS (AUTH) ---
Route::middleware('auth')->group(function () {

    // Dashboard (Agora usando o Controller correto)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Trilhas
    Route::get('/trilhas/{id}', [TrilhaController::class, 'show'])->name('trilhas.show');

    // ADV+CONECTA
    Route::get('/sobre', [AboutController::class, 'index'])->name('about');

    // Cursos
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{courseId}/lessons/{lessonId}', [CourseController::class, 'lesson'])->name('courses.lesson');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});