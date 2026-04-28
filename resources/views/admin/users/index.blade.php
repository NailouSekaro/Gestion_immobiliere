@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card user-management-card animate__animated animate__fadeIn">
                    <div class="card-header user-management-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-users me-2"></i>Gestion des Utilisateurs
                                </h4>
                                <p class="mb-0 mt-1 opacity-75">Administration complète des comptes utilisateurs</p>
                            </div>
                            <a href="{{ route('users.create') }}" class="btn btn-light btn-create-user">
                                <i class="fas fa-plus me-1"></i> Nouvel Utilisateur
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div
                                style="background: #28a745; color: #fff; padding: 12px; border-radius: 8px; margin: 10px 0; font-weight: bold;">
                                ✅ {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-container">
                            <table class="table user-management-table">
                                <thead class="table-header">
                                    <tr>
                                        <th class="user-column">
                                            <i class="fas fa-user me-1"></i> Utilisateur
                                        </th>
                                        <th class="email-column">
                                            <i class="fas fa-envelope me-1"></i> Email
                                        </th>
                                        <th class="phone-column">
                                            <i class="fas fa-phone me-1"></i> Téléphone
                                        </th>
                                        <th class="role-column">
                                            <i class="fas fa-shield-alt me-1"></i> Rôle
                                        </th>

                                        <th class="role-column">
                                            <i class="fas fa-shield-alt me-1"></i> Spécialité
                                        </th>

                                        <th class="status-column">
                                            <i class="fas fa-circle me-1"></i> Statut
                                        </th>
                                        <th class="actions-column">
                                            <i class="fas fa-cogs me-1"></i> Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr
                                            class="user-row {{ $user->trashed() ? 'archived' : '' }} animate__animated animate__fadeInUp">
                                            <td class="user-info-cell">
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar-container">
                                                        <img src="{{ $user->photo_profil ? asset('storage/' . $user->photo_profil) : asset('images/default-avatar.jpg') }}"
                                                            alt="{{ $user->prenom }} {{ $user->nom }}"
                                                            class="user-avatar rounded-circle">
                                                        @if ($user->trashed())
                                                            <span class="archived-badge" data-bs-toggle="tooltip"
                                                                title="Utilisateur archivé">
                                                                <i class="fas fa-archive"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="user-details">
                                                        <strong class="user-name">{{ $user->prenom }}
                                                            {{ $user->nom }}</strong>
                                                        <small class="user-id">ID: {{ $user->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="email-cell">
                                                <div class="email-content">
                                                    <i class="fas fa-envelope text-muted me-2"></i>
                                                    <a href="mailto:{{ $user->email }}"
                                                        class="email-link">{{ $user->email }}</a>
                                                </div>
                                            </td>
                                            <td class="phone-cell">
                                                <div class="phone-content">
                                                    <i class="fas fa-phone text-muted me-2"></i>
                                                    <span class="phone-number">{{ $user->telephone ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td class="role-cell">
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
                                                <span class="role-badge bg-{{ $roleColors[$user->role] }}">
                                                    <i class="fas fa-{{ $roleIcons[$user->role] }} me-1"></i>
                                                    {{ ucfirst($user->role) }}
                                                    @if ($user->specialite)
                                                        {{-- - {{ ucfirst($user->specialite) }} --}}
                                                    @endif
                                                </span>
                                            </td>

                                            <td class="status-cell">
                                                <span
                                                    class="status-badge bg-warning">{{ $user->specialite ?? 'N/A' }}</span>

                                            </td>

                                            <td class="status-cell">
                                                <div class="status-indicator">
                                                    <span
                                                        class="status-badge bg-{{ $user->est_actif ? 'success' : 'secondary' }}">
                                                        <i
                                                            class="fas fa-{{ $user->est_actif ? 'check' : 'times' }} me-1"></i>
                                                        {{ $user->est_actif ? 'Actif' : 'Inactif' }}
                                                    </span>
                                                    @if ($user->email_verifie_le)
                                                        <span class="verification-badge" data-bs-toggle="tooltip"
                                                            title="Email vérifié">
                                                            <i class="fas fa-check-circle text-success"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="actions-cell">
                                                <div class="btn-group action-buttons" role="group">
                                                    @if ($user->trashed())
                                                        <form action="{{ route('users.restore', $user->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-action"
                                                                title="Restaurer l'utilisateur">
                                                                <i class="fas fa-undo"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('users.force-delete', $user->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-action"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet utilisateur ?')"
                                                                title="Supprimer définitivement">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('users.show', $user) }}"
                                                            class="btn btn-info btn-action" title="Voir les détails">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('users.edit', $user) }}"
                                                            class="btn btn-warning btn-action"
                                                            title="Modifier l'utilisateur">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-action"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir archiver cet utilisateur ?')"
                                                                title="Archiver l'utilisateur">
                                                                <i class="fas fa-archive"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="no-users-row">
                                            <td colspan="6" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-users fa-4x mb-3 text-muted"></i>
                                                    <h5 class="text-muted">Aucun utilisateur trouvé</h5>
                                                    <p class="text-muted">Commencez par créer votre premier utilisateur</p>
                                                    <a href="{{ route('users.create') }}" class="btn btn-primary mt-2">
                                                        <i class="fas fa-plus me-2"></i>Créer un utilisateur
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- @if ($users->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            {{ $users->links() }}
                        </nav>
                    </div>
                    @endif --}}
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

        .user-management-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: var(--transition);
        }

        .user-management-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .user-management-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            border-bottom: none;
            padding: 20px 25px;
        }

        .btn-create-user {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-create-user:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: white;
        }

        .alert-premium {
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--success), #2f855a);
            color: white;
            box-shadow: 0 4px 15px rgba(56, 161, 105, 0.3);
        }

        .table-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .user-management-table {
            margin-bottom: 0;
        }

        .table-header {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        }

        .table-header th {
            border: none;
            padding: 15px 20px;
            font-weight: 600;
            color: #2d3748;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .user-row {
            transition: var(--transition);
            border-bottom: 1px solid #e2e8f0;
        }

        .user-row:hover {
            background-color: #f7fafc;
            transform: translateY(-1px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .user-row.archived {
            background-color: #fed7d7;
        }

        .user-row.archived:hover {
            background-color: #feb2b2;
        }

        .user-info-cell {
            padding: 15px 20px;
        }

        .user-avatar-container {
            position: relative;
            margin-right: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .user-row:hover .user-avatar {
            transform: scale(1.1);
        }

        .archived-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        .user-details {
            line-height: 1.3;
        }

        .user-name {
            color: #2d3748;
            font-weight: 600;
        }

        .user-id {
            color: #718096;
            font-size: 0.8rem;
        }

        .email-cell,
        .phone-cell,
        .role-cell,
        .status-cell,
        .actions-cell {
            padding: 15px 20px;
            vertical-align: middle;
        }

        .email-content,
        .phone-content {
            display: flex;
            align-items: center;
        }

        .email-link {
            color: #4a5568;
            text-decoration: none;
            transition: var(--transition);
        }

        .email-link:hover {
            color: var(--primary-blue);
            text-decoration: underline;
        }

        .phone-number {
            color: #4a5568;
        }

        .role-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .verification-badge {
            font-size: 1.1rem;
        }

        .actions-cell {
            min-width: 160px;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .no-users-row {
            background: #f8fafc;
        }

        .empty-state {
            padding: 40px 20px;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 8px;
            margin: 0 3px;
            border: 1px solid #e2e8f0;
            color: var(--primary-blue);
            transition: var(--transition);
        }

        .page-link:hover {
            background: var(--light-blue);
            border-color: var(--primary-blue);
        }

        .page-item.active .page-link {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        @media (max-width: 992px) {
            .table-responsive {
                overflow-x: auto;
            }

            .user-management-table {
                min-width: 800px;
            }

            .email-column,
            .phone-column {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .user-management-header {
                padding: 15px;
            }

            .btn-create-user {
                padding: 8px 15px;
                font-size: 0.9rem;
            }

            .role-column {
                display: none;
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

            // Animation des lignes du tableau
            const userRows = document.querySelectorAll('.user-row');
            userRows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
            });
        });
    </script>
@endsection
