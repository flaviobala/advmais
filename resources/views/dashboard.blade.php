<x-layout title="Painel do Aluno">

    <!-- Mensagem de boas-vindas -->
    <div class="mb-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold mb-2">Olá, {{ $user->name }}!</h2>
        <p class="text-blue-100">Bem-vindo de volta. Continue aprendendo e evoluindo!</p>
    </div>

    @if($courses->isEmpty())
        <div class="text-center py-12 bg-white rounded-lg border-2 border-dashed border-gray-300">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum curso disponível</h3>
            <p class="text-gray-500">Você ainda não possui acesso a nenhum curso. Entre em contato com o administrador.</p>
        </div>
    @else
        {{-- Cursos agrupados por categoria --}}
        @foreach($categories as $category)
            @if($categorizedCourses->has($category->id))
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        {{ $category->name }}
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($categorizedCourses[$category->id] as $course)
                            @include('dashboard._course-card', ['course' => $course])
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Cursos sem categoria --}}
        @if($categorizedCourses->has(0))
            <div class="mb-10">
                @if($categories->isNotEmpty() && $categorizedCourses->count() > 1)
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Outros Cursos</h2>
                @endif
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categorizedCourses[0] as $course)
                        @include('dashboard._course-card', ['course' => $course])
                    @endforeach
                </div>
            </div>
        @endif
    @endif

</x-layout>
