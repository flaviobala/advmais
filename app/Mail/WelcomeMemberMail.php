<?php

namespace App\Mail;

use App\Models\MemberOnboarding;
use App\Models\OnboardingSetting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMemberMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $bodyHtml;
    public string $termHtml;

    public function __construct(
        public User $user,
        public MemberOnboarding $onboarding
    ) {
        $formLink = route('onboarding.form', ['token' => $onboarding->token]);
        $data     = now()->format('d/m/Y');

        $replacements = [
            '{{nome}}'            => $user->name,
            '{{email}}'           => $user->email,
            '{{data}}'            => $data,
            '{{link_formulario}}' => $formLink,
        ];

        $this->bodyHtml = str_replace(
            array_keys($replacements),
            array_values($replacements),
            OnboardingSetting::get('welcome_message')
        );

        $this->termHtml = str_replace(
            array_keys($replacements),
            array_values($replacements),
            OnboardingSetting::get('term_content')
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: OnboardingSetting::get('welcome_subject', 'Bem-vindo(a) à ADV+ CONECTA!'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome-member',
        );
    }

    public function attachments(): array
    {
        $pdfTitle    = OnboardingSetting::get('pdf_title', 'ADV+ CONECTA');
        $pdfSubtitle = OnboardingSetting::get('pdf_subtitle', 'Comunidade de Profissionais do Direito');
        $pdfLogoB64  = null;
        $logoPath    = OnboardingSetting::get('pdf_logo');
        if ($logoPath) {
            $fullPath = \Illuminate\Support\Facades\Storage::disk('public')->path($logoPath);
            if (file_exists($fullPath)) {
                $mime       = mime_content_type($fullPath);
                $pdfLogoB64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($fullPath));
            }
        }

        $pdf = Pdf::loadView('pdf.termo-adesao', [
            'termHtml'    => $this->termHtml,
            'user'        => $this->user,
            'pdfTitle'    => $pdfTitle,
            'pdfSubtitle' => $pdfSubtitle,
            'pdfLogoB64'  => $pdfLogoB64,
        ])->setPaper('a4', 'portrait');

        return [
            Attachment::fromData(fn () => $pdf->output(), 'Termo-de-Adesao-ADV-CONECTA.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
