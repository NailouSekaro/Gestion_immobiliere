@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <!-- En-tête du dashboard -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-1">Tableau de bord</h2>
                <p class="text-muted">Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
            </div>
        </div>

        <!-- Cartes statistiques -->
        <div class="row g-4 mb-4">
            <!-- Card Messages -->
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 hover-lift h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted mb-0">Messages</h6>
                                <h2 class="mb-0 mt-2">{{ auth()->user()->unread_messages_count }}</h2>
                            </div>
                            <div class="p-3 bg-primary bg-opacity-10 rounded-circle">
                                <i class="fas fa-envelope fa-lg text-primary"></i>
                            </div>
                        </div>
                        <a href="{{ route('chat.index') }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-comments me-2"></i>Voir les messages
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Conversations -->
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 hover-lift h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted mb-0">Conversations</h6>
                                <h2 class="mb-0 mt-2">
                                    {{ \App\Models\Message::getUserConversations(auth()->id())->count() }}
                                </h2>
                            </div>
                            <div class="p-3 bg-success bg-opacity-10 rounded-circle">
                                <i class="fas fa-comments fa-lg text-success"></i>
                            </div>
                        </div>
                        <a href="{{ route('chat.index') }}" class="btn btn-sm btn-outline-success w-100">
                            <i class="fas fa-list me-2"></i>Voir tout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Autres statistiques... -->
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 hover-lift h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted mb-0">Exemple Stat</h6>
                                <h2 class="mb-0 mt-2">0</h2>
                            </div>
                            <div class="p-3 bg-info bg-opacity-10 rounded-circle">
                                <i class="fas fa-chart-line fa-lg text-info"></i>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-info w-100" disabled>
                            Bientôt disponible
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 hover-lift h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted mb-0">Exemple Stat 2</h6>
                                <h2 class="mb-0 mt-2">0</h2>
                            </div>
                            <div class="p-3 bg-warning bg-opacity-10 rounded-circle">
                                <i class="fas fa-star fa-lg text-warning"></i>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-warning w-100" disabled>
                            Bientôt disponible
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Conversations récentes (Colonne gauche) -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-comments text-primary me-2"></i>Conversations récentes
                        </h5>
                        <a href="{{ route('chat.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>Nouvelle conversation
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @php
                            $conversations = \App\Models\Message::getUserConversations(auth()->id())->take(5);
                        @endphp

                        @forelse($conversations as $conv)
                            <a href="{{ route('chat.show', $conv['conversation_id']) }}"
                                class="d-flex align-items-center p-3 border-bottom text-decoration-none hover-bg">
                                <div class="position-relative me-3">
                                    <img src="{{ $conv['other_user']->photo_profil ? asset('storage/' . $conv['other_user']->photo_profil) : asset('images/default-avatar.jpg') }}"
                                        class="rounded-circle" width="55" height="55" style="object-fit: cover;">
                                    @if ($conv['other_user']->isOnline())
                                        <span
                                            class="position-absolute bottom-0 end-0 p-2 bg-success border border-3 border-white rounded-circle"></span>
                                    @endif
                                </div>

                                <div class="flex-grow-1 min-width-0">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0 fw-semibold text-dark">
                                            {{ $conv['other_user']->prenom }} {{ $conv['other_user']->nom }}
                                        </h6>
                                        <small class="text-muted ms-2">
                                            {{ $conv['last_message']->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 text-muted text-truncate" style="max-width: 400px;">
                                            @if ($conv['last_message']->expediteur_id === auth()->id())
                                                <span class="text-primary fw-medium">Vous:</span>
                                            @endif
                                            {{ $conv['last_message']->contenu }}
                                        </p>

                                        @if ($conv['unread_count'] > 0)
                                            <span class="badge bg-primary rounded-pill ms-2">
                                                {{ $conv['unread_count'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <i class="fas fa-chevron-right text-muted ms-3"></i>
                            </a>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-comments fa-4x text-muted mb-3 opacity-50"></i>
                                <h5 class="text-muted">Aucune conversation</h5>
                                <p class="text-muted mb-4">Commencez à discuter avec d'autres utilisateurs</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newChatModal">
                                    <i class="fas fa-plus me-2"></i>Démarrer une conversation
                                </button>
                            </div>
                        @endforelse

                        @if ($conversations->count() > 0)
                            <a href="{{ route('chat.index') }}"
                                class="d-block text-center p-3 text-primary text-decoration-none border-top fw-semibold">
                                <i class="fas fa-comments me-2"></i>Voir toutes les conversations
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar droite - Utilisateurs en ligne -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-users text-success me-2"></i>Utilisateurs en ligne
                        </h5>
                    </div>
                    <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                        @php
                            $onlineUsers = \App\Models\User::where('id', '!=', auth()->id())
                                ->where('est_actif', true)
                                ->get()
                                ->filter(fn($u) => $u->isOnline())
                                ->take(10);
                        @endphp

                        @forelse($onlineUsers as $user)
                            <div class="d-flex align-items-center p-3 border-bottom hover-bg">
                                <div class="position-relative me-3">
                                    <img src="{{ $user->photo_profil ? asset('storage/' . $user->photo_profil) : asset('images/default-avatar.jpg') }}"
                                        class="rounded-circle" width="45" height="45" style="object-fit: cover;">
                                    <span
                                        class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"></span>
                                </div>

                                <div class="flex-grow-1 min-width-0">
                                    <h6 class="mb-0 text-dark">{{ $user->prenom }} {{ $user->nom }}</h6>
                                    <small class="text-muted">{{ $user->role }}</small>
                                </div>

                                <a href="{{ route('chat.new', $user->id) }}" class="btn btn-sm btn-outline-primary"
                                    title="Envoyer un message">
                                    <i class="fas fa-comment"></i>
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-user-slash fa-2x mb-2 opacity-50"></i>
                                <p class="mb-0 small">Aucun utilisateur en ligne</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Accès rapide -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt text-warning me-2"></i>Accès rapide
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('chat.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-inbox me-2"></i>Boîte de réception
                            </a>
                            <button class="btn btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#newChatModal">
                                <i class="fas fa-plus me-2"></i>Nouvelle conversation
                            </button>
                            <a href="{{ route('messages.sent') }}" class="btn btn-outline-info">
                                <i class="fas fa-paper-plane me-2"></i>Messages envoyés
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal nouvelle conversation -->
    <div class="modal fade" id="newChatModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle text-primary me-2"></i>Nouvelle conversation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="searchUsersModal"
                            placeholder="Rechercher un utilisateur...">
                    </div>
                    <div id="usersListModal" style="max-height: 400px; overflow-y: auto;">
                        @php
                            $allUsers = \App\Models\User::where('id', '!=', auth()->id())
                                ->where('est_actif', true)
                                ->orderBy('prenom')
                                ->get();
                        @endphp

                        @foreach ($allUsers as $user)
                            <a href="{{ route('chat.new', $user->id) }}"
                                class="d-flex align-items-center p-2 text-decoration-none text-dark hover-bg rounded mb-1 user-item">
                                <div class="position-relative me-3">
                                    <img src="{{ $user->photo_profil ? asset('storage/' . $user->photo_profil) : asset('images/default-avatar.jpg') }}"
                                        class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    @if ($user->isOnline())
                                        <span
                                            class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"></span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $user->prenom }} {{ $user->nom }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                                <i class="fas fa-comment-alt text-primary"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .hover-bg {
            transition: background-color 0.2s;
        }

        .hover-bg:hover {
            background-color: #f8f9fa;
        }

        .min-width-0 {
            min-width: 0;
        }
    </style>

    @push('scripts')
        <script>
            // Recherche d'utilisateurs dans le modal
            document.getElementById('searchUsersModal')?.addEventListener('input', function(e) {
                const search = e.target.value.toLowerCase();
                document.querySelectorAll('#usersListModal .user-item').forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(search) ? 'flex' : 'none';
                });
            });
        </script>
    @endpush
@endsection
