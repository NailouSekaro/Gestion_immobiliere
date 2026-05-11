@extends('layouts.template')

@section('title', 'Tableau de Bord')

@section('content')
    <style>
        :root {
            --brand-primary: #667eea;
            --brand-secondary: #764ba2;
            --brand-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --surface-hover: #f0f4ff;
            --border: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.04);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.08), 0 4px 8px rgba(0,0,0,0.04);
            --transition: all 0.25s ease;
        }

        .dashboard-page {
            padding: 1.75rem 2rem;
            max-width: 1400px;
            font-family: 'Poppins', sans-serif;
        }

        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 320px;
            height: 320px;
            background: rgba(255,255,255,0.12);
            border-radius: 50%;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 1.75rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 58px;
            height: 58px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .action-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            transition: var(--transition);
            height: 100%;
        }

        .action-card:hover {
            border-color: var(--brand-primary);
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
        }

        .dashboard-section-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--brand-primary);
        }
    </style>

    <div class="dashboard-page">

        <!-- Welcome Card -->
        <div class="welcome-card mb-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="mb-2">
                        @php
                            $hour = date('H');
                            if ($hour < 12) echo 'Bonjour';
                            elseif ($hour < 18) echo 'Bon après-midi';
                            else echo 'Bonsoir';
                        @endphp,
                        {{ auth()->user()->prenom ?? auth()->user()->nom ?? 'Cher utilisateur' }} 👋
                    </h2>
                    <p class="opacity-90 mb-0">
                        Bienvenue sur votre tableau de bord de gestion locative.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="d-inline-flex align-items-center gap-2 text-secondary bg-black bg-opacity-20 rounded-3xl px-4 py-2">
                        <i class="fas fa-calendar"></i>
                        <span class="text-secondary">{{ now()->format('l d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div><br><br>

        <!-- Statistiques -->
        <div class="row g-4 mb-5">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(102,126,234,0.15); color: var(--brand-primary);">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $propertiesCount ?? 0 }}</h3>
                    <p class="text-muted mb-0">Propriétés</p>
                    <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-primary mt-3">
                        Voir tout
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(16,185,129,0.15); color: var(--success);">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $tenantsCount ?? 0 }}</h3>
                    <p class="text-muted mb-0">Locataires</p>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-success mt-3">
                        Voir tout
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(245,158,11,0.15); color: var(--warning);">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($rentCollected ?? 0, 0, ',', ' ') }}</h3>
                    <p class="text-muted mb-0">Loyers perçus</p>
                    <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-warning mt-3">
                        Voir détails
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(239,68,68,0.15); color: var(--danger);">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $maintenanceCount ?? 0 }}</h3>
                    <p class="text-muted mb-0">Interventions</p>
                    <a href="{{ route('travaux.index') }}" class="btn btn-sm btn-outline-danger mt-3">
                        Voir tout
                    </a>
                </div>
            </div>
        </div><br><br>

        <div class="row g-4">
            <!-- Actions Rapides -->
            <div class="col-lg-7">
                <div class="results-card">
                    <div class="results-header">
                        <h5><i class="fas fa-bolt me-2"></i>Actions rapides</h5>
                    </div><br><br>
                    <div class="p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="{{ route('users.create') }}" class="action-card d-block">
                                    <i class="fas fa-user-plus fa-2xl mb-3 text-primary"></i>
                                    <h6>Ajouter Locataire</h6>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('payments.create') }}" class="action-card d-block">
                                    <i class="fas fa-money-bill fa-2xl mb-3 text-success"></i>
                                    <h6>Enregistrer Paiement</h6>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('travaux.create') }}" class="action-card d-block">
                                    <i class="fas fa-tools fa-2xl mb-3 text-warning"></i>
                                    <h6>Nouvelle Intervention</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conseils / Rappels -->
            <div class="col-lg-5">
                <div class="results-card h-100">
                    <div class="results-header">
                        <h5><i class="fas fa-lightbulb me-2"></i>Conseils & Rappels</h5>
                    </div><br><br>
                    <div class="p-4">
                        <div class="alert alert-info border-0">
                            Vérifiez régulièrement l’état des loyers en retard pour éviter les impayés.
                        </div>
                        <div class="alert alert-success border-0">
                            Documentez tous les états des lieux pour une meilleure traçabilité.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
