<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo(a) à ADV+ CONECTA</title>
    <style>
        body { margin: 0; padding: 0; background: #f3f4f6; font-family: Arial, sans-serif; color: #1f2937; }
        .wrapper { max-width: 620px; margin: 32px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #1d4ed8; padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; letter-spacing: 1px; }
        .header p { color: #bfdbfe; margin: 6px 0 0; font-size: 14px; }
        .body { padding: 36px 40px; font-size: 15px; line-height: 1.7; color: #374151; }
        .body p { margin: 0 0 14px; }
        .body ol, .body ul { margin: 0 0 14px; padding-left: 20px; }
        .body li { margin-bottom: 6px; }
        .btn-wrap { text-align: center; margin: 28px 0; }
        .btn { background: #1d4ed8; color: #ffffff !important; padding: 14px 32px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 16px; display: inline-block; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 24px 0; }
        .footer { background: #f9fafb; padding: 20px 40px; text-align: center; font-size: 12px; color: #9ca3af; }
        .footer a { color: #6b7280; }
        strong { color: #1f2937; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>ADV+ CONECTA</h1>
            <p>Comunidade de Profissionais do Direito</p>
        </div>

        <div class="body">
            {!! $bodyHtml !!}

            <hr class="divider">
            <p style="font-size:13px;color:#6b7280;">
                O <strong>Termo de Adesão</strong> está em anexo neste email (PDF).
                Leia com atenção, assine e envie de volta pelo formulário acima.
            </p>
        </div>

        <div class="footer">
            <p>ADV+ CONECTA &mdash; adv+conecta@advconecta.com.br</p>
            <p>
                <a href="https://wa.me/5582993678371">WhatsApp: +55 82 99367-8371</a>
            </p>
            <p style="margin-top:10px;font-size:11px;">
                Você recebeu este email porque efetuou uma assinatura na plataforma ADV+ CONECTA.
            </p>
        </div>
    </div>
</body>
</html>
