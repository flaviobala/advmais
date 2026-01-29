<x-admin-layout title="Nova Aula">
    <div class="mb-6">
        <a href="{{ route('admin.courses.edit', $course) }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para {{ $course->title }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Nova Aula para: {{ $course->title }}</h2>
        </div>

        <form action="{{ route('admin.courses.lessons.store', $course) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título da Aula *</label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') }}"
                       required
                       placeholder="Ex: Aula 01 - Introdução"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="video_provider" class="block text-sm font-medium text-gray-700 mb-1">Provedor de Vídeo *</label>
                    <select id="video_provider"
                            name="video_provider"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('video_provider') border-red-500 @enderror">
                        @foreach($providers as $provider)
                            <option value="{{ $provider->value }}" {{ old('video_provider') === $provider->value ? 'selected' : '' }}>
                                {{ strtoupper($provider->value) }}
                            </option>
                        @endforeach
                    </select>
                    @error('video_provider')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="video_ref_id" class="block text-sm font-medium text-gray-700 mb-1">ID do Vídeo *</label>
                    <input type="text"
                           id="video_ref_id"
                           name="video_ref_id"
                           value="{{ old('video_ref_id') }}"
                           required
                           placeholder="Ex: dQw4w9WgXcQ (YouTube) ou 76979871 (Vimeo)"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('video_ref_id') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">ID do vídeo na plataforma escolhida.</p>
                    @error('video_ref_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="attachments" class="block text-sm font-medium text-gray-700 mb-1">Arquivos Complementares (opcional)</label>
                <input type="file"
                       id="attachments"
                       name="attachments[]"
                       multiple
                       accept="video/*,audio/*,application/pdf,application/zip,application/x-rar-compressed,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,image/*"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('attachments') border-red-500 @enderror @error('attachments.*') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">PDF, DOCX, XLSX, PPTX, ZIP, MP4, MP3, imagens. Máximo 200MB por arquivo. Você pode selecionar múltiplos arquivos.</p>
                @error('attachments')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('attachments.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                {{-- Preview dos arquivos selecionados --}}
                <div id="files-preview" class="mt-3 space-y-2 hidden">
                    <p class="text-sm font-medium text-gray-700">Arquivos selecionados:</p>
                    <ul id="files-list" class="text-sm text-gray-600 space-y-1"></ul>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Ordem *</label>
                    <input type="number"
                           id="order"
                           name="order"
                           value="{{ old('order', $nextOrder) }}"
                           required
                           min="0"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('order') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Ordem de exibição da aula no curso.</p>
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration_seconds" class="block text-sm font-medium text-gray-700 mb-1">Duração (segundos)</label>
                    <input type="number"
                           id="duration_seconds"
                           name="duration_seconds"
                           value="{{ old('duration_seconds') }}"
                           min="0"
                           placeholder="Ex: 600 (para 10 minutos)"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('duration_seconds') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Opcional. Duração do vídeo em segundos.</p>
                    @error('duration_seconds')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.courses.edit', $course) }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Criar Aula
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('attachments').addEventListener('change', function(e) {
            const filesList = document.getElementById('files-list');
            const preview = document.getElementById('files-preview');
            filesList.innerHTML = '';
            
            if (this.files.length > 0) {
                preview.classList.remove('hidden');
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    const size = (file.size / 1024 / 1024).toFixed(2);
                    const li = document.createElement('li');
                    li.className = 'flex items-center gap-2 text-gray-600';
                    li.innerHTML = `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12a2 2 0 002-2V6l-4-4H4a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> ${file.name} <span class="text-gray-400">(${size} MB)</span>`;
                    filesList.appendChild(li);
                }
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
</x-admin-layout>
