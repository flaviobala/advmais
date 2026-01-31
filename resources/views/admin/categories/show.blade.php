<x-admin-layout title="Trilha: {{ $category->name }}">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para lista de trilhas
        </a>
        <a href="{{ route('admin.categories.edit', $category) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
            Editar Trilha
        </a>
    </div>

    <!-- Cabeçalho da Trilha -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-6">
                @if($category->cover_image)
                    <img src="{{ asset('storage/' . $category->cover_image) }}" alt="{{ $category->name }}" class="w-full sm:w-64 h-36 rounded-lg object-cover flex-shrink-0">
                @endif
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-xl font-bold text-gray-900">{{ $category->name }}</h1>
                        @if($category->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativa</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inativa</span>
                        @endif
                    </div>
                    @if($category->description)
                        <p class="text-sm text-gray-600 mb-3">{{ $category->description }}</p>
                    @endif
                    <p class="text-sm text-gray-500">{{ $category->courses->count() }} curso(s) nesta trilha</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cursos da Trilha -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">Cursos</h2>
            <a href="{{ route('admin.courses.create') }}?category_id={{ $category->id }}"
               class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                + Novo Curso
            </a>
        </div>

        @if($category->courses->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($category->courses as $course)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            @if($course->cover_image)
                                <img src="{{ asset('storage/' . $course->cover_image) }}" alt="{{ $course->title }}" class="w-20 h-11 rounded object-cover flex-shrink-0">
                            @else
                                <div class="w-20 h-11 rounded bg-gray-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <a href="{{ route('admin.courses.edit', $course) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 truncate block">{{ $course->title }}</a>
                                <div class="text-xs text-gray-500">{{ $course->lessons_count }} aula(s)</div>
                                @if($course->description)
                                    <div class="text-xs text-gray-400 truncate mt-0.5">{{ Str::limit($course->description, 80) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                            @if(!$course->is_approved)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendente</span>
                            @endif
                            @if($course->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativo</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inativo</span>
                            @endif
                            <a href="{{ route('admin.courses.edit', $course) }}" class="text-sm text-yellow-600 hover:text-yellow-900">Editar</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <p class="mt-2 text-sm text-gray-500">Nenhum curso nesta trilha ainda.</p>
                <a href="{{ route('admin.courses.create') }}?category_id={{ $category->id }}"
                   class="mt-3 inline-block text-sm text-blue-600 hover:text-blue-800">
                    Criar o primeiro curso &rarr;
                </a>
            </div>
        @endif
    </div>
</x-admin-layout>
