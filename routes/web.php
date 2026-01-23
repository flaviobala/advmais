<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\CourseController;

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

    // Cursos
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});