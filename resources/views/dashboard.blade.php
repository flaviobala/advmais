<x-layout title="Painel do Aluno">

    <!-- Mensagem de boas-vindas -->
    <div class="mb-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold mb-2">Ol&aacute;, {{ $user->name }}!</h2>
        <p class="text-blue-100">Bem-vindo de volta. Continue aprendendo e evoluindo!</p>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if($categories->isEmpty() && $orphanCourses->isEmpty())
        <div class="text-center py-12 bg-white rounded-lg border-2 border-dashed border-gray-300">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum conte&uacute;do dispon&iacute;vel</h3>
            <p class="text-gray-500">Nenhuma trilha ou curso cadastrado no sistema.</p>
        </div>
    @else
        {{-- Trilhas --}}
        @if($categories->isNotEmpty())
            <h2 class="text-xl font-bold text-gray-900 mb-4">Trilhas de Aprendizado</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 mb-10">
                {{-- Card ADV+CONECTA --}}
                <a href="{{ route('about') }}" class="group block bg-white rounded-lg shadow hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                    <div class="aspect-video bg-gradient-to-br from-purple-500 to-blue-600 relative overflow-hidden">
                        @if($aboutSettings->card_image)
                            <img src="{{ Storage::url($aboutSettings->card_image) }}" alt="ADV+CONECTA" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-tight">ADV+CONECTA</h3>
                        <p class="text-xs text-purple-500 mt-1">Saiba mais</p>
                    </div>
                </a>

                @foreach($categories as $category)
                    @if($category->is_locked)
                        <div class="group block bg-white rounded-lg shadow overflow-hidden opacity-90">
                            <div class="aspect-video bg-gradient-to-br from-blue-400 to-blue-600 relative overflow-hidden">
                                @if($category->cover_image)
                                    <img src="{{ Storage::url($category->cover_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute bottom-2 right-2 bg-black bg-opacity-70 rounded-full p-1.5">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-tight">{{ $category->name }}</h3>
                                <p class="text-xs text-gray-400 mt-1">{{ $category->courses_count }} {{ $category->courses_count == 1 ? 'curso' : 'cursos' }}</p>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('trilhas.show', $category->id) }}" class="group block bg-white rounded-lg shadow hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                            <div class="aspect-video bg-gradient-to-br from-blue-400 to-blue-600 relative overflow-hidden">
                                @if($category->cover_image)
                                    <img src="{{ Storage::url($category->cover_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-tight">{{ $category->name }}</h3>
                                <p class="text-xs text-gray-400 mt-1">{{ $category->courses_count }} {{ $category->courses_count == 1 ? 'curso' : 'cursos' }}</p>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif

        {{-- Cursos sem trilha --}}
        @if($orphanCourses->isNotEmpty())
            <h2 class="text-xl font-bold text-gray-900 mb-4">Cursos</h2>
            <div class="relative -mx-4 px-4">
                <div class="flex gap-5 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-thin">
                    @foreach($orphanCourses as $course)
                        @include('dashboard._course-card', ['course' => $course])
                    @endforeach
                </div>
            </div>
        @endif
    @endif

</x-layout>
