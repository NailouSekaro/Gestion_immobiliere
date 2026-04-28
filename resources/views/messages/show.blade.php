@extends('messages.layout')

@section('title', $message->sujet ?: 'Message sans sujet')

@section('content')
    <div class="card shadow-sm animate__animated animate__fadeIn">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">
                <i class="fas fa-envelope me-2 text-primary"></i>
                {{ $message->sujet ?: 'Sans sujet' }}
            </h5>
            <div class="btn-group">
                <a href="{{ route('messages.reply', $message) }}" class="btn btn-success btn-sm btn-hover">
                    <i class="fas fa-reply me-1"></i> Répondre
                </a>
                <form action="{{ route('messages.destroy', $message) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm btn-hover"
                        onclick="return confirm('Supprimer définitivement ce message ?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <!-- En-tête du message avec animation -->
            <div class="message-header border-bottom pb-3 mb-3 animate__animated animate__fadeInDown">
                <div class="d-flex align-items-center mb-3">
                    <div class="position-relative me-3">
                        <img src="{{ $message->expediteur->photo_profil ? asset('storage/' . $message->expediteur->photo_profil) : asset('images/default-avatar.jpg') }}"
                            class="rounded-circle shadow-sm message-avatar" width="70" height="70"
                            alt="{{ $message->expediteur->prenom }}" style="object-fit: cover;">
                        @if ($message->expediteur->isOnline())
                            <span
                                class="position-absolute bottom-0 end-0 p-1 bg-success border border-3 border-white rounded-circle">
                                <span class="visually-hidden">En ligne</span>
                            </span>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">{{ $message->expediteur->prenom }} {{ $message->expediteur->nom }}</h6>
                        <span class="badge bg-primary">{{ $message->expediteur->role }}</span>
                        <div class="text-muted small mt-1">
                            <i class="fas fa-envelope me-1"></i>{{ $message->expediteur->email }}
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted">
                        <i class="fas fa-paper-plane me-1"></i>
                        Envoyé le {{ $message->created_at->format('d/m/Y à H:i') }}
                    </div>
                    @if ($message->lu && $message->lu_at)
                        <div class="text-success fw-medium">
                            <i class="fas fa-check-double me-1"></i>
                            Lu le {{ $message->lu_at->format('d/m/Y à H:i') }}
                        </div>
                    @else
                        <div class="text-warning fw-medium">
                            <i class="fas fa-clock me-1"></i>
                            Non lu
                        </div>
                    @endif

                </div>
            </div>

            <!-- Pièce jointe avec animation -->
            @if ($message->piece_jointe)
                <div class="alert alert-info d-flex align-items-center animate__animated animate__fadeInLeft mb-4">
                    <i class="fas fa-paperclip fa-2x me-3 text-primary"></i>
                    <div class="flex-grow-1">
                        <strong class="d-block mb-1">Pièce jointe</strong>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <span class="file-name">{{ basename($message->piece_jointe) }}</span>
                            <a href="{{ asset('storage/' . $message->piece_jointe) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm btn-hover ms-2" download>
                                <i class="fas fa-download me-1"></i> Télécharger
                            </a>
                            <span class="badge bg-light text-dark ms-2">
                                <i class="fas fa-info-circle me-1"></i>
                                {{ round(filesize(storage_path('app/public/' . $message->piece_jointe)) / 1024) }} KB
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contenu du message avec animation -->
            <div class="message-content mb-4 animate__animated animate__fadeInUp">
                <div class="message-body bg-light p-4 rounded-3 shadow-sm">
                    <div class="message-text" style="line-height: 1.6; white-space: pre-wrap;">
                        {{ $message->contenu }}
                    </div>
                </div>
            </div>

            <!-- Métadonnées optionnelles -->
            @if ($message->replyTo || $message->forwarded_from)
                <div class="message-metadata border-top pt-3 mt-4">
                    <h6 class="text-muted mb-2"><i class="fas fa-info-circle me-2"></i>Informations</h6>
                    <div class="small text-muted">
                        @if ($message->replyTo && $message->replyTo->expediteur)
                            Réponse à un message de {{ $message->replyTo->expediteur->prenom }}
                        @endif

                        @if ($message->forwarded_from)
                            <div>
                                <i class="fas fa-share me-1"></i>
                                Transféré par {{ $message->forwarded_from }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Actions avec animation -->
            <div class="border-top pt-4 mt-4 animate__animated animate__fadeIn">
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <a href="{{ route('messages.reply', $message) }}" class="btn btn-primary btn-hover">
                        <i class="fas fa-reply me-1"></i> Répondre
                    </a>
                    <a href="{{ route('messages.create') }}" class="btn btn-outline-primary btn-hover">
                        <i class="fas fa-edit me-1"></i> Nouveau message
                    </a>
                    <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary btn-hover">
                        <i class="fas fa-inbox me-1"></i> Boîte de réception
                    </a>
                    <button class="btn btn-outline-info btn-hover" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Imprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .message-avatar {
            transition: transform 0.3s ease;
        }

        .message-avatar:hover {
            transform: scale(1.1);
        }

        .message-body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 4px solid #0d6efd;
        }

        .message-text {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1.05rem;
        }

        .file-name {
            font-family: 'Courier New', monospace;
            background: rgba(0, 0, 0, 0.05);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Animation pour le contenu du message */
        @keyframes highlight {
            0% {
                background-color: rgba(13, 110, 253, 0.1);
            }

            100% {
                background-color: transparent;
            }
        }

        .message-body {
            animation: highlight 2s ease;
        }
    </style>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation de surbrillance pour le message
            const messageBody = document.querySelector('.message-body');
            messageBody.style.animation = 'none';
            setTimeout(() => {
                messageBody.style.animation = 'highlight 2s ease';
            }, 100);

            // Confirmation avant suppression
            const deleteForm = document.querySelector('form[method="POST"]');
            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    if (!confirm(
                            'Êtes-vous sûr de vouloir supprimer définitivement ce message ? Cette action est irréversible.'
                        )) {
                        e.preventDefault();
                    }
                });
            }

            // Tooltip pour les badges
            const badges = document.querySelectorAll('.badge');
            badges.forEach(badge => {
                badge.setAttribute('title', badge.textContent.trim());
                new bootstrap.Tooltip(badge);
            });

            // Copier l'adresse email
            const emailElement = document.querySelector('.text-muted.small');
            if (emailElement) {
                emailElement.style.cursor = 'pointer';
                emailElement.title = 'Cliquer pour copier l\'email';
                emailElement.addEventListener('click', function() {
                    const email = this.textContent.trim();
                    navigator.clipboard.writeText(email).then(() => {
                        const originalText = this.innerHTML;
                        this.innerHTML =
                            '<i class="fas fa-check me-1 text-success"></i>Email copié !';
                        setTimeout(() => {
                            this.innerHTML = originalText;
                        }, 2000);
                    });
                });
            }
        });
    </script>
@endsection
@endsection
