@extends('layouts.app')

@section('title', 'Messagerie')

@section('content')
<div class="chat-container">
    <div class="row g-0" style="height: calc(100vh - 100px);">
        <!-- Sidebar gauche - Liste des conversations -->
        <div class="col-md-4 col-lg-3 border-end">
            <div class="sidebar-chat h-100 d-flex flex-column">
                <!-- Header de la sidebar -->
                <div class="p-3 border-bottom bg-white">
                    <h5 class="mb-3">
                        <i class="fas fa-comments text-primary me-2"></i>Messages
                    </h5>

                    <!-- Barre de recherche -->
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

                <!-- Liste des conversations -->
                <div class="conversations-list flex-grow-1 overflow-auto">
                    @forelse($conversations as $conv)
                        <a href="{{ route('chat.show', $conv['conversation_id']) }}"
                           class="conversation-item d-flex align-items-center p-3 text-decoration-none {{ request()->route('conversationId') === $conv['conversation_id'] ? 'active' : '' }}">

                            <!-- Avatar -->
                            <div class="position-relative me-3">
                                <img src="{{ $conv['other_user']->photo_profil ? asset('storage/' . $conv['other_user']->photo_profil) : asset('images/default-avatar.jpg') }}"
                                     class="rounded-circle"
                                     width="50"
                                     height="50"
                                     style="object-fit: cover;"
                                     alt="{{ $conv['other_user']->prenom }}">

                                @if($conv['other_user']->isOnline())
                                <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"></span>
                                @endif
                            </div>

                            <!-- Info conversation -->
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
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newChatModal">
                                <i class="fas fa-plus me-1"></i>Démarrer un chat
                            </button>
                        </div>
                    @endforelse
                </div>

                <!-- Bouton nouveau chat -->
                <div class="p-3 border-top bg-white">
                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#newChatModal">
                        <i class="fas fa-plus me-2"></i>Nouvelle conversation
                    </button>
                </div>
            </div>
        </div>

        <!-- Zone de message vide -->
        <div class="col-md-8 col-lg-9 d-flex align-items-center justify-content-center bg-light">
            <div class="text-center">
                <i class="fas fa-comments fa-5x text-muted mb-4"></i>
                <h4 class="text-muted">Sélectionnez une conversation</h4>
                <p class="text-muted">Choisissez une conversation dans la liste ou démarrez-en une nouvelle</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal nouvelle conversation -->
<div class="modal fade" id="newChatModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle conversation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Choisir un destinataire</label>
                    <input type="text" class="form-control mb-2" id="searchUsers" placeholder="Rechercher un utilisateur...">
                    <div id="usersList" style="max-height: 300px; overflow-y: auto;">
                        @foreach($users ?? [] as $user)
                        <a href="{{ route('chat.new', $user->id) }}"
                           class="d-flex align-items-center p-2 text-decoration-none text-dark hover-bg-light rounded">
                            <img src="{{ $user->photo_profil ? asset('storage/' . $user->photo_profil) : asset('images/default-avatar.jpg') }}"
                                 class="rounded-circle me-2"
                                 width="40"
                                 height="40">
                            <div>
                                <div class="fw-semibold">{{ $user->prenom }} {{ $user->nom }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
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

.hover-bg-light:hover {
    background-color: #f8f9fa;
}

.min-width-0 {
    min-width: 0;
}
</style>

<script>
// Recherche dans les conversations
document.getElementById('searchConversations')?.addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.conversation-item').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(search) ? 'flex' : 'none';
    });
});

// Recherche d'utilisateurs dans le modal
document.getElementById('searchUsers')?.addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('#usersList a').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(search) ? 'flex' : 'none';
    });
});
</script>
@endsection
