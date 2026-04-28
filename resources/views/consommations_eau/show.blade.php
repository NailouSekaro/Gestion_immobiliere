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
                max-width: 1200px;
                margin: 0 auto;
            }

            .back-button {
                margin-bottom: 2rem;
                animation: fadeInLeft 0.5s ease forwards;
                opacity: 0;
            }

            @keyframes fadeInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
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

            .btn-outline-secondary {
                background: transparent;
                color: var(--gray);
                border: 2px solid #dee2e6;
            }

            .btn-outline-secondary:hover {
                background: #f8f9fa;
                border-color: var(--primary);
                color: var(--primary);
                transform: translateY(-2px);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                color: white;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
            }

            .btn-success {
                background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
                color: white;
            }

            .btn-success:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
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

            .card {
                border: none;
                border-radius: 16px;
                box-shadow: var(--card-shadow);
                transition: var(--transition);
                overflow: hidden;
                background: white;
                margin-bottom: 2rem;
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

            .card:hover {
                transform: translateY(-5px);
                box-shadow: var(--card-hover-shadow);
            }

            .card-header {
                padding: 1.5rem;
                background: linear-gradient(120deg, var(--primary), var(--primary-dark)) !important;
                color: white;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                display: flex;
                align-items: center;
            }

            .card-header .header-icon {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(255, 255, 255, 0.2);
                margin-right: 1rem;
            }

            .card-header .header-icon i {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 2rem;
            }

            .info-section {
                margin-bottom: 2.5rem;
            }

            .section-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--dark);
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
                padding-bottom: 0.75rem;
                border-bottom: 2px solid var(--primary-light);
            }

            .section-title i {
                margin-right: 0.75rem;
                color: var(--primary);
            }

            .user-info {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 2rem;
                padding: 1.5rem;
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border-radius: 12px;
                border-left: 4px solid var(--primary);
                animation: fadeInRight 0.5s ease forwards;
                opacity: 0;
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

            .user-avatar {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid var(--primary-light);
                box-shadow: 0 4px 10px rgba(14, 165, 233, 0.2);
            }

            .user-details {
                flex: 1;
            }

            .user-name {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--dark);
                margin-bottom: 0.25rem;
            }

            .user-email {
                color: var(--gray);
                font-size: 0.95rem;
                margin-bottom: 0.5rem;
            }

            .property-info {
                background: #e0f2fe;
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 2rem;
                border-left: 4px solid var(--primary);
                animation: fadeInLeft 0.5s ease forwards;
                opacity: 0;
            }

            .property-title {
                font-size: 1rem;
                color: var(--primary-dark);
                font-weight: 600;
                margin-bottom: 0.75rem;
                display: flex;
                align-items: center;
            }

            .property-title i {
                margin-right: 0.5rem;
            }

            .property-details {
                font-size: 1rem;
                color: var(--dark);
                font-weight: 500;
            }

            .consumption-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .consumption-card {
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border-radius: 12px;
                padding: 1.5rem;
                border: 2px solid #e2e8f0;
                transition: var(--transition);
                position: relative;
                overflow: hidden;
                animation: fadeInUp 0.5s ease forwards;
                opacity: 0;
            }

            .consumption-card:hover {
                border-color: var(--primary);
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            }

            .consumption-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: linear-gradient(180deg, var(--primary), var(--primary-dark));
            }

            .consumption-card:nth-child(2)::before {
                background: linear-gradient(180deg, #10b981, #059669);
            }

            .consumption-card:nth-child(3)::before {
                background: linear-gradient(180deg, #f59e0b, #d97706);
            }

            .consumption-card:nth-child(4)::before {
                background: linear-gradient(180deg, #3b82f6, #2563eb);
            }

            .consumption-icon {
                width: 50px;
                height: 50px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
                background: rgba(14, 165, 233, 0.1);
            }

            .consumption-card:nth-child(2) .consumption-icon {
                background: rgba(16, 185, 129, 0.1);
            }

            .consumption-card:nth-child(3) .consumption-icon {
                background: rgba(245, 158, 11, 0.1);
            }

            .consumption-card:nth-child(4) .consumption-icon {
                background: rgba(59, 130, 246, 0.1);
            }

            .consumption-icon i {
                color: var(--primary);
                font-size: 1.5rem;
            }

            .consumption-card:nth-child(2) .consumption-icon i {
                color: #10b981;
            }

            .consumption-card:nth-child(3) .consumption-icon i {
                color: #f59e0b;
            }

            .consumption-card:nth-child(4) .consumption-icon i {
                color: #3b82f6;
            }

            .consumption-label {
                font-size: 0.9rem;
                color: var(--gray);
                margin-bottom: 0.5rem;
                font-weight: 500;
            }

            .consumption-value {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--dark);
                margin: 0;
            }

            .amount-section {
                background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                border-radius: 12px;
                padding: 2rem;
                color: white;
                text-align: center;
                margin: 2rem 0;
                position: relative;
                overflow: hidden;
                animation: fadeInUp 0.5s ease forwards;
                opacity: 0;
            }

            .amount-section::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -20%;
                width: 200px;
                height: 200px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
            }

            .amount-section::after {
                content: '';
                position: absolute;
                bottom: -30%;
                left: -10%;
                width: 150px;
                height: 150px;
                background: rgba(255, 255, 255, 0.05);
                border-radius: 50%;
            }

            .amount-label {
                font-size: 1rem;
                opacity: 0.9;
                margin-bottom: 0.5rem;
                position: relative;
                z-index: 1;
            }

            .amount-value {
                font-size: 2.5rem;
                font-weight: 700;
                margin: 0;
                position: relative;
                z-index: 1;
            }

            .amount-subtitle {
                font-size: 0.9rem;
                opacity: 0.8;
                position: relative;
                z-index: 1;
            }

            .status-section {
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border-radius: 12px;
                padding: 1.5rem;
                margin-top: 2rem;
                border-left: 4px solid #10b981;
                animation: fadeInRight 0.5s ease forwards;
                opacity: 0;
            }

            .status-title {
                font-size: 1rem;
                color: var(--dark);
                font-weight: 600;
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
            }

            .status-title i {
                margin-right: 0.5rem;
            }

            .status-badge {
                display: inline-block;
                padding: 0.5rem 1rem;
                border-radius: 50px;
                font-weight: 600;
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .status-paid {
                background: linear-gradient(135deg, #d1fae5, #a7f3d0);
                color: #065f46;
            }

            .status-unpaid {
                background: linear-gradient(135deg, #fef3c7, #fde68a);
                color: #92400e;
            }

            .payment-info {
                background: #f0f9ff;
                border-radius: 12px;
                padding: 1.5rem;
                margin-top: 1rem;
                border: 2px solid #b3e0ff;
            }

            .payment-title {
                font-size: 0.95rem;
                color: #0c5460;
                font-weight: 600;
                margin-bottom: 0.75rem;
                display: flex;
                align-items: center;
            }

            .payment-title i {
                margin-right: 0.5rem;
            }

            .payment-details {
                font-size: 0.9rem;
                color: var(--dark);
            }

            .action-buttons {
                display: flex;
                gap: 1rem;
                margin-top: 3rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .calculate-section {
                background: #fef3c7;
                border-radius: 12px;
                padding: 1.5rem;
                margin-top: 2rem;
                border: 2px solid #facc15;
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.02);
                }

                100% {
                    transform: scale(1);
                }
            }

            .calculate-title {
                font-size: 1rem;
                color: #92400e;
                font-weight: 600;
                margin-bottom: 0.75rem;
                display: flex;
                align-items: center;
            }

            .calculate-title i {
                margin-right: 0.5rem;
            }

            .calculate-formula {
                font-size: 0.9rem;
                color: #854d0e;
                background: white;
                padding: 1rem;
                border-radius: 8px;
                font-family: 'Courier New', monospace;
                margin: 0;
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

                .card-body {
                    padding: 1.5rem;
                }

                .consumption-grid {
                    grid-template-columns: 1fr;
                }

                .user-info {
                    flex-direction: column;
                    text-align: center;
                }

                .action-buttons {
                    flex-direction: column;
                }

                .btn {
                    width: 100%;
                    justify-content: center;
                }

                .amount-value {
                    font-size: 2rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="container">
            <!-- Bouton retour -->
            <div class="back-button animate-delay-1">
                <a href="{{ route('consommations-eau.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                </a>
            </div>

            <!-- En-tête de page -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-tint"></i>Détails de la Consommation d'Eau
                </h1>
                <p class="page-subtitle">Informations détaillées sur la consommation d'eau</p>
            </div>

            @if (session('success'))
                <div class="alert-success animate__animated animate__slideInDown">
                    <i class="fas fa-check-circle"></i>
                    <div class="alert-content">
                        <h5>Succès !</h5>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Carte principale -->
            <div class="card">
                <div class="card-header">
                    <div class="header-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Consommation #{{ $consommationEau->id }}</h5>
                        <small>Période :
                            {{ \Carbon\Carbon::parse($consommationEau->periode_debut)->format('d/m/Y') }}
                            →
                            {{ \Carbon\Carbon::parse($consommationEau->periode_fin)->format('d/m/Y') }}
                        </small>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Informations du locataire -->
                    <div class="info-section">
                        <h4 class="section-title">
                            <i class="fas fa-user"></i>Informations du Locataire
                        </h4>

                        <div class="user-info animate-delay-1">
                            @if ($consommationEau->user && $consommationEau->user->photo_profil)
                                <img src="{{ asset('storage/' . $consommationEau->user->photo_profil) }}"
                                    alt="{{ $consommationEau->user->prenom }}" class="user-avatar">
                            @else
                                <div class="user-avatar"
                                    style="background: linear-gradient(135deg, var(--primary-light), var(--primary)); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user fa-2x text-white"></i>
                                </div>
                            @endif
                            <div class="user-details">
                                @if ($consommationEau->user)
                                    <h3 class="user-name">{{ $consommationEau->user->prenom }}
                                        {{ $consommationEau->user->nom }}</h3>
                                    <p class="user-email">
                                        <i class="fas fa-envelope me-1"></i>{{ $consommationEau->user->email }}
                                    </p>
                                    @if ($consommationEau->user->telephone)
                                        <p class="text-muted">
                                            <i class="fas fa-phone me-1"></i>{{ $consommationEau->user->telephone }}
                                        </p>
                                    @endif
                                @else
                                    <h3 class="user-name text-danger">Locataire non défini</h3>
                                    <p class="user-email text-muted">Aucune information disponible</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Informations de la propriété -->
                    @if ($consommationEau->property)
                        <div class="property-info animate-delay-2">
                            <div class="property-title">
                                <i class="fas fa-home"></i>Informations de la Chambre
                            </div>
                            <div class="property-details">
                                {{ $consommationEau->property->libelle ?? '—' }}
                                @if ($consommationEau->property->numero_chambre)
                                    <br><span class="text-muted">Chambre
                                        {{ $consommationEau->property->numero_chambre }}</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Détails de la consommation -->
                    <div class="info-section">
                        <h4 class="section-title">
                            <i class="fas fa-chart-line"></i>Détails de la Consommation
                        </h4>

                        <div class="consumption-grid">
                            <!-- Index précédent -->
                            <div class="consumption-card animate-delay-1">
                                <div class="consumption-icon">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                                <div>
                                    <div class="consumption-label">Index précédent</div>
                                    <h3 class="consumption-value">{{ $consommationEau->index_precedent }} m³</h3>
                                </div>
                            </div>

                            <!-- Index actuel -->
                            <div class="consumption-card animate-delay-2">
                                <div class="consumption-icon">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                                <div>
                                    <div class="consumption-label">Index actuel</div>
                                    <h3 class="consumption-value">{{ $consommationEau->index_compteur }} m³</h3>
                                </div>
                            </div>

                            <!-- Consommation -->
                            <div class="consumption-card animate-delay-3">
                                <div class="consumption-icon">
                                    <i class="fas fa-tint"></i>
                                </div>
                                <div>
                                    <div class="consumption-label">Consommation totale</div>
                                    <h3 class="consumption-value">{{ $consommationEau->consommation }} m³</h3>
                                </div>
                            </div>

                            <!-- Prix du m³ -->
                            <div class="consumption-card animate-delay-4">
                                <div class="consumption-icon">
                                    <i class="fas fa-money-bill"></i>
                                </div>
                                <div>
                                    <div class="consumption-label">Prix du m³</div>
                                    <h3 class="consumption-value">
                                        {{ number_format($consommationEau->prix_m3, 0, ',', ' ') }} FCFA</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Montant total -->
                        <div class="amount-section animate-delay-3">
                            <div class="amount-label">Montant à payer</div>
                            <h2 class="amount-value">{{ number_format($consommationEau->montant, 0, ',', ' ') }} FCFA</h2>
                            <div class="amount-subtitle">Facture d'eau pour la période indiquée</div>
                        </div>

                        <!-- Calcul détaillé -->
                        <div class="calculate-section animate-delay-4">
                            <div class="calculate-title">
                                <i class="fas fa-calculator"></i>Calcul détaillé
                            </div>
                            <div class="calculate-formula">
                                {{ $consommationEau->index_compteur }} m³ - {{ $consommationEau->index_precedent }} m³
                                = {{ $consommationEau->consommation }} m³<br>
                                {{ $consommationEau->consommation }} m³ × {{ $consommationEau->prix_m3 }} FCFA/m³
                                = {{ number_format($consommationEau->montant, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                    </div>

                    <!-- Statut de paiement -->
                    <div class="status-section animate-delay-5">
                        <div class="status-title">
                            <i class="fas fa-receipt"></i>Statut de Paiement
                        </div>

                        @if ($consommationEau->paiementEau)
                            <div class="d-flex align-items-center gap-3">
                                <span class="status-badge status-paid">
                                    <i class="fas fa-check-circle me-1"></i>Payé
                                </span>
                                <div class="payment-info">
                                    <div class="payment-title">
                                        <i class="fas fa-info-circle"></i>Informations de paiement
                                    </div>
                                    <div class="payment-details">
                                        @if ($consommationEau->paiementEau->methode)
                                            <strong>Méthode :</strong>
                                            {{ ucfirst($consommationEau->paiementEau->methode) }}<br>
                                        @endif
                                        @if ($consommationEau->paiementEau->date_paiement)
                                            <strong>Date :</strong>
                                            {{ \Carbon\Carbon::parse($consommationEau->paiementEau->date_paiement)->format('d/m/Y H:i') }}<br>
                                        @endif
                                        @if ($consommationEau->paiementEau->numero_transaction)
                                            <strong>N° transaction :</strong>
                                            {{ $consommationEau->paiementEau->numero_transaction }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="d-flex align-items-center gap-3">
                                <span class="status-badge status-unpaid">
                                    <i class="fas fa-clock me-1"></i>Non payé
                                </span>
                                <div>
                                    <p class="mb-2">Cette consommation n'a pas encore été payée.</p>
                                    @if (!$consommationEau->paiementEau)
                                        <form method="POST"
                                            action="{{ route('paiements-eau.store', ['consommationEau' => $consommationEau->id]) }}">
                                            @csrf

                                            <input type="hidden" name="montant_paye"
                                                value="{{ $consommationEau->montant }}">
                                            <input type="hidden" name="methode" value="especes">
                                            <input type="hidden" name="date_paiement"
                                                value="{{ now()->toDateString() }}">

                                            <button type="submit" class="btn btn-success">
                                                Payer l’eau
                                            </button>
                                        </form>
                                    @endif


                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Boutons d'action -->
                    <div class="action-buttons">
                        <a href="{{ route('consommations-eau.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-2"></i>Retour à la liste
                        </a>

                        @if (!$consommationEau->paiementEau)
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="fas fa-print me-2"></i>Imprimer la facture
                            </button>
                        @endif

                        <a href=" {{ route('consommations-eau.facture', $consommationEau) }} " class="btn btn-primary"
                            target="_blank">
                            <i class="fas fa-file-invoice me-2"></i>Voir la facture
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
            // Animation des éléments
            const animatedElements = document.querySelectorAll(
                '.animate-delay-1, .animate-delay-2, .animate-delay-3, .animate-delay-4, .animate-delay-5');
            animatedElements.forEach(element => {
                element.classList.add('animate__animated');

                if (element.classList.contains('consumption-card')) {
                    element.classList.add('animate__fadeInUp');
                } else if (element.classList.contains('user-info')) {
                    element.classList.add('animate__fadeInRight');
                } else if (element.classList.contains('property-info')) {
                    element.classList.add('animate__fadeInLeft');
                } else if (element.classList.contains('amount-section')) {
                    element.classList.add('animate__fadeInUp');
                } else if (element.classList.contains('status-section')) {
                    element.classList.add('animate__fadeInRight');
                } else {
                    element.classList.add('animate__fadeIn');
                }
            });

            // Animation au survol des cartes
            const consumptionCards = document.querySelectorAll('.consumption-card');
            consumptionCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Animation du montant
            const amountSection = document.querySelector('.amount-section');
            setInterval(() => {
                amountSection.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    amountSection.classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            }, 5000);

            // Confirmation avant paiement
            const payButton = document.querySelector('form button[type="submit"]');
            if (payButton) {
                payButton.addEventListener('click', function(e) {
                    const amount = document.querySelector('.amount-value').textContent;
                    if (!confirm(
                            `Confirmez-vous le paiement de ${amount} pour cette consommation d'eau ?`)) {
                        e.preventDefault();
                        return false;
                    }

                    // Animation pendant le paiement
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Traitement en cours...';
                    this.disabled = true;
                });
            }

            // Animation du bouton d'impression
            const printBtn = document.querySelector('button[onclick*="print"]');
            if (printBtn) {
                printBtn.addEventListener('click', function(e) {
                    // Animation pendant l'impression
                    this.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        this.classList.remove('animate__animated', 'animate__pulse');
                    }, 1000);
                });
            }
        });
    </script>
@endpush
