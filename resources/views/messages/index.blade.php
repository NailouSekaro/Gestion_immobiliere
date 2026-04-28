@extends('messages.layout')

@section('title', 'Boîte de réception')

@section('content')
<div class="card shadow-sm animate__animated animate__fadeIn">
    <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0"><i class="fas fa-inbox me-2 text-primary"></i>Boîte de réception</h5>
        <div class="d-flex align-items-center">
            <!-- Filtre des messages -->
            <div class="dropdown me-2">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-1"></i> Filtre
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item filter-option" href="#" data-filter="all">Tous les messages</a></li>
                    <li><a class="dropdown-item filter-option" href="#" data-filter="unread">Non lus</a></li>
                    <li><a class="dropdown-item filter-option" href="#" data-filter="read">Lus</a></li>
                </ul>
            </div>
            <a href="{{ route('messages.create') }}" class="btn btn-primary btn-sm btn-hover">
                <i class="fas fa-plus me-1"></i> Nouveau
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        @if($messages->count() > 0)
        <div class="message-list" id="messageList">
            @foreach($messages as $message)
            <div class="message-item p-3 border-bottom message-entry {{ !$message->lu ? 'unread' : 'read' }}"
                 data-message-id="{{ $message->id }}" data-read-status="{{ !$message->lu ? 'unread' : 'read' }}">
                <div class="d-flex align-items-start">
                    <img src="{{ $message->expediteur->photo_profil ? asset('storage/' . $message->expediteur->photo_profil) : asset('images/default-avatar.jpg') }}"
                         class="rounded-circle message-avatar me-3" alt="{{ $message->expediteur->prenom }}"
                         style="width: 50px; height: 50px; object-fit: cover;">

                    <div class="message-content flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="message-title mb-0 fw-medium">
                                {{ $message->expediteur->prenom }} {{ $message->expediteur->nom }}
                                <span class="badge bg-secondary ms-2">{{ $message->expediteur->role }}</span>
                                @if(!$message->lu)
                                <span class="badge bg-primary ms-2">Nouveau</span>
                                @endif
                            </h6>
                            <small class="message-time text-muted">{{ $message->created_at->diffForHumans() }}</small>
                        </div>

                        @if($message->sujet)
                        <h6 class="text-primary mb-1 fw-medium">{{ $message->sujet }}</h6>
                        @endif

                        <p class="text-muted mb-2 message-preview">{{ Str::limit($message->contenu, 150) }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($message->piece_jointe)
                                <span class="message-attachment badge bg-light text-dark">
                                    <i class="fas fa-paperclip me-1"></i> Pièce jointe
                                </span>
                                @endif
                            </div>
                            <div class="btn-group message-actions">
                                <a href="{{ route('messages.show', $message) }}" class="btn btn-sm btn-outline-primary btn-hover">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('messages.reply', $message) }}" class="btn btn-sm btn-outline-success btn-hover">
                                    <i class="fas fa-reply"></i>
                                </a>
                                <form action="{{ route('messages.destroy', $message) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-hover"
                                            onclick="return confirm('Supprimer ce message ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5 animate__animated animate__fadeIn">
            <i class="fas fa-envelope-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Aucun message</h5>
            <p class="text-muted">Votre boîte de réception est vide.</p>
            <a href="{{ route('messages.create') }}" class="btn btn-primary btn-hover">
                <i class="fas fa-plus me-1"></i> Écrire un message
            </a>
        </div>
        @endif
    </div>

    @if($messages->hasPages())
    <div class="card-footer">
        {{ $messages->links() }}
    </div>
    @endif
</div>

<style>
.message-item {
    transition: all 0.3s ease;
    cursor: pointer;
    background-color: #fff;
}
.message-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}
.message-item.unread {
    background-color: #e8f4ff;
    border-left: 4px solid #0d6efd !important;
}
.message-item.unread:hover {
    background-color: #d1e7ff;
}
.message-actions {
    opacity: 0.6;
    transition: opacity 0.3s ease;
}
.message-item:hover .message-actions {
    opacity: 1;
}
.message-preview {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.message-entry {
    animation: slideInRight 0.5s ease-out;
    animation-fill-mode: both;
}
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
/* Délai d'animation pour chaque élément */
.message-entry:nth-child(1) { animation-delay: 0.1s; }
.message-entry:nth-child(2) { animation-delay: 0.2s; }
.message-entry:nth-child(3) { animation-delay: 0.3s; }
.message-entry:nth-child(4) { animation-delay: 0.4s; }
.message-entry:nth-child(5) { animation-delay: 0.5s; }
</style>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtrage des messages
    const filterOptions = document.querySelectorAll('.filter-option');
    const messageItems = document.querySelectorAll('.message-item');

    filterOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const filter = this.getAttribute('data-filter');

            messageItems.forEach(item => {
                const readStatus = item.getAttribute('data-read-status');

                if (filter === 'all' || filter === readStatus) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateX(0)';
                    }, 50);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });

            // Mettre à jour le texte du dropdown
            document.getElementById('filterDropdown').querySelector('span').textContent = this.textContent;
        });
    });

    // Cliquer sur toute la ligne pour voir le message
    messageItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Ne pas déclencher si on clique sur les boutons d'action
            if (!e.target.closest('.btn-group')) {
                const messageId = this.getAttribute('data-message-id');
                window.location.href = "{{ route('messages.show', '') }}/" + messageId;
            }
        });
    });

    // Marquer comme lu quand on passe la souris dessus (optionnel)
    messageItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            if (this.classList.contains('unread')) {
                this.style.backgroundColor = '#d1e7ff';
            }
        });
        item.addEventListener('mouseleave', function() {
            if (this.classList.contains('unread')) {
                this.style.backgroundColor = '#e8f4ff';
            }
        });
    });
});
</script>
@endsection
@endsection
