@extends('messages.layout')

@section('title', 'Messages envoyés')

@section('content')
    <div class="card shadow-sm animate__animated animate__fadeIn">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="fas fa-paper-plane me-2 text-primary"></i>Messages envoyés</h5>

            <!-- Bouton de tri optionnel -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown"
                    data-bs-toggle="dropdown">
                    <i class="fas fa-sort me-1"></i> Trier par
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Plus
                            récent</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}">Plus
                            ancien</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'read']) }}">Messages
                            lus</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'unread']) }}">Messages non
                            lus</a></li>
                </ul>
            </div>
        </div>

        <div class="card-body p-0">
            @if ($messages->count() > 0)
                <div class="message-list" id="sentMessagesList">
                    @foreach ($messages as $message)
                        <div class="message-item p-3 border-bottom message-entry-sent {{ $message->lu ? 'read' : 'unread' }}"
                            data-message-id="{{ $message->id }}" data-read-status="{{ $message->lu ? 'read' : 'unread' }}">
                            <div class="d-flex align-items-start">
                                <div class="position-relative me-3">
                                    <img src="{{ $message->destinataire->photo_profil ? asset('storage/' . $message->destinataire->photo_profil) : asset('images/default-avatar.jpg') }}"
                                        class="rounded-circle message-avatar" alt="{{ $message->destinataire->prenom }}"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                    <!-- Indicateur de statut de lecture -->
                                    @if ($message->lu)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                                            <span class="visually-hidden">Message lu</span>
                                        </span>
                                    @else
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle p-1 bg-secondary border border-light rounded-circle">
                                            <span class="visually-hidden">Message non lu</span>
                                        </span>
                                    @endif
                                </div>

                                <div class="message-content flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0 fw-medium">
                                            À : {{ $message->destinataire->prenom }} {{ $message->destinataire->nom }}
                                            <span class="badge bg-secondary ms-2">{{ $message->destinataire->role }}</span>
                                        </h6>
                                        <small
                                            class="message-time text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                    </div>

                                    @if ($message->sujet)
                                        <h6 class="text-primary mb-1 fw-medium">{{ $message->sujet }}</h6>
                                    @endif

                                    <p class="text-muted mb-2 message-preview">{{ Str::limit($message->contenu, 150) }}</p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if ($message->lu)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i> Lu
                                                    @if ($message->lu_at)
                                                        <small class="ms-1">le
                                                            {{ $message->lu_at->format('d/m/Y H:i') }}</small>
                                                    @endif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-clock me-1"></i> En attente
                                                </span>
                                            @endif

                                            @if ($message->piece_jointe)
                                                <span class="badge bg-light text-dark ms-2">
                                                    <i class="fas fa-paperclip me-1"></i> Pièce jointe
                                                </span>
                                            @endif
                                        </div>
                                        <div class="message-actions">
                                            <a href="{{ route('messages.show', $message) }}"
                                                class="btn btn-sm btn-outline-primary btn-hover">
                                                <i class="fas fa-eye me-1"></i> Voir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 animate__animated animate__fadeIn">
                    <i class="fas fa-paper-plane fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun message envoyé</h5>
                    <p class="text-muted">Vous n'avez pas encore envoyé de messages.</p>
                    <a href="{{ route('messages.create') }}" class="btn btn-primary btn-hover">
                        <i class="fas fa-plus me-1"></i> Écrire un message
                    </a>
                </div>
            @endif
        </div>

        @if ($messages->hasPages())
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
            border-left: 4px solid #28a745 !important;
        }

        .message-item.read {
            border-left: 4px solid #6c757d !important;
        }

        .message-actions {
            opacity: 0.7;
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

        .message-entry-sent {
            animation: slideInLeft 0.5s ease-out;
            animation-fill-mode: both;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Délai d'animation pour chaque élément */
        .message-entry-sent:nth-child(1) {
            animation-delay: 0.1s;
        }

        .message-entry-sent:nth-child(2) {
            animation-delay: 0.2s;
        }

        .message-entry-sent:nth-child(3) {
            animation-delay: 0.3s;
        }

        .message-entry-sent:nth-child(4) {
            animation-delay: 0.4s;
        }

        .message-entry-sent:nth-child(5) {
            animation-delay: 0.5s;
        }

        .avatar-status {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            border: 2px solid white;
            border-radius: 50%;
        }

        .avatar-status.read {
            background-color: #28a745;
        }

        .avatar-status.unread {
            background-color: #6c757d;
        }
    </style>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cliquer sur toute la ligne pour voir le message
            const messageItems = document.querySelectorAll('.message-item');
            messageItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // Ne pas déclencher si on clique sur le bouton "Voir"
                    if (!e.target.closest('.message-actions')) {
                        const messageId = this.getAttribute('data-message-id');
                        window.location.href = "{{ route('messages.show', '') }}/" + messageId;
                    }
                });
            });

            // Animation au survol pour les badges d'état
            const statusBadges = document.querySelectorAll('.badge');
            statusBadges.forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                    this.style.transition = 'transform 0.2s ease';
                });
                badge.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Optionnel: Auto-refresh pour mettre à jour le statut "lu"
            @if ($messages->where('lu', false)->count() > 0)
                setTimeout(function() {
                    window.location.reload();
                }, 30000); // Refresh toutes les 30 secondes s'il y a des messages non lus
            @endif
        });
    </script>
@endsection
@endsection
