<x-admin-layout title="Nova Trilha">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para lista de trilhas
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Criar Nova Trilha</h2>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descri&ccedil;&atilde;o</label>
                <textarea id="description"
                          name="description"
                          rows="3"
                          maxlength="500"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                <div class="flex justify-between mt-1">
                    @error('description')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @else
                        <span></span>
                    @enderror
                    <span class="text-xs text-gray-400" id="desc-counter">0 / 500</span>
                </div>
            </div>

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
                        <img id="cover-preview-img" src="" alt="Preview" class="mx-auto rounded-lg max-h-48 object-contain">
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
            </div>

            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Ordem de exibi&ccedil;&atilde;o</label>
                <input type="number"
                       id="order"
                       name="order"
                       value="{{ old('order', 0) }}"
                       min="0"
                       class="w-32 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-sm text-gray-500">Quanto menor o n&uacute;mero, mais acima aparece.</p>
            </div>

            <div class="flex items-center">
                <input type="checkbox"
                       id="is_active"
                       name="is_active"
                       value="1"
                       checked
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                    Trilha ativa (vis&iacute;vel no site)
                </label>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.categories.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Criar Trilha
                </button>
            </div>
        </form>
    </div>

    <script>
        // Contador de caracteres da descrição
        const descField = document.getElementById('description');
        const descCounter = document.getElementById('desc-counter');
        function updateCounter() {
            descCounter.textContent = descField.value.length + ' / 500';
        }
        descField.addEventListener('input', updateCounter);
        updateCounter();

        // Preview e redimensionamento da imagem
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
                // Preencher com fundo branco
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, 1280, 720);

                // Calcular proporção para cover (preencher todo o canvas)
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
    </script>
</x-admin-layout>
