<x-layout :title="$lesson->title">

    {{-- Voltar para o curso --}}
    <div class="mb-6">
        <a href="{{ route('courses.show', $course->id) }}"
           class="text-blue-600 hover:text-blue-800 font-medium">
            ← Voltar para o curso
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">

        {{-- Título da aula --}}
        <h1 class="text-2xl font-bold text-gray-900 mb-4">
            {{ $lesson->title }}
        </h1>

        {{-- Player --}}
        <div class="w-full aspect-video bg-black rounded-lg overflow-hidden">

            @php $provider = $lesson->video_provider->value ?? $lesson->video_provider; @endphp

            @if($provider === 'youtube')
                <iframe
                    id="video-player"
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/{{ $lesson->video_ref_id }}?enablejsapi=1"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>

            @elseif($provider === 'vimeo')
                @php
                    $vimeoClean = strtok($lesson->video_ref_id, '?');
                    if (str_contains($vimeoClean, '/')) {
                        [$vimeoId, $vimeoHash] = explode('/', $vimeoClean, 2);
                        $vimeoSrc = "https://player.vimeo.com/video/{$vimeoId}?h={$vimeoHash}";
                    } else {
                        $vimeoSrc = "https://player.vimeo.com/video/{$vimeoClean}";
                    }
                @endphp
                <iframe
                    id="video-player"
                    class="w-full h-full"
                    src="{{ $vimeoSrc }}"
                    frameborder="0"
                    allow="autoplay; fullscreen; picture-in-picture"
                    allowfullscreen>
                </iframe>

            @else
                <div class="flex items-center justify-center h-full text-white">
                    Vídeo não disponível
                </div>
            @endif

        </div>

        @php $provider = $lesson->video_provider->value ?? $lesson->video_provider; @endphp
        @if(in_array($provider, ['youtube', 'vimeo']))
        <script>
            const PROGRESS_URL = '{{ route('courses.lesson.progress', [$course->id, $lesson->id]) }}';
            const CSRF = '{{ csrf_token() }}';
            let lastSent = 0;

            function sendProgress(pct) {
                pct = Math.round(pct);
                if (pct <= lastSent) return;
                lastSent = pct;
                fetch(PROGRESS_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                    body: JSON.stringify({ percentage: pct }),
                });
            }

            @if($provider === 'youtube')
            var tag = document.createElement('script');
            tag.src = 'https://www.youtube.com/iframe_api';
            document.head.appendChild(tag);

            var ytPlayer;
            var ytInterval;

            function onYouTubeIframeAPIReady() {
                ytPlayer = new YT.Player('video-player', {
                    events: {
                        onStateChange: function(e) {
                            if (e.data === YT.PlayerState.PLAYING) {
                                ytInterval = setInterval(function() {
                                    var duration = ytPlayer.getDuration();
                                    if (!duration) return;
                                    var pct = (ytPlayer.getCurrentTime() / duration) * 100;
                                    sendProgress(pct);
                                }, 10000);
                            } else {
                                clearInterval(ytInterval);
                                if (e.data === YT.PlayerState.ENDED) {
                                    sendProgress(100);
                                }
                            }
                        }
                    }
                });
            }
            @endif

            @if($provider === 'vimeo')
            var vimeoScript = document.createElement('script');
            vimeoScript.src = 'https://player.vimeo.com/api/player.js';
            vimeoScript.onload = function() {
                var vimeoPlayer = new Vimeo.Player(document.getElementById('video-player'));
                var vimeoInterval;

                vimeoPlayer.on('play', function() {
                    vimeoInterval = setInterval(function() {
                        Promise.all([vimeoPlayer.getCurrentTime(), vimeoPlayer.getDuration()]).then(function(values) {
                            var pct = (values[0] / values[1]) * 100;
                            sendProgress(pct);
                        });
                    }, 10000);
                });

                vimeoPlayer.on('pause', function() { clearInterval(vimeoInterval); });
                vimeoPlayer.on('ended', function() {
                    clearInterval(vimeoInterval);
                    sendProgress(100);
                });
            };
            document.head.appendChild(vimeoScript);
            @endif
        </script>
        @endif

        {{-- Duração --}}
        @if($lesson->duration_seconds)
            <p class="mt-4 text-sm text-gray-500">
                Duração: {{ gmdate('i:s', $lesson->duration_seconds) }} minutos
            </p>
        @endif


        {{-- Material Complementar da Aula --}}
        @php
            $hasMaterials = $lesson->materials->count() > 0 || $lesson->attachments->count() > 0;
        @endphp
        @if($hasMaterials)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    Material Complementar
                </h3>
                <div class="space-y-2">
                    {{-- Attachments (enviados via formulário da aula) --}}
                    @foreach($lesson->attachments as $attachment)
                        <a href="{{ $attachment->url }}"
                           target="_blank"
                           class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                            {!! $attachment->icon !!}
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $attachment->filename }}</p>
                                <p class="text-xs text-gray-400">{{ $attachment->formatted_size }} &bull; {{ strtoupper($attachment->filetype) }}</p>
                            </div>
                        </a>
                    @endforeach

                    {{-- Materials (adicionados via seção de materiais) --}}
                    @foreach($lesson->materials as $material)
                        <a href="{{ $material->type === 'link' ? $material->url : Storage::url($material->filepath) }}"
                           target="_blank"
                           class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                            @if($material->cover_image)
                                <img src="{{ Storage::url($material->cover_image) }}" alt="" class="w-12 h-12 rounded object-cover flex-shrink-0">
                            @else
                                {!! $material->icon !!}
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $material->title ?? $material->filename }}</p>
                                @if($material->description)
                                    <p class="text-xs text-gray-600">{{ $material->description }}</p>
                                @endif
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

    </div>

</x-layout>
