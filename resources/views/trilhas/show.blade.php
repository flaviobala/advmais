<x-layout title="{{ $category->name }}">

    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            &larr; Voltar para o Painel
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header da trilha --}}
    <div class="mb-8 flex gap-5 items-stretch">
        {{-- Card da trilha - mesmo tamanho dos cards de curso --}}
        <div class="flex-shrink-0" style="width: calc((100% - 4 * 1.25rem) / 5);">
            <div class="bg-white rounded-lg shadow overflow-hidden h-full flex flex-col">
                <div class="aspect-video bg-gradient-to-br from-gray-800 to-black relative overflow-hidden">
                    @if($category->cover_image)
                        <img src="{{ Storage::url($category->cover_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-3 flex-1">
                    <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-tight">{{ $category->name }}</h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $courses->count() }} {{ $courses->count() == 1 ? 'curso' : 'cursos' }}</p>
                </div>
            </div>
        </div>

        {{-- Container de informações da trilha --}}
        <div class="flex-1 bg-white rounded-lg shadow p-5 flex flex-col">
            <h2 class="text-lg font-bold text-gray-900 mb-2">{{ $category->name }}</h2>
            @if($category->description)
                <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ $category->description }}</p>
            @endif
            <div class="flex items-center gap-4 text-sm text-gray-500">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    {{ $courses->count() }} {{ $courses->count() == 1 ? 'curso' : 'cursos' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Cursos da trilha --}}
    @if($courses->isEmpty())
        <div class="text-center py-12 bg-white rounded-lg border-2 border-dashed border-gray-300">
            <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum curso nesta trilha</h3>
            <p class="text-gray-500">Os cursos ser&atilde;o exibidos aqui quando forem cadastrados.</p>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            @foreach($courses as $course)
                @include('trilhas._course-card', ['course' => $course])
            @endforeach
        </div>
    @endif

</x-layout>
