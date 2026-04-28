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
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #e0e7ff;
            --success: #4cc9f0;
            --success-dark: #3a8fb8;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --danger: #dc2626;
            --warning: #facc15;
            --info: #60a5fa;
            --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            --card-hover-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
        }

        .container-fluid {
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
            background: linear-gradient(180deg, #4cc9f0, #3a8fb8);
        }

        .stat-card:nth-child(3)::before {
            background: linear-gradient(180deg, #facc15, #d97706);
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
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.2) 0%, rgba(76, 201, 240, 0.4) 100%);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: linear-gradient(135deg, rgba(250, 204, 21, 0.2) 0%, rgba(250, 204, 21, 0.4) 100%);
        }

        .stat-icon i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .stat-card:nth-child(2) .stat-icon i {
            color: #4cc9f0;
        }

        .stat-card:nth-child(3) .stat-icon i {
            color: #facc15;
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
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
        }

        .btn-sm {
            padding: 0.4rem 0.9rem;
            font-size: 0.85rem;
        }

        .btn-info {
            background: linear-gradient(to right, #60a5fa, #3b82f6);
            color: white;
        }

        .btn-info:hover {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(96, 165, 250, 0.3);
        }

        .btn-success {
            background: linear-gradient(to right, #34d399, #059669);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(to right, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(52, 211, 153, 0.3);
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
            from { opacity: 0; }
            to { opacity: 1; }
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
            min-width: 800px;
        }

        .table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table th {
            background: #2d3748;
            color: white;
            font-weight: 600;
            padding: 1.2rem 1rem;
            text-align: left;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #4a5568;
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

        .table tbody tr:nth-child(1) { animation-delay: 0.1s; }
        .table tbody tr:nth-child(2) { animation-delay: 0.2s; }
        .table tbody tr:nth-child(3) { animation-delay: 0.3s; }
        .table tbody tr:nth-child(4) { animation-delay: 0.4s; }
        .table tbody tr:nth-child(5) { animation-delay: 0.5s; }

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

        .amount-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.9rem;
            background: linear-gradient(135deg, #4cc9f0, #3a8fb8);
            color: white;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }

        .date-cell {
            color: var(--gray);
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: #f9fafc;
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

        .alert-success {
            background: linear-gradient(135deg, rgba(52, 211, 153, 0.1), rgba(5, 150, 105, 0.1));
            border-left: 4px solid #059669;
            border-radius: 10px;
            padding: 1.2rem 1.5rem;
            margin-bottom: 2rem;
            animation: slideInDown 0.5s ease forwards;
            opacity: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success i {
            color: #059669;
            font-size: 1.5rem;
        }

        .alert-success .alert-content {
            flex: 1;
        }

        .alert-success h5 {
            color: #059669;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .alert-success p {
            color: #065f46;
            margin: 0;
            font-weight: 500;
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
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
        }

        .scroll-btn:disabled {
            background: var(--gray);
            cursor: not-allowed;
            opacity: 0.6;
        }

        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        .animate-delay-5 { animation-delay: 0.5s; }

        @media (max-width: 768px) {
            .container-fluid {
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
<div class="container-fluid">
    <!-- En-tête de page -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-shield-alt"></i>Gestion des Cautions
        </h1>
        <p class="page-subtitle">Visualisez et gérez toutes les cautions des locataires</p>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
    <div class="alert-success animate__animated animate__slideInDown">
        <i class="fas fa-check-circle"></i>
        <div class="alert-content">
            <h5>Succès !</h5>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Cartes de statistiques -->
    <div class="stats-cards">
        <div class="stat-card animate-delay-1">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-label">Total des Cautions</div>
            <h3 class="stat-value">{{ number_format($totalCautions, 0, ',', ' ') }} FCFA</h3>
        </div>

        <div class="stat-card animate-delay-2">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-label">Locataires avec Caution</div>
            <h3 class="stat-value">{{ $cautions->count() }}</h3>
        </div>

        <div class="stat-card animate-delay-3">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-label">Ce Mois</div>
            <h3 class="stat-value">{{ number_format($cautionsCeMois, 0, ',', ' ') }} FCFA</h3>
        </div>
    </div>

    <!-- Bouton d'action -->
    <div class="d-flex justify-content-between align-items-center mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Rechercher un locataire...">
        </div>
        <a href="{{ route('cautions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Caution
        </a>
    </div>

    <!-- Tableau -->
    <div class="table-container">
        <div class="table-header">
            <h4 class="table-title">
                <i class="fas fa-list"></i>Liste des Cautions
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
                        <th><i class="fas fa-money-bill"></i> Montant</th>
                        <th><i class="fas fa-calendar"></i> Date</th>
                        <th><i class="fas fa-cogs"></i> Actions</th>
                    </tr>
                </thead>
                <tbody id="cautionsTable">
                    @forelse($cautions as $caution)
                    <tr data-name="{{ $caution->user->prenom }} {{ $caution->user->nom }}">
                        <td>
                            <div class="user-info">
                                <img src="{{ $caution->user->photo_profil ? asset('storage/' . $caution->user->photo_profil) : asset('images/default-avatar.jpg') }}"
                                     alt="{{ $caution->user->prenom }}"
                                     class="user-avatar">
                                <div>
                                    <div class="user-name">{{ $caution->user->prenom }} {{ $caution->user->nom }}</div>
                                    <small class="text-muted">{{ $caution->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="amount-badge">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                {{ number_format($caution->total_caution, 0, ',', ' ') }} FCFA
                            </span>
                        </td>
                        <td>
                            <div class="date-cell">
                                <i class="fas fa-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($caution->date_paiement)->format('d/m/Y H:i') }}
                            </div>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($caution->date_paiement)->diffForHumans() }}
                            </small>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('cautions.show', $caution) }}"
                                   class="btn btn-sm btn-info"
                                   data-tooltip="Voir les détails">
                                    <i class="fas fa-eye"></i>
                                    <span class="d-none d-md-inline">Voir</span>
                                </a>
                                <a href="{{ route('cautions.receipt', $caution) }}"
                                   class="btn btn-sm btn-success"
                                   data-tooltip="Télécharger le reçu"
                                   target="_blank">
                                    <i class="fas fa-download"></i>
                                    <span class="d-none d-md-inline">Reçu</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="fas fa-shield-alt"></i>
                                <h4>Aucune caution enregistrée</h4>
                                <p>Commencez par enregistrer une caution pour un locataire</p>
                                <a href="{{ route('cautions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Enregistrer une caution
                                </a>
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
    const tableRows = document.querySelectorAll('#cautionsTable tr[data-name]');
    const tableContainer = document.querySelector('.table-responsive');
    const scrollLeftBtn = document.getElementById('scrollLeft');
    const scrollRightBtn = document.getElementById('scrollRight');

    // Fonction de recherche
    function filterTable() {
        const searchText = searchInput.value.toLowerCase();

        tableRows.forEach(row => {
            const userName = row.getAttribute('data-name').toLowerCase();
            const shouldShow = userName.includes(searchText);

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

        // Animation sur la recherche
        this.classList.add('animate__animated', 'animate__pulse');
        setTimeout(() => {
            this.classList.remove('animate__animated', 'animate__pulse');
        }, 300);
    });

    // Gestion du défilement horizontal
    function updateScrollButtons() {
        const maxScroll = tableContainer.scrollWidth - tableContainer.clientWidth;
        scrollLeftBtn.disabled = tableContainer.scrollLeft === 0;
        scrollRightBtn.disabled = tableContainer.scrollLeft >= maxScroll - 1;
    }

    scrollLeftBtn.addEventListener('click', function() {
        tableContainer.scrollBy({ left: -200, behavior: 'smooth' });
        setTimeout(updateScrollButtons, 300);

        // Animation sur le bouton
        this.classList.add('animate__animated', 'animate__pulse');
        setTimeout(() => {
            this.classList.remove('animate__animated', 'animate__pulse');
        }, 300);
    });

    scrollRightBtn.addEventListener('click', function() {
        tableContainer.scrollBy({ left: 200, behavior: 'smooth' });
        setTimeout(updateScrollButtons, 300);

        // Animation sur le bouton
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
            // Animation de clic
            this.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__animated__pulse');
            }, 300);

            // Confirmation pour le téléchargement
            if (this.classList.contains('btn-success')) {
                const tooltip = this.getAttribute('data-tooltip');
                if (tooltip === 'Télécharger le reçu') {
                    // Animation de chargement
                    const icon = this.querySelector('i');
                    const originalIcon = icon.className;
                    icon.className = 'fas fa-spinner fa-spin';

                    setTimeout(() => {
                        icon.className = originalIcon;
                    }, 1000);
                }
            }
        });
    });

    // Statistiques en temps réel (simulation)
    function updateStats() {
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            // Animation périodique
            if (index === 0) { // Carte du total
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
            tooltip.style.background = '#2d3748';
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
