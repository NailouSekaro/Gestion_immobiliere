{{-- resources/views/layouts/app.blade.php --}}
{{-- Ajouter ceci dans ton layout principal --}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Application')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Custom Chat CSS -->
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">

    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" >
                <i class="fas fa-home me-2"></i>Gestion Loyer
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-1"></i>Accueil
                        </a>
                    </li>

                    <!-- Messages avec dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="messagesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-comments fa-lg"></i>
                            <span class="d-lg-none ms-2">Messages</span>
                            @if (auth()->user()->unread_messages_count > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.65rem;">
                                    {{ auth()->user()->unread_messages_count > 9 ? '9+' : auth()->user()->unread_messages_count }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animate__animated animate__fadeIn"
                            style="min-width: 350px; max-height: 400px; overflow-y: auto;">
                            <li>
                                <h6 class="dropdown-header d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-envelope me-2"></i>Messages</span>
                                    <a href="{{ route('chat.index') }}" class="badge bg-primary text-decoration-none">
                                        Voir tout
                                    </a>
                                </h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            @php
                                $recentConversations = \App\Models\Message::getUserConversations(auth()->id())->take(5);
                            @endphp

                            @forelse($recentConversations as $conv)
                                <li>
                                    <a class="dropdown-item py-2 hover-bg"
                                        href="{{ route('chat.show', $conv['conversation_id']) }}">
                                        <div class="d-flex align-items-start">
                                            <div class="position-relative me-2">
                                                <img src="{{ $conv['other_user']->photo_profil ? asset('storage/' . $conv['other_user']->photo_profil) : asset('images/default-avatar.jpg') }}"
                                                    class="rounded-circle" width="40" height="40"
                                                    style="object-fit: cover;">
                                                @if ($conv['other_user']->isOnline())
                                                    <span
                                                        class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"></span>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 min-width-0">
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <strong class="text-truncate d-block" style="max-width: 180px;">
                                                        {{ $conv['other_user']->prenom }} {{ $conv['other_user']->nom }}
                                                    </strong>
                                                    <small class="text-muted ms-1">
                                                        {{ $conv['last_message']->created_at->diffForHumans(null, true) }}
                                                    </small>
                                                </div>
                                                <p class="mb-0 text-muted small text-truncate">
                                                    @if ($conv['last_message']->expediteur_id === auth()->id())
                                                        <span class="text-primary">Vous:</span>
                                                    @endif
                                                    {{ Str::limit($conv['last_message']->contenu, 40) }}
                                                </p>
                                            </div>
                                            @if ($conv['unread_count'] > 0)
                                                <span class="badge bg-primary rounded-pill ms-2">
                                                    {{ $conv['unread_count'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <div class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 opacity-50"></i>
                                        <p class="mb-0 small">Aucun message</p>
                                        <a href="{{ route('chat.index') }}" class="btn btn-sm btn-primary mt-2">
                                            Démarrer une conversation
                                        </a>
                                    </div>
                                </li>
                            @endforelse

                            @if ($recentConversations->count() > 0)
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-center text-primary fw-semibold"
                                        href="{{ route('chat.index') }}">
                                        <i class="fas fa-comments me-2"></i>Ouvrir la messagerie
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <!-- Profil -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->photo_profil ? asset('storage/' . auth()->user()->photo_profil) : asset('images/default-avatar.jpg') }}"
                                class="rounded-circle me-1" width="30" height="30" style="object-fit: cover;">
                            {{ auth()->user()->prenom }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Mon profil</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>

                                    <a href="{{ route('logout') }}" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </a>

                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Messages Flash -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3 animate__animated animate__fadeInDown"
            role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3 animate__animated animate__fadeInDown"
            role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Contenu principal -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bouton flottant pour le chat (visible partout sauf sur les pages de chat) -->
    @if (!request()->routeIs('chat.*'))
        <div class="chat-fab-button">
            <a href="{{ route('chat.index') }}" class="btn btn-primary rounded-circle shadow-lg position-fixed"
                style="bottom: 30px; right: 30px; width: 60px; height: 60px; z-index: 1040;" title="Messagerie">
                <i class="fas fa-comments" style="font-size: 24px;"></i>
                @if (auth()->user()->unread_messages_count > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ auth()->user()->unread_messages_count > 9 ? '9+' : auth()->user()->unread_messages_count }}
                    </span>
                @endif
            </a>
        </div>
    @endif

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <div class="container">
            {{-- <p class="mb-0 text-muted">&copy; {{ date('Y') }} Mon Application. Tous droits réservés.</p> --}}
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Script pour mettre à jour le compteur de messages -->
    <script>
        // Mettre à jour le compteur de messages non lus
        function updateUnreadCount() {
            fetch('/api/unread-messages-count')
                .then(response => response.json())
                .then(data => {
                    const badges = document.querySelectorAll('.badge.bg-danger');
                    badges.forEach(badge => {
                        if (data.count > 0) {
                            badge.textContent = data.count > 9 ? '9+' : data.count;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    });
                })
                .catch(error => console.error('Erreur:', error));
        }

        // Mettre à jour toutes les 30 secondes
        setInterval(updateUnreadCount, 30000);

        // Animation du bouton flottant
        const fabButton = document.querySelector('.chat-fab-button a');
        if (fabButton) {
            fabButton.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1) rotate(5deg)';
            });
            fabButton.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) rotate(0deg)';
            });
        }
    </script>

    @stack('scripts')

    <style>
        .chat-fab-button a {
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-fab-button a:hover {
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4) !important;
        }

        .chat-fab-button .badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                transform: translate(-50%, -50%) scale(1.1);
            }
        }

        .hover-bg:hover {
            background-color: #f8f9fa !important;
        }

        .min-width-0 {
            min-width: 0;
        }

        /* Smooth transitions */
        .dropdown-menu {
            transition: all 0.3s ease;
        }
    </style>
</body>

</html>
