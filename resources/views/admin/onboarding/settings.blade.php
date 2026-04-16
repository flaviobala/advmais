<x-admin-layout title="Configurações de Integração">

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.onboarding.index') }}"
               class="text-sm text-blue-600 hover:underline flex items-center gap-1 mb-1">
                ← Voltar à lista
            </a>
            <h2 class="text-xl font-bold text-gray-800">Configurações de Integração</h2>
            <p class="text-sm text-gray-500 mt-1">Edite o email de boas-vindas e o Termo de Adesão</p>
        </div>
    </div>

    {{-- Variáveis disponíveis --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl px-5 py-4 mb-6 text-sm text-blue-800">
        <strong>Variáveis que você pode usar nos textos:</strong>
        <span class="ml-2 font-mono text-xs bg-white border border-blue-200 px-2 py-0.5 rounded cursor-pointer hover:bg-blue-100"
              onclick="copiarVariavel('@{{nome}}')" title="Clique para copiar">@{{nome}}</span>
        <span class="ml-1 font-mono text-xs bg-white border border-blue-200 px-2 py-0.5 rounded cursor-pointer hover:bg-blue-100"
              onclick="copiarVariavel('@{{email}}')" title="Clique para copiar">@{{email}}</span>
        <span class="ml-1 font-mono text-xs bg-white border border-blue-200 px-2 py-0.5 rounded cursor-pointer hover:bg-blue-100"
              onclick="copiarVariavel('@{{data}}')" title="Clique para copiar">@{{data}}</span>
        <span class="ml-1 font-mono text-xs bg-white border border-blue-200 px-2 py-0.5 rounded cursor-pointer hover:bg-blue-100"
              onclick="copiarVariavel('@{{link_formulario}}')" title="Clique para copiar">@{{link_formulario}}</span>
        <span class="ml-2 text-blue-500 text-xs">(clique na variável para copiar)</span>
    </div>

    <form method="POST" action="{{ route('admin.onboarding.settings.save') }}"
          id="settings-form" class="space-y-6" enctype="multipart/form-data">
        @csrf

        {{-- Cabeçalho do PDF --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Cabeçalho do PDF (Termo de Adesão)
            </label>
            <p class="text-xs text-gray-400 mb-4">Aparece no topo do PDF. Se enviar um logo, ele substitui o título.</p>

            {{-- Logo --}}
            <div class="mb-5">
                <label class="block text-xs font-medium text-gray-600 mb-2">Logo (PNG ou JPG, máx. 2MB)</label>
                @if (!empty($settings['pdf_logo']))
                    <div class="flex items-center gap-4 mb-3">
                        <img src="{{ Storage::url($settings['pdf_logo']) }}"
                             alt="Logo atual" class="h-14 object-contain border border-gray-200 rounded-lg p-1">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Logo atual</p>
                            <label class="flex items-center gap-2 text-xs text-red-600 cursor-pointer">
                                <input type="checkbox" name="pdf_logo_remove" value="1" class="w-3.5 h-3.5">
                                Remover logo
                            </label>
                        </div>
                    </div>
                @endif
                <input type="file" name="pdf_logo" accept="image/png,image/jpeg"
                       class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg px-3 py-2
                              file:mr-4 file:py-1 file:px-4 file:rounded-md file:border-0
                              file:bg-blue-50 file:text-blue-700 file:font-medium hover:file:bg-blue-100">
                @error('pdf_logo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Título — usado se não houver logo
                    </label>
                    <input type="text" name="pdf_title"
                           value="{{ old('pdf_title', $settings['pdf_title']) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    @error('pdf_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
                    <input type="text" name="pdf_subtitle"
                           value="{{ old('pdf_subtitle', $settings['pdf_subtitle']) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    @error('pdf_subtitle')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Assunto do email --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Assunto do email
            </label>
            <input type="text" name="welcome_subject"
                   value="{{ old('welcome_subject', $settings['welcome_subject']) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            @error('welcome_subject')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Corpo do email --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Corpo do email
            </label>
            <p class="text-xs text-gray-400 mb-3">
                Use as variáveis acima para personalizar. O botão com link para o formulário
                é inserido automaticamente via <code class="bg-gray-100 px-1 rounded">@{{link_formulario}}</code>.
            </p>
            <textarea name="welcome_message" id="welcome_message">{{ old('welcome_message', $settings['welcome_message']) }}</textarea>
            @error('welcome_message')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Termo de adesão --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Termo de Adesão
            </label>
            <p class="text-xs text-gray-400 mb-3">
                Este conteúdo é convertido em PDF e enviado em anexo no email.
                Edite aqui sempre que mudar a promoção ou as condições do plano.
            </p>
            <textarea name="term_content" id="term_content">{{ old('term_content', $settings['term_content']) }}</textarea>
            @error('term_content')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 pb-6">
            <a href="{{ route('admin.onboarding.index') }}"
               class="border border-gray-300 text-gray-700 text-sm px-5 py-2 rounded-lg hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit" id="btn-salvar"
                    class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold px-6 py-2 rounded-lg transition">
                Salvar configurações
            </button>
        </div>
    </form>

    {{-- CKEditor 4 via CDN --}}
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        // Desativa o aviso de versão desatualizada
        window.CKEDITOR_BASEPATH = 'https://cdn.ckeditor.com/4.22.1/full/';

        const editorConfig = {
            versionCheck: false,
            language: 'pt-br',
            height: 380,
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat'] },
                { name: 'paragraph',   items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                { name: 'styles',      items: ['Format'] },
                { name: 'links',       items: ['Link', 'Unlink'] },
                { name: 'insert',      items: ['Table', 'HorizontalRule', 'SpecialChar'] },
                { name: 'colors',      items: ['TextColor', 'BGColor'] },
                { name: 'clipboard',   items: ['Undo', 'Redo'] },
                { name: 'tools',       items: ['Source'] },
            ],
            removePlugins: 'elementspath',
            resize_enabled: true,
            allowedContent: true,
        };

        CKEDITOR.replace('welcome_message', editorConfig);
        CKEDITOR.replace('term_content', { ...editorConfig, height: 480 });

        // Antes de submeter, sincroniza o conteúdo dos editores nos textareas
        document.getElementById('settings-form').addEventListener('submit', function () {
            for (const name in CKEDITOR.instances) {
                CKEDITOR.instances[name].updateElement();
            }
        });

        // Copiar variável para área de transferência
        function copiarVariavel(texto) {
            navigator.clipboard.writeText(texto).then(() => {
                alert('Copiado: ' + texto + '\n\nAgora é só colar no editor (Ctrl+V).');
            });
        }
    </script>

</x-admin-layout>
