<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMemberMail;
use App\Models\MemberOnboarding;
use App\Models\OnboardingSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
{
    public function index(Request $request)
    {
        $query = MemberOnboarding::with('user')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn ($q) => $q->where('name', 'ilike', "%$search%")
                ->orWhere('email', 'ilike', "%$search%"));
        }

        $onboardings = $query->paginate(20)->withQueryString();

        $counts = [
            'total'    => MemberOnboarding::count(),
            'pending'  => MemberOnboarding::where('status', 'pending')->count(),
            'received' => MemberOnboarding::where('status', 'received')->count(),
            'approved' => MemberOnboarding::where('status', 'approved')->count(),
        ];

        return view('admin.onboarding.index', compact('onboardings', 'counts'));
    }

    public function show(MemberOnboarding $onboarding)
    {
        $onboarding->load('user', 'approvedBy');
        return view('admin.onboarding.show', compact('onboarding'));
    }

    public function approve(MemberOnboarding $onboarding)
    {
        $onboarding->update([
            'status'      => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.onboarding.show', $onboarding)
            ->with('success', 'Membro aprovado com sucesso.');
    }

    public function resend(MemberOnboarding $onboarding)
    {
        $onboarding->load('user');

        Mail::to($onboarding->user->email)->send(
            new WelcomeMemberMail($onboarding->user, $onboarding)
        );

        $onboarding->update(['welcome_sent_at' => now()]);

        return redirect()->back()->with('success', 'Email reenviado com sucesso para ' . $onboarding->user->email);
    }

    public function settingsForm()
    {
        $settings = [
            'welcome_subject' => OnboardingSetting::get('welcome_subject'),
            'welcome_message' => OnboardingSetting::get('welcome_message'),
            'term_content'    => OnboardingSetting::get('term_content'),
            'pdf_title'       => OnboardingSetting::get('pdf_title', 'ADV+ CONECTA'),
            'pdf_subtitle'    => OnboardingSetting::get('pdf_subtitle', 'Comunidade de Profissionais do Direito'),
            'pdf_logo'        => OnboardingSetting::get('pdf_logo'),
        ];

        return view('admin.onboarding.settings', compact('settings'));
    }

    public function settingsSave(Request $request)
    {
        $request->validate([
            'welcome_subject' => 'required|string|max:255',
            'welcome_message' => 'required|string',
            'term_content'    => 'required|string',
            'pdf_title'       => 'nullable|string|max:100',
            'pdf_subtitle'    => 'nullable|string|max:150',
            'pdf_logo'        => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        OnboardingSetting::set('welcome_subject', $request->welcome_subject);
        OnboardingSetting::set('welcome_message', $request->welcome_message);
        OnboardingSetting::set('term_content', $request->term_content);
        OnboardingSetting::set('pdf_title', $request->pdf_title);
        OnboardingSetting::set('pdf_subtitle', $request->pdf_subtitle);

        if ($request->hasFile('pdf_logo')) {
            $path = $request->file('pdf_logo')->storeAs('onboarding', 'logo.' . $request->file('pdf_logo')->extension(), 'public');
            OnboardingSetting::set('pdf_logo', $path);
        }

        if ($request->boolean('pdf_logo_remove')) {
            OnboardingSetting::set('pdf_logo', null);
        }

        return redirect()->route('admin.onboarding.settings')
            ->with('success', 'Configurações salvas com sucesso.');
    }

    private function getPdfLogoBase64(): ?string
    {
        $logoPath = OnboardingSetting::get('pdf_logo');
        if ($logoPath) {
            $fullPath = Storage::disk('public')->path($logoPath);
            if (file_exists($fullPath)) {
                $mime = mime_content_type($fullPath);
                return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($fullPath));
            }
        }
        return null;
    }

    public function previewPdf(MemberOnboarding $onboarding)
    {
        $onboarding->load('user');
        $user = $onboarding->user;

        $replacements = [
            '{{nome}}'  => $user->name,
            '{{email}}' => $user->email,
            '{{data}}'  => now()->format('d/m/Y'),
        ];

        $termHtml = str_replace(
            array_keys($replacements),
            array_values($replacements),
            OnboardingSetting::get('term_content')
        );

        $pdfTitle    = OnboardingSetting::get('pdf_title', 'ADV+ CONECTA');
        $pdfSubtitle = OnboardingSetting::get('pdf_subtitle', 'Comunidade de Profissionais do Direito');
        $pdfLogoB64  = $this->getPdfLogoBase64();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.termo-adesao', compact('termHtml', 'user', 'pdfTitle', 'pdfSubtitle', 'pdfLogoB64'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Termo-de-Adesao-' . str($user->name)->slug() . '.pdf');
    }
}
