@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card user-detail-card animate__animated animate__fadeIn">
                    <div class="card-header user-detail-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-user-circle me-2"></i>Détails de l'Utilisateur
                                </h4>
                                <p class="mb-0 mt-1 opacity-75">Informations complètes du profil</p>
                            </div>
                            <div class="btn-group">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-action">
                                    <i class="fas fa-edit me-1"></i> Modifier
                                </a>
                                <a href="{{ route('users.index') }}" class="btn btn-light btn-action">
                                    <i class="fas fa-arrow-left me-1"></i> Retour
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Colonne Photo et Informations Principales -->
                            <div class="col-md-4 text-center">
                                <div class="user-profile-section animate__animated animate__fadeInLeft">
                                    <div class="profile-image-container">
                                        <img src="{{ $user->photo_profil ? asset('storage/' . $user->photo_profil) : asset('images/default-avatar.jpg') }}"
                                            alt="{{ $user->prenom }} {{ $user->nom }}"
                                            class="profile-image rounded-circle">
                                        <div class="profile-status {{ $user->est_actif ? 'status-active' : 'status-inactive' }}"
                                            data-bs-toggle="tooltip"
                                            title="{{ $user->est_actif ? 'Compte actif' : 'Compte inactif' }}">
                                        </div>
                                    </div>

                                    <h3 class="user-name mt-3">{{ $user->prenom }} {{ $user->nom }}</h3>

                                    @php
                                        $roleColors = [
                                            'admin' => 'danger',
                                            'locataire' => 'success',
                                            'prestataire' => 'warning',
                                        ];

                                        $roleIcons = [
                                            'admin' => 'crown',
                                            'locataire' => 'home',
                                            'prestataire' => 'tools',
                                        ];
                                    @endphp

                                    <div class="role-badge bg-{{ $roleColors[$user->role] }}">
                                        <i class="fas fa-{{ $roleIcons[$user->role] }} me-1"></i>
                                        {{ ucfirst($user->role) }}
                                        @if ($user->specialite)
                                            - {{ ucfirst($user->specialite) }}
                                        @endif
                                    </div>

                                    <div class="status-badges mt-3">
                                        <span
                                            class="badge bg-{{ $user->est_actif ? 'success' : 'secondary' }} status-badge">
                                            <i class="fas fa-{{ $user->est_actif ? 'check' : 'times' }} me-1"></i>
                                            {{ $user->est_actif ? 'Actif' : 'Inactif' }}
                                        </span>
                                        @if ($user->email_verifie_le)
                                            <span class="badge bg-success status-badge mt-2">
                                                <i class="fas fa-check-circle me-1"></i> Email vérifié
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Colonne Informations Détaillées -->
                            <div class="col-md-8">
                                <div class="row">
                                    <!-- Informations Personnelles -->
                                    <div class="col-md-6 mb-4">
                                        <div class="info-card card h-100 animate__animated animate__fadeIn animate-delay-1">
                                            <div class="card-header info-card-header">
                                                <i class="fas fa-id-card me-2"></i>Informations Personnelles
                                            </div>
                                            <div class="card-body">
                                                <div class="info-item">
                                                    <div class="info-icon">
                                                        <i class="fas fa-envelope text-primary"></i>
                                                    </div>
                                                    <div class="info-content">
                                                        <strong>Email</strong>
                                                        <p>{{ $user->email }}</p>
                                                    </div>
                                                </div>

                                                <div class="info-item">
                                                    <div class="info-icon">
                                                        <i class="fas fa-phone text-primary"></i>
                                                    </div>
                                                    <div class="info-content">
                                                        <strong>Téléphone</strong>
                                                        <p>{{ $user->telephone ?? 'Non renseigné' }}</p>
                                                    </div>
                                                </div>

                                                <div class="info-item">
                                                    <div class="info-icon">
                                                        <i class="fas fa-calendar text-primary"></i>
                                                    </div>
                                                    <div class="info-content">
                                                        <strong>Créé le</strong>
                                                        <p>{{ optional($user->created_at)->format('d/m/Y H:i') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Informations de Sécurité -->
                                    <div class="col-md-6 mb-4">
                                        <div class="info-card card h-100 animate__animated animate__fadeIn animate-delay-2">
                                            <div class="card-header info-card-header">
                                                <i class="fas fa-shield-alt me-2"></i>Sécurité
                                            </div>
                                            <div class="card-body">
                                                <div class="info-item">
                                                    <div class="info-icon">
                                                        <i class="fas fa-key text-primary"></i>
                                                    </div>
                                                    <div class="info-content">
                                                        <strong>Dernier changement mot de passe</strong>
                                                        <p>{{ optional($user->password_changed_at)->format('d/m/Y H:i') ?? 'Jamais' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="info-item">
                                                    <div class="info-icon">
                                                        <i class="fas fa-sign-in-alt text-primary"></i>
                                                    </div>
                                                    <div class="info-content">
                                                        <strong>Dernière connexion</strong>
                                                        <p>{{ $user->derniere_connexion ? $user->derniere_connexion->format('d/m/Y H:i') : 'Jamais' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="info-item">
                                                    <div class="info-icon">
                                                        <i class="fas fa-lock text-primary"></i>
                                                    </div>
                                                    <div class="info-content">
                                                        <strong>2FA</strong>
                                                        <p>
                                                            <span
                                                                class="badge bg-{{ $user->secret_2fa ? 'success' : 'secondary' }}">
                                                                {{ $user->secret_2fa ? 'Activé' : 'Désactivé' }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informations Prestataire -->
                                @if ($user->role === 'prestataire' && $user->specialite)
                                    <div class="row animate__animated animate__fadeIn animate-delay-3">
                                        <div class="col-12">
                                            <div class="info-card card">
                                                <div class="card-header info-card-header">
                                                    <i class="fas fa-tools me-2"></i>Informations Prestataire
                                                </div>
                                                <div class="card-body">
                                                    <div class="specialty-badge">
                                                        @php
                                                            $specialtyIcons = [
                                                                'plombier' => 'faucet',
                                                                'electricien' => 'bolt',
                                                                'technicien' => 'cogs',
                                                            ];
                                                        @endphp
                                                        <i
                                                            class="fas fa-{{ $specialtyIcons[$user->specialite] ?? 'tools' }} me-2"></i>
                                                        <span>Spécialité: {{ ucfirst($user->specialite) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-blue: #3490dc;
            --secondary-blue: #1a6fc9;
            --light-blue: #e6f0fa;
            --success: #38a169;
            --warning: #ed8936;
            --danger: #e53e3e;
            --transition: all 0.3s ease;
        }

        .user-detail-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: var(--transition);
        }

        .user-detail-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .user-detail-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            border-bottom: none;
            padding: 20px 25px;
        }

        .btn-action {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .user-profile-section {
            padding: 20px;
            background: var(--light-blue);
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .profile-image-container {
            position: relative;
            display: inline-block;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .profile-image:hover {
            transform: scale(1.05);
        }

        .profile-status {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .status-active {
            background-color: var(--success);
        }

        .status-inactive {
            background-color: #a0aec0;
        }

        .user-name {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 15px;
        }

        .role-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
        }

        .info-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .info-card-header {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #2d3748;
            padding: 15px 20px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            transition: var(--transition);
        }

        .info-item:hover {
            background-color: #f7fafc;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: var(--light-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-content strong {
            color: #4a5568;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 5px;
        }

        .info-content p {
            color: #2d3748;
            margin-bottom: 0;
            font-weight: 500;
        }

        .specialty-badge {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            border-radius: 25px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(52, 144, 220, 0.3);
        }

        /* Animations */
        .animate-delay-1 {
            animation-delay: 0.2s;
        }

        .animate-delay-2 {
            animation-delay: 0.4s;
        }

        .animate-delay-3 {
            animation-delay: 0.6s;
        }

        @media (max-width: 768px) {
            .user-detail-header .d-flex {
                flex-direction: column;
                gap: 15px;
            }

            .btn-group {
                width: 100%;
            }

            .btn-action {
                flex: 1;
            }

            .info-item {
                flex-direction: column;
                text-align: center;
            }

            .info-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les tooltips Bootstrap
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Animation des éléments
            const animateElements = document.querySelectorAll('.animate__animated');
            animateElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
@endsection
