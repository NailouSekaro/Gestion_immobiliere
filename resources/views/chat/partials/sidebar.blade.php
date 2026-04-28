<div class="sidebar-chat h-100 d-flex flex-column">
    <div class="p-3 border-bottom bg-white">
        <h5 class="mb-3">
            <i class="fas fa-comments text-primary me-2"></i>Messages
        </h5>

        <div class="input-group">
            <span class="input-group-text bg-light border-0">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text"
                   class="form-control border-0 bg-light"
                   id="searchConversations"
                   placeholder="Rechercher...">
        </div>
    </div>

    <div class="conversations-list flex-grow-1 overflow-auto">
        @forelse($conversations as $conv)
            <a href="{{ route('chat.show', $conv['conversation_id']) }}"
               class="conversation-item d-flex align-items-center p-3 text-decoration-none {{ request()->route('conversationId') === $conv['conversation_id'] ? 'active' : '' }}">

                <div class="position-relative me-3">
                    <img src="{{ $conv['other_user']->photo_profil ? asset('storage/' . $conv['other_user']->photo_profil) : asset('images/default-avatar.jpg') }}"
                         class="rounded-circle"
                         width="50"
                         height="50"
                         style="object-fit: cover;">

                    @if($conv['other_user']->isOnline())
                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"></span>
                    @endif
                </div>

                <div class="flex-grow-1 min-width-0">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <h6 class="mb-0 fw-semibold text-dark text-truncate">
                            {{ $conv['other_user']->prenom }} {{ $conv['other_user']->nom }}
                        </h6>
                        <small class="text-muted ms-2">
                            {{ $conv['last_message']->created_at->diffForHumans(null, true) }}
                        </small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 text-muted small text-truncate" style="max-width: 200px;">
                            @if($conv['last_message']->expediteur_id === auth()->id())
                                <span class="text-primary">Vous:</span>
                            @endif
                            {{ Str::limit($conv['last_message']->contenu, 30) }}
                        </p>

                        @if($conv['unread_count'] > 0)
                        <span class="badge bg-primary rounded-pill ms-2">
                            {{ $conv['unread_count'] }}
                        </span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucune conversation</p>
            </div>
        @endforelse
    </div>

    <div class="p-3 border-top bg-white">
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#newChatModal">
            <i class="fas fa-plus me-2"></i>Nouvelle conversation
        </button>
    </div>
</div>

<style>
.conversation-item {
    transition: all 0.2s;
    border-bottom: 1px solid #f0f0f0;
}

.conversation-item:hover {
    background-color: #f8f9fa;
}

.conversation-item.active {
    background-color: #e8f4ff;
    border-left: 4px solid #0d6efd;
}
</style>

{{-- ================================== --}}

{{-- resources/views/chat/partials/messages.blade.php --}}
{{-- (Pour le polling - retourne plusieurs messages) --}}
<!-- @foreach($messages as $message)
    @include('chat.partials.message', ['message' => $message])
@endforeach -->
