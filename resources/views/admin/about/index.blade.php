<x-admin-layout title="ADV+CONECTA">

    {{-- Seção: Introdução --}}
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-4 border-b border-gray-200"></div>
        <div class="p-4">
            <form action="{{ route('admin.about.intro.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Imagem do Card no Dashboard</label>
                    <p class="text-xs text-gray-400 mb-1">Esta imagem aparece no painel do aluno, antes das trilhas, como atalho para o ADV+CONECTA.</p>
                    @if($settings->card_image)
                        <div class="flex items-center gap-3 mb-2">
                            <img src="{{ Storage::url($settings->card_image) }}" class="w-32 h-20 rounded object-cover">
                            <label class="flex items-center gap-2 text-xs text-red-600 cursor-pointer">
                                <input type="checkbox" name="remove_card_image" value="1"> Remover imagem
                            </label>
                        </div>
                    @endif
                    <input type="file" name="card_image" accept="image/png,image/jpeg,image/webp"
                           class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-white">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Link do Vídeo de Abertura (YouTube ou Vimeo)</label>
                    <input type="url" name="intro_video_url" value="{{ $settings->intro_video_url }}"
                           placeholder="https://youtube.com/watch?v=..."
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Texto sobre a Comunidade</label>
                    <p class="text-xs text-gray-400 mb-1">Use **palavra** para deixar em <strong>negrito</strong>.</p>
                    <textarea name="intro_text" rows="5" placeholder="Descreva o que é o ADV+CONECTA, sua missão, valores..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">{{ $settings->intro_text }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm">
                        Salvar Introdução
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Seção: Eventos --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-medium text-gray-900">Eventos</h2>
                <p class="text-sm text-gray-500">Fotos e vídeos dos eventos ADV+CONECTA</p>
            </div>
            <button type="button" onclick="document.getElementById('new-event-form').classList.toggle('hidden')"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition-colors">
                + Novo Evento
            </button>
        </div>

        {{-- Formulário novo evento --}}
        <div id="new-event-form" class="hidden p-4 bg-blue-50 border-b border-blue-200">
            <form action="{{ route('admin.about.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Título *</label>
                        <input type="text" name="title" required placeholder="Nome do evento"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Link do Vídeo</label>
                        <input type="url" name="video_url" placeholder="https://youtube.com/watch?v=..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Descrição</label>
                    <textarea name="description" rows="2" placeholder="Breve descrição do evento"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Foto do Evento</label>
                        <input type="file" name="photo" accept="image/png,image/jpeg,image/webp"
                               class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-white">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm whitespace-nowrap">
                        Adicionar Evento
                    </button>
                </div>
            </form>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($events as $event)
                <div class="p-4">
                    <div class="flex items-start gap-4">
                        @if($event->photo)
                            <img src="{{ Storage::url($event->photo) }}" alt="{{ $event->title }}" class="w-20 h-12 rounded object-cover flex-shrink-0">
                        @else
                            <div class="w-20 h-12 rounded bg-gray-200 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $event->title }}</p>
                            @if($event->description)
                                <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $event->description }}</p>
                            @endif
                            @if($event->video_url)
                                <a href="{{ $event->video_url }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 mt-1 inline-block">Ver vídeo</a>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                            <button type="button" onclick="document.getElementById('edit-event-{{ $event->id }}').classList.toggle('hidden')"
                                    class="text-xs text-yellow-600 hover:text-yellow-900 font-medium px-2 py-1 rounded hover:bg-yellow-50">Editar</button>
                            <form action="{{ route('admin.about.events.destroy', $event) }}" method="POST" class="inline-flex" onsubmit="return confirm('Excluir este evento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-medium px-2 py-1 rounded hover:bg-red-50">Excluir</button>
                            </form>
                        </div>
                    </div>

                    {{-- Formulário de edição inline --}}
                    <div id="edit-event-{{ $event->id }}" class="hidden mt-3 p-3 bg-yellow-50 rounded-lg">
                        <form action="{{ route('admin.about.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Título</label>
                                    <input type="text" name="title" value="{{ $event->title }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Link do Vídeo</label>
                                    <input type="url" name="video_url" value="{{ $event->video_url }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Descrição</label>
                                <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ $event->description }}</textarea>
                            </div>
                            <div class="flex items-end gap-3">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Nova Foto</label>
                                    <input type="file" name="photo" accept="image/png,image/jpeg,image/webp"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-white">
                                    @if($event->photo)
                                        <label class="flex items-center gap-2 mt-1 text-xs text-red-600 cursor-pointer">
                                            <input type="checkbox" name="remove_photo" value="1"> Remover foto atual
                                        </label>
                                    @endif
                                </div>
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg text-sm whitespace-nowrap">
                                    Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <p>Nenhum evento cadastrado.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Seção: Idealizadores --}}
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-medium text-gray-900">Idealizadores</h2>
                <p class="text-sm text-gray-500">Equipe por trás do ADV+CONECTA</p>
            </div>
            <button type="button" onclick="document.getElementById('new-founder-form').classList.toggle('hidden')"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition-colors">
                + Novo Idealizador
            </button>
        </div>

        {{-- Formulário novo idealizador --}}
        <div id="new-founder-form" class="hidden p-4 bg-blue-50 border-b border-blue-200">
            <form action="{{ route('admin.about.founders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nome *</label>
                        <input type="text" name="name" required placeholder="Nome completo"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Cargo / Função</label>
                        <input type="text" name="role" placeholder="Ex: CEO, Fundador, Diretor..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Currículo / Bio</label>
                    <textarea name="bio" rows="3" placeholder="Breve currículo ou biografia"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Foto</label>
                        <input type="file" name="photo" accept="image/png,image/jpeg,image/webp"
                               class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-white">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm whitespace-nowrap">
                        Adicionar
                    </button>
                </div>
            </form>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($founders as $founder)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4 min-w-0 flex-1">
                            @if($founder->photo)
                                <img src="{{ Storage::url($founder->photo) }}" alt="{{ $founder->name }}" class="w-16 h-16 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $founder->name }}</p>
                                @if($founder->role)
                                    <p class="text-xs text-blue-600">{{ $founder->role }}</p>
                                @endif
                                @if($founder->bio)
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $founder->bio }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button type="button" onclick="document.getElementById('edit-founder-{{ $founder->id }}').classList.toggle('hidden')"
                                    class="text-xs text-yellow-600 hover:text-yellow-900">Editar</button>
                            <form action="{{ route('admin.about.founders.destroy', $founder) }}" method="POST" class="inline-flex" onsubmit="return confirm('Excluir?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-900">Excluir</button>
                            </form>
                        </div>
                    </div>

                    {{-- Formulário de edição inline --}}
                    <div id="edit-founder-{{ $founder->id }}" class="hidden mt-3 p-3 bg-yellow-50 rounded-lg">
                        <form action="{{ route('admin.about.founders.update', $founder) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Nome</label>
                                    <input type="text" name="name" value="{{ $founder->name }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Cargo</label>
                                    <input type="text" name="role" value="{{ $founder->role }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Bio</label>
                                <textarea name="bio" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ $founder->bio }}</textarea>
                            </div>
                            <div class="flex items-end gap-3">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Nova Foto</label>
                                    <input type="file" name="photo" accept="image/png,image/jpeg,image/webp"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-white">
                                    @if($founder->photo)
                                        <label class="flex items-center gap-2 mt-1 text-xs text-red-600 cursor-pointer">
                                            <input type="checkbox" name="remove_photo" value="1"> Remover foto atual
                                        </label>
                                    @endif
                                </div>
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg text-sm whitespace-nowrap">
                                    Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <p>Nenhum idealizador cadastrado.</p>
                </div>
            @endforelse
        </div>
    </div>

</x-admin-layout>
