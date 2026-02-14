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
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">T&iacute;tulo *</label>
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
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descri&ccedil;&atilde;o</label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $course->description) }}</textarea>
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
                                <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
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
                               value="{{ old('course_video', $course->course_video) }}"
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
                               {{ $course->is_active ? 'checked' : '' }}
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
                        <div id="cover-placeholder" class="{{ $course->cover_image ? 'hidden' : '' }} space-y-2">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-600">Clique para selecionar uma imagem</p>
                            <p class="text-xs text-gray-400">Formato horizontal 16:9 &bull; 1280 &times; 720 px &bull; PNG, JPG ou WebP</p>
                            <p class="text-xs text-gray-400">A imagem ser&aacute; ajustada automaticamente para o tamanho correto</p>
                        </div>
                        <div id="cover-preview" class="{{ $course->cover_image ? '' : 'hidden' }}">
                            <img id="cover-preview-img"
                                 src="{{ $course->cover_image ? asset('storage/' . $course->cover_image) : '' }}"
                                 alt="Preview"
                                 class="mx-auto rounded-lg max-h-52 object-contain">
                            <button type="button" id="cover-remove-btn" class="relative z-10 mt-2 text-xs text-red-500 hover:text-red-700">Remover imagem</button>
                        </div>
                        <input type="file"
                               id="cover_image"
                               name="cover_image"
                               accept="image/png,image/jpeg,image/webp"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                    <input type="hidden" id="remove_cover_image" name="remove_cover_image" value="0">
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    {{-- Thumbnail retrato --}}
                    <label class="block text-sm font-medium text-gray-700 mb-1 mt-6">Thumbnail (p&aacute;gina do curso)</label>
                    <div id="thumb-upload-area" class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors cursor-pointer">
                        <div id="thumb-placeholder" class="{{ $course->thumbnail ? 'hidden' : '' }} space-y-2">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-600">Clique para selecionar</p>
                            <p class="text-xs text-gray-400">Formato retrato 4:5 &bull; 400 &times; 500 px &bull; PNG, JPG ou WebP</p>
                            <p class="text-xs text-gray-400">Ajustada automaticamente</p>
                        </div>
                        <div id="thumb-preview" class="{{ $course->thumbnail ? '' : 'hidden' }}">
                            <img id="thumb-preview-img"
                                 src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : '' }}"
                                 alt="Preview"
                                 class="mx-auto rounded-lg max-h-48 object-contain">
                            <button type="button" id="thumb-remove-btn" class="relative z-10 mt-2 text-xs text-red-500 hover:text-red-700">Remover</button>
                        </div>
                        <input type="file"
                               id="thumbnail"
                               name="thumbnail"
                               accept="image/png,image/jpeg,image/webp"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                    <input type="hidden" id="remove_thumbnail" name="remove_thumbnail" value="0">
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
                    Salvar Altera&ccedil;&otilde;es
                </button>
            </div>
        </form>
    </div>

    {{-- Seção de Conteúdo: Módulos e Aulas --}}
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h2 class="text-lg font-medium text-gray-900">Conte&uacute;do do Curso</h2>
                <p class="text-sm text-gray-500">Organize em m&oacute;dulos ou adicione aulas diretas</p>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('new-module-form').classList.toggle('hidden')"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                    + Novo M&oacute;dulo
                </button>
                <a href="{{ route('admin.courses.lessons.create', $course) }}"
                   class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                    + Aula Direta
                </a>
            </div>
        </div>

        {{-- Formulário inline para criar módulo --}}
        <div id="new-module-form" class="hidden p-4 bg-blue-50 border-b border-blue-200">
            <form action="{{ route('admin.courses.modules.store', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nome do M&oacute;dulo *</label>
                        <input type="text" name="title" required placeholder="Ex: M&oacute;dulo 1 - Introdu&ccedil;&atilde;o"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Descri&ccedil;&atilde;o (opcional)</label>
                        <input type="text" name="description" placeholder="Breve descri&ccedil;&atilde;o do m&oacute;dulo"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Capa do M&oacute;dulo (opcional)</label>
                        <input type="file" name="cover_image" accept="image/png,image/jpeg,image/webp"
                               class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <p class="text-xs text-gray-400 mt-1">1280 &times; 720px &bull; 16:9 &bull; PNG, JPG ou WebP &bull; M&aacute;x 4MB</p>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm whitespace-nowrap">
                        Criar M&oacute;dulo
                    </button>
                </div>
            </form>
        </div>

        <div class="divide-y divide-gray-200">
            {{-- Módulos com suas aulas --}}
            @foreach($course->modules as $module)
                <div class="border-l-4 border-blue-400">
                    {{-- Cabeçalho do módulo --}}
                    <div class="p-4 bg-blue-50 flex items-center justify-between">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            @if($module->cover_image)
                                <img src="{{ Storage::url($module->cover_image) }}" alt="{{ $module->title }}" class="w-16 h-9 rounded object-cover flex-shrink-0">
                            @else
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $module->title }}</p>
                                <p class="text-xs text-gray-500">{{ $module->lessons_count }} aula(s)
                                    @if($module->description)
                                        &bull; {{ $module->description }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0 ml-3 flex-nowrap">
                            @if($module->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap">Ativo</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 whitespace-nowrap">Inativo</span>
                            @endif
                            <a href="{{ route('admin.courses.lessons.create', $course) }}?module_id={{ $module->id }}"
                               class="text-xs bg-green-100 text-green-700 hover:bg-green-200 px-2 py-1 rounded font-medium whitespace-nowrap">+ Aula</a>
                            <button type="button" onclick="document.getElementById('edit-module-{{ $module->id }}').classList.toggle('hidden')"
                                    class="text-xs text-yellow-600 hover:text-yellow-900 whitespace-nowrap">Editar</button>
                            <form action="{{ route('admin.modules.destroy', $module) }}" method="POST" class="inline-flex"
                                  onsubmit="return confirm('Excluir este m&oacute;dulo? As aulas ser&atilde;o mantidas como aulas diretas.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-900 whitespace-nowrap">Excluir</button>
                            </form>
                        </div>
                    </div>

                    {{-- Formulário de edição inline do módulo --}}
                    <div id="edit-module-{{ $module->id }}" class="hidden p-3 bg-yellow-50 border-b border-yellow-200">
                        <form action="{{ route('admin.modules.update', $module) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <div class="flex items-end gap-3">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Nome</label>
                                    <input type="text" name="title" value="{{ $module->title }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Descri&ccedil;&atilde;o</label>
                                    <input type="text" name="description" value="{{ $module->description }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="flex items-end gap-3">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Capa do M&oacute;dulo</label>
                                    <div class="flex items-center gap-3">
                                        @if($module->cover_image)
                                            <img src="{{ Storage::url($module->cover_image) }}" class="w-20 h-11 rounded object-cover" alt="Capa atual">
                                        @endif
                                        <input type="file" name="cover_image" accept="image/png,image/jpeg,image/webp"
                                               class="flex-1 border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                    @if($module->cover_image)
                                        <label class="flex items-center gap-2 mt-1 text-xs text-red-600 cursor-pointer">
                                            <input type="checkbox" name="remove_cover_image" value="1"> Remover capa atual
                                        </label>
                                    @endif
                                </div>
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg text-sm whitespace-nowrap">
                                    Salvar
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Aulas do módulo --}}
                    @forelse($module->lessons as $lesson)
                        <div class="p-4 pl-12 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center gap-3">
                                <span class="text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $lesson->order }}. {{ $lesson->title }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $lesson->video_provider }}
                                        @if($lesson->duration_seconds)
                                            &bull; {{ gmdate('i:s', $lesson->duration_seconds) }}
                                        @endif
                                        @if($lesson->attachments_count > 0)
                                            &bull; <span class="text-blue-600">{{ $lesson->attachments_count }} {{ $lesson->attachments_count == 1 ? 'arquivo' : 'arquivos' }}</span>
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
                                <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="inline" onsubmit="return confirm('Excluir esta aula?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Excluir</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 pl-12 text-sm text-gray-400 italic">
                            Nenhuma aula neste m&oacute;dulo.
                            <a href="{{ route('admin.courses.lessons.create', $course) }}?module_id={{ $module->id }}"
                               class="text-blue-600 hover:text-blue-800 not-italic">Adicionar aula &rarr;</a>
                        </div>
                    @endforelse

                    {{-- Materiais do módulo --}}
                    <div class="p-3 pl-12 bg-gray-50 border-t border-gray-200">
                        <button type="button" onclick="document.getElementById('module-materials-{{ $module->id }}').classList.toggle('hidden')"
                                class="text-xs font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                            Materiais do Módulo ({{ $module->materials->count() }})
                        </button>

                        <div id="module-materials-{{ $module->id }}" class="{{ $module->materials->count() > 0 ? '' : 'hidden' }} mt-3 space-y-2">
                            @foreach($module->materials as $material)
                                <div class="flex items-center justify-between p-2 bg-white rounded border border-gray-200">
                                    <div class="flex items-center gap-2 min-w-0">
                                        @if($material->cover_image)
                                            <img src="{{ Storage::url($material->cover_image) }}" alt="" class="w-8 h-8 rounded object-cover flex-shrink-0">
                                        @else
                                            <div class="flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">{!! $material->icon !!}</div>
                                        @endif
                                        <div class="min-w-0">
                                            @if($material->type === 'link')
                                                <a href="{{ $material->url }}" target="_blank" class="text-xs font-medium text-blue-600 hover:text-blue-800 truncate block">{{ $material->title }}</a>
                                            @else
                                                <a href="{{ Storage::url($material->filepath) }}" target="_blank" class="text-xs font-medium text-gray-900 hover:text-blue-600 truncate block">{{ $material->filename }}</a>
                                                <p class="text-xs text-gray-400">{{ $material->formatted_size }}</p>
                                            @endif
                                            @if($material->description)
                                                <p class="text-xs text-gray-500 truncate">{{ $material->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Excluir?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Excluir</button>
                                    </form>
                                </div>
                            @endforeach

                            <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-2 pt-2">
                                @csrf
                                <input type="hidden" name="materialable_type" value="module">
                                <input type="hidden" name="materialable_id" value="{{ $module->id }}">
                                <div class="flex flex-wrap items-end gap-2">
                                    <div class="flex-1 min-w-[200px]">
                                        <input type="file" name="files[]" multiple
                                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.mp3,.mp4,.jpg,.jpeg,.png,.webp"
                                               class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white">
                                    </div>
                                    <div class="flex-1 min-w-[150px]">
                                        <input type="url" name="link_url" placeholder="ou cole um link..."
                                               class="w-full border border-gray-300 rounded px-2 py-1 text-xs">
                                    </div>
                                </div>
                                <div class="flex flex-wrap items-end gap-2">
                                    <div class="flex-1 min-w-[150px]">
                                        <input type="file" name="cover_image" accept="image/*"
                                               class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white">
                                        <p class="text-xs text-gray-400 mt-0.5">Capa (opcional)</p>
                                    </div>
                                    <div class="flex-1 min-w-[200px]">
                                        <input type="text" name="description" placeholder="Descrição (opcional)"
                                               class="w-full border border-gray-300 rounded px-2 py-1 text-xs">
                                    </div>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium py-1 px-3 rounded">
                                        Adicionar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Aulas diretas (sem módulo) --}}
            @if($course->lessons->count() > 0)
                @if($course->modules->count() > 0)
                    <div class="p-3 bg-gray-50 border-b border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Aulas Diretas (sem m&oacute;dulo)</p>
                    </div>
                @endif
                @foreach($course->lessons as $lesson)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <span class="text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $lesson->order }}. {{ $lesson->title }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $lesson->video_provider }}
                                    @if($lesson->duration_seconds)
                                        &bull; {{ gmdate('i:s', $lesson->duration_seconds) }}
                                    @endif
                                    @if($lesson->attachments_count > 0)
                                        &bull; <span class="text-blue-600">{{ $lesson->attachments_count }} {{ $lesson->attachments_count == 1 ? 'arquivo' : 'arquivos' }}</span>
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
                            <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="inline" onsubmit="return confirm('Excluir esta aula?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Excluir</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- Estado vazio --}}
            @if($course->modules->count() === 0 && $course->lessons->count() === 0)
                <div class="p-12 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="mt-4">Nenhum conte&uacute;do cadastrado.</p>
                    <p class="mt-1 text-sm">Comece criando um m&oacute;dulo ou adicionando uma aula direta.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Seção de Material Complementar do Curso --}}
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Material Complementar do Curso</h2>
            <p class="text-sm text-gray-500">Arquivos e links disponíveis para todos os alunos do curso</p>
        </div>

        <div class="p-6 space-y-4">
            @if($course->materials->count() > 0)
                <div class="space-y-2">
                    @foreach($course->materials as $material)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($material->cover_image)
                                    <img src="{{ Storage::url($material->cover_image) }}" alt="" class="w-12 h-12 rounded object-cover flex-shrink-0">
                                @else
                                    {!! $material->icon !!}
                                @endif
                                <div class="min-w-0">
                                    @if($material->type === 'link')
                                        <a href="{{ $material->url }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-800 truncate block">{{ $material->title }}</a>
                                        <p class="text-xs text-gray-400 truncate">{{ $material->url }}</p>
                                    @else
                                        <a href="{{ Storage::url($material->filepath) }}" target="_blank" class="text-sm font-medium text-gray-900 hover:text-blue-600 truncate block">{{ $material->filename }}</a>
                                        <p class="text-xs text-gray-400">{{ $material->formatted_size }} &bull; {{ strtoupper($material->filetype) }}</p>
                                    @endif
                                    @if($material->description)
                                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $material->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Excluir este material?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Excluir</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 pt-2 border-t border-gray-200">
                @csrf
                <input type="hidden" name="materialable_type" value="course">
                <input type="hidden" name="materialable_id" value="{{ $course->id }}">

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Enviar arquivos</label>
                    <input type="file" name="files[]" multiple
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.mp3,.mp4,.jpg,.jpeg,.png,.webp"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
                    <p class="text-xs text-gray-400 mt-1">PDF, Word, Excel, PowerPoint, imagens, áudio, vídeo, ZIP &bull; Máx 50MB por arquivo</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Ou adicionar link</label>
                        <input type="text" name="link_title" placeholder="Título do link"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">&nbsp;</label>
                        <input type="url" name="link_url" placeholder="https://..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Capa (opcional)</label>
                        <input type="file" name="cover_image" accept="image/*"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
                        <p class="text-xs text-gray-400 mt-1">Imagem de capa do material &bull; Máx 2MB</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Descrição (opcional)</label>
                        <textarea name="description" rows="2" placeholder="Breve descrição do material..."
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm resize-none"></textarea>
                    </div>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition-colors">
                    Adicionar Material
                </button>
            </form>
        </div>
    </div>

    <script>
        const coverInput = document.getElementById('cover_image');
        const placeholder = document.getElementById('cover-placeholder');
        const preview = document.getElementById('cover-preview');
        const previewImg = document.getElementById('cover-preview-img');
        const removeBtn = document.getElementById('cover-remove-btn');
        const removeCoverField = document.getElementById('remove_cover_image');

        coverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            removeCoverField.value = '0';

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
                    coverInput.style.pointerEvents = 'none';
                }, 'image/png', 0.9);
            };
            img.src = URL.createObjectURL(file);
        });

        // Esconder input file se já tem preview
        if (!preview.classList.contains('hidden')) {
            coverInput.style.pointerEvents = 'none';
        }

        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            coverInput.value = '';
            removeCoverField.value = '1';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            coverInput.style.pointerEvents = 'auto';
        });

        // Thumbnail 400x500
        const thumbInput = document.getElementById('thumbnail');
        const thumbPlaceholder = document.getElementById('thumb-placeholder');
        const thumbPreview = document.getElementById('thumb-preview');
        const thumbPreviewImg = document.getElementById('thumb-preview-img');
        const thumbRemoveBtn = document.getElementById('thumb-remove-btn');
        const removeThumbField = document.getElementById('remove_thumbnail');

        thumbInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            removeThumbField.value = '0';

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
                    thumbInput.style.pointerEvents = 'none';
                }, 'image/png', 0.9);
            };
            img.src = URL.createObjectURL(file);
        });

        if (!thumbPreview.classList.contains('hidden')) {
            thumbInput.style.pointerEvents = 'none';
        }

        thumbRemoveBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            thumbInput.value = '';
            removeThumbField.value = '1';
            thumbPreview.classList.add('hidden');
            thumbPlaceholder.classList.remove('hidden');
            thumbInput.style.pointerEvents = 'auto';
        });
    </script>
</x-admin-layout>
