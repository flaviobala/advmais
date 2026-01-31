<x-admin-layout title="Novo Curso">
    <div class="mb-6">
        <a href="{{ route('admin.courses.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para lista de cursos
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Criar Novo Curso</h2>
        </div>

        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Coluna esquerda: Dados do curso --}}
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">T&iacute;tulo *</label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descri&ccedil;&atilde;o</label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Trilha</label>
                        <select id="category_id"
                                name="category_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Sem trilha</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="course_video" class="block text-sm font-medium text-gray-700 mb-1">V&iacute;deo de Abertura</label>
                        <input type="url"
                               id="course_video"
                               name="course_video"
                               value="{{ old('course_video') }}"
                               placeholder="https://www.youtube.com/watch?v=... ou https://vimeo.com/..."
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('course_video') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Cole o link do YouTube, Vimeo ou outra plataforma. Este v&iacute;deo ser&aacute; exibido como apresenta&ccedil;&atilde;o do curso.</p>
                        @error('course_video')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox"
                               id="is_active"
                               name="is_active"
                               value="1"
                               checked
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Curso ativo (vis&iacute;vel para os alunos)
                        </label>
                    </div>
                </div>

                {{-- Coluna direita: Imagem de Capa --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagem de Capa</label>
                    <div id="cover-upload-area" class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors cursor-pointer">
                        <div id="cover-placeholder" class="space-y-2">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-600">Clique para selecionar uma imagem</p>
                            <p class="text-xs text-gray-400">Formato horizontal 16:9 &bull; 1280 &times; 720 px &bull; PNG, JPG ou WebP</p>
                            <p class="text-xs text-gray-400">A imagem ser&aacute; ajustada automaticamente para o tamanho correto</p>
                        </div>
                        <div id="cover-preview" class="hidden">
                            <img id="cover-preview-img" src="" alt="Preview" class="mx-auto rounded-lg max-h-52 object-contain">
                            <button type="button" id="cover-remove-btn" class="mt-2 text-xs text-red-500 hover:text-red-700">Remover imagem</button>
                        </div>
                        <input type="file"
                               id="cover_image"
                               name="cover_image"
                               accept="image/png,image/jpeg,image/webp"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    {{-- Thumbnail retrato --}}
                    <label class="block text-sm font-medium text-gray-700 mb-1 mt-6">Thumbnail (p&aacute;gina do curso)</label>
                    <div id="thumb-upload-area" class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors cursor-pointer">
                        <div id="thumb-placeholder" class="space-y-2">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-600">Clique para selecionar</p>
                            <p class="text-xs text-gray-400">Formato retrato 4:5 &bull; 400 &times; 500 px &bull; PNG, JPG ou WebP</p>
                            <p class="text-xs text-gray-400">Ajustada automaticamente</p>
                        </div>
                        <div id="thumb-preview" class="hidden">
                            <img id="thumb-preview-img" src="" alt="Preview" class="mx-auto rounded-lg max-h-48 object-contain">
                            <button type="button" id="thumb-remove-btn" class="mt-2 text-xs text-red-500 hover:text-red-700">Remover</button>
                        </div>
                        <input type="file"
                               id="thumbnail"
                               name="thumbnail"
                               accept="image/png,image/jpeg,image/webp"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.courses.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Criar Curso
                </button>
            </div>
        </form>
    </div>

    {{-- Aviso sobre Aulas --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg shadow mt-6 p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-blue-800">Adicionar Aulas</h3>
                <p class="mt-1 text-sm text-blue-700">
                    Ap&oacute;s criar o curso, voc&ecirc; poder&aacute; adicionar aulas diretamente na p&aacute;gina de edi&ccedil;&atilde;o do curso.
                </p>
            </div>
        </div>
    </div>

    <script>
        const coverInput = document.getElementById('cover_image');
        const placeholder = document.getElementById('cover-placeholder');
        const preview = document.getElementById('cover-preview');
        const previewImg = document.getElementById('cover-preview-img');
        const removeBtn = document.getElementById('cover-remove-btn');

        coverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const canvas = document.createElement('canvas');
            canvas.width = 1280;
            canvas.height = 720;
            const ctx = canvas.getContext('2d');

            const img = new Image();
            img.onload = function() {
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, 1280, 720);

                const scale = Math.max(1280 / img.width, 720 / img.height);
                const w = img.width * scale;
                const h = img.height * scale;
                const x = (1280 - w) / 2;
                const y = (720 - h) / 2;

                ctx.drawImage(img, x, y, w, h);

                canvas.toBlob(function(blob) {
                    const resizedFile = new File([blob], 'cover.png', { type: 'image/png' });
                    const dt = new DataTransfer();
                    dt.items.add(resizedFile);
                    coverInput.files = dt.files;

                    previewImg.src = URL.createObjectURL(blob);
                    placeholder.classList.add('hidden');
                    preview.classList.remove('hidden');
                }, 'image/png', 0.9);
            };
            img.src = URL.createObjectURL(file);
        });

        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            coverInput.value = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        });

        // Thumbnail 400x500
        const thumbInput = document.getElementById('thumbnail');
        const thumbPlaceholder = document.getElementById('thumb-placeholder');
        const thumbPreview = document.getElementById('thumb-preview');
        const thumbPreviewImg = document.getElementById('thumb-preview-img');
        const thumbRemoveBtn = document.getElementById('thumb-remove-btn');

        thumbInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const canvas = document.createElement('canvas');
            canvas.width = 400;
            canvas.height = 500;
            const ctx = canvas.getContext('2d');

            const img = new Image();
            img.onload = function() {
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, 400, 500);

                const scale = Math.max(400 / img.width, 500 / img.height);
                const w = img.width * scale;
                const h = img.height * scale;
                const x = (400 - w) / 2;
                const y = (500 - h) / 2;

                ctx.drawImage(img, x, y, w, h);

                canvas.toBlob(function(blob) {
                    const resizedFile = new File([blob], 'thumbnail.png', { type: 'image/png' });
                    const dt = new DataTransfer();
                    dt.items.add(resizedFile);
                    thumbInput.files = dt.files;

                    thumbPreviewImg.src = URL.createObjectURL(blob);
                    thumbPlaceholder.classList.add('hidden');
                    thumbPreview.classList.remove('hidden');
                }, 'image/png', 0.9);
            };
            img.src = URL.createObjectURL(file);
        });

        thumbRemoveBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            thumbInput.value = '';
            thumbPreview.classList.add('hidden');
            thumbPlaceholder.classList.remove('hidden');
        });
    </script>
</x-admin-layout>
