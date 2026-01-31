<x-layout :title="$course->title">

    <!-- Cabeçalho do Curso -->
    <div class="mb-8 bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Imagem / V&iacute;deo do Curso -->
            <div class="md:w-56 flex-shrink-0 bg-gradient-to-br from-blue-400 to-blue-600">
                @if($course->preview_video_id)
                    <div class="w-full aspect-video bg-black">
                        @if($course->preview_video_provider === 'youtube')
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $course->preview_video_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @elseif($course->preview_video_provider === 'vimeo')
                            <iframe class="w-full h-full" src="https://player.vimeo.com/video/{{ $course->preview_video_id }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        @endif
                    </div>
                @elseif($course->thumbnail)
                    <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover aspect-[4/5] md:aspect-auto">
                @elseif($course->cover_image)
                    <img src="{{ Storage::url($course->cover_image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover aspect-video md:aspect-auto">
                @else
                    <div class="w-full h-48 md:h-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Informa&ccedil;&otilde;es do Curso -->
            <div class="flex-1 p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h1 class="text-xl font-bold text-gray-900">{{ $course->title }}</h1>
                        @if($course->progress >= 100)
                            <span class="flex-shrink-0 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Conclu&iacute;do</span>
                        @elseif($course->progress > 0)
                            <span class="flex-shrink-0 bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">Em andamento</span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ $course->description ?? 'Sem descri&ccedil;&atilde;o dispon&iacute;vel.' }}</p>

                    <div class="flex items-center gap-6 text-sm text-gray-500 mb-4">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            {{ $course->lessons->count() }} aulas
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $course->lessons->where('is_completed', true)->count() }} conclu&iacute;das
                        </span>
                    </div>
                </div>

                <!-- Barra de Progresso -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs font-medium text-gray-500">Progresso</span>
                        <span class="text-xs font-bold text-blue-600">{{ $course->progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $course->progress }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo do Curso -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Conte&uacute;do do Curso</h2>

        @php $lessonNumber = 0; @endphp

        <div class="space-y-4">
            {{-- Módulos com suas aulas --}}
            @foreach($course->modules as $module)
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.chevron').classList.toggle('rotate-180')"
                            class="w-full p-4 bg-gray-50 flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-3">
                            @if($module->cover_image)
                                <img src="{{ Storage::url($module->cover_image) }}" alt="{{ $module->title }}" class="w-16 h-9 rounded object-cover flex-shrink-0">
                            @else
                                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            @endif
                            <div class="text-left">
                                <h3 class="font-semibold text-gray-900">{{ $module->title }}</h3>
                                @if($module->description)
                                    <p class="text-xs text-gray-500">{{ $module->description }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-500">{{ $module->lessons->count() }} aula(s)</span>
                            <svg class="w-5 h-5 text-gray-400 chevron transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="divide-y divide-gray-100">
                        @foreach($module->lessons as $lesson)
                            @php $lessonNumber++; @endphp
                            @include('courses._lesson_row', ['lesson' => $lesson, 'course' => $course, 'number' => $lessonNumber])
                        @endforeach
                    </div>
                    @if($module->materials->count() > 0)
                        <div class="p-3 bg-blue-50 border-t border-blue-100">
                            <p class="text-xs font-semibold text-blue-700 mb-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                Material Complementar
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($module->materials as $material)
                                    <a href="{{ $material->type === 'link' ? $material->url : Storage::url($material->filepath) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-blue-200 rounded-lg text-xs text-gray-700 hover:bg-blue-100 transition-colors">
                                        <span class="flex-shrink-0 [&_svg]:w-4 [&_svg]:h-4">{!! $material->icon !!}</span>
                                        {{ $material->title ?? $material->filename }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            {{-- Aulas diretas (sem módulo) --}}
            @if($course->modules->count() > 0 && $course->lessons->where('module_id', null)->count() > 0)
                <div class="pt-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Aulas Avulsas</p>
                </div>
            @endif

            @foreach($course->lessons->where('module_id', null) as $lesson)
                @php $lessonNumber++; @endphp
                <div class="border border-gray-200 rounded-lg">
                    @include('courses._lesson_row', ['lesson' => $lesson, 'course' => $course, 'number' => $lessonNumber])
                </div>
            @endforeach

            {{-- Estado vazio --}}
            @if($course->modules->count() === 0 && $course->lessons->count() === 0)
                <div class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <p>Nenhuma aula dispon&iacute;vel neste curso.</p>
                </div>
            @endif
        </div>

        {{-- Material Complementar do Curso --}}
        @if($course->materials->count() > 0)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    Material Complementar
                </h3>
                <div class="space-y-2">
                    @foreach($course->materials as $material)
                        <a href="{{ $material->type === 'link' ? $material->url : Storage::url($material->filepath) }}"
                           target="_blank"
                           class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                            {!! $material->icon !!}
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $material->title ?? $material->filename }}</p>
                                @if($material->type === 'file')
                                    <p class="text-xs text-gray-400">{{ $material->formatted_size }} &bull; {{ strtoupper($material->filetype) }}</p>
                                @else
                                    <p class="text-xs text-gray-400">{{ $material->url }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Botão Voltar -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar ao Dashboard
            </a>
        </div>
    </div>

</x-layout>
