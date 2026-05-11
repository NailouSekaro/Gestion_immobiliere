@extends('layouts.template')

@section('content')
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
        <style>
            :root {
                --primary: #0ea5e9;
                --primary-dark: #0369a1;
                --primary-light: #e0f2fe;
                --success: #10b981;
                --success-dark: #059669;
                --danger: #ef4444;
                --warning: #f59e0b;
                --info: #3b82f6;
                --light: #f8fafc;
                --dark: #1e293b;
                --gray: #64748b;
                --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
                --card-hover-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            * {
                font-family: 'Poppins', sans-serif;
            }

            body {
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
                min-height: 100vh;
            }

            .container {
                padding: 2rem;
                max-width: 1400px;
                margin: 0 auto;
            }

            .page-header {
                margin-bottom: 2.5rem;
                animation: fadeInDown 0.5s ease forwards;
                opacity: 0;
            }

            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .page-title {
                font-size: 2rem;
                font-weight: 700;
                color: var(--dark);
                margin-bottom: 0.5rem;
                background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                display: flex;
                align-items: center;
            }

            .page-title i {
                margin-right: 0.75rem;
                font-size: 1.8rem;
            }

            .page-subtitle {
                color: var(--gray);
                font-size: 1rem;
                margin: 0;
            }

            .stats-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: white;
                border-radius: 16px;
                padding: 1.5rem;
                box-shadow: var(--card-shadow);
                transition: var(--transition);
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                overflow: hidden;
                animation: fadeInUp 0.5s ease forwards;
                opacity: 0;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .stat-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: linear-gradient(180deg, var(--primary), var(--primary-dark));
            }

            .stat-card:nth-child(2)::before {
                background: linear-gradient(180deg, #10b981, #059669);
            }

            .stat-card:nth-child(3)::before {
                background: linear-gradient(180deg, #f59e0b, #d97706);
            }

            .stat-card:nth-child(4)::before {
                background: linear-gradient(180deg, #ef4444, #dc2626);
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--card-hover-shadow);
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
                background: linear-gradient(135deg, var(--primary-light), rgba(14, 165, 233, 0.2));
            }

            .stat-card:nth-child(2) .stat-icon {
                background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.4));
            }

            .stat-card:nth-child(3) .stat-icon {
                background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.4));
            }

            .stat-card:nth-child(4) .stat-icon {
                background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.4));
            }

            .stat-icon i {
                color: var(--primary);
                font-size: 1.5rem;
            }

            .stat-card:nth-child(2) .stat-icon i {
                color: #10b981;
            }

            .stat-card:nth-child(3) .stat-icon i {
                color: #f59e0b;
            }

            .stat-card:nth-child(4) .stat-icon i {
                color: #ef4444;
            }

            .stat-label {
                font-size: 0.9rem;
                color: var(--gray);
                margin-bottom: 0.5rem;
                font-weight: 500;
            }

            .stat-value {
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--dark);
                margin: 0;
            }

            .btn {
                padding: 0.7rem 1.5rem;
                border-radius: 10px;
                font-weight: 500;
                transition: var(--transition);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: none;
                cursor: pointer;
                text-decoration: none;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                position: relative;
                overflow: hidden;
            }

            .btn::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 5px;
                height: 5px;
                background: rgba(255, 255, 255, 0.5);
                opacity: 0;
                border-radius: 100%;
                transform: scale(1, 1) translate(-50%);
                transform-origin: 50% 50%;
            }

            .btn:focus:not(:active)::after {
                animation: ripple 1s ease-out;
            }

            @keyframes ripple {
                0% {
                    transform: scale(0, 0);
                    opacity: 0.5;
                }

                20% {
                    transform: scale(25, 25);
                    opacity: 0.3;
                }

                100% {
                    opacity: 0;
                    transform: scale(40, 40);
                }
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                color: white;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
            }

            .btn-sm {
                padding: 0.4rem 0.9rem;
                font-size: 0.85rem;
            }

            .btn-info {
                background: linear-gradient(to right, #3b82f6, #2563eb);
                color: white;
            }

            .btn-info:hover {
                background: linear-gradient(to right, #2563eb, #1d4ed8);
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3);
            }

            .btn-secondary {
                background: linear-gradient(to right, #64748b, #475569);
                color: white;
            }

            .btn-secondary:hover {
                background: linear-gradient(to right, #475569, #334155);
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(100, 116, 139, 0.3);
            }

            .btn-success {
                background: linear-gradient(to right, #10b981, #059669);
                color: white;
            }

            .btn-success:hover {
                background: linear-gradient(to right, #059669, #047857);
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(16, 185, 129, 0.3);
            }

            .table-container {
                background: white;
                border-radius: 16px;
                box-shadow: var(--card-shadow);
                overflow: hidden;
                margin-top: 2rem;
                animation: fadeIn 0.6s ease forwards;
                opacity: 0;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            .table-header {
                padding: 1.5rem;
                background: linear-gradient(120deg, var(--primary), var(--primary-dark));
                color: white;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .table-title {
                margin: 0;
                font-size: 1.25rem;
                font-weight: 600;
                display: flex;
                align-items: center;
            }

            .table-title i {
                margin-right: 0.75rem;
            }

            .search-box {
                position: relative;
                width: 300px;
            }

            .search-box input {
                width: 100%;
                padding: 0.7rem 1rem 0.7rem 2.5rem;
                border: 2px solid rgba(255, 255, 255, 0.2);
                border-radius: 8px;
                background: rgba(255, 255, 255, 0.1);
                color: white;
                transition: var(--transition);
            }

            .search-box input:focus {
                outline: none;
                border-color: white;
                background: rgba(255, 255, 255, 0.2);
            }

            .search-box i {
                position: absolute;
                left: 0.75rem;
                top: 50%;
                transform: translateY(-50%);
                color: rgba(255, 255, 255, 0.7);
            }

            .table-responsive {
                overflow-x: auto;
                position: relative;
            }

            .table {
                margin: 0;
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                min-width: 1000px;
            }

            .table thead {
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .table th {
                background: #1e293b;
                color: white;
                font-weight: 600;
                padding: 1.2rem 1rem;
                text-align: left;
                text-transform: uppercase;
                font-size: 0.85rem;
                letter-spacing: 0.5px;
                border-bottom: 2px solid #334155;
            }

            .table th i {
                margin-right: 0.5rem;
                opacity: 0.8;
            }

            .table tbody tr {
                transition: var(--transition);
                opacity: 0;
                transform: translateY(10px);
                animation: fadeInUp 0.5s ease forwards;
            }

            .table tbody tr:nth-child(1) {
                animation-delay: 0.1s;
            }

            .table tbody tr:nth-child(2) {
                animation-delay: 0.2s;
            }

            .table tbody tr:nth-child(3) {
                animation-delay: 0.3s;
            }

            .table tbody tr:nth-child(4) {
                animation-delay: 0.4s;
            }

            .table tbody tr:nth-child(5) {
                animation-delay: 0.5s;
            }

            .table td {
                padding: 1rem;
                vertical-align: middle;
                border-bottom: 1px solid #e2e8f0;
            }

            .table tbody tr:hover {
                background-color: #f0f9ff;
                transform: scale(1.01);
            }

            .user-info {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .user-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid var(--primary-light);
            }

            .user-name {
                font-weight: 500;
                color: var(--dark);
            }

            .consumption-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.4rem 0.9rem;
                background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                color: white;
                border-radius: 50px;
                font-weight: 600;
                font-size: 0.9rem;
            }

            .consumption-badge i {
                margin-right: 0.5rem;
            }

            .amount-cell {
                font-weight: 700;
                color: var(--primary-dark);
            }

            .period-cell {
                color: var(--gray);
                font-weight: 500;
                font-size: 0.9rem;
            }

            .status-badge {
                display: inline-block;
                padding: 0.4rem 0.9rem;
                border-radius: 50px;
                font-weight: 600;
                font-size: 0.85rem;
                text-transform: uppercase;
            }

            .status-paid {
                background: linear-gradient(135deg, #d1fae5, #a7f3d0);
                color: #065f46;
            }

            .status-unpaid {
                background: linear-gradient(135deg, #fee2e2, #fecaca);
                color: #991b1b;
            }

            .action-buttons {
                display: flex;
                gap: 0.5rem;
            }

            .empty-state {
                text-align: center;
                padding: 4rem 2rem;
                background: #f8fafc;
                border-radius: 0 0 16px 16px;
            }

            .empty-state i {
                font-size: 4rem;
                color: var(--gray);
                margin-bottom: 1.5rem;
                opacity: 0.5;
            }

            .empty-state h4 {
                color: var(--dark);
                margin-bottom: 1rem;
                font-weight: 600;
            }

            .empty-state p {
                color: var(--gray);
                margin-bottom: 2rem;
                max-width: 400px;
                margin-left: auto;
                margin-right: auto;
            }

            .scroll-buttons {
                display: flex;
                justify-content: flex-end;
                gap: 0.5rem;
                margin-bottom: 1rem;
            }

            .scroll-btn {
                padding: 0.5rem;
                border-radius: 50%;
                background: var(--primary);
                color: white;
                border: none;
                cursor: pointer;
                transition: var(--transition);
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .scroll-btn:hover {
                background: var(--primary-dark);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(14, 165, 233, 0.3);
            }

            .scroll-btn:disabled {
                background: var(--gray);
                cursor: not-allowed;
                opacity: 0.6;
            }

            .filter-section {
                display: flex;
                gap: 1rem;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
            }

            .filter-select {
                padding: 0.6rem 1rem;
                border: 2px solid #e2e8f0;
                border-radius: 8px;
                background: white;
                color: var(--dark);
                font-size: 0.9rem;
                transition: var(--transition);
                cursor: pointer;
            }

            .filter-select:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
            }

            .animate-delay-1 {
                animation-delay: 0.1s;
            }

            .animate-delay-2 {
                animation-delay: 0.2s;
            }

            .animate-delay-3 {
                animation-delay: 0.3s;
            }

            .animate-delay-4 {
                animation-delay: 0.4s;
            }

            .animate-delay-5 {
                animation-delay: 0.5s;
            }

            @media (max-width: 768px) {
                .container {
                    padding: 1rem;
                }

                .stats-cards {
                    grid-template-columns: 1fr;
                }

                .table-header {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: stretch;
                }

                .search-box {
                    width: 100%;
                }

                .filter-section {
                    flex-direction: column;
                }

                .action-buttons {
                    flex-direction: column;
                }

                .scroll-buttons {
                    justify-content: center;
                }

                .page-title {
                    font-size: 1.5rem;
                }

                .stat-value {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="container">
            <!-- En-tête de page -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-tint"></i>Consommations d'Eau
                </h1>
                <p class="page-subtitle">
                    {{ auth()->user()->isAdmin() ? "Suivez et gérez les consommations d'eau des locataires" : "Consultez vos consommations et factures d'eau" }}
                </p>
            </div>

            <!-- Cartes de statistiques -->
            <div class="stats-cards">
                <div class="stat-card animate-delay-1">
                    <div class="stat-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <div class="stat-label">Consommation totale (m³)</div>
                    <h3 class="stat-value">{{ number_format($totalConsumption, 0, ',', ' ') }} m³</h3>
                </div>

                <div class="stat-card animate-delay-2">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-label">Montant total (FCFA)</div>
                    <h3 class="stat-value">{{ number_format($totalAmount, 0, ',', ' ') }}</h3>
                </div>

                <div class="stat-card animate-delay-3">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-label">Consommations payées</div>
                    <h3 class="stat-value">{{ $paidCount }}</h3>
                </div>

                <div class="stat-card animate-delay-4">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-label">En attente</div>
                    <h3 class="stat-value">{{ $unpaidCount }}</h3>
                </div>
            </div>

            <!-- Filtres -->
            <div class="filter-section">
                <select class="filter-select" id="statusFilter">
                    <option value="">Tous les statuts</option>
                    <option value="paye">Payé</option>
                    <option value="non_paye">Impayé</option>
                </select>

                <select class="filter-select" id="monthFilter">
                    <option value="">Tous les mois</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">
                            {{ \Carbon\Carbon::create()->month($i)->locale('fr')->monthName }}</option>
                    @endfor
                </select>

                <select class="filter-select" id="yearFilter">
                    <option value="">Toutes les années</option>
                    @for ($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>

            <!-- Actions et recherche -->
            <div class="d-flex justify-content-between align-items-center mb-3 animate__animated animate__fadeInUp"
                style="animation-delay: 0.2s;">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher un locataire...">
                </div>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('consommations-eau.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouvelle Consommation
                    </a>
                @endif
            </div>

            <!-- Tableau -->
            <div class="table-container">
                <div class="table-header">
                    <h4 class="table-title">
                        <i class="fas fa-list"></i>{{ auth()->user()->isAdmin() ? 'Liste des Consommations' : 'Mes Consommations' }}
                    </h4>
                </div>

                <div class="scroll-buttons">
                    <button class="scroll-btn" id="scrollLeft" title="Défiler vers la gauche">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="scroll-btn" id="scrollRight" title="Défiler vers la droite">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user"></i> Locataire</th>
                                <th><i class="fas fa-bed"></i> Chambre</th>
                                <th><i class="fas fa-calendar"></i> Période</th>
                                <th><i class="fas fa-water"></i> Consommation</th>
                                <th><i class="fas fa-money-bill"></i> Montant</th>
                                <th><i class="fas fa-circle"></i> Statut</th>
                                <th><i class="fas fa-cogs"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody id="consumptionsTable">
                            @forelse($consommations as $conso)
                                <tr data-name="{{ $conso->user->prenom ?? '' }} {{ $conso->user->nom ?? '' }}"
                                    data-status="{{ $conso->statut }}"
                                    data-month="{{ \Carbon\Carbon::parse($conso->periode_debut)->month }}"
                                    data-year="{{ \Carbon\Carbon::parse($conso->periode_debut)->year }}">
                                    <td>
                                        <div class="user-info">
                                            @if ($conso->user && $conso->user->photo_profil)
                                                <img src="{{ asset('storage/' . $conso->user->photo_profil) }}"
                                                    alt="{{ $conso->user->prenom }}" class="user-avatar">
                                            @else
                                                <div class="user-avatar"
                                                    style="background: linear-gradient(135deg, var(--primary-light), var(--primary)); display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="user-name">{{ $conso->user->prenom ?? '-' }}
                                                    {{ $conso->user->nom ?? '' }}</div>
                                                @if ($conso->user && $conso->user->email)
                                                    <small class="text-muted">{{ $conso->user->email }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $conso->property->nom ?? '-' }}</strong>
                                        @if ($conso->property && $conso->property->numero_chambre)
                                            <br><small class="text-muted">Chambre
                                                {{ $conso->property->numero_chambre }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="period-cell">
                                            {{ \Carbon\Carbon::parse($conso->periode_debut)->format('d/m/Y') }}
                                            <i class="fas fa-arrow-right mx-2"></i>
                                            {{ \Carbon\Carbon::parse($conso->periode_fin)->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="consumption-badge">
                                            <i class="fas fa-tint"></i>
                                            {{ $conso->consommation }} m³
                                        </span>
                                    </td>
                                    <td>
                                        <div class="amount-cell">{{ number_format($conso->montant, 0, ',', ' ') }} FCFA
                                        </div>
                                    </td>
                                    <td>
                                        @if ($conso->statut === 'paye')
                                            <span class="status-badge status-paid">
                                                <i class="fas fa-check-circle me-1"></i>Payé
                                            </span>
                                        @else
                                            <span class="status-badge status-unpaid">
                                                <i class="fas fa-clock me-1"></i>Impayé
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('consommations-eau.show', $conso) }}"
                                                class="btn btn-sm btn-info" data-tooltip="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-md-inline">Voir</span>
                                            </a>
                                            <a href="{{ route('consommations-eau.facture', $conso) }}"
                                                class="btn btn-sm btn-secondary" data-tooltip="Voir la facture"
                                                target="_blank">
                                                <i class="fas fa-file-invoice"></i>
                                                <span class="d-none d-md-inline">Facture</span>
                                            </a>
                                            {{-- @if ($conso->paiementEau)
                                                <a href="{{ route('consommations-eau.facture', $conso) }}"
                                                    class="btn btn-outline-success" target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                    Télécharger le reçu (PDF)
                                                </a>
                                            @endif --}}

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fas fa-tint"></i>
                                            <h4>Aucune consommation enregistrée</h4>
                                            <p>
                                                {{ auth()->user()->isAdmin() ? "Commencez par enregistrer une consommation d'eau pour un locataire" : "Aucune consommation d'eau n'est encore disponible pour votre compte" }}
                                            </p>
                                            @if (auth()->user()->isAdmin())
                                                <a href="{{ route('consommations-eau.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Enregistrer une consommation
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const monthFilter = document.getElementById('monthFilter');
            const yearFilter = document.getElementById('yearFilter');
            const tableRows = document.querySelectorAll('#consumptionsTable tr[data-name]');
            const tableContainer = document.querySelector('.table-responsive');
            const scrollLeftBtn = document.getElementById('scrollLeft');
            const scrollRightBtn = document.getElementById('scrollRight');

            // Fonction de filtrage
            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const monthValue = monthFilter.value;
                const yearValue = yearFilter.value;

                tableRows.forEach(row => {
                    const userName = row.getAttribute('data-name').toLowerCase();
                    const status = row.getAttribute('data-status');
                    const month = row.getAttribute('data-month');
                    const year = row.getAttribute('data-year');

                    const matchesSearch = userName.includes(searchText);
                    const matchesStatus = !statusValue || status === statusValue;
                    const matchesMonth = !monthValue || month === monthValue;
                    const matchesYear = !yearValue || year === yearValue;

                    const shouldShow = matchesSearch && matchesStatus && matchesMonth && matchesYear;

                    if (shouldShow) {
                        row.style.display = '';
                        // Animation d'apparition
                        row.classList.add('animate__animated', 'animate__fadeIn');
                        setTimeout(() => {
                            row.classList.remove('animate__animated', 'animate__fadeIn');
                        }, 500);
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Recherche en temps réel
            searchInput.addEventListener('input', function() {
                filterTable();
                this.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    this.classList.remove('animate__animated', 'animate__pulse');
                }, 300);
            });

            // Filtres
            statusFilter.addEventListener('change', filterTable);
            monthFilter.addEventListener('change', filterTable);
            yearFilter.addEventListener('change', filterTable);

            // Gestion du défilement horizontal
            function updateScrollButtons() {
                const maxScroll = tableContainer.scrollWidth - tableContainer.clientWidth;
                scrollLeftBtn.disabled = tableContainer.scrollLeft === 0;
                scrollRightBtn.disabled = tableContainer.scrollLeft >= maxScroll - 1;
            }

            scrollLeftBtn.addEventListener('click', function() {
                tableContainer.scrollBy({
                    left: -200,
                    behavior: 'smooth'
                });
                setTimeout(updateScrollButtons, 300);
                this.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    this.classList.remove('animate__animated', 'animate__pulse');
                }, 300);
            });

            scrollRightBtn.addEventListener('click', function() {
                tableContainer.scrollBy({
                    left: 200,
                    behavior: 'smooth'
                });
                setTimeout(updateScrollButtons, 300);
                this.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    this.classList.remove('animate__animated', 'animate__pulse');
                }, 300);
            });

            tableContainer.addEventListener('scroll', updateScrollButtons);
            window.addEventListener('resize', updateScrollButtons);
            updateScrollButtons(); // Initialisation

            // Animation au survol des lignes
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.1)';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                });
            });

            // Animation des boutons d'action
            document.querySelectorAll('.action-buttons a').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.05)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                });

                // Effet de clic
                button.addEventListener('click', function(e) {
                    this.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        this.classList.remove('animate__animated', 'animate__pulse');
                    }, 300);

                    // Animation de chargement pour le paiement
                    if (this.classList.contains('btn-success')) {
                        const icon = this.querySelector('i');
                        const originalIcon = icon.className;
                        icon.className = 'fas fa-spinner fa-spin';

                        setTimeout(() => {
                            icon.className = originalIcon;
                        }, 1000);
                    }
                });
            });

            // Statistiques en temps réel
            function updateStats() {
                const statCards = document.querySelectorAll('.stat-card');
                statCards.forEach((card, index) => {
                    if (index === 0) { // Carte de consommation
                        card.classList.add('animate__animated', 'animate__pulse');
                        setTimeout(() => {
                            card.classList.remove('animate__animated', 'animate__pulse');
                        }, 2000);
                    }
                });
            }

            // Mettre à jour les stats toutes les 30 secondes
            setInterval(updateStats, 30000);

            // Animation d'entrée des statistiques
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.2}s`;
            });

            // Tooltips
            document.querySelectorAll('[data-tooltip]').forEach(element => {
                element.addEventListener('mouseenter', function() {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip';
                    tooltip.textContent = this.getAttribute('data-tooltip');
                    tooltip.style.position = 'absolute';
                    tooltip.style.background = '#1e293b';
                    tooltip.style.color = 'white';
                    tooltip.style.padding = '0.5rem 0.75rem';
                    tooltip.style.borderRadius = '6px';
                    tooltip.style.fontSize = '0.85rem';
                    tooltip.style.zIndex = '1000';
                    tooltip.style.whiteSpace = 'nowrap';

                    const rect = this.getBoundingClientRect();
                    tooltip.style.top = `${rect.top - 40}px`;
                    tooltip.style.left = `${rect.left + rect.width / 2}px`;
                    tooltip.style.transform = 'translateX(-50%)';

                    document.body.appendChild(tooltip);

                    this._tooltip = tooltip;
                });

                element.addEventListener('mouseleave', function() {
                    if (this._tooltip) {
                        this._tooltip.remove();
                        this._tooltip = null;
                    }
                });
            });
        });
    </script>
@endpush
