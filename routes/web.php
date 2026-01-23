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

// Redireciona a raiz para o login
Route::get('/', function () {
    return redirect()->route('login');
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