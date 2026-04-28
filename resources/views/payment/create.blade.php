@extends('layouts.template')

@section('title', 'Enregistrer un Paiement')

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

            .container-fluid {
                padding: 2rem 0;
                max-width: 1400px;
            }

            .text-gradient {
                background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .page-header {
                padding: 2rem 0;
                margin-bottom: 2rem;
            }

            .page-title {
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

            .btn-secondary {
                background: linear-gradient(to right, #64748b, #475569);
                color: white;
            }

            .btn-secondary:hover {
                background: linear-gradient(to right, #475569, #334155);
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(100, 116, 139, 0.3);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                color: white;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
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

            .card {
                border: none;
                border-radius: 16px;
                box-shadow: var(--card-shadow);
                transition: var(--transition);
                overflow: hidden;
                background: white;
                margin-bottom: 1.5rem;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: var(--card-hover-shadow);
            }

            .card-header {
                padding: 1.5rem;
                font-weight: 600;
                background: linear-gradient(120deg, var(--primary), var(--primary-dark)) !important;
                color: white;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .card-header.bg-gradient-info {
                background: linear-gradient(120deg, #60a5fa, #3b82f6) !important;
            }

            .card-header .d-flex {
                align-items: center;
            }

            .header-icon-wrapper {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(10px);
                margin-right: 1rem;
            }

            .card-body {
                padding: 2rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
                position: relative;
            }

            .floating-label {
                position: relative;
                padding-top: 1.5rem;
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

            .form-control,
            .form-select {
                width: 100%;
                padding: 0.9rem 1.2rem;
                border: 2px solid #e2e8f0;
                border-radius: 10px;
                transition: var(--transition);
                font-size: 1rem;
                background-color: #f9fafc;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
                outline: none;
                background-color: white;
                transform: translateY(-1px);
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
                transition: var(--transition);
            }

            .input-group:focus-within {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .input-group-text {
                background: var(--primary-light);
                border: 2px solid #e2e8f0;
                color: var(--primary);
                font-weight: 500;
            }

            .textarea-animated {
                transition: var(--transition);
                min-height: 100px;
                resize: vertical;
            }

            .textarea-animated:focus {
                min-height: 120px;
                transform: translateY(-1px);
            }

            .invalid-feedback {
                animation: shake 0.5s ease-in-out;
                color: var(--danger);
                font-weight: 500;
                margin-top: 0.5rem;
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

            .info-panel {
                position: sticky;
                top: 20px;
            }

            .info-item {
                padding: 1.5rem;
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border-radius: 12px;
                margin-bottom: 1rem;
                border-left: 4px solid var(--info);
                transition: var(--transition);
            }

            .info-item:hover {
                transform: translateX(5px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .info-item:nth-child(2) {
                border-left-color: var(--warning);
            }

            .info-icon-wrapper {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(58, 12, 163, 0.1));
                margin-right: 1rem;
                flex-shrink: 0;
            }

            .info-content {
                flex: 1;
            }

            .info-title {
                font-size: 1rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                color: var(--dark);
            }

            .info-text {
                font-size: 0.875rem;
                color: var(--gray);
                line-height: 1.5;
            }

            .file-upload-wrapper {
                position: relative;
                overflow: hidden;
                border-radius: 10px;
                border: 2px dashed #e2e8f0;
                padding: 2rem;
                text-align: center;
                background: #f9fafc;
                transition: var(--transition);
                cursor: pointer;
            }

            .file-upload-wrapper:hover {
                border-color: var(--primary);
                background: rgba(67, 97, 238, 0.05);
                transform: translateY(-2px);
            }

            .file-upload-input {
                opacity: 0;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                cursor: pointer;
            }

            .file-upload-placeholder i {
                font-size: 2rem;
                color: var(--primary);
                margin-bottom: 1rem;
            }

            .progress-info {
                padding: 1rem;
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border-radius: 12px;
                border: 1px solid #e2e8f0;
            }

            .progress {
                height: 8px;
                border-radius: 4px;
                background: #e2e8f0;
                overflow: hidden;
            }

            .progress-bar {
                background: linear-gradient(90deg, var(--primary), var(--primary-dark));
                border-radius: 4px;
                transition: width 0.5s ease;
            }

            .progress-bar.progress-bar-striped {
                background-image: linear-gradient(45deg,
                        rgba(255, 255, 255, 0.15) 25%,
                        transparent 25%,
                        transparent 50%,
                        rgba(255, 255, 255, 0.15) 50%,
                        rgba(255, 255, 255, 0.15) 75%,
                        transparent 75%,
                        transparent);
                background-size: 1rem 1rem;
                animation: progress-bar-stripes 1s linear infinite;
            }

            @keyframes progress-bar-stripes {
                from {
                    background-position: 1rem 0;
                }

                to {
                    background-position: 0 0;
                }
            }

            .payment-method-card {
                border: 2px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
                animation: slideInDown 0.5s ease;
            }

            .payment-method-card .card-header {
                background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
                color: var(--dark);
                border-bottom: 1px solid #e2e8f0;
            }

            .info-card {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border-left: 4px solid var(--primary);
                animation: slideInRight 0.5s ease;
            }

            .alert-glass {
                background: rgba(248, 215, 218, 0.9);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-left: 4px solid var(--danger);
                border-radius: 10px;
                animation: slideInDown 0.5s ease;
            }

            .alert-icon-wrapper {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: rgba(220, 38, 38, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1rem;
            }

            .alert-icon-wrapper i {
                color: var(--danger);
                font-size: 1.25rem;
            }

            .btn-spinner {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .sticky-top {
                animation: slideInRight 0.5s ease;
            }

            .animate__animated {
                opacity: 0;
                animation-fill-mode: forwards;
            }

            .animate__fadeInLeft {
                animation: fadeInLeft 0.5s ease forwards;
            }

            .animate__fadeInRight {
                animation: fadeInRight 0.5s ease forwards;
            }

            .animate__fadeInDown {
                animation: fadeInDown 0.5s ease forwards;
            }

            .animate__fadeInUp {
                animation: fadeInUp 0.5s ease forwards;
            }

            .animate__headShake {
                animation: headShake 1s ease;
            }

            .animate__pulse {
                animation: pulse 2s infinite;
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

            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(20px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes headShake {
                0% {
                    transform: translateX(0);
                }

                6.5% {
                    transform: translateX(-6px) rotateY(-9deg);
                }

                18.5% {
                    transform: translateX(5px) rotateY(7deg);
                }

                31.5% {
                    transform: translateX(-3px) rotateY(-5deg);
                }

                43.5% {
                    transform: translateX(2px) rotateY(3deg);
                }

                50% {
                    transform: translateX(0);
                }
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }

                100% {
                    transform: scale(1);
                }
            }

            @media (max-width: 768px) {
                .container-fluid {
                    padding: 1rem;
                }

                .card-body {
                    padding: 1.5rem;
                }

                .btn {
                    padding: 0.6rem 1.2rem;
                }

                .info-item {
                    padding: 1rem;
                }

                .sticky-top {
                    position: static;
                }
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <!-- En-tête de page -->
            <div class="row mb-4 animate__animated animate__fadeInDown">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="page-title mb-1">Enregistrer un Paiement</h2>
                            <p class="text-muted mb-0">
                                <span class="text-gradient">Enregistrer un paiement manuel ou initier un paiement en
                                    ligne</span>
                            </p>
                        </div>
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>


            <!-- Messages d'erreur -->
            @if (session('error'))
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

            <!-- Contenu principal -->
            <div class="row g-4">
                <!-- Formulaire principal -->
                <div class="col-lg-8">
                    <div class="card animate__animated animate__fadeInLeft">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="header-icon-wrapper">
                                    <i class="fas fa-file-invoice-dollar fa-lg"></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Informations du Paiement</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data"
                                id="paymentForm">
                                @csrf

                                <!-- Sélection du locataire -->
                                <div class="form-group floating-label">
                                    <label for="user_id" class="form-label">
                                        <i class="fas fa-user"></i> Locataire <span class="text-danger">*</span>
                                    </label>
                                    <select name="user_id" id="user_id"
                                        class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">-- Sélectionner un locataire --</option>

                                        @foreach ($locataires as $locataire)
                                            @php
                                                $lastPayment = $locataire->paiements->first();
                                            @endphp

                                            <option value="{{ $locataire->id }}"
                                                data-property="{{ $locataire->property->adresse }}"
                                                data-loyer="{{ $locataire->property->loyer_mensuel }}"
                                                data-last-mois="{{ $lastPayment ? \Carbon\Carbon::parse($lastPayment->mois_paye)->month : '' }}"
                                                data-last-annee="{{ $lastPayment ? \Carbon\Carbon::parse($lastPayment->mois_paye)->year : '' }}">
                                                {{ $locataire->prenom }} {{ $locataire->nom }} - {{ $locataire->email }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div id="propertyCard" class="info-card mt-3" style="display: none;">
                                        <div class="card-body py-2">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="info-icon-wrapper me-3">
                                                            <i class="fas fa-home text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted d-block">Propriété</small>
                                                            <strong id="propertyAddress" class="text-dark"></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="info-icon-wrapper me-3">
                                                            <i class="fas fa-money-bill-wave text-success"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted d-block">Loyer mensuel</small>
                                                            <strong id="propertyRent" class="text-success"></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="paymentInfo" class="mt-3" style="display:none;">
                                    <div class="p-3 bg-light rounded border-start border-primary border-4">
                                        <strong>Informations paiement</strong><br>

                                        <span id="propertyInfo"></span><br>
                                        <span id="lastPaymentInfo"></span><br>
                                        <span id="delayInfo" class="fw-bold"></span>
                                    </div>
                                </div>


                                <!-- Période -->
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group floating-label">
                                            <label for="mois" class="form-label">
                                                <i class="fas fa-calendar-alt"></i> Mois <span class="text-danger">*</span>
                                            </label>
                                            <select name="mois" id="mois"
                                                class="form-select @error('mois') is-invalid @enderror" required>
                                                <option value="">-- Sélectionner --</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ old('mois', date('n')) == $i ? 'selected' : '' }}>
                                                        {{ \App\Models\Payment::getNomMois($i) }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('mois')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group floating-label">
                                            <label for="annee" class="form-label">
                                                <i class="fas fa-calendar"></i> Année <span class="text-danger">*</span>
                                            </label>
                                            @php
                                                $currentYear = now()->year;
                                                $startYear = $currentYear - 10;
                                                $endYear = $currentYear + 5;
                                            @endphp

                                            <select name="annee" id="annee"
                                                class="form-select @error('annee') is-invalid @enderror" required>
                                                @for ($year = $endYear; $year >= $startYear; $year--)
                                                    <option value="{{ $year }}"
                                                        {{ old('annee', $currentYear) == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <!-- Montant -->
                                <div class="form-group floating-label">
                                    <label for="montant" class="form-label">
                                        <i class="fas fa-coins"></i> Montant (FCFA) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-money-bill"></i>
                                        </span>
                                        <input type="number" name="montant" id="montant"
                                            class="form-control @error('montant') is-invalid @enderror"
                                            value="{{ old('montant') }}" min="0" step="1"
                                            placeholder="Ex: 50000" required>
                                        <span class="input-group-text">FCFA</span>
                                    </div>
                                    @error('montant')
                                        <div class="invalid-feedback animate__animated animate__headShake">{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Méthode de paiement -->
                                <div class="form-group floating-label">
                                    <label for="methode" class="form-label">
                                        <i class="fas fa-credit-card"></i> Méthode de paiement <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="methode" id="methode"
                                        class="form-select @error('methode') is-invalid @enderror" required>
                                        <option value="">-- Sélectionner --</option>
                                        <option value="feda_pay" {{ old('methode') == 'feda_pay' ? 'selected' : '' }}>
                                            💳 Paiement en ligne (FedaPay)
                                        </option>
                                        <option value="mtn_momo" {{ old('methode') == 'mtn_momo' ? 'selected' : '' }}>
                                            📱 MTN Mobile Money (Manuel)
                                        </option>
                                        <option value="orange_money"
                                            {{ old('methode') == 'orange_money' ? 'selected' : '' }}>
                                            📱 Orange Money (Manuel)
                                        </option>
                                        <option value="wave" {{ old('methode') == 'wave' ? 'selected' : '' }}>
                                            📱 Wave (Manuel)
                                        </option>
                                        <option value="virement" {{ old('methode') == 'virement' ? 'selected' : '' }}>
                                            🏦 Virement bancaire
                                        </option>
                                        <option value="especes" {{ old('methode') == 'especes' ? 'selected' : '' }}>
                                            💵 Espèces
                                        </option>
                                        <option value="autre" {{ old('methode') == 'autre' ? 'selected' : '' }}>
                                            ➕ Autre
                                        </option>
                                    </select>
                                    @error('methode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Champs additionnels pour paiements manuels -->
                                <div id="manualPaymentFields" class="animate__animated" style="display: none;">
                                    <div class="payment-method-card">
                                        <div class="card-header">
                                            <h6 class="mb-0">
                                                <i class="fas fa-receipt me-2"></i>Détails du paiement manuel
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="operateur" class="form-label">Opérateur</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-building"></i>
                                                            </span>
                                                            <input type="text" name="operateur" id="operateur"
                                                                class="form-control @error('operateur') is-invalid @enderror"
                                                                value="{{ old('operateur') }}"
                                                                placeholder="Ex: MTN, Orange">
                                                        </div>
                                                        @error('operateur')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="numero_transaction" class="form-label">N° de
                                                            transaction</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-hashtag"></i>
                                                            </span>
                                                            <input type="text" name="numero_transaction"
                                                                id="numero_transaction"
                                                                class="form-control @error('numero_transaction') is-invalid @enderror"
                                                                value="{{ old('numero_transaction') }}"
                                                                placeholder="Ex: MP241215.1234.A12345">
                                                        </div>
                                                        @error('numero_transaction')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mt-3">
                                                <label for="date_paiement" class="form-label">
                                                    <i class="fas fa-calendar-check"></i> Date de paiement <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-day"></i>
                                                    </span>
                                                    <input type="date" name="date_paiement" id="date_paiement"
                                                        class="form-control @error('date_paiement') is-invalid @enderror"
                                                        value="{{ old('date_paiement', date('Y-m-d')) }}" required>
                                                </div>
                                                @error('date_paiement')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group mt-3">
                                                <label for="preuve_paiement" class="form-label">
                                                    <i class="fas fa-file-upload"></i> Preuve de paiement
                                                </label>
                                                <div class="file-upload-wrapper">
                                                    <input type="file" name="preuve_paiement" id="preuve_paiement"
                                                        class="file-upload-input @error('preuve_paiement') is-invalid @enderror"
                                                        accept=".jpg,.jpeg,.png,.pdf">
                                                    <div class="file-upload-placeholder">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                        <p class="small mb-0 mt-2">Glissez-déposez ou cliquez pour
                                                            télécharger</p>
                                                        <p class="text-muted small">JPG, PNG, PDF (Max: 2Mo)</p>
                                                    </div>
                                                </div>
                                                @error('preuve_paiement')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="form-group floating-label">
                                    <label for="notes" class="form-label">
                                        <i class="fas fa-sticky-note"></i> Notes (optionnel)
                                    </label>
                                    <textarea name="notes" id="notes" class="form-control textarea-animated @error('notes') is-invalid @enderror"
                                        rows="3" placeholder="Ajoutez des notes supplémentaires si nécessaire...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Boutons -->

                                <div class="d-flex justify-content-end gap-3 mt-5">
                                    {{-- <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Annuler
                                    </a> --}}
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        <span id="submitText">Enregistrer</span>
                                        <span class="btn-spinner ms-2" style="display: none;">
                                            <i class="fas fa-spinner"></i>
                                        </span>
                                    </button>
                                </div>

                                <!-- Boutons de soumission -->
                                <div class="d-flex justify-content-end gap-3 mt-5">
                                    <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Annuler
                                    </a>

                                    <!-- Bouton pour paiement manuel -->
                                    <button type="submit" class="btn btn-primary" id="submitBtn"
                                        style="display: none;">
                                        <i class="fas fa-save me-2"></i>
                                        <span id="submitText">Enregistrer le paiement</span>
                                        <span class="btn-spinner ms-2" style="display: none;">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </span>
                                    </button>

                                    <!-- Bouton pour FedaPay -->
                                    <button type="button" class="btn btn-success" id="fedapayBtn"
                                        style="display: none;">
                                        <i class="fas fa-credit-card me-2"></i>
                                        Payer avec FedaPay
                                    </button>
                                </div>

                                {{-- <div class="d-flex justify-content-end gap-3 mt-5">
                                    <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Annuler
                                    </a>

                                    <!-- Bouton paiement manuel -->
                                    <button type="submit" class="btn btn-primary" id="submitBtn" style="display:none;">
                                        <i class="fas fa-save me-2"></i>
                                        <span id="submitText">Enregistrer le paiement</span>
                                        <span class="btn-spinner ms-2" style="display:none;">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </span>
                                    </button>

                                    <!-- Bouton FedaPay -->
                                    <button type="button" class="btn btn-success" id="fedapayBtn"
                                        style="display:none;">
                                        <i class="fas fa-credit-card me-2"></i>
                                        Payer avec FedaPay
                                    </button>
                                </div> --}}


                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar avec informations -->
                <div class="col-lg-4">
                    <div class="sticky-top">
                        <div class="card info-panel animate__animated animate__fadeInRight">
                            <div class="card-header bg-gradient-info text-white">
                                <div class="d-flex align-items-center">
                                    <div class="header-icon-wrapper">
                                        <i class="fas fa-info-circle fa-lg"></i>
                                    </div>
                                    <h5 class="mb-0 fw-semibold">Informations</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="info-item animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                                    <div class="info-icon-wrapper">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="info-title">💳 Paiement en ligne</h6>
                                        <p class="info-text">
                                            Si vous sélectionnez "Paiement en ligne (FedaPay)", le locataire sera redirigé
                                            vers la page de paiement FedaPay pour effectuer le paiement.
                                        </p>
                                    </div>
                                </div>

                                <div class="info-item animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                                    <div class="info-icon-wrapper">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="info-title">📝 Paiement manuel</h6>
                                        <p class="info-text">
                                            Pour les autres méthodes, le paiement sera enregistré comme déjà effectué.
                                            Assurez-vous d'avoir reçu le paiement avant de l'enregistrer.
                                        </p>
                                    </div>
                                </div>

                                <div class="progress-info animate__animated animate__fadeInUp"
                                    style="animation-delay: 0.3s;">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Complétion du formulaire</small>
                                        <small id="formProgress">0%</small>
                                    </div>
                                    <div class="progress">
                                        <div id="formProgressBar" class="progress-bar progress-bar-striped"
                                            role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection


{{-- @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* ==============================
                INITIALISATION
            ============================== */

            const userSelect = document.getElementById('user_id');
            const methodeSelect = document.getElementById('methode');
            const montantInput = document.getElementById('montant');
            const moisSelect = document.getElementById('mois');
            const anneeSelect = document.getElementById('annee');

            const manualFields = document.getElementById('manualPaymentFields');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const fedapayBtn = document.getElementById('fedapayBtn');
            const paymentForm = document.getElementById('paymentForm');

            const formProgressBar = document.getElementById('formProgressBar');
            const formProgress = document.getElementById('formProgress');

            const fedapayRoute = @json(route('payments.fedapay.initiate'));

            const formElements = [userSelect, moisSelect, anneeSelect, montantInput, methodeSelect];


            /* ==============================
                PROGRESSION
            ============================== */

            function updateFormProgress() {

                let filled = 0;

                formElements.forEach(el => {
                    if (el && el.value && el.value.trim() !== '') {
                        filled++;
                    }
                });

                const percent = Math.round((filled / formElements.length) * 100);

                if (formProgressBar) {
                    formProgressBar.style.width = percent + '%';
                    formProgress.textContent = percent + '%';
                }
            }


            /* ==============================
                AFFICHAGE SELON MÉTHODE
            ============================== */

            methodeSelect?.addEventListener('change', function() {

                if (!this.value) {
                    submitBtn.style.display = 'none';
                    fedapayBtn.style.display = 'none';
                    manualFields.style.display = 'none';
                    return;
                }

                if (this.value === 'feda_pay') {

                    manualFields.style.display = 'none';

                    submitBtn.style.display = 'none';
                    fedapayBtn.style.display = 'inline-block';

                } else {

                    manualFields.style.display = 'block';

                    submitBtn.style.display = 'inline-block';
                    fedapayBtn.style.display = 'none';

                    // Auto opérateur
                    const operateur = document.getElementById('operateur');
                    if (operateur) {
                        if (this.value === 'mtn_momo') operateur.value = 'MTN';
                        if (this.value === 'orange_money') operateur.value = 'Orange';
                        if (this.value === 'wave') operateur.value = 'Wave';
                    }
                }

                updateFormProgress();
            });


            /* ==============================
                FEDA PAY CLICK
            ============================== */

            fedapayBtn?.addEventListener('click', function() {

                if (!userSelect.value) {
                    alert('Veuillez sélectionner un locataire');
                    return;
                }

                if (!moisSelect.value || !anneeSelect.value) {
                    alert('Veuillez sélectionner le mois et l’année');
                    return;
                }

                if (!montantInput.value || montantInput.value <= 0) {
                    alert('Veuillez saisir un montant valide');
                    return;
                }

                const montantFormat = new Intl.NumberFormat('fr-FR')
                    .format(montantInput.value);

                if (!confirm(`Initier un paiement de ${montantFormat} FCFA via FedaPay ?`)) {
                    return;
                }

                fedapayBtn.disabled = true;
                fedapayBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin me-2"></i>Redirection...';

                const url = new URL(fedapayRoute, window.location.origin);
                url.searchParams.append('user_id', userSelect.value);
                url.searchParams.append('mois', moisSelect.value);
                url.searchParams.append('annee', anneeSelect.value);
                url.searchParams.append('montant', montantInput.value);

                window.location.href = url.toString();
            });


            /* ==============================
                SOUMISSION MANUELLE
            ============================== */

            paymentForm?.addEventListener('submit', function(e) {

                if (methodeSelect.value === 'feda_pay') return;

                const montantFormat = new Intl.NumberFormat('fr-FR')
                    .format(montantInput.value);

                if (!confirm(`Confirmer l'enregistrement de ${montantFormat} FCFA ?`)) {
                    e.preventDefault();
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.querySelector('.btn-spinner').style.display = 'inline-block';
            });


            /* ==============================
                AUTO UPDATE PROGRESSION
            ============================== */

            formElements.forEach(el => {
                el?.addEventListener('change', updateFormProgress);
                el?.addEventListener('input', updateFormProgress);
            });

            updateFormProgress();

        });
    </script>
@endpush --}}



{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation des éléments
        const userSelect = document.getElementById('user_id');
        const methodeSelect = document.getElementById('methode');
        const montantInput = document.getElementById('montant');
        const moisSelect = document.getElementById('mois');
        const anneeSelect = document.getElementById('annee');
        const manualFields = document.getElementById('manualPaymentFields');
        const submitBtn = document.getElementById('submitBtn');
        const fedapayBtn = document.getElementById('fedapayBtn');
        const paymentForm = document.getElementById('paymentForm');

        // Gérer l'affichage des boutons selon la méthode
        methodeSelect.addEventListener('change', function() {
            if (this.value === 'feda_pay') {
                // Masquer champs manuels et bouton submit classique
                manualFields.style.display = 'none';
                submitBtn.style.display = 'none';

                // Afficher bouton FedaPay
                fedapayBtn.style.display = 'inline-block';

            } else if (this.value) {
                // Afficher champs manuels et bouton submit
                manualFields.style.display = 'block';
                submitBtn.style.display = 'inline-block';
                fedapayBtn.style.display = 'none';

                // Pré-remplir l'opérateur
                if (this.value === 'mtn_momo') {
                    document.getElementById('operateur').value = 'MTN';
                } else if (this.value === 'orange_money') {
                    document.getElementById('operateur').value = 'Orange';
                } else if (this.value === 'wave') {
                    document.getElementById('operateur').value = 'Wave';
                }
            } else {
                manualFields.style.display = 'none';
                submitBtn.style.display = 'none';
                fedapayBtn.style.display = 'none';
            }
        });

        // ✅ Gestion du clic sur le bouton FedaPay
        fedapayBtn.addEventListener('click', function() {
            // Validation des champs requis
            if (!userSelect.value) {
                alert('Veuillez sélectionner un locataire');
                return;
            }

            if (!moisSelect.value || !anneeSelect.value) {
                alert('Veuillez sélectionner le mois et l\'année');
                return;
            }

            if (!montantInput.value || montantInput.value <= 0) {
                alert('Veuillez saisir un montant valide');
                return;
            }

            // Confirmation
            const montantFormate = new Intl.NumberFormat('fr-FR').format(montantInput.value);
            if (!confirm(`Voulez-vous initier un paiement de ${montantFormate} FCFA via FedaPay ?`)) {
                return;
            }

            // Afficher le spinner
            fedapayBtn.disabled = true;
            fedapayBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Redirection...';

            // ✅ Construire l'URL avec tous les paramètres
            const url = new URL('{{ route('payments.fedapay.initiate') }}', window.location.origin);
            url.searchParams.append('user_id', userSelect.value);
            url.searchParams.append('mois', moisSelect.value);
            url.searchParams.append('annee', anneeSelect.value);
            url.searchParams.append('montant', montantInput.value);

            // Rediriger
            window.location.href = url.toString();
        });

        fedapayBtn.addEventListener('click', function() {
            // ... validations ...

            // ✅ Générer l'URL
            const baseUrl = '{{ route('payments.fedapay.initiate') }}';

            // ✅ AFFICHER L'URL DANS UNE ALERT (temporaire)
            alert('URL générée: ' + baseUrl);

            const url = new URL(baseUrl, window.location.origin);
            url.searchParams.append('user_id', userSelect.value);
            url.searchParams.append('mois', moisSelect.value);
            url.searchParams.append('annee', anneeSelect.value);
            url.searchParams.append('montant', montantInput.value);

            // ✅ AFFICHER L'URL COMPLÈTE
            alert('URL complète: ' + url.toString());

            console.log('Redirection vers:', url.toString());

            // Redirection
            window.location.href = url.toString();
        });

        methodeSelect.addEventListener('change', function() {
            if (this.value === 'feda_pay') {
                // Masquer les champs manuels
                manualFields.style.display = 'none';

                // Changer le texte du bouton
                submitText.innerHTML = '<i class="fas fa-credit-card me-2"></i>Payer avec FedaPay';
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-success');
            } else if (this.value) {
                // Afficher les champs manuels
                manualFields.style.display = 'block';
                submitText.innerHTML = '<i class="fas fa-save me-2"></i>Enregistrer le paiement';
                submitBtn.classList.remove('btn-success');
                submitBtn.classList.add('btn-primary');
            }
        });

        // Le formulaire se soumet normalement
        // Pas besoin de JavaScript spécial pour FedaPay

        // Soumission normale du formulaire (pour paiements manuels)
        paymentForm.addEventListener('submit', function(e) {
            const montant = new Intl.NumberFormat('fr-FR').format(montantInput.value);

            if (!confirm(`Confirmer l'enregistrement de ce paiement de ${montant} FCFA ?`)) {
                e.preventDefault();
            }
        });
    });
</script> --}}

{{-- @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* =====================================================
                INITIALISATION DES ÉLÉMENTS
            ===================================================== */

            const userSelect = document.getElementById('user_id');
            const methodeSelect = document.getElementById('methode');
            const montantInput = document.getElementById('montant');
            const moisSelect = document.getElementById('mois');
            const anneeSelect = document.getElementById('annee');

            const manualFields = document.getElementById('manualPaymentFields');
            const propertyCard = document.getElementById('propertyCard');
            const propertyInfo = document.getElementById('propertyInfo');
            const paymentInfo = document.getElementById('paymentInfo');

            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const fedapayBtn = document.getElementById('fedapayBtn');
            const paymentForm = document.getElementById('paymentForm');

            const formProgressBar = document.getElementById('formProgressBar');
            const formProgress = document.getElementById('formProgress');

            const fileUploadInput = document.getElementById('preuve_paiement');
            const fileUploadWrapper = document.querySelector('.file-upload-wrapper');

            const formElements = [userSelect, moisSelect, anneeSelect, montantInput, methodeSelect];


            /* =====================================================
                PROGRESSION FORMULAIRE
            ===================================================== */

            function updateFormProgress() {
                let filledCount = 0;

                formElements.forEach(element => {
                    if (element && element.value && element.value.trim() !== '') {
                        filledCount++;
                    }
                });

                const progress = Math.min(100, (filledCount / formElements.length) * 100);

                if (formProgressBar) {
                    formProgressBar.style.width = progress + '%';
                    formProgress.textContent = Math.round(progress) + '%';

                    if (progress === 100) {
                        formProgressBar.classList.add('bg-success');
                        formProgressBar.classList.remove('bg-primary');
                    } else {
                        formProgressBar.classList.remove('bg-success');
                        formProgressBar.classList.add('bg-primary');
                    }
                }
            }


            /* =====================================================
                CHANGEMENT LOCATAIRE
            ===================================================== */

            userSelect?.addEventListener('change', function() {

                const option = this.selectedOptions[0];

                if (!option || !option.value) {
                    propertyCard && (propertyCard.style.display = 'none');
                    paymentInfo && (paymentInfo.style.display = 'none');
                    return;
                }

                const property = option.dataset.property;
                const loyer = option.dataset.loyer;

                document.getElementById('propertyAddress').textContent = property ?? '—';
                document.getElementById('propertyRent').textContent =
                    new Intl.NumberFormat('fr-FR').format(loyer ?? 0) + ' FCFA';

                propertyCard && (propertyCard.style.display = 'block');

                if (!montantInput.value && loyer) {
                    montantInput.value = loyer;
                }

                /* ===== INFOS DERNIER PAIEMENT ===== */

                const lastMois = option.dataset.lastMois;
                const lastAnnee = option.dataset.lastAnnee;

                if (!lastMois || !lastAnnee) {

                    document.getElementById('lastPaymentInfo').textContent =
                        '❌ Aucun paiement enregistré';

                    document.getElementById('delayInfo').textContent =
                        '⚠️ Retard : paiement jamais effectué';

                    document.getElementById('delayInfo').className = 'text-danger fw-bold';

                } else {

                    document.getElementById('lastPaymentInfo').textContent =
                        `💳 Dernier paiement : ${lastMois}/${lastAnnee}`;

                    const today = new Date();
                    let expectedMonth = today.getMonth();
                    let expectedYear = today.getFullYear();

                    if (expectedMonth === 0) {
                        expectedMonth = 12;
                        expectedYear--;
                    }

                    const lastPaymentDate = new Date(lastAnnee, lastMois - 1);
                    const expectedDate = new Date(expectedYear, expectedMonth - 1);

                    const diffMonths =
                        (expectedDate.getFullYear() - lastPaymentDate.getFullYear()) * 12 +
                        (expectedDate.getMonth() - lastPaymentDate.getMonth());

                    if (diffMonths <= 0) {
                        document.getElementById('delayInfo').textContent =
                            '✅ Aucun retard de paiement';
                        document.getElementById('delayInfo').className =
                            'text-success fw-bold';
                    } else {
                        document.getElementById('delayInfo').textContent =
                            `⏰ Retard : ${diffMonths} mois`;
                        document.getElementById('delayInfo').className =
                            'text-danger fw-bold';
                    }
                }

                paymentInfo && (paymentInfo.style.display = 'block');

                updateFormProgress();
            });


            /* =====================================================
                CHANGEMENT MÉTHODE DE PAIEMENT
            ===================================================== */

            methodeSelect?.addEventListener('change', function() {

                if (this.value === 'feda_pay') {

                    manualFields && (manualFields.style.display = 'none');

                    submitText.innerHTML =
                        '<i class="fas fa-credit-card me-2"></i>Initier le paiement en ligne';

                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-success');

                } else if (this.value) {

                    manualFields && (manualFields.style.display = 'block');

                    submitText.innerHTML =
                        '<i class="fas fa-save me-2"></i>Enregistrer le paiement';

                    submitBtn.classList.remove('btn-success');
                    submitBtn.classList.add('btn-primary');

                    if (this.value === 'mtn_momo') {
                        document.getElementById('operateur').value = 'MTN';
                    } else if (this.value === 'orange_money') {
                        document.getElementById('operateur').value = 'Orange';
                    } else if (this.value === 'wave') {
                        document.getElementById('operateur').value = 'Wave';
                    }

                } else {
                    manualFields && (manualFields.style.display = 'none');
                }

                updateFormProgress();
            });


            /* =====================================================
                BOUTON FEDAPAY
            ===================================================== */

            fedapayBtn?.addEventListener('click', function() {

                if (!userSelect.value || !moisSelect.value || !anneeSelect.value || !montantInput.value) {
                    alert('Veuillez remplir tous les champs requis.');
                    return;
                }

                const montantFormate = new Intl.NumberFormat('fr-FR').format(montantInput.value);

                if (!confirm(`Voulez-vous initier un paiement de ${montantFormate} FCFA via FedaPay ?`)) {
                    return;
                }

                fedapayBtn.disabled = true;
                fedapayBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Redirection...';

                const url = new URL('{{ route('payments.fedapay.initiate') }}', window.location.origin);
                url.searchParams.append('user_id', userSelect.value);
                url.searchParams.append('mois', moisSelect.value);
                url.searchParams.append('annee', anneeSelect.value);
                url.searchParams.append('montant', montantInput.value);

                window.location.href = url.toString();
            });


            /* =====================================================
                CONFIRMATION SOUMISSION
            ===================================================== */

            paymentForm?.addEventListener('submit', function(e) {

                const montant = new Intl.NumberFormat('fr-FR').format(montantInput.value);
                const methode = methodeSelect.value;

                let message = (methode === 'feda_pay') ?
                    `Voulez-vous initier un paiement en ligne de ${montant} FCFA via FedaPay ?` :
                    `Confirmer l'enregistrement de ce paiement de ${montant} FCFA ?`;

                if (!confirm(message)) {
                    e.preventDefault();
                }
            });


            /* =====================================================
                PROGRESSION AUTO
            ===================================================== */

            formElements.forEach(element => {
                element?.addEventListener('change', updateFormProgress);
                element?.addEventListener('input', updateFormProgress);
            });

            updateFormProgress();

        });
    </script>
@endpush --}}



@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation des éléments
            const userSelect = document.getElementById('user_id');
            const methodeSelect = document.getElementById('methode');
            const montantInput = document.getElementById('montant');
            const manualFields = document.getElementById('manualPaymentFields');
            const propertyInfo = document.getElementById('propertyInfo');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const paymentForm = document.getElementById('paymentForm');
            const formProgressBar = document.getElementById('formProgressBar');
            const formProgress = document.getElementById('formProgress');
            const fileUploadInput = document.getElementById('preuve_paiement');
            const fileUploadWrapper = document.querySelector('.file-upload-wrapper');

            // Éléments à surveiller pour la progression
            const formElements = [
                userSelect,
                document.getElementById('mois'),
                document.getElementById('annee'),
                montantInput,
                methodeSelect
            ];

            // Mettre à jour la progression du formulaire
            function updateFormProgress() {
                let filledCount = 0;
                const totalElements = formElements.length;

                formElements.forEach(element => {
                    if (element && element.value && element.value.trim() !== '') {
                        filledCount++;
                    }
                });

                const progress = Math.min(100, (filledCount / totalElements) * 100);
                formProgressBar.style.width = progress + '%';
                formProgress.textContent = Math.round(progress) + '%';

                // Animation sur la barre de progression
                if (progress === 100) {
                    formProgressBar.classList.add('bg-success');
                    formProgressBar.classList.remove('bg-primary');
                } else {
                    formProgressBar.classList.remove('bg-success');
                    formProgressBar.classList.add('bg-primary');
                }
            }

            // Afficher les infos de la propriété
            userSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (this.value) {
                    const property = selectedOption.dataset.property;
                    const loyer = selectedOption.dataset.loyer;

                    document.getElementById('propertyAddress').textContent = property;
                    document.getElementById('propertyRent').textContent =
                        new Intl.NumberFormat('fr-FR').format(loyer) + ' FCFA';

                    // Animation d'entrée
                    propertyInfo.style.display = 'block';
                    propertyInfo.classList.add('animate__animated', 'animate__fadeIn');

                    // Pré-remplir le montant avec le loyer mensuel
                    if (!montantInput.value && loyer > 0) {
                        montantInput.value = loyer;
                        // Animation sur le champ montant
                        montantInput.classList.add('animate__animated', 'animate__pulse');
                        setTimeout(() => {
                            montantInput.classList.remove('animate__animated', 'animate__pulse');
                        }, 1000);
                    }
                } else {
                    propertyInfo.classList.remove('animate__fadeIn');
                    propertyInfo.classList.add('animate__fadeOut');
                    setTimeout(() => {
                        propertyInfo.style.display = 'none';
                        propertyInfo.classList.remove('animate__fadeOut');
                    }, 500);
                }
                updateFormProgress();
            });

            // Gérer l'affichage des champs selon la méthode
            methodeSelect.addEventListener('change', function() {
                if (this.value === 'feda_pay') {
                    // Animation de sortie pour les champs manuels
                    manualFields.classList.remove('animate__fadeIn');
                    manualFields.classList.add('animate__fadeOut');
                    setTimeout(() => {
                        manualFields.style.display = 'none';
                        manualFields.classList.remove('animate__fadeOut');
                    }, 300);

                    submitText.innerHTML =
                        '<i class="fas fa-credit-card me-2"></i>Initier le paiement en ligne';
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-success');
                } else if (this.value) {
                    // Animation d'entrée pour les champs manuels
                    manualFields.style.display = 'block';
                    manualFields.classList.remove('animate__fadeOut');
                    manualFields.classList.add('animate__fadeIn');

                    submitText.innerHTML = '<i class="fas fa-save me-2"></i>Enregistrer le paiement';
                    submitBtn.classList.remove('btn-success');
                    submitBtn.classList.add('btn-primary');

                    // Si c'est une méthode mobile, remplir automatiquement l'opérateur
                    if (this.value === 'mtn_momo') {
                        document.getElementById('operateur').value = 'MTN';
                    } else if (this.value === 'orange_money') {
                        document.getElementById('operateur').value = 'Orange';
                    } else if (this.value === 'wave') {
                        document.getElementById('operateur').value = 'Wave';
                    }
                } else {
                    manualFields.style.display = 'none';
                    submitText.innerHTML = 'Enregistrer';
                }
                updateFormProgress();
            });

            // Gestion du téléchargement de fichier
            fileUploadWrapper.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--primary)';
                this.style.transform = 'scale(1.02)';
            });

            fileUploadWrapper.addEventListener('dragleave', function() {
                this.style.borderColor = '#e2e8f0';
                this.style.transform = 'scale(1)';
            });

            fileUploadWrapper.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#e2e8f0';
                this.style.transform = 'scale(1)';

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileUploadInput.files = files;
                    updateFilePreview(files[0]);
                }
            });

            fileUploadInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    updateFilePreview(this.files[0]);
                }
            });

            function updateFilePreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewHTML = `
                <div class="text-center">
                    <i class="fas fa-file-alt fa-3x text-success mb-2"></i>
                    <p class="mb-1"><strong>${file.name}</strong></p>
                    <p class="small text-muted">${(file.size / 1024 / 1024).toFixed(2)} Mo</p>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="clearFile()">
                        <i class="fas fa-times me-1"></i>Supprimer
                    </button>
                </div>
            `;
                    fileUploadWrapper.innerHTML = previewHTML;
                    fileUploadWrapper.style.borderColor = '#4CAF50';
                    fileUploadWrapper.style.background = 'rgba(76, 175, 80, 0.05)';
                };
                reader.readAsDataURL(file);
            }

            // Confirmation avant soumission
            paymentForm.addEventListener('submit', function(e) {
                const methode = methodeSelect.value;
                const montant = new Intl.NumberFormat('fr-FR').format(montantInput.value);

                // Afficher le spinner
                submitBtn.querySelector('.btn-spinner').style.display = 'inline-block';
                submitBtn.disabled = true;

                // Animation de pulsation
                submitBtn.classList.add('animate__animated', 'animate__pulse');

                let message = '';
                if (methode === 'feda_pay') {
                    message = `Voulez-vous initier un paiement en ligne de ${montant} FCFA via FedaPay ?`;
                } else {
                    message = `Confirmer l'enregistrement de ce paiement de ${montant} FCFA ?`;
                }

                if (!confirm(message)) {
                    e.preventDefault();
                    submitBtn.querySelector('.btn-spinner').style.display = 'none';
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('animate__animated', 'animate__pulse');
                }
            });

            // Écouter les changements pour la progression
            formElements.forEach(element => {
                if (element) {
                    element.addEventListener('change', updateFormProgress);
                    element.addEventListener('input', updateFormProgress);
                }
            });

            // Mettre à jour la progression au chargement
            updateFormProgress();

            // Trigger les événements au chargement si déjà sélectionné
            if (userSelect.value) {
                setTimeout(() => userSelect.dispatchEvent(new Event('change')), 300);
            }
            if (methodeSelect.value) {
                setTimeout(() => methodeSelect.dispatchEvent(new Event('change')), 500);
            }

            // Animation d'entrée progressive
            const animatedElements = document.querySelectorAll('.animate__animated');
            animatedElements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Fonction pour effacer le fichier
        window.clearFile = function() {
            const fileInput = document.getElementById('preuve_paiement');
            const fileUploadWrapper = document.querySelector('.file-upload-wrapper');

            fileInput.value = '';
            fileUploadWrapper.innerHTML = `
        <div class="file-upload-placeholder">
            <i class="fas fa-cloud-upload-alt"></i>
            <p class="small mb-0 mt-2">Glissez-déposez ou cliquez pour télécharger</p>
            <p class="text-muted small">JPG, PNG, PDF (Max: 2Mo)</p>
        </div>
        <input type="file"
               name="preuve_paiement"
               id="preuve_paiement"
               class="file-upload-input"
               accept=".jpg,.jpeg,.png,.pdf">
    `;
            fileUploadWrapper.style.borderColor = '#e2e8f0';
            fileUploadWrapper.style.background = '#f9fafc';
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const userSelect = document.getElementById('user_id');
            const montantInput = document.getElementById('montant');

            const propertyCard = document.getElementById('propertyCard');
            const paymentInfo = document.getElementById('paymentInfo');

            userSelect.addEventListener('change', function() {

                const option = this.selectedOptions[0];

                if (!option || !option.value) {
                    propertyCard.style.display = 'none';
                    paymentInfo.style.display = 'none';
                    return;
                }

                /* =========================
                   INFOS PROPRIÉTÉ
                ========================== */
                const property = option.dataset.property;
                const loyer = option.dataset.loyer;

                document.getElementById('propertyAddress').textContent = property ?? '—';
                document.getElementById('propertyRent').textContent =
                    new Intl.NumberFormat('fr-FR').format(loyer ?? 0) + ' FCFA';

                propertyCard.style.display = 'block';

                // Pré-remplir le montant
                if (!montantInput.value && loyer) {
                    montantInput.value = loyer;
                }

                /* =========================
                   INFOS DERNIER PAIEMENT
                ========================== */
                const lastMois = option.dataset.lastMois;
                const lastAnnee = option.dataset.lastAnnee;

                if (!lastMois || !lastAnnee) {

                    document.getElementById('lastPaymentInfo').textContent =
                        '❌ Aucun paiement enregistré';

                    document.getElementById('delayInfo').textContent =
                        '⚠️ Retard : paiement jamais effectué';

                    document.getElementById('delayInfo').className = 'text-danger fw-bold';

                } else {

                    document.getElementById('lastPaymentInfo').textContent =
                        `💳 Dernier paiement : ${lastMois}/${lastAnnee}`;

                    /* ===== LOGIQUE RETARD ===== */
                    const today = new Date();
                    let expectedMonth = today.getMonth(); // mois précédent
                    let expectedYear = today.getFullYear();

                    if (expectedMonth === 0) {
                        expectedMonth = 12;
                        expectedYear--;
                    }

                    const lastPaymentDate = new Date(lastAnnee, lastMois - 1);
                    const expectedDate = new Date(expectedYear, expectedMonth - 1);

                    const diffMonths =
                        (expectedDate.getFullYear() - lastPaymentDate.getFullYear()) * 12 +
                        (expectedDate.getMonth() - lastPaymentDate.getMonth());

                    if (diffMonths <= 0) {
                        document.getElementById('delayInfo').textContent =
                            '✅ Aucun retard de paiement';
                        document.getElementById('delayInfo').className =
                            'text-success fw-bold';
                    } else {
                        document.getElementById('delayInfo').textContent =
                            `⏰ Retard : ${diffMonths} mois`;
                        document.getElementById('delayInfo').className =
                            'text-danger fw-bold';
                    }
                }

                paymentInfo.style.display = 'block';
            });

        });
    </script>
@endpush
