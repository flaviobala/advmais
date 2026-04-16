<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 13px;
            color: #1f2937;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .page { padding: 50px 60px; }
        .logo-area {
            text-align: center;
            border-bottom: 2px solid #1d4ed8;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .logo-area h1 {
            color: #1d4ed8;
            font-size: 22px;
            margin: 0;
            letter-spacing: 2px;
        }
        .logo-area p {
            color: #6b7280;
            font-size: 11px;
            margin: 4px 0 0;
        }
        h2, h3 { color: #1d4ed8; }
        h4 { color: #374151; margin: 16px 0 6px; }
        p { margin: 0 0 10px; }
        ul, ol { margin: 0 0 10px; padding-left: 20px; }
        li { margin-bottom: 4px; }
        .footer-stamp {
            margin-top: 40px;
            border-top: 1px solid #d1d5db;
            padding-top: 16px;
            font-size: 11px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="logo-area">
            @if (!empty($pdfLogoB64))
                <img src="{{ $pdfLogoB64 }}" alt="Logo" style="max-height:70px; max-width:280px; margin-bottom:6px;">
                @if (!empty($pdfSubtitle))
                    <p>{{ $pdfSubtitle }}</p>
                @endif
            @else
                <h1>{{ $pdfTitle }}</h1>
                @if (!empty($pdfSubtitle))
                    <p>{{ $pdfSubtitle }}</p>
                @endif
            @endif
        </div>

        {!! $termHtml !!}

        <div class="footer-stamp">
            Documento gerado automaticamente pela plataforma ADV+ CONECTA &mdash; {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
