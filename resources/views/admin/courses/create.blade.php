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
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
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
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                        <select id="category_id"
                                name="category_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Sem categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox"
                               id="is_active"
                               name="is_active"
                               value="1"
                               checked
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Curso ativo (visível para os alunos)
                        </label>
                    </div>
                </div>

                {{-- Coluna direita: Mídia (Capa + Vídeo) --}}
                <div class="space-y-6">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Imagem de Capa</h3>

                        {{-- Preview da imagem --}}
                        <div id="image-preview-container" class="hidden mb-3">
                            <img id="image-preview" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg">
                        </div>

                        <input type="file"
                               id="cover_image"
                               name="cover_image"
                               accept="image/*"
                               onchange="previewImage(this)"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('cover_image') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">JPEG, PNG, JPG, WebP. Máximo 2MB.</p>
                        @error('cover_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Vídeo do Curso (arquivo)</h3>

                        <div id="course-video-preview" class="hidden mb-3">
                            <video id="course-video-element" class="w-full h-48 object-cover rounded-lg" controls></video>
                        </div>

                        <input type="file"
                               id="course_video"
                               name="course_video"
                               accept="video/*"
                               onchange="previewCourseVideo(this)"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('course_video') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">MP4, WebM, MOV. Máximo 200MB.</p>
                        @error('course_video')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
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
                    Após criar o curso, você poderá adicionar aulas diretamente na página de edição do curso.
                    As aulas ficarão visíveis na mesma página para facilitar o gerenciamento.
                </p>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const container = document.getElementById('image-preview-container');
            const img = document.getElementById('image-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    container.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function previewCourseVideo(input) {
            const container = document.getElementById('course-video-preview');
            const video = document.getElementById('course-video-element');
            if (input.files && input.files[0]) {
                const url = URL.createObjectURL(input.files[0]);
                video.src = url;
                container.classList.remove('hidden');
            }
        }
    </script>
</x-admin-layout>
