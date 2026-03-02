<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * Exibe o formulário de "esqueci minha senha".
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envia o e-mail com o link de redefinição.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Informe seu e-mail.',
            'email.email'    => 'E-mail inválido.',
        ]);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro ao enviar e-mail de reset: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Não foi possível enviar o e-mail. Tente novamente em instantes ou entre em contato com o suporte.']);
        }

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'E-mail enviado! Verifique sua caixa de entrada para redefinir a senha.');
        }

        return back()
            ->withInput()
            ->withErrors(['email' => __($status)]);
    }

    /**
     * Exibe o formulário de redefinição de senha (via link do e-mail).
     */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Processa a nova senha e loga o usuário.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|string|min:6|confirmed',
        ], [
            'password.required'  => 'Informe a nova senha.',
            'password.min'       => 'A senha deve ter no mínimo 6 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Senha redefinida com sucesso! Faça login com sua nova senha.');
        }

        return back()
            ->withInput()
            ->withErrors(['email' => __($status)]);
    }
}
