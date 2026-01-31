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
    <div class="mb-8 bg-white rounded-lg shadow overflow-hidden">
        <div class="flex flex-col sm:flex-row">
            <div class="sm:w-48 md:w-56 flex-shrink-0 bg-gradient-to-br from-blue-400 to-blue-600">
                @if($category->cover_image)
                    <img src="{{ Storage::url($category->cover_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover aspect-video">
                @else
                    <div class="w-full aspect-video flex items-center justify-center">
                        <svg class="w-12 h-12 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                @endif
            </div>
            <div class="p-5 flex flex-col justify-center">
                <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $category->name }}</h2>
                @if($category->description)
                    <p class="text-sm text-gray-600 line-clamp-3">{{ $category->description }}</p>
                @endif
                <p class="text-xs text-gray-400 mt-2">{{ $courses->count() }} {{ $courses->count() == 1 ? 'curso' : 'cursos' }}</p>
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
