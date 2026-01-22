<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login (Cria a sessão via Cookie HttpOnly)
     */
    public function login(Request $request): JsonResponse
    {
        // 1. Valida email e senha
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Tenta autenticar
        if (Auth::attempt($credentials)) {
            // 3. Segurança: Regenera ID da sessão (evita roubo de sessão)
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login realizado com sucesso',
                'user' => Auth::user(),
            ]);
        }

        // 4. Se falhar, retorna erro 422
        throw ValidationException::withMessages([
            'email' => ['As credenciais fornecidas estão incorretas.'],
        ]);
    }

    /**
     * Logout (Destrói a sessão)
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout realizado']);
    }

    /**
     * Me (Retorna usuário logado)
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}