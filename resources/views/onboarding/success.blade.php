<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos enviados — ADV+ CONECTA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
<div class="text-center max-w-md">
    <div class="inline-block bg-blue-700 text-white px-6 py-3 rounded-xl mb-6">
        <span class="text-xl font-bold tracking-widest">ADV+ CONECTA</span>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10">
        <div class="text-green-500 text-6xl mb-4">✓</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Documentos enviados!</h1>
        <p class="text-gray-500 text-sm mb-6">
            Obrigado, <strong>{{ $onboarding->user->name }}</strong>!<br>
            Recebemos seus documentos. Nossa equipe irá analisá-los e você será notificado(a) em breve.
        </p>
        <p class="text-xs text-gray-400">
            Dúvidas?
            <a href="https://wa.me/5582993678371" class="text-blue-600 underline">Fale conosco no WhatsApp</a>
        </p>
    </div>
</div>
</body>
</html>
