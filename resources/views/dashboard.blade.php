<x-layout title="Painel do Aluno">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($courses as $course)
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow duration-300">
                <div class="h-48 bg-gray-200">
                    <img src="{{ $course->cover_image }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                </div>
                
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-900 truncate">
                        {{ $course->title }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-500 line-clamp-3">
                        {{ $course->description }}
                    </p>
                    
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-xs font-semibold inline-block py-1 px-2 rounded text-blue-600 bg-blue-100 uppercase last:mr-0 mr-1">
                            {{ $course->lessons_count }} Aulas
                        </span>
                        
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                            Assistir Agora &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-10 bg-white rounded-lg border-2 border-dashed border-gray-300">
                <p class="text-gray-500">Nenhum curso disponível no momento.</p>
            </div>
        @endforelse

    </div>

</x-layout>