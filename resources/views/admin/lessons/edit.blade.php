<x-admin-layout title="Editar Aula">
    <div class="mb-6">
        <a href="{{ route('admin.courses.edit', $lesson->course_id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para {{ $lesson->course->title }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Editar Aula: {{ $lesson->title }}</h2>
        </div>

        <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título da Aula *</label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title', $lesson->title) }}"
                       required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Anexos Existentes --}}
            @if($lesson->attachments->count() > 0)
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-900 mb-3">Arquivos Anexados ({{ $lesson->attachments->count() }})</h3>
                <div class="space-y-2">
                    @foreach($lesson->attachments as $attachment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                {!! $attachment->icon !!}
                                <div>
                                    <a href="{{ $attachment->url }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                        {{ $attachment->filename }}
                                    </a>
                                    <p class="text-xs text-gray-500">{{ $attachment->formatted_size }} • {{ strtoupper($attachment->filetype) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ $attachment->url }}" download class="text-green-600 hover:text-green-800 text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.lessons.attachments.destroy', $attachment) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este anexo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Adicionar Novos Anexos --}}
            <div>
                <label for="attachments" class="block text-sm font-medium text-gray-700 mb-1">Adicionar Novos Arquivos</label>
                <input type="file"
                       id="attachments"
                       name="attachments[]"
                       multiple
                       accept="video/*,audio/*,application/pdf,application/zip,application/x-rar-compressed,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,image/*"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">PDF, DOCX, XLSX, PPTX, ZIP, MP4, MP3, imagens. Máximo 200MB por arquivo.</p>
                
                <div id="files-preview" class="mt-3 space-y-2 hidden">
                    <p class="text-sm font-medium text-gray-700">Arquivos selecionados:</p>
                    <ul id="files-list" class="text-sm text-gray-600 space-y-1"></ul>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="video_provider" class="block text-sm font-medium text-gray-700 mb-1">Provedor de Vídeo *</label>
                    <select id="video_provider"
                            name="video_provider"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('video_provider') border-red-500 @enderror">
                        @foreach($providers as $provider)
                            <option value="{{ $provider->value }}" {{ old('video_provider', $lesson->video_provider->value ?? $lesson->video_provider) === $provider->value ? 'selected' : '' }}>
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
                           value="{{ old('video_ref_id', $lesson->video_ref_id) }}"
                           required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('video_ref_id') border-red-500 @enderror">
                    @error('video_ref_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Ordem *</label>
                    <input type="number"
                           id="order"
                           name="order"
                           value="{{ old('order', $lesson->order) }}"
                           required
                           min="0"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('order') border-red-500 @enderror">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration_seconds" class="block text-sm font-medium text-gray-700 mb-1">Duração (segundos)</label>
                    <input type="number"
                           id="duration_seconds"
                           name="duration_seconds"
                           value="{{ old('duration_seconds', $lesson->duration_seconds) }}"
                           min="0"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('duration_seconds') border-red-500 @enderror">
                    @error('duration_seconds')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.courses.edit', $lesson->course_id) }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Salvar Alterações
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
