<?php

namespace App\Http\Controllers;

use App\Models\MemberOnboarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
{
    public function form(string $token)
    {
        $onboarding = MemberOnboarding::with('user')
            ->where('token', $token)
            ->firstOrFail();

        if ($onboarding->status === 'approved') {
            return view('onboarding.already-approved', compact('onboarding'));
        }

        return view('onboarding.form', compact('onboarding'));
    }

    public function submit(Request $request, string $token)
    {
        $onboarding = MemberOnboarding::with('user')
            ->where('token', $token)
            ->firstOrFail();

        if ($onboarding->status === 'approved') {
            return redirect()->back()->with('info', 'Seu cadastro já foi aprovado.');
        }

        $request->validate([
            'photo'      => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'mini_bio'   => 'required|string|min:30|max:1000',
            'oab_number' => 'required|string|max:30',
            'signed_term'=> 'nullable|file|mimes:pdf|max:10240',
            'term_accept'=> 'nullable|accepted',
        ], [
            'photo.required'    => 'A foto é obrigatória.',
            'photo.image'       => 'O arquivo deve ser uma imagem.',
            'photo.max'         => 'A foto deve ter no máximo 4MB.',
            'mini_bio.required' => 'O mini currículo é obrigatório.',
            'mini_bio.min'      => 'O mini currículo deve ter ao menos 30 caracteres.',
            'oab_number.required' => 'O número da OAB é obrigatório.',
            'signed_term.mimes' => 'O termo deve ser enviado em PDF.',
            'signed_term.max'   => 'O PDF deve ter no máximo 10MB.',
        ]);

        if (!$request->hasFile('signed_term') && !$request->boolean('term_accept')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['signed_term' => 'Envie o termo assinado em PDF ou aceite digitalmente.']);
        }

        $dir  = 'onboarding/' . $onboarding->user_id;
        $data = [];

        // Foto
        $data['photo'] = $request->file('photo')->store($dir, 'public');

        // Mini currículo
        $data['mini_bio'] = $request->input('mini_bio');

        // OAB
        $data['oab_number'] = $request->input('oab_number');

        // Termo assinado
        if ($request->hasFile('signed_term')) {
            $data['signed_term'] = $request->file('signed_term')->store($dir, 'public');
        }

        if ($request->boolean('term_accept')) {
            $data['term_accepted_at'] = now();
        }

        $data['docs_submitted_at'] = now();
        $data['status']            = 'received';

        $onboarding->update($data);

        return redirect()->route('onboarding.success', ['token' => $token]);
    }

    public function success(string $token)
    {
        $onboarding = MemberOnboarding::with('user')
            ->where('token', $token)
            ->firstOrFail();

        return view('onboarding.success', compact('onboarding'));
    }
}
