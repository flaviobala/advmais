<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Cadastro — ADV+ CONECTA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-start justify-center py-10 px-4">

<div class="w-full max-w-2xl">
    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-block bg-blue-700 text-white px-6 py-3 rounded-xl mb-3">
            <span class="text-xl font-bold tracking-widest">ADV+ CONECTA</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Complete seu cadastro de membro</h1>
        <p class="text-gray-500 mt-1">Olá, <strong>{{ $onboarding->user->name }}</strong>! Preencha os campos abaixo para concluir seu cadastro.</p>
    </div>

    {{-- Erros --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <p class="text-red-700 font-semibold text-sm mb-1">Corrija os erros abaixo:</p>
            <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('onboarding.submit', ['token' => $onboarding->token]) }}"
          method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
        @csrf

        {{-- Foto --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Foto profissional <span class="text-red-500">*</span>
            </label>
            <input type="file" name="photo" accept="image/png,image/jpeg"
                   class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg px-3 py-2 file:mr-4 file:py-1 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 file:font-medium hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-300">
            <p class="text-xs text-gray-400 mt-1">JPG ou PNG, máximo 4MB</p>
        </div>

        {{-- Mini currículo --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Mini currículo <span class="text-red-500">*</span>
            </label>
            <textarea name="mini_bio" rows="5"
                      placeholder="Apresentação profissional resumida: formação, especialidades, experiência relevante..."
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none">{{ old('mini_bio') }}</textarea>
            <p class="text-xs text-gray-400 mt-1">Mínimo 30 caracteres, máximo 1.000 caracteres</p>
        </div>

        {{-- OAB --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Número da OAB <span class="text-red-500">*</span>
            </label>
            <input type="text" name="oab_number" value="{{ old('oab_number') }}"
                   placeholder="Ex: 12345/AL"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>

        {{-- Termo assinado --}}
        <div class="border border-blue-100 bg-blue-50 rounded-xl p-5 space-y-4">
            <p class="text-sm font-semibold text-blue-800">Termo de Adesão</p>
            <p class="text-xs text-blue-700">
                Você recebeu o Termo de Adesão em PDF por email.
                Imprima, assine, digitalize e envie abaixo — <strong>ou</strong> aceite digitalmente marcando a opção.
            </p>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Enviar termo assinado (PDF)
                </label>
                <input type="file" name="signed_term" accept="application/pdf"
                       class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg px-3 py-2 file:mr-4 file:py-1 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 file:font-medium hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <p class="text-xs text-gray-400 mt-1">PDF, máximo 10MB</p>
            </div>

            <div class="flex items-start gap-3">
                <input type="checkbox" id="term_accept" name="term_accept" value="1"
                       class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-400">
                <label for="term_accept" class="text-sm text-gray-600">
                    Li e aceito os termos do <strong>Termo de Adesão ADV+ CONECTA</strong> digitalmente,
                    comprometendo-me a cumprir todas as obrigações nele descritas.
                </label>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-xl transition text-sm tracking-wide">
            Enviar documentos
        </button>
    </form>

    <p class="text-center text-xs text-gray-400 mt-6">
        Dúvidas? Fale conosco:
        <a href="https://wa.me/5582993678371" class="text-blue-600 underline">WhatsApp +55 82 99367-8371</a>
    </p>
</div>

</body>
</html>
