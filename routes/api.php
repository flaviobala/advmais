<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;       // Import do Controller de Auth (Novo)
use App\Http\Controllers\Api\CourseController; // Import do Controller de Cursos (Existente)

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ========================================================================
// 1. ROTAS PÚBLICAS (Não exigem login)
// ========================================================================

// Login (Cria a sessão/cookie)
Route::post('/login', [AuthController::class, 'login']);

// ========================================================================
// 2. ROTAS PROTEGIDAS (Exigem login via Sanctum)
// ========================================================================

Route::middleware(['auth:sanctum'])->group(function () {

    // --- Autenticação / Usuário ---
    
    // Retorna os dados do usuário logado
    // (Substituí a rota /user antiga por esta que usa o Controller padronizado)
    Route::get('/me', [AuthController::class, 'me']);
    
    // Logout (Encerra a sessão)
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- LMS / Cursos (Suas rotas originais) ---
    
    Route::get('/courses', [CourseController::class, 'index']); // Lista cursos
    Route::get('/courses/{id}', [CourseController::class, 'show']); // Detalhes e Aulas

});