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
            max-width: 1200px;
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
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
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
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
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

        .caution-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .caution-item {
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

        .caution-item:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .caution-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary), var(--primary-dark));
        }

        .caution-item:nth-child(2)::before {
            background: linear-gradient(180deg, #4cc9f0, #3a8fb8);
        }

        .caution-item:nth-child(3)::before {
            background: linear-gradient(180deg, #facc15, #d97706);
        }

        .caution-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            background: rgba(67, 97, 238, 0.1);
        }

        .caution-item:nth-child(2) .caution-icon {
            background: rgba(76, 201, 240, 0.1);
        }

        .caution-item:nth-child(3) .caution-icon {
            background: rgba(250, 204, 21, 0.1);
        }

        .caution-icon i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .caution-item:nth-child(2) .caution-icon i {
            color: #4cc9f0;
        }

        .caution-item:nth-child(3) .caution-icon i {
            color: #facc15;
        }

        .caution-label {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .caution-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .status-paid {
            background: linear-gradient(135deg, rgba(52, 211, 153, 0.1), rgba(5, 150, 105, 0.1));
            color: #065f46;
        }

        .status-not-paid {
            background: linear-gradient(135deg, rgba(251, 113, 133, 0.1), rgba(225, 29, 72, 0.1));
            color: #881337;
        }

        .total-card {
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

        .total-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .total-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .total-label {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .total-amount {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .payment-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            border-left: 4px solid #4cc9f0;
            animation: fadeInRight 0.5s ease forwards;
            opacity: 0;
        }

        .payment-method {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .payment-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(76, 201, 240, 0.1);
        }

        .payment-icon i {
            color: #4cc9f0;
        }

        .payment-details {
            flex: 1;
        }

        .payment-label {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 0.25rem;
        }

        .payment-value {
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 3rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .receipt-card {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            margin-top: 2rem;
            border: 2px solid #facc15;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .receipt-icon {
            font-size: 3rem;
            color: #d97706;
            margin-bottom: 1rem;
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

            .card-body {
                padding: 1.5rem;
            }

            .caution-details-grid {
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

            .total-amount {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <!-- Bouton retour -->
    <div class="back-button animate-delay-1">
        <a href="{{ route('cautions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    <!-- En-tête de page -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-file-invoice-dollar"></i>Détails de la Caution
        </h1>
        <p class="page-subtitle">Informations détaillées sur le paiement de la caution</p>
    </div>

    <!-- Carte principale -->
    <div class="card">
        <div class="card-header">
            <div class="header-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div>
                <h5 class="mb-0">Caution #{{ $caution->id }}</h5>
                <small>Enregistrée le {{ $caution->created_at->format('d/m/Y à H:i') }}</small>
            </div>
        </div>

        <div class="card-body">
            <!-- Informations du locataire -->
            <div class="info-section">
                <h4 class="section-title">
                    <i class="fas fa-user"></i>Informations du Locataire
                </h4>

                <div class="user-info animate-delay-1">
                    @if($caution->user->photo_profil)
                    <img src="{{ asset('storage/' . $caution->user->photo_profil) }}"
                         alt="{{ $caution->user->prenom }}"
                         class="user-avatar">
                    @else
                    <div class="user-avatar" style="background: linear-gradient(135deg, var(--primary-light), var(--primary)); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user fa-2x text-white"></i>
                    </div>
                    @endif
                    <div class="user-details">
                        <h3 class="user-name">{{ $caution->user->prenom }} {{ $caution->user->nom }}</h3>
                        <p class="user-email">
                            <i class="fas fa-envelope me-1"></i>{{ $caution->user->email }}
                        </p>
                        @if($caution->user->telephone)
                        <p class="text-muted">
                            <i class="fas fa-phone me-1"></i>{{ $caution->user->telephone }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Détails des cautions -->
            <div class="info-section">
                <h4 class="section-title">
                    <i class="fas fa-money-bill-wave"></i>Détails des Cautions
                </h4>

                <div class="caution-details-grid">
                    <!-- Caution chambre -->
                    <div class="caution-item animate-delay-1">
                        <div class="caution-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div>
                            <div class="caution-label">Caution Chambre</div>
                            <h3 class="caution-amount">60,000 FCFA</h3>
                            <span class="status-badge status-paid">
                                <i class="fas fa-check-circle me-1"></i>Payée
                            </span>
                        </div>
                    </div>

                    <!-- Caution eau -->
                    <div class="caution-item animate-delay-2">
                        <div class="caution-icon">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div>
                            <div class="caution-label">Caution Eau</div>
                            <h3 class="caution-amount">
                                {{ $caution->caution_eau ? number_format($caution->caution_eau, 0, ',', ' ') . ' FCFA' : '0 FCFA' }}
                            </h3>
                            <span class="status-badge {{ $caution->caution_eau ? 'status-paid' : 'status-not-paid' }}">
                                <i class="fas {{ $caution->caution_eau ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                {{ $caution->caution_eau ? 'Payée' : 'Non payée' }}
                            </span>
                        </div>
                    </div>

                    <!-- Caution électricité -->
                    <div class="caution-item animate-delay-3">
                        <div class="caution-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <div class="caution-label">Caution Électricité</div>
                            <h3 class="caution-amount">
                                {{ $caution->caution_electricite ? number_format($caution->caution_electricite, 0, ',', ' ') . ' FCFA' : '0 FCFA' }}
                            </h3>
                            <span class="status-badge {{ $caution->caution_electricite ? 'status-paid' : 'status-not-paid' }}">
                                <i class="fas {{ $caution->caution_electricite ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                {{ $caution->caution_electricite ? 'Payée' : 'Non payée' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="total-card animate-delay-4">
                    <div class="total-label">Total de la Caution</div>
                    <h2 class="total-amount">{{ number_format($caution->total_caution, 0, ',', ' ') }} FCFA</h2>
                    <small style="opacity: 0.8; position: relative; z-index: 1;">Montant total encaissé</small>
                </div>

                <!-- Informations de paiement -->
                <div class="payment-info animate-delay-5">
                    <h4 class="section-title" style="border-bottom: none; padding-bottom: 0;">
                        <i class="fas fa-credit-card"></i>Informations de Paiement
                    </h4>

                    <div class="payment-method">
                        <div class="payment-icon">
                            @php
                                $methodIcons = [
                                    'especes' => 'money-bill-wave',
                                    'mtn_momo' => 'mobile-alt',
                                    'orange_money' => 'mobile-alt',
                                    'wave' => 'wave-square'
                                ];
                                $methodNames = [
                                    'especes' => 'Espèces',
                                    'mtn_momo' => 'MTN MoMo',
                                    'orange_money' => 'Orange Money',
                                    'wave' => 'Wave'
                                ];
                            @endphp
                            <i class="fas fa-{{ $methodIcons[$caution->methode] ?? 'money-bill-wave' }}"></i>
                        </div>
                        <div class="payment-details">
                            <div class="payment-label">Méthode de paiement</div>
                            <p class="payment-value">{{ $methodNames[$caution->methode] ?? 'Espèces' }}</p>
                        </div>
                    </div>

                    <div class="payment-method">
                        <div class="payment-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="payment-details">
                            <div class="payment-label">Date et heure du paiement</div>
                            <p class="payment-value">
                                {{ \Carbon\Carbon::parse($caution->date_paiement)->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte de téléchargement -->
            <div class="receipt-card animate-delay-4">
                <div class="receipt-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <h4>Télécharger le Reçu</h4>
                <p class="text-muted mb-3">Générez un reçu officiel pour cette caution</p>
                <a href="{{ route('cautions.receipt', $caution) }}"
                   class="btn btn-success"
                   target="_blank">
                    <i class="fas fa-download me-2"></i>Télécharger le Reçu
                </a>
            </div>

            <!-- Boutons d'action -->
            <div class="action-buttons">
                <a href="{{ route('cautions.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list me-2"></i>Retour à la liste
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Imprimer
                </button>
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
    const animatedElements = document.querySelectorAll('.animate-delay-1, .animate-delay-2, .animate-delay-3, .animate-delay-4, .animate-delay-5');
    animatedElements.forEach(element => {
        element.classList.add('animate__animated');

        if (element.classList.contains('caution-item')) {
            element.classList.add('animate__fadeInUp');
        } else if (element.classList.contains('user-info')) {
            element.classList.add('animate__fadeInRight');
        } else if (element.classList.contains('total-card')) {
            element.classList.add('animate__fadeInUp');
        } else if (element.classList.contains('payment-info')) {
            element.classList.add('animate__fadeInRight');
        } else {
            element.classList.add('animate__fadeIn');
        }
    });

    // Animation au survol des cartes
    const cautionItems = document.querySelectorAll('.caution-item');
    cautionItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });

        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Animation du total
    const totalCard = document.querySelector('.total-card');
    setInterval(() => {
        totalCard.classList.add('animate__animated', 'animate__pulse');
        setTimeout(() => {
            totalCard.classList.remove('animate__animated', 'animate__pulse');
        }, 1000);
    }, 5000);

    // Confirmation avant impression
    const printBtn = document.querySelector('button[onclick*="print"]');
    if (printBtn) {
        printBtn.addEventListener('click', function(e) {
            if (!confirm('Voulez-vous imprimer cette page ?')) {
                e.preventDefault();
                return false;
            }

            // Animation pendant l'impression
            this.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__pulse');
            }, 1000);
        });
    }

    // Animation du bouton de téléchargement
    const downloadBtn = document.querySelector('.btn-success');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function() {
            // Animation pendant le téléchargement
            const icon = this.querySelector('i');
            const originalIcon = icon.className;
            icon.className = 'fas fa-spinner fa-spin me-2';

            setTimeout(() => {
                icon.className = originalIcon;
            }, 3000);

            // Animation sur le bouton
            this.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__pulse');
            }, 1000);
        });
    }

    // Animation du montant total
    const totalAmount = document.querySelector('.total-amount');
    setInterval(() => {
        totalAmount.classList.add('animate__animated', 'animate__pulse');
        setTimeout(() => {
            totalAmount.classList.remove('animate__animated', 'animate__pulse');
        }, 500);
    }, 10000);
});
</script>
@endpush
