<x-admin-layout title="Editar Curso">
    <div class="mb-6">
        <a href="{{ route('admin.courses.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para lista de cursos
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Editar Curso: {{ $course->title }}</h2>
        </div>

        <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Coluna esquerda: Dados do curso --}}
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title', $course->title) }}"
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
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $course->description) }}</textarea>
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
                                <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
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
                               {{ $course->is_active ? 'checked' : '' }}
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

                        {{-- Preview da imagem atual ou nova --}}
                        <div id="image-preview-container" class="{{ $course->cover_image ? '' : 'hidden' }} mb-3">
                            <img id="image-preview"
                                 src="{{ $course->cover_image ? Storage::url($course->cover_image) : '' }}"
                                 alt="Capa"
                                 class="w-full h-48 object-cover rounded-lg">
                        </div>

                        <input type="file"
                               id="cover_image"
                               name="cover_image"
                               accept="image/*"
                               onchange="previewImage(this)"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('cover_image') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Deixe em branco para manter a imagem atual. JPEG, PNG, JPG, WebP. Máximo 2MB.</p>
                        @error('cover_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Vídeo do Curso (arquivo)</h3>

                        <div id="course-video-preview" class="{{ $course->course_video ? '' : 'hidden' }} mb-3">
                            <video id="course-video-element" class="w-full h-48 object-cover rounded-lg" controls>
                                @if($course->course_video)
                                    <source src="{{ Storage::url($course->course_video) }}">
                                @endif
                            </video>
                        </div>

                        <input type="file"
                               id="course_video"
                               name="course_video"
                               accept="video/*"
                               onchange="previewCourseVideo(this)"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('course_video') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Deixe em branco para manter o vídeo atual. MP4, WebM, MOV. Máximo 200MB.</p>
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
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    {{-- Seção de Aulas --}}
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-medium text-gray-900">Aulas do Curso</h2>
                <p class="text-sm text-gray-500">Gerencie as aulas deste curso</p>
            </div>
            <a href="{{ route('admin.courses.lessons.create', $course) }}"
               class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                + Nova Aula
            </a>
        </div>

        <div class="divide-y divide-gray-200" id="lessons-list">
            @forelse($course->lessons as $lesson)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50" data-lesson-id="{{ $lesson->id }}">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-400 cursor-move drag-handle">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $lesson->order }}. {{ $lesson->title }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $lesson->video_provider }} 
                                @if($lesson->duration_seconds)
                                    • {{ gmdate('i:s', $lesson->duration_seconds) }}
                                @endif
                                @if($lesson->attachments_count > 0)
                                    • <span class="text-blue-600">{{ $lesson->attachments_count }} {{ $lesson->attachments_count == 1 ? 'arquivo' : 'arquivos' }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($lesson->is_active ?? true)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativa</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inativa</span>
                        @endif
                        <a href="{{ route('admin.lessons.edit', $lesson) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">Editar</a>
                        <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta aula?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Excluir</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-4">Nenhuma aula cadastrada.</p>
                    <a href="{{ route('admin.courses.lessons.create', $course) }}"
                       class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                        Adicionar primeira aula
                    </a>
                </div>
            @endforelse
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
