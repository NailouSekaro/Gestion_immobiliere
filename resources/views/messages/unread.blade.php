@extends('messages.layout')

@section('title', 'Messages non lus')

@section('content')
<div class="card shadow-sm animate__animated animate__fadeIn">
    <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">
            <i class="fas fa-envelope me-2 text-primary"></i>Messages non lus
            <span class="badge bg-danger ms-2 pulse">{{ $messages->total() }}</span>
        </h5>
        <div class="d-flex align-items-center">
            <!-- Bouton Marquer tous comme lus -->
            @if($messages->count() > 0)
            <form action="{{ route('messages.mark-unread', $messages) }}" method="POST" class="me-2">
                @csrf
                <button type="submit" class="btn btn-success btn-sm btn-hover"
                        onclick="return confirm('Marquer tous les messages comme lus ?')">
                    <i class="fas fa-check-double me-1"></i> Tout marquer comme lu
                </button>
            </form>
            @endif
            <a href="{{ route('messages.create') }}" class="btn btn-primary btn-sm btn-hover">
                <i class="fas fa-plus me-1"></i> Nouveau
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        @if($messages->count() > 0)
        <div class="message-list" id="unreadMessagesList">
            @foreach($messages as $message)
            <div class="message-item p-3 border-bottom message-entry-unread unread"
                 data-message-id="{{ $message->id }}"
                 onclick="markAsReadAndRedirect('{{ route('messages.mark-read', $message) }}', '{{ route('messages.show', $message) }}')">
                <div class="d-flex align-items-start">
                    <div class="position-relative me-3">
                        <img src="{{ $message->expediteur->photo_profil ? asset('storage/' . $message->expediteur->photo_profil) : asset('images/default-avatar.png') }}"
                             class="rounded-circle message-avatar"
                             alt="{{ $message->expediteur->prenom }}"
                             style="width: 50px; height: 50px; object-fit: cover;">
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">Non lu</span>
                        </span>
                    </div>

                    <div class="message-content flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="message-title mb-0 fw-bold">
                                {{ $message->expediteur->prenom }} {{ $message->expediteur->nom }}
                                <span class="badge bg-secondary ms-2">{{ $message->expediteur->role }}</span>
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
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-paperclip me-1"></i> Pièce jointe
                                </span>
                                @endif
                                <span class="badge bg-warning text-dark ms-2">
                                    <i class="fas fa-clock me-1"></i> Non lu
                                </span>
                            </div>
                            <div class="btn-group message-actions" onclick="event.stopPropagation()">
                                <a href="{{ route('messages.show', $message) }}" class="btn btn-sm btn-outline-primary btn-hover"
                                   onclick="event.preventDefault(); markAsReadAndRedirect('{{ route('messages.mark-read', $message) }}', '{{ route('messages.show', $message) }}')">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('messages.reply', $message) }}" class="btn btn-sm btn-outline-success btn-hover">
                                    <i class="fas fa-reply"></i>
                                </a>
                                <form action="{{ route('messages.destroy', $message) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-hover"
                                            onclick="event.stopPropagation(); return confirm('Supprimer ce message ?')">
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
        <div class="text-center py-5 animate__animated animate__bounceIn">
            <div class="success-animation mb-3">
                <i class="fas fa-check-circle fa-4x text-success"></i>
                <div class="success-circle"></div>
            </div>
            <h5 class="text-success fw-bold">Félicitations !</h5>
            <p class="text-muted">Vous n'avez aucun message non lu.</p>
            <div class="mt-3">
                <a href="{{ route('messages.index') }}" class="btn btn-primary btn-hover me-2">
                    <i class="fas fa-inbox me-1"></i> Boîte de réception
                </a>
                <a href="{{ route('messages.create') }}" class="btn btn-outline-primary btn-hover">
                    <i class="fas fa-plus me-1"></i> Nouveau message
                </a>
            </div>
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
    background-color: #e8f4ff;
    border-left: 4px solid #0d6efd !important;
}
.message-item:hover {
    background-color: #d1e7ff;
    transform: translateX(8px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
}
.message-preview {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.message-actions {
    opacity: 0.7;
    transition: opacity 0.3s ease;
}
.message-item:hover .message-actions {
    opacity: 1;
}
.message-entry-unread {
    animation: pulseEntry 0.6s ease-out;
    animation-fill-mode: both;
}
@keyframes pulseEntry {
    0% {
        opacity: 0;
        transform: translateX(-30px);
        background-color: rgba(13, 110, 253, 0.3);
    }
    50% {
        background-color: rgba(13, 110, 253, 0.1);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
        background-color: #e8f4ff;
    }
}
/* Délai d'animation pour chaque élément */
.message-entry-unread:nth-child(1) { animation-delay: 0.1s; }
.message-entry-unread:nth-child(2) { animation-delay: 0.2s; }
.message-entry-unread:nth-child(3) { animation-delay: 0.3s; }
.message-entry-unread:nth-child(4) { animation-delay: 0.4s; }
.message-entry-unread:nth-child(5) { animation-delay: 0.5s; }
.pulse {
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
.success-animation {
    position: relative;
    display: inline-block;
}
.success-circle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    border: 3px solid #28a745;
    border-radius: 50%;
    animation: successPulse 2s ease-out;
    opacity: 0;
}
@keyframes successPulse {
    0% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 0.7;
    }
    100% {
        transform: translate(-50%, -50%) scale(1.5);
        opacity: 0;
    }
}
.unread-highlight {
    animation: highlightUnread 1.5s ease-in-out;
}
@keyframes highlightUnread {
    0% { background-color: rgba(255, 193, 7, 0.3); }
    100% { background-color: #e8f4ff; }
}
</style>



@endsection

