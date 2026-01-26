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
                <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Imagem de Capa</label>
                <input type="file"
                       id="cover_image"
                       name="cover_image"
                       accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('cover_image') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Formatos aceitos: JPEG, PNG, JPG, WebP. Máximo 2MB.</p>
                @error('cover_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-md font-medium text-gray-900 mb-4">Vídeo de Apresentação (opcional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="preview_video_provider" class="block text-sm font-medium text-gray-700 mb-1">Provedor</label>
                        <select id="preview_video_provider"
                                name="preview_video_provider"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Nenhum vídeo</option>
                            <option value="youtube" {{ old('preview_video_provider') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                            <option value="vimeo" {{ old('preview_video_provider') === 'vimeo' ? 'selected' : '' }}>Vimeo</option>
                        </select>
                    </div>
                    <div>
                        <label for="preview_video_id" class="block text-sm font-medium text-gray-700 mb-1">ID do Vídeo</label>
                        <input type="text"
                               id="preview_video_id"
                               name="preview_video_id"
                               value="{{ old('preview_video_id') }}"
                               placeholder="Ex: dQw4w9WgXcQ (YouTube) ou 76979871 (Vimeo)"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-sm text-gray-500">ID do vídeo na plataforma (não a URL completa).</p>
                    </div>
                </div>
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
</x-admin-layout>
