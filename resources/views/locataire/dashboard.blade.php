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

            .container-fluid {
                padding: 2rem;
                max-width: 1400px;
                margin: 0 auto;
            }

            .tenant-dashboard-container {
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
                font-size: 1.25rem;
                color: var(--gray);
                font-weight: 400;
            }

            .welcome-name {
                color: var(--primary-dark);
                font-weight: 600;
            }

            /* Alertes */
            .alert-success-custom {
                background: linear-gradient(135deg, rgba(76, 201, 240, 0.1) 0%, rgba(76, 201, 240, 0.2) 100%);
                border: 2px solid rgba(76, 201, 240, 0.3);
                border-left: 4px solid var(--success);
                color: var(--success-dark);
                padding: 1.5rem;
                border-radius: 12px;
                margin-bottom: 2rem;
                animation: fadeInRight 0.5s ease forwards;
                opacity: 0;
            }

            .alert-danger-custom {
                background: linear-gradient(135deg, rgba(220, 38, 38, 0.1) 0%, rgba(220, 38, 38, 0.2) 100%);
                border: 2px solid rgba(220, 38, 38, 0.3);
                border-left: 4px solid var(--danger);
                color: var(--danger);
                padding: 1.5rem;
                border-radius: 12px;
                margin-bottom: 2rem;
                animation: shake 0.5s ease-in-out;
            }

            @keyframes fadeInRight {
                from {
                    opacity: 0;
                    transform: translateX(20px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                10%,
                30%,
                50%,
                70%,
                90% {
                    transform: translateX(-5px);
                }

                20%,
                40%,
                60%,
                80% {
                    transform: translateX(5px);
                }
            }

            /* Cartes */
            .dashboard-card {
                border: none;
                border-radius: 16px;
                box-shadow: var(--card-shadow);
                transition: var(--transition);
                overflow: hidden;
                background: white;
                margin-bottom: 1.5rem;
                animation: fadeInUp 0.5s ease forwards;
                opacity: 0;
            }

            .dashboard-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--card-hover-shadow);
            }

            .card-header {
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border-bottom: 2px solid var(--primary-light);
                padding: 1.5rem;
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .card-header-icon {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .card-header-icon i {
                color: var(--primary);
                font-size: 1.5rem;
            }

            .card-header-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--dark);
                margin: 0;
            }

            .card-body {
                padding: 1.5rem;
            }

            /* Stats Grid */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stat-item {
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border: 2px solid #e2e8f0;
                border-radius: 12px;
                padding: 1.5rem;
                transition: var(--transition);
                position: relative;
                overflow: hidden;
            }

            .stat-item:hover {
                border-color: var(--primary);
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(67, 97, 238, 0.1);
            }

            .stat-item::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: linear-gradient(180deg, var(--primary), var(--primary-dark));
            }

            .stat-item:nth-child(2)::before {
                background: linear-gradient(180deg, #4cc9f0, #3a8fb8);
            }

            .stat-item:nth-child(3)::before {
                background: linear-gradient(180deg, #facc15, #d97706);
            }

            .stat-item:nth-child(4)::before {
                background: linear-gradient(180deg, #60a5fa, #2563eb);
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: rgba(67, 97, 238, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
            }

            .stat-icon i {
                color: var(--primary);
                font-size: 1.25rem;
            }

            .stat-item:nth-child(2) .stat-icon {
                background: rgba(76, 201, 240, 0.1);
            }

            .stat-item:nth-child(2) .stat-icon i {
                color: #4cc9f0;
            }

            .stat-item:nth-child(3) .stat-icon {
                background: rgba(250, 204, 21, 0.1);
            }

            .stat-item:nth-child(3) .stat-icon i {
                color: #facc15;
            }

            .stat-item:nth-child(4) .stat-icon {
                background: rgba(96, 165, 250, 0.1);
            }

            .stat-item:nth-child(4) .stat-icon i {
                color: #60a5fa;
            }

            .stat-label {
                font-size: 0.9rem;
                color: var(--gray);
                margin-bottom: 0.5rem;
                font-weight: 500;
            }

            .stat-value {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--dark);
                margin: 0;
            }

            .stat-subtext {
                font-size: 0.85rem;
                color: var(--gray);
                margin-top: 0.5rem;
            }

            /* Info list */
            .info-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .info-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0.75rem 0;
                border-bottom: 1px solid #e2e8f0;
            }

            .info-item:last-child {
                border-bottom: none;
            }

            .info-label {
                color: var(--gray);
                font-weight: 500;
            }

            .info-value {
                color: var(--dark);
                font-weight: 600;
            }

            .info-value.success {
                color: var(--success-dark);
            }

            .info-value.warning {
                color: var(--warning-dark);
            }

            .info-value.danger {
                color: var(--danger);
            }

            /* Quick actions */
            .quick-actions {
                background: white;
                border-radius: 16px;
                padding: 2rem;
                margin-top: 2rem;
                box-shadow: var(--card-shadow);
            }

            .actions-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--dark);
                margin-bottom: 1.5rem;
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
                border-radius: 10px;
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
                border-radius: 8px;
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1rem;
                color: white;
            }

            .action-text {
                font-weight: 500;
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
                .container-fluid {
                    padding: 1rem;
                }

                .stats-grid {
                    grid-template-columns: 1fr;
                }

                .actions-grid {
                    grid-template-columns: 1fr;
                }

                .dashboard-card {
                    margin-bottom: 1rem;
                }

                .page-title {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>

    <body class="sidebar-mini fixed">
        @include('layouts.role-navigation')
        <div class="loader-bg">
            <div class="loader-bar">
            </div>
        </div>
        <!-- Sidebar chat start -->
        @include('layouts.sidebar-clean')
        <!-- Sidebar chat end-->
        <div class="content-wrapper">
            <!-- Container-fluid starts -->
            <!-- Main content starts -->
            <div class="container-fluid">
                <div class="tenant-dashboard-container">
                    <!-- En-tête -->
                    <div class="page-header">
                        <h1 class="page-title">Tableau de bord locataire</h1>
                        <div class="welcome-message animate-delay-1">
                            👋 Bienvenue, <span class="welcome-name">{{ Auth::user()->prenom }}</span> !
                        </div>
                    </div>

                    <!-- Messages flash -->
                    @if (session('success'))
                        <div class="alert-success-custom animate-delay-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x me-3"></i>
                                <div>
                                    <h5 class="mb-1">Succès !</h5>
                                    <p class="mb-0">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert-danger-custom animate-delay-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                                <div>
                                    <h5 class="mb-1">Erreur !</h5>
                                    <p class="mb-0">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Grille de statistiques -->
                    <div class="stats-grid">
                        <!-- Ma chambre -->
                        <div class="stat-item animate-delay-1">
                            <div class="stat-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="stat-label">Ma Chambre</div>
                            @if ($user->property)
                                <h3 class="stat-value">{{ $user->property->nom }}</h3>
                                <p class="stat-subtext">
                                    Loyer: {{ number_format($user->property->loyer_mensuel, 0, ',', ' ') }} FCFA
                                </p>
                            @else
                                <h3 class="stat-value danger">Non attribuée</h3>
                                <p class="stat-subtext">Contactez l'administration</p>
                            @endif
                        </div>

                        <!-- Dernier paiement -->
                        <div class="stat-item animate-delay-2">
                            <div class="stat-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="stat-label">Dernier paiement</div>
                            @if ($dernierPaiement)
                                <h3 class="stat-value">{{ number_format($dernierPaiement->montant) }}FCFA</h3>
                                <p class="stat-subtext">
                                    {{ $dernierPaiement->mois_paye }}
                                    <span class="text-success ms-2">
                                        <i class="fas fa-check-circle"></i> À jour
                                    </span>
                                </p>
                            @else
                                <h3 class="stat-value warning">0 FCFA</h3>
                                <p class="stat-subtext">
                                    <i class="fas fa-exclamation-triangle"></i> Aucun paiement
                                </p>
                            @endif
                        </div>

                        <!-- Caution -->
                        <div class="stat-item animate-delay-3">
                            <div class="stat-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="stat-label">Caution</div>
                            @if ($caution)
                                <h3 class="stat-value">
                                    {{ number_format($caution->caution_chambre) }} /
                                    {{ number_format($caution->caution_chambre) }} FCFA
                                </h3>
                                <p class="stat-subtext">
                                    Reste:
                                    <span
                                        class="{{ $caution->montant_total - $caution->montant_paye > 0 ? 'text-danger' : 'text-success' }}">
                                        {{ number_format($caution->montant_total - $caution->montant_paye, 0, ',', ' ') }}
                                        FCFA
                                    </span>
                                </p>
                            @else
                                <h3 class="stat-value">0 FCFA</h3>
                                <p class="stat-subtext">Aucune caution enregistrée</p>
                            @endif
                        </div>

                        <!-- Eau -->
                        <div class="stat-item animate-delay-4">
                            <div class="stat-icon">
                                <i class="fas fa-tint"></i>
                            </div>
                            <div class="stat-label">Consommation eau</div>
                            @if ($derniereEau)
                                <h3 class="stat-value">{{ $derniereEau->consommation }} m³</h3>
                                <p class="stat-subtext">
                                    {{ number_format($derniereEau->montant, 0, ',', ' ') }} FCFA
                                </p>
                            @else
                                <h3 class="stat-value">0 m³</h3>
                                <p class="stat-subtext">Aucune facture disponible</p>
                            @endif
                        </div>
                    </div>

                    <!-- Détails complets -->
                    <div class="row">
                        <!-- Ma chambre - Détails -->
                        <div class="col-lg-6">
                            <div class="dashboard-card animate-delay-3">
                                <div class="card-header">
                                    <div class="card-header-icon">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <h3 class="card-header-title">Détails de ma chambre</h3>
                                </div>
                                <div class="card-body">
                                    @if ($user->property)
                                        <ul class="info-list">
                                            <li class="info-item">
                                                <span class="info-label">Nom de la propriété</span>
                                                <span class="info-value">{{ $user->property->nom }}</span>
                                            </li>
                                            <li class="info-item">
                                                <span class="info-label">Adresse</span>
                                                <span
                                                    class="info-value">{{ $user->property->adresse ?? 'Non spécifiée' }}</span>
                                            </li>
                                            <li class="info-item">
                                                <span class="info-label">Loyer mensuel</span>
                                                <span
                                                    class="info-value">{{ number_format($user->property->loyer_mensuel) }}
                                                    FCFA</span>
                                            </li>
                                            <li class="info-item">
                                                <span class="info-label">Type</span>
                                                <span
                                                    class="info-value">{{ $user->property->type ?? 'Non spécifié' }}</span>
                                            </li>
                                            <li class="info-item">
                                                <span class="info-label">Surface</span>
                                                <span class="info-value">{{ $user->property->surface ?? '0' }} m²</span>
                                            </li>
                                        </ul>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-home fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Aucune chambre attribuée</h5>
                                            <p class="text-muted">Contactez l'administration pour plus d'informations</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- État des paiements -->
                        <div class="col-lg-6">
                            <div class="dashboard-card animate-delay-4">
                                <div class="card-header">
                                    <div class="card-header-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <h3 class="card-header-title">État des paiements</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="info-list">
                                        @if ($dernierPaiement)
                                            <li class="info-item">
                                                <span class="info-label">Dernier paiement</span>
                                                <span class="info-value success">{{ $dernierPaiement->mois_paye }}</span>
                                            </li>
                                            <li class="info-item">
                                                <span class="info-label">Montant payé</span>
                                                <span
                                                    class="info-value">{{ number_format($dernierPaiement->montant, 0, ',', ' ') }}
                                                    FCFA</span>
                                            </li>
                                            <li class="info-item">
                                                <span class="info-label">Méthode de paiement</span>
                                                <span
                                                    class="info-value">{{ $dernierPaiement->methode_paiement ?? 'Non spécifiée' }}</span>
                                            </li>
                                            <li class="info-item">
                                                <span class="info-label">Statut</span>
                                                <span class="info-value success">
                                                    <i class="fas fa-check-circle me-1"></i> À jour
                                                </span>
                                            </li>
                                            <li class="info-item">
                                                <span class="info-label">Prochain paiement</span>
                                                <span class="info-value warning">
                                                    {{ \Carbon\Carbon::parse($dernierPaiement->mois_paye)->addMonth()->format('F Y') }}
                                                </span>
                                            </li>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-money-bill-wave fa-3x text-warning mb-3"></i>
                                                <h5 class="text-warning">Aucun paiement enregistré</h5>
                                                <p class="text-muted">Aucun paiement n'a encore été effectué</p>
                                            </div>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="quick-actions animate-delay-5">
                        <h3 class="actions-title">
                            <i class="fas fa-bolt me-2"></i>Actions rapides
                        </h3>
                        <div class="actions-grid">
                            <a href="{{ route('paiements.fedapay.page') }}" class="action-btn">
                                <div class="action-icon">
                                    <i class="fas fa-money-check-alt"></i>
                                </div>
                                <div class="action-text">Effectuer un paiement</div>
                            </a>

                            <a href="" class="action-btn">
                                <div class="action-icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div class="action-text">Signaler un problème</div>
                            </a>

                            <a href="{{ route('chat.index') }}" class="action-btn">
                                <div class="action-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div class="action-text">Contacter l'administration</div>
                            </a>

                            <a href="{{ route('profile.edit') }}" class="action-btn">
                                <div class="action-icon">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                                <div class="action-text">Modifier mon profil</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Required Jqurey -->
        <script src="{{ asset('assets/plugins/Jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/tether/dist/js/tether.min.js') }}"></script>

        <!-- Required Fremwork -->
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

        <!-- Scrollbar JS-->
        <script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js') }}"></script>

        <!-- Classic JS -->
        <script src="{{ asset('assets/plugins/classie/classie.js') }}"></script>

        <!-- Notification -->
        <script src="{{ asset('assets/plugins/notification/js/bootstrap-growl.min.js') }}"></script>

        <!-- Custom JS -->
        <script type="text/javascript" src="{{ asset('assets/js/main.min.js') }}"></script>
        <script src="assets/js/menu.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Animation des cartes
                const cards = document.querySelectorAll('.dashboard-card, .stat-item');
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${(index % 5 + 1) * 0.1}s`;
                    card.classList.add('animate__animated', 'animate__fadeInUp');
                });

                // Animation des alertes
                const alerts = document.querySelectorAll('.alert-success-custom, .alert-danger-custom');
                alerts.forEach((alert, index) => {
                    alert.style.animationDelay = `${index * 0.2}s`;
                });

                // Animation des actions rapides
                const actionBtns = document.querySelectorAll('.action-btn');
                actionBtns.forEach((btn, index) => {
                    btn.style.animationDelay = `${index * 0.1 + 0.5}s`;
                    btn.classList.add('animate__animated', 'animate__fadeInUp');

                    btn.addEventListener('mouseenter', function() {
                        this.classList.add('animate__animated', 'animate__pulse');
                        setTimeout(() => {
                            this.classList.remove('animate__animated', 'animate__pulse');
                        }, 500);
                    });
                });

                // Mettre à jour l'heure en temps réel
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

                // Animation des chiffres (si besoin)
                function animateCounter(element, start, end, duration) {
                    let startTimestamp = null;
                    const step = (timestamp) => {
                        if (!startTimestamp) startTimestamp = timestamp;
                        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                        const value = Math.floor(progress * (end - start) + start);
                        element.textContent = value.toLocaleString('fr-FR');
                        if (progress < 1) {
                            window.requestAnimationFrame(step);
                        }
                    };
                    window.requestAnimationFrame(step);
                }

                // Animer les valeurs statistiques
                const statValues = document.querySelectorAll('.stat-value');
                statValues.forEach(value => {
                    const text = value.textContent;
                    const numberMatch = text.match(/(\d[\d,.]*)/);

                    if (numberMatch) {
                        const number = parseFloat(numberMatch[1].replace(/,/g, ''));
                        if (!isNaN(number) && number > 0) {
                            value.textContent = '0';
                            setTimeout(() => {
                                animateCounter(value, 0, number, 1000);
                            }, 500);
                        }
                    }
                });

                // Auto-hide alerts after 5 seconds
                setTimeout(() => {
                    const alerts = document.querySelectorAll('.alert-success-custom, .alert-danger-custom');
                    alerts.forEach(alert => {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateX(20px)';
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.parentNode.removeChild(alert);
                            }
                        }, 300);
                    });
                }, 5000);
            });

            var $window = $(window);
            var nav = $('.fixed-button');
            $window.scroll(function() {
                if ($window.scrollTop() >= 200) {
                    nav.addClass('active');
                } else {
                    nav.removeClass('active');
                }
            });
        </script>
    </body>

    </html>
@endsection
