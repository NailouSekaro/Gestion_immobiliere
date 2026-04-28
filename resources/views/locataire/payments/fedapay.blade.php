@extends('layouts.template')

@section('title', 'Paiement en ligne - FedaPay')

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
            --success: #10b981;
            --success-dark: #059669;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
            --fedapay: #0a2540;
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

        .btn-fedapay {
            background: linear-gradient(135deg, #0a2540 0%, #1a3a5f 100%);
            color: white;
        }

        .btn-fedapay:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(10, 37, 64, 0.3);
        }

        .card {
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
        }

        .card-header .header-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            margin-right: 1rem;
        }

        .card-body {
            padding: 2rem;
        }

        .alert-glass {
            background: rgba(239, 68, 68, 0.1);
            backdrop-filter: blur(10px);
            border-left: 4px solid var(--danger);
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            animation: slideInDown 0.5s ease forwards;
            opacity: 0;
        }

        .alert-success-glass {
            background: rgba(16, 185, 129, 0.1);
            backdrop-filter: blur(10px);
            border-left: 4px solid var(--success);
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            animation: slideInDown 0.5s ease forwards;
            opacity: 0;
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

        .alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .alert-danger .alert-icon {
            background: rgba(239, 68, 68, 0.2);
        }

        .alert-success .alert-icon {
            background: rgba(16, 185, 129, 0.2);
        }

        .info-card {
            background: linear-gradient(135deg, var(--primary-light), rgba(67, 97, 238, 0.1));
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary);
        }

        .info-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }

        .info-title i {
            margin-right: 0.5rem;
        }

        .info-text {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 0.5rem;
            color: var(--primary);
        }

        .form-select {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            transition: var(--transition);
            font-size: 1rem;
            background-color: #f9fafc;
            cursor: pointer;
        }

        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
            transform: translateY(-1px);
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .payment-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: var(--transition);
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }

        .payment-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
            border-color: var(--primary-light);
        }

        .payment-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .payment-period {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
        }

        .payment-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .status-overdue {
            background: #fee2e2;
            color: #991b1b;
        }

        .payment-body {
            padding: 1.5rem;
        }

        .payment-property {
            color: var(--gray);
            font-size: 0.85rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .payment-property i {
            margin-right: 0.5rem;
            color: var(--primary);
        }

        .payment-amount {
            margin-bottom: 1rem;
        }

        .amount-label {
            font-size: 0.75rem;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .amount-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
        }

        .payment-deadline {
            margin-bottom: 1.5rem;
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .deadline-label {
            font-size: 0.7rem;
            color: var(--gray);
            text-transform: uppercase;
        }

        .deadline-value {
            font-weight: 600;
            color: var(--dark);
        }

        .deadline-overdue {
            color: var(--danger);
        }

        .payment-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: #f8fafc;
            border-radius: 12px;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--gray);
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .empty-state h4 {
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .btn-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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

            .page-header {
                flex-direction: column;
                gap: 1rem;
            }

            .payment-grid {
                grid-template-columns: 1fr;
            }

            .payment-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-credit-card"></i>Paiement en ligne
                </h1>
                <p class="page-subtitle">Payez votre loyer en toute sécurité via FedaPay</p>
            </div>
            <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Mes paiements
            </a>
        </div>
    </div>

    <!-- Messages d'alerte -->
    @if (session('error'))
        <div class="alert-glass alert-danger animate__animated animate__shakeX">
            <div class="d-flex align-items-center">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-circle text-danger"></i>
                </div>
                <div>
                    <strong class="text-danger">Erreur !</strong>
                    <p class="mb-0 text-danger">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="alert-success-glass alert-success animate__animated animate__pulse">
            <div class="d-flex align-items-center">
                <div class="alert-icon">
                    <i class="fas fa-check-circle text-success"></i>
                </div>
                <div>
                    <strong class="text-success">Succès !</strong>
                    <p class="mb-0 text-success">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-glass alert-danger animate__animated animate__shakeX">
            <div class="d-flex align-items-center">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                </div>
                <div>
                    <strong class="text-danger">Erreurs de validation</strong>
                    <ul class="mb-0 text-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulaire de paiement -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="header-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div>
                    <h5 class="mb-0">Nouveau paiement</h5>
                    <small>Choisissez le mois à régler</small>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="info-card">
                <div class="info-title">
                    <i class="fas fa-info-circle"></i>Informations importantes
                </div>
                <p class="info-text">
                    Le paiement en ligne règle le montant total du loyer pour le mois sélectionné.
                    Si votre compte FedaPay a un plafond inférieur au montant du loyer, veuillez contacter votre banque pour une augmentation de plafond.
                </p>
            </div>

            <form method="POST" action="{{ route('paiements.fedapay.initiate') }}" id="paymentForm">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mois" class="form-label">
                                <i class="fas fa-calendar-alt"></i>Mois
                            </label>
                            <select name="mois" id="mois" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach ($months as $number => $label)
                                    <option value="{{ $number }}" {{ (int) old('mois', now()->month) === $number ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="annee" class="form-label">
                                <i class="fas fa-calendar"></i>Année
                            </label>
                            <select name="annee" id="annee" class="form-select" required>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ (int) old('annee', now()->year) === $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-fedapay w-100" id="initiateBtn">
                                <i class="fas fa-credit-card me-2"></i>
                                <span>Initier le paiement FedaPay</span>
                                <span class="btn-spinner ms-2" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des paiements existants -->
    @if ($payments->isEmpty())
        <div class="card">
            <div class="card-body">
                <div class="empty-state">
                    <i class="fas fa-receipt"></i>
                    <h4>Aucun paiement à régler</h4>
                    <p>Tous vos paiements sont déjà réglés ou aucun paiement n'est encore généré.</p>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Paiements générés</h4>
            <span class="badge bg-primary">{{ $payments->count() }} paiement(s)</span>
        </div>

        <div class="payment-grid">
            @foreach ($payments as $payment)
                <div class="payment-card animate-delay-{{ min($loop->index + 1, 5) }}">
                    <div class="payment-header">
                        <span class="payment-period">
                            <i class="fas fa-calendar-alt me-1"></i>{{ $payment->periode }}
                        </span>
                        <span class="payment-status status-{{ $payment->statut === 'en_attente' ? 'pending' : ($payment->statut === 'paye' ? 'paid' : 'overdue') }}">
                            <i class="fas {{ $payment->statut === 'en_attente' ? 'fa-clock' : ($payment->statut === 'paye' ? 'fa-check-circle' : 'fa-exclamation-triangle') }} me-1"></i>
                            {{ ucfirst(str_replace('_', ' ', $payment->statut)) }}
                        </span>
                    </div>
                    <div class="payment-body">
                        <div class="payment-property">
                            <i class="fas fa-building"></i>
                            {{ $payment->property->nom ?? 'Bien non renseigné' }}
                            @if($payment->property && $payment->property->ville)
                                <span class="text-muted ms-1">({{ $payment->property->ville }})</span>
                            @endif
                        </div>

                        <div class="payment-amount">
                            <div class="amount-label">Montant</div>
                            <div class="amount-value">{{ number_format($payment->montant, 0, ',', ' ') }} FCFA</div>
                        </div>

                        <div class="payment-deadline">
                            <div class="deadline-label">Date limite</div>
                            <div class="deadline-value {{ optional($payment->date_limite)->isPast() && $payment->statut !== 'paye' ? 'deadline-overdue' : '' }}">
                                <i class="fas fa-calendar-day me-1"></i>
                                {{ optional($payment->date_limite)->format('d/m/Y') ?? 'Non définie' }}
                                @if(optional($payment->date_limite)->isPast() && $payment->statut !== 'paye')
                                    <span class="ms-2 text-danger">
                                        <i class="fas fa-exclamation-circle"></i> En retard
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="payment-actions">
                            <form method="POST" action="{{ route('locataire.payments.fedapay', $payment) }}" class="w-100">
                                @csrf
                                <button type="submit" class="btn btn-fedapay w-100 payment-btn" data-payment-id="{{ $payment->id }}">
                                    <i class="fas fa-credit-card me-2"></i>
                                    <span>Payer avec FedaPay</span>
                                    <span class="btn-spinner ms-2" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                </button>
                            </form>

                            <a href="{{ route('paiements.show', $payment) }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-eye me-2"></i>Voir le détail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des formulaires de paiement
    const paymentForms = document.querySelectorAll('form[action*="fedapay"]');

    paymentForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const spinner = submitBtn.querySelector('.btn-spinner');
            const btnText = submitBtn.querySelector('span:not(.btn-spinner)');

            // Afficher le spinner
            spinner.style.display = 'inline-block';
            submitBtn.disabled = true;
            btnText.innerHTML = 'Traitement en cours...';

            // Animation
            submitBtn.classList.add('animate__animated', 'animate__pulse');

            // Confirmation
            if (!confirm('Confirmez-vous le paiement de ce loyer via FedaPay ?')) {
                e.preventDefault();
                spinner.style.display = 'none';
                submitBtn.disabled = false;
                btnText.innerHTML = 'Payer avec FedaPay';
                submitBtn.classList.remove('animate__animated', 'animate__pulse');
            }
        });
    });

    // Gestion du formulaire d'initiation
    const initiateForm = document.getElementById('paymentForm');
    if (initiateForm) {
        initiateForm.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('initiateBtn');
            const spinner = submitBtn.querySelector('.btn-spinner');
            const btnText = submitBtn.querySelector('span:not(.btn-spinner)');

            // Afficher le spinner
            spinner.style.display = 'inline-block';
            submitBtn.disabled = true;
            btnText.innerHTML = 'Initialisation...';

            // Animation
            submitBtn.classList.add('animate__animated', 'animate__pulse');
        });
    }

    // Animation des cartes
    const paymentCards = document.querySelectorAll('.payment-card');
    paymentCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endpush
