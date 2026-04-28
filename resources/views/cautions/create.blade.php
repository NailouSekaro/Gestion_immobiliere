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

        .caution-form-container {
            max-width: 800px;
            margin: 0 auto;
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
            text-align: center;
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

        .page-subtitle {
            color: var(--gray);
            font-size: 1rem;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            overflow: hidden;
            background: white;
            margin-bottom: 2rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .card-body {
            padding: 2.5rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary-light);
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

        .section-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .section-icon i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
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

        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .form-label i {
            margin-right: 0.5rem;
            color: var(--primary);
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            transition: var(--transition);
            font-size: 1rem;
            background-color: #f9fafc;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
            background-color: white;
            transform: translateY(-2px);
        }

        select.form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px;
            padding-right: 3rem;
            cursor: pointer;
        }

        .input-group {
            position: relative;
        }

        .currency-symbol {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-weight: 500;
            pointer-events: none;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 2rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary);
            content: '➕';
            font-size: 1.2rem;
        }

        .caution-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .caution-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .caution-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.1);
        }

        .caution-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary), var(--primary-dark));
        }

        .caution-card:nth-child(2)::before {
            background: linear-gradient(180deg, #4cc9f0, #3a8fb8);
        }

        .caution-card:nth-child(3)::before {
            background: linear-gradient(180deg, #facc15, #d97706);
        }

        .caution-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(67, 97, 238, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .caution-icon i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .caution-card:nth-child(2) .caution-icon {
            background: rgba(76, 201, 240, 0.1);
        }

        .caution-card:nth-child(2) .caution-icon i {
            color: #4cc9f0;
        }

        .caution-card:nth-child(3) .caution-icon {
            background: rgba(250, 204, 21, 0.1);
        }

        .caution-card:nth-child(3) .caution-icon i {
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

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .payment-method {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
            background: white;
        }

        .payment-method:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .payment-method.selected {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(67, 97, 238, 0.1) 100%);
        }

        .payment-method-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .payment-method-icon i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .payment-method-name {
            font-weight: 500;
            color: var(--dark);
            margin: 0;
        }

        .alert-glass {
            background: rgba(220, 38, 38, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-left: 4px solid var(--danger);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .alert-icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(220, 38, 38, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .alert-icon-wrapper i {
            color: var(--danger);
        }

        .btn {
            padding: 0.9rem 2rem;
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
            font-size: 1rem;
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

        .btn-success {
            background: linear-gradient(135deg, #4cc9f0 0%, #3a8fb8 100%);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #3a8fb8 0%, #4cc9f0 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(76, 201, 240, 0.3);
        }

        .btn-back {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
            padding: 0.7rem 1.5rem;
            font-size: 0.9rem;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #475569 0%, #64748b 100%);
            transform: translateY(-2px);
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
        }

        .total-caution {
            text-align: right;
            padding: 1rem 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-radius: 12px;
            border: 2px solid var(--primary-light);
        }

        .total-label {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
        }

        .total-amount {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0;
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

            .caution-grid {
                grid-template-columns: 1fr;
            }

            .payment-methods {
                grid-template-columns: 1fr;
            }

            .form-footer {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="caution-form-container">
        <!-- En-tête -->
        <div class="page-header">
            <h1 class="page-title">Paiement de la Caution</h1>
            <p class="page-subtitle">Enregistrez les cautions des locataires pour leur nouvelle location</p>
        </div>

        <!-- Messages d'erreur -->
        @if(session('error'))
        <div class="alert-glass animate__animated animate__shakeX">
            <div class="d-flex align-items-center">
                <div class="alert-icon-wrapper">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div>
                    <h5 class="mb-1" style="color: var(--danger);">Erreur de paiement</h5>
                    <p class="mb-0" style="color: var(--danger-dark);">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Formulaire principal -->
        <form method="POST" action="{{ route('cautions.store') }}" id="cautionForm" class="card">
            @csrf

            <div class="card-body">
                <!-- Section Locataire -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 class="section-title">Sélection du Locataire</h3>
                </div>

                <div class="form-group animate-delay-1">
                    <label class="form-label">
                        <i class="fas fa-user-circle"></i>Locataire
                    </label>
                    <select name="user_id" class="form-select" required>
                        <option value="">-- Sélectionnez un locataire --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" data-address="{{ $user->property ? $user->property->adresse : 'Aucune adresse' }}">
                                {{ $user->prenom }} {{ $user->nom }}
                                @if($user->property)
                                    — {{ $user->property->adresse }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <div id="addressInfo" class="mt-2" style="display: none;">
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            <span id="selectedAddress"></span>
                        </small>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Section Cautions -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="section-title">Détails des Cautions</h3>
                </div>

                <div class="caution-grid">
                    <div class="caution-card animate-delay-2">
                        <div class="caution-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div>
                            <div class="caution-label">Caution Chambre</div>
                            <div class="input-group">
                                <input type="number"
                                       name="caution_chambre"
                                       class="form-control caution-input"
                                       value="60000"
                                       min="0"
                                       required
                                       data-type="chambre">
                                <div class="currency-symbol">FCFA</div>
                            </div>
                        </div>
                    </div>

                    <div class="caution-card animate-delay-3">
                        <div class="caution-icon">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div>
                            <div class="caution-label">Caution Eau</div>
                            <div class="input-group">
                                <input type="number"
                                       name="caution_eau"
                                       class="form-control caution-input"
                                       value="10000"
                                       min="0"
                                       data-type="eau">
                                <div class="currency-symbol">FCFA</div>
                            </div>
                        </div>
                    </div>

                    <div class="caution-card animate-delay-4">
                        <div class="caution-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <div class="caution-label">Caution Électricité</div>
                            <div class="input-group">
                                <input type="number"
                                       name="caution_electricite"
                                       class="form-control caution-input"
                                       value="10000"
                                       min="0"
                                       data-type="electricite">
                                <div class="currency-symbol">FCFA</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Section Paiement -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3 class="section-title">Méthode de Paiement</h3>
                </div>

                <div class="payment-methods">
                    <div class="payment-method animate-delay-2" data-method="especes">
                        <div class="payment-method-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div>
                            <p class="payment-method-name">Espèces</p>
                        </div>
                    </div>

                    <div class="payment-method animate-delay-3" data-method="mtn_momo">
                        <div class="payment-method-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div>
                            <p class="payment-method-name">MTN MoMo</p>
                        </div>
                    </div>

                    <div class="payment-method animate-delay-4" data-method="orange_money">
                        <div class="payment-method-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div>
                            <p class="payment-method-name">Orange Money</p>
                        </div>
                    </div>

                    <div class="payment-method animate-delay-5" data-method="wave">
                        <div class="payment-method-icon">
                            <i class="fas fa-wave-square"></i>
                        </div>
                        <div>
                            <p class="payment-method-name">Wave</p>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="methode" id="selectedMethod" value="especes" required>

                <div class="form-group animate-delay-2">
                    <label class="form-label">
                        <i class="fas fa-calendar-day"></i>Date et Heure du Paiement
                    </label>
                    <input type="datetime-local"
                           name="date_paiement"
                           class="form-control"
                           required
                           value="{{ date('Y-m-d\TH:i') }}">
                </div>

                <!-- Pied de formulaire -->
                <div class="form-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>

                    <div class="total-caution">
                        <div class="total-label">Total de la Caution</div>
                        <h3 class="total-amount" id="totalAmount">80,000 FCFA</h3>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-shield-alt me-2"></i>
                        <span>Enregistrer la Caution</span>
                        <span class="btn-spinner ms-2" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation
    const cautionForm = document.getElementById('cautionForm');
    const cautionInputs = document.querySelectorAll('.caution-input');
    const totalAmount = document.getElementById('totalAmount');
    const paymentMethods = document.querySelectorAll('.payment-method');
    const selectedMethodInput = document.getElementById('selectedMethod');
    const userSelect = document.querySelector('select[name="user_id"]');
    const addressInfo = document.getElementById('addressInfo');
    const selectedAddress = document.getElementById('selectedAddress');
    const submitBtn = cautionForm.querySelector('.btn-success');
    const btnSpinner = submitBtn.querySelector('.btn-spinner');

    // Calcul du total
    function calculateTotal() {
        let total = 0;
        cautionInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });

        // Formatage avec séparateurs de milliers
        const formattedTotal = new Intl.NumberFormat('fr-FR').format(total);
        totalAmount.textContent = `${formattedTotal} FCFA`;

        // Animation sur le total
        totalAmount.classList.add('animate__animated', 'animate__pulse');
        setTimeout(() => {
            totalAmount.classList.remove('animate__animated', 'animate__pulse');
        }, 500);

        return total;
    }

    // Mise à jour du total à chaque changement
    cautionInputs.forEach(input => {
        input.addEventListener('input', function() {
            calculateTotal();

            // Animation sur le champ modifié
            this.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__pulse');
            }, 500);
        });

        input.addEventListener('focus', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 5px 15px rgba(67, 97, 238, 0.1)';
        });

        input.addEventListener('blur', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });

    // Sélection de la méthode de paiement
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            // Retirer la classe selected de toutes les méthodes
            paymentMethods.forEach(m => m.classList.remove('selected'));

            // Ajouter la classe selected à la méthode cliquée
            this.classList.add('selected');

            // Animation
            this.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__pulse');
            }, 500);

            // Mettre à jour le champ caché
            const methodValue = this.getAttribute('data-method');
            selectedMethodInput.value = methodValue;
        });
    });

    // Sélection automatique de la première méthode
    document.querySelector('.payment-method[data-method="especes"]').classList.add('selected');

    // Affichage de l'adresse du locataire
    userSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const address = selectedOption.getAttribute('data-address');

        if (this.value && address !== 'Aucune adresse') {
            selectedAddress.textContent = address;
            addressInfo.style.display = 'block';

            // Animation
            addressInfo.classList.add('animate__animated', 'animate__fadeIn');
            setTimeout(() => {
                addressInfo.classList.remove('animate__animated', 'animate__fadeIn');
            }, 500);
        } else {
            addressInfo.style.display = 'none';
        }

        // Animation sur la sélection
        this.classList.add('animate__animated', 'animate__pulse');
        setTimeout(() => {
            this.classList.remove('animate__animated', 'animate__pulse');
        }, 500);
    });

    // Gestion de la soumission du formulaire
    cautionForm.addEventListener('submit', function(e) {
        const total = calculateTotal();

        if (total === 0) {
            e.preventDefault();
            alert('Veuillez saisir au moins un montant de caution.');
            return;
        }

        // Afficher le spinner
        btnSpinner.style.display = 'inline-block';
        submitBtn.disabled = true;
        submitBtn.classList.add('animate__animated', 'animate__pulse');

        // Récupérer les informations pour la confirmation
        const userName = userSelect.options[userSelect.selectedIndex].textContent;
        const method = document.querySelector('.payment-method.selected .payment-method-name').textContent;

        // Confirmation
        if (!confirm(`Confirmez-vous l'enregistrement de la caution de ${totalAmount.textContent} pour ${userName} via ${method} ?`)) {
            e.preventDefault();
            btnSpinner.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.classList.remove('animate__animated', 'animate__pulse');
        }
    });

    // Animation d'entrée des éléments
    const animatedElements = document.querySelectorAll('.form-group, .caution-card, .payment-method');
    animatedElements.forEach((element, index) => {
        element.style.animationDelay = `${(index * 0.1) + 0.3}s`;
        element.classList.add('animate__animated');

        // Définir l'animation selon le type d'élément
        if (element.classList.contains('form-group')) {
            element.classList.add('animate__fadeInRight');
        } else if (element.classList.contains('caution-card')) {
            element.classList.add('animate__fadeInUp');
        } else if (element.classList.contains('payment-method')) {
            element.classList.add('animate__fadeInUp');
        }
    });

    // Calcul initial du total
    calculateTotal();
});
</script>
@endpush
