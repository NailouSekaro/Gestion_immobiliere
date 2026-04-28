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
            --warning: #facc15;
            --warning-dark: #d97706;
            --danger: #dc2626;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
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

        .container {
            max-width: 1200px;
            padding: 2rem;
            margin: 0 auto;
        }

        .prestataire-dashboard {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        }

        .welcome-message {
            font-size: 1.1rem;
            color: var(--gray);
        }

        .welcome-name {
            color: var(--primary-dark);
            font-weight: 600;
        }

        /* Statistiques */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
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
            background: linear-gradient(180deg, var(--success), var(--success-dark));
        }

        .stat-card:nth-child(3)::before {
            background: linear-gradient(180deg, var(--warning), var(--warning-dark));
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.1) 0%, rgba(76, 201, 240, 0.2) 100%);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: linear-gradient(135deg, rgba(250, 204, 21, 0.1) 0%, rgba(250, 204, 21, 0.2) 100%);
        }

        .stat-icon i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .stat-card:nth-child(2) .stat-icon i {
            color: var(--success);
        }

        .stat-card:nth-child(3) .stat-icon i {
            color: var(--warning);
        }

        .stat-title {
            font-size: 0.9rem;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0 0 0.25rem 0;
        }

        .stat-currency {
            font-size: 1rem;
            color: var(--gray);
            font-weight: 500;
        }

        .stat-description {
            font-size: 0.85rem;
            color: var(--gray);
            margin: 0;
        }

        /* Table des travaux */
        .works-table-container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        .table-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-bottom: 2px solid var(--primary-light);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .table-title i {
            color: var(--primary);
        }

        .table-count {
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .works-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .works-table thead {
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.1) 100%);
        }

        .works-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--primary-dark);
            border-bottom: 2px solid var(--primary-light);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .works-table tbody tr {
            transition: var(--transition);
            animation: fadeInRow 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInRow {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .works-table tbody tr:hover {
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.03) 0%, rgba(67, 97, 238, 0.05) 100%);
            transform: translateY(-2px);
        }

        .works-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            color: var(--dark);
        }

        .works-table tr:last-child td {
            border-bottom: none;
        }

        .property-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .property-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .property-icon i {
            color: var(--primary);
            font-size: 1rem;
        }

        .property-info h6 {
            margin: 0;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .property-address {
            font-size: 0.85rem;
            color: var(--gray);
            margin: 0.25rem 0 0 0;
        }

        .type-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.1) 0%, rgba(76, 201, 240, 0.2) 100%);
            color: var(--success-dark);
            border: 1px solid rgba(76, 201, 240, 0.3);
        }

        .date-cell {
            font-weight: 500;
            color: var(--primary-dark);
        }

        .expenses-cell {
            font-weight: 700;
            color: var(--danger);
            font-size: 1.1rem;
        }

        .empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .empty-icon i {
            color: var(--primary);
            font-size: 2rem;
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .empty-subtitle {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        /* Actions rapides */
        .quick-actions {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            animation: fadeInUp 0.7s ease forwards;
            opacity: 0;
        }

        .actions-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .actions-title i {
            color: var(--primary);
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 12px;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border: 2px solid #e2e8f0;
            color: var(--dark);
            text-decoration: none;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.1) 100%);
            border-color: var(--primary);
            transform: translateY(-2px);
            color: var(--primary-dark);
            text-decoration: none;
        }

        .action-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: white;
            flex-shrink: 0;
        }

        .action-text {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        .animate-delay-5 { animation-delay: 0.5s; }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .works-table {
                display: block;
                overflow-x: auto;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="prestataire-dashboard">
        <!-- En-tête -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-tools me-2"></i>Dashboard Prestataire
            </h1>
            <p class="welcome-message animate-delay-1">
                Bienvenue, <span class="welcome-name">{{ Auth::user()->prenom }}</span> !
                Gérez vos travaux et suivre vos dépenses.
            </p>
        </div>

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card animate-delay-2">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-title">Travaux Assignés</div>
                <h2 class="stat-value">{{ $totalTravaux }}</h2>
                <p class="stat-description">Total des interventions qui vous sont confiées</p>
            </div>

            <div class="stat-card animate-delay-3">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-title">Total Dépenses</div>
                <h2 class="stat-value">
                    {{ number_format($totalDepenses, 0, ',', ' ') }}
                    <span class="stat-currency">FCFA</span>
                </h2>
                <p class="stat-description">Somme totale des dépenses liées à vos travaux</p>
            </div>

            <div class="stat-card animate-delay-4">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-title">Dépenses Moyennes</div>
                <h2 class="stat-value">
                    {{ $totalTravaux > 0 ? number_format($totalDepenses / $totalTravaux, 0, ',', ' ') : 0 }}
                    <span class="stat-currency">FCFA</span>
                </h2>
                <p class="stat-description">Moyenne par intervention</p>
            </div>
        </div>

        <!-- Table des travaux -->
        <div class="works-table-container animate-delay-5">
            <div class="table-header">
                <h2 class="table-title">
                    <i class="fas fa-list-check"></i>Mes Travaux Assignés
                    <span class="table-count">{{ $travaux->count() }}</span>
                </h2>
            </div>

            <div class="table-responsive">
                <table class="works-table">
                    <thead>
                        <tr>
                            <th style="width: 25%">Propriété</th>
                            <th style="width: 20%">Type d'intervention</th>
                            <th style="width: 20%">Date prévue</th>
                            <th style="width: 20%">Dépenses engagées</th>
                            <th style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($travaux as $index => $travail)
                            <tr class="animate-delay-{{ ($index % 5) + 1 }}">
                                <td>
                                    <div class="property-cell">
                                        <div class="property-icon">
                                            <i class="fas fa-home"></i>
                                        </div>
                                        <div class="property-info">
                                            <h6>{{ $travail->property->nom ?? 'Non spécifié' }}</h6>
                                            <p class="property-address">
                                                {{ $travail->property->adresse ?? '—' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="type-badge">
                                        <i class="fas fa-wrench me-1"></i>
                                        {{ $travail->type_travail }}
                                    </span>
                                </td>
                                <td class="date-cell">
                                    <i class="far fa-calendar-alt me-2"></i>
                                    {{ \Carbon\Carbon::parse($travail->date_travail)->format('d/m/Y') }}
                                </td>
                                <td class="expenses-cell">
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    {{ number_format($travail->depenses->sum('montant'), 0, ',', ' ') }} FCFA
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('travaux.show', $travail) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('travaux.depenses.create', $travail) }}"
                                           class="btn btn-sm btn-outline-success"
                                           title="Ajouter une dépense">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-tools"></i>
                                        </div>
                                        <h4 class="empty-title">Aucun travail assigné</h4>
                                        <p class="empty-subtitle">
                                            Vous n'avez pas encore d'intervention enregistrée
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="quick-actions">
            <h3 class="actions-title">
                <i class="fas fa-bolt"></i>Actions rapides
            </h3>
            <div class="actions-grid">
                <a href="{{ route('travaux.create') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div class="action-text">Nouvelle intervention</div>
                </a>

                <a href="" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div class="action-text">Gérer les dépenses</div>
                </a>

                <a href="" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="action-text">Voir mes rapports</div>
                </a>

                <a href="{{ route('profile.edit') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="action-text">Mon profil</div>
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes de stats
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.animationDelay = `${(index * 0.2) + 0.3}s`;
        card.classList.add('animate__animated', 'animate__fadeInUp');
    });

    // Animation des lignes du tableau
    const tableRows = document.querySelectorAll('.works-table tbody tr');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${(index % 5 + 1) * 0.1}s`;
        row.classList.add('animate__animated', 'animate__fadeInLeft');
    });

    // Animation des boutons d'action
    const actionBtns = document.querySelectorAll('.action-btn');
    actionBtns.forEach((btn, index) => {
        btn.style.animationDelay = `${(index * 0.1) + 0.6}s`;
        btn.classList.add('animate__animated', 'animate__fadeInUp');

        btn.addEventListener('mouseenter', function() {
            this.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__pulse');
            }, 500);
        });
    });

    // Animation des valeurs des stats (compteur)
    const statValues = document.querySelectorAll('.stat-value');
    statValues.forEach(value => {
        const text = value.textContent.trim();
        const numberMatch = text.match(/(\d[\d,.]*)/);

        if (numberMatch) {
            const number = parseFloat(numberMatch[1].replace(/,/g, ''));
            if (!isNaN(number) && number > 0) {
                const originalText = value.textContent;
                value.textContent = '0';

                setTimeout(() => {
                    animateCounter(value, 0, number, 1000, originalText);
                }, 300);
            }
        }
    });

    // Fonction d'animation de compteur
    function animateCounter(element, start, end, duration, originalText) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);

            // Garder le texte original avec seulement le nombre remplacé
            if (originalText.includes('FCFA')) {
                element.textContent = value.toLocaleString('fr-FR') + ' FCFA';
            } else {
                element.textContent = value.toLocaleString('fr-FR');
            }

            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                element.textContent = originalText;
            }
        };
        window.requestAnimationFrame(step);
    }

    // Effet hover sur les lignes du tableau
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__pulse');
            }, 500);
        });
    });

    // Mise à jour de l'heure en temps réel (si tu veux l'ajouter)
    function updateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };

        const timeString = now.toLocaleDateString('fr-FR', options);
        const timeElements = document.querySelectorAll('.current-time');
        timeElements.forEach(el => {
            el.textContent = timeString;
        });
    }

    // Mettre à jour l'heure toutes les minutes
    setInterval(updateTime, 60000);
    updateTime(); // Appel initial
});
</script>
@endpush
