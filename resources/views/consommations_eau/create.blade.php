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
                max-width: 900px;
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

            /* Messages d'erreur */
            .alert-glass {
                background: rgba(239, 68, 68, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-left: 4px solid var(--danger);
                border-radius: 10px;
                padding: 1.5rem;
                margin-bottom: 2rem;
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

            .alert-icon-wrapper {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: rgba(239, 68, 68, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1rem;
            }

            .alert-icon-wrapper i {
                color: var(--danger);
            }

            /* Formulaires */
            .form-section {
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

            .form-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
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

            .required::after {
                content: ' *';
                color: var(--danger);
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
                box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
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
                position: relative;
                transition: var(--transition);
            }

            .input-group:focus-within {
                transform: translateY(-2px);
            }

            .input-group-text {
                position: absolute;
                right: 1rem;
                top: 50%;
                transform: translateY(-50%);
                color: var(--gray);
                font-weight: 500;
                pointer-events: none;
                font-size: 0.9rem;
            }

            .invalid-feedback {
                color: var(--danger);
                font-size: 0.85rem;
                margin-top: 0.5rem;
                font-weight: 500;
                animation: headShake 0.5s ease;
            }

            @keyframes headShake {

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

            /* Informations calculées */
            .calculation-card {
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border-radius: 12px;
                padding: 1.5rem;
                margin: 2rem 0;
                border: 2px solid #e2e8f0;
                animation: fadeInUp 0.5s ease forwards;
                opacity: 0;
            }

            .calculation-title {
                font-size: 1rem;
                color: var(--primary-dark);
                font-weight: 600;
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
            }

            .calculation-title i {
                margin-right: 0.5rem;
            }

            .calculation-result {
                background: white;
                border-radius: 8px;
                padding: 1rem;
                border: 1px solid #e2e8f0;
                margin-bottom: 1rem;
            }

            .result-label {
                font-size: 0.9rem;
                color: var(--gray);
                margin-bottom: 0.25rem;
            }

            .result-value {
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--primary-dark);
                margin: 0;
            }

            .price-info {
                background: #fff3cd;
                border: 1px solid #ffc107;
                border-radius: 8px;
                padding: 1rem;
                margin-top: 1rem;
                font-size: 0.9rem;
                color: #856404;
            }

            .period-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .action-buttons {
                display: flex;
                gap: 1rem;
                margin-top: 3rem;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            .btn-cancel {
                background: transparent;
                color: var(--gray);
                border: 2px solid #dee2e6;
            }

            .btn-cancel:hover {
                background: #f8f9fa;
                border-color: var(--gray);
                transform: translateY(-2px);
            }

            .btn-submit {
                background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
                color: white;
            }

            .btn-submit:hover {
                background: linear-gradient(135deg, var(--success-dark) 0%, var(--success) 100%);
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
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

                .form-grid,
                .period-grid {
                    grid-template-columns: 1fr;
                }

                .action-buttons {
                    flex-direction: column;
                }

                .btn {
                    width: 100%;
                    justify-content: center;
                }

                .page-title {
                    font-size: 1.5rem;
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
                    <i class="fas fa-plus-circle"></i>Nouvelle Consommation d'Eau
                </h1>
                <p class="page-subtitle">Enregistrez une nouvelle consommation d'eau pour un locataire</p>
            </div>

            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="alert-glass animate__animated animate__shakeX">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon-wrapper">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <h5 class="mb-1" style="color: var(--danger);">Erreurs de validation</h5>
                            <ul class="mb-0 ps-3" style="color: var(--danger-dark);">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulaire principal -->
            <form method="POST" action="{{ route('consommations-eau.store') }}" id="consumptionForm">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <div class="header-icon">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Formulaire d'enregistrement</h5>
                            <small>Remplissez tous les champs obligatoires (*)</small>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Section Locataire -->
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-user"></i>Sélection du Locataire
                            </h4>

                            <div class="form-group animate-delay-1">
                                <label for="user_id" class="form-label required">
                                    <i class="fas fa-user-circle"></i>Locataire
                                </label>
                                <select name="user_id" id="user_id"
                                    class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionnez un locataire --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            data-property="{{ $user->property->nom ?? 'Aucune' }}"
                                            data-last-index="{{ optional($user->consommationsEau->first())->index_compteur ?? 0 }}">

                                            {{ $user->prenom }} {{ $user->nom }}
                                            @if ($user->property)
                                                - {{ $user->property->nom }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback animate__animated animate__headShake">{{ $message }}</div>
                                @enderror

                                <!-- Informations du locataire sélectionné -->
                                <div id="userInfo" class="mt-3" style="display: none;">
                                    <div
                                        style="padding: 1rem; background: #f0f9ff; border-radius: 8px; border-left: 4px solid var(--primary);">
                                        <div style="font-weight: 500; color: var(--primary-dark); margin-bottom: 0.5rem;">
                                            <i class="fas fa-info-circle me-1"></i>Informations du locataire
                                        </div>
                                        <div style="font-size: 0.9rem;">
                                            <span id="propertyInfo"></span><br>
                                            <span id="lastIndexInfo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Index de compteur -->
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-chart-line"></i>Relevé du Compteur
                            </h4>

                            <div class="form-grid">
                                <div class="form-group animate-delay-2">
                                    <label for="index_precedent" class="form-label">
                                        <i class="fas fa-arrow-left"></i>Index précédent (m³)
                                    </label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" name="index_precedent"
                                            id="index_precedent"
                                            class="form-control @error('index_precedent') is-invalid @enderror"
                                            value="{{ old('index_precedent') }}" placeholder="0.00">
                                        <div class="input-group-text">m³</div>
                                    </div>
                                    @error('index_precedent')
                                        <div class="invalid-feedback animate__animated animate__headShake">{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted mt-1 d-block">Dernier index enregistré pour ce
                                        locataire</small>
                                </div>

                                <div class="form-group animate-delay-3">
                                    <label for="index_compteur" class="form-label required">
                                        <i class="fas fa-arrow-right"></i>Index actuel (m³)
                                    </label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" name="index_compteur"
                                            id="index_compteur"
                                            class="form-control @error('index_compteur') is-invalid @enderror"
                                            value="{{ old('index_compteur') }}" placeholder="0.00" required>
                                        <div class="input-group-text">m³</div>
                                    </div>
                                    @error('index_compteur')
                                        <div class="invalid-feedback animate__animated animate__headShake">{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted mt-1 d-block">Nouveau relevé du compteur</small>
                                </div>
                            </div>
                        </div>

                        <!-- Section Période -->
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-calendar-alt"></i>Période de Consommation
                            </h4>

                            <div class="period-grid">
                                <div class="form-group animate-delay-4">
                                    <label for="periode_debut" class="form-label required">
                                        <i class="fas fa-calendar-day"></i>Date de début
                                    </label>
                                    <input type="date" name="periode_debut" id="periode_debut"
                                        class="form-control @error('periode_debut') is-invalid @enderror"
                                        value="{{ old('periode_debut', date('Y-m-d', strtotime('-1 month'))) }}" required>
                                    @error('periode_debut')
                                        <div class="invalid-feedback animate__animated animate__headShake">{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group animate-delay-5">
                                    <label for="periode_fin" class="form-label required">
                                        <i class="fas fa-calendar-day"></i>Date de fin
                                    </label>
                                    <input type="date" name="periode_fin" id="periode_fin"
                                        class="form-control @error('periode_fin') is-invalid @enderror"
                                        value="{{ old('periode_fin', date('Y-m-d')) }}" required>
                                    @error('periode_fin')
                                        <div class="invalid-feedback animate__animated animate__headShake">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section Prix et Calcul -->
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-calculator"></i>Calcul de la Facture
                            </h4>

                            <div class="form-group animate-delay-2">
                                <label for="prix_m3" class="form-label required">
                                    <i class="fas fa-money-bill"></i>Prix du mètre cube (FCFA)
                                </label>
                                <div class="input-group">
                                    <input type="number" step="1" min="0" name="prix_m3" id="prix_m3"
                                        class="form-control @error('prix_m3') is-invalid @enderror"
                                        value="{{ old('prix_m3', 550) }}" placeholder="550" required>
                                    <div class="input-group-text">FCFA/m³</div>
                                </div>
                                @error('prix_m3')
                                    <div class="invalid-feedback animate__animated animate__headShake">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Calcul automatique -->
                            <div id="calculationResult" class="calculation-card" style="display: none;">
                                <div class="calculation-title">
                                    <i class="fas fa-calculator"></i>Résultat du calcul
                                </div>

                                <div class="calculation-result">
                                    <div class="result-label">Consommation</div>
                                    <h3 class="result-value" id="consumptionValue">0.00 m³</h3>
                                </div>

                                <div class="calculation-result">
                                    <div class="result-label">Montant estimé</div>
                                    <h3 class="result-value" id="estimatedAmount">0 FCFA</h3>
                                </div>

                                <div class="price-info">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Le montant sera calculé automatiquement à partir des index et du prix au m³.
                                </div>
                            </div>
                        </div>

                        <!-- Notes (optionnel) -->
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-sticky-note"></i>Notes (optionnel)
                            </h4>

                            <div class="form-group animate-delay-3">
                                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"
                                    placeholder="Ajoutez des notes ou commentaires si nécessaire...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback animate__animated animate__headShake">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="action-buttons">
                            <a href="{{ route('consommations-eau.index') }}" class="btn btn-cancel">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-submit" id="submitBtn">
                                <i class="fas fa-save me-2"></i>
                                <span id="submitText">Enregistrer la consommation</span>
                                <span class="btn-spinner ms-2" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>

    </html>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation
            const userSelect = document.getElementById('user_id');
            const indexPrecedentInput = document.getElementById('index_precedent');
            const indexActuelInput = document.getElementById('index_compteur');
            const prixM3Input = document.getElementById('prix_m3');
            const userInfo = document.getElementById('userInfo');
            const calculationResult = document.getElementById('calculationResult');
            const consumptionValue = document.getElementById('consumptionValue');
            const estimatedAmount = document.getElementById('estimatedAmount');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const consommationForm = document.getElementById('consumptionForm');

            // Afficher les informations du locataire sélectionné
            // userSelect.addEventListener('change', function() {
            //     const selectedOption = this.options[this.selectedIndex];
            //     if (this.value) {
            //         const property = selectedOption.dataset.property;
            //         const lastIndex = selectedOption.dataset.lastIndex || 0;

            //         document.getElementById('propertyInfo').textContent = `Chambre: ${property}`;
            //         document.getElementById('lastIndexInfo').textContent = `Dernier index: ${lastIndex} m³`;
            //         userInfo.style.display = 'block';

            //         // Pré-remplir l'index précédent
            //         if (lastIndex > 0 && !indexPrecedentInput.value) {
            //             indexPrecedentInput.value = lastIndex;
            //             indexPrecedentInput.classList.add('animate__animated', 'animate__pulse');
            //             setTimeout(() => {
            //                 indexPrecedentInput.classList.remove('animate__animated',
            //                     'animate__pulse');
            //             }, 1000);
            //         }
            //     } else {
            //         userInfo.style.display = 'none';
            //     }
            //     calculateConsumption();
            // });



            // Calculer la consommation
            function calculateConsumption() {
                const indexPrecedent = parseFloat(indexPrecedentInput.value) || 0;
                const indexActuel = parseFloat(indexActuelInput.value) || 0;
                const prixM3 = parseFloat(prixM3Input.value) || 0;

                if (indexActuel > 0 && indexPrecedent >= 0) {
                    const consommation = indexActuel - indexPrecedent;
                    const montant = consommation * prixM3;

                    consumptionValue.textContent = `${consommation.toFixed(2)} m³`;
                    estimatedAmount.textContent = `${Math.round(montant).toLocaleString('fr-FR')} FCFA`;

                    calculationResult.style.display = 'block';
                    calculationResult.classList.add('animate__animated', 'animate__fadeIn');

                    // Animation sur le résultat
                    consumptionValue.classList.add('animate__animated', 'animate__pulse');
                    estimatedAmount.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        consumptionValue.classList.remove('animate__animated', 'animate__pulse');
                        estimatedAmount.classList.remove('animate__animated', 'animate__pulse');
                    }, 500);
                } else {
                    calculationResult.style.display = 'none';
                }
            }

            // Écouter les changements pour le calcul
            indexPrecedentInput.addEventListener('input', calculateConsumption);
            indexActuelInput.addEventListener('input', calculateConsumption);
            prixM3Input.addEventListener('input', calculateConsumption);

            // Validation des dates
            const periodeDebut = document.getElementById('periode_debut');
            const periodeFin = document.getElementById('periode_fin');

            periodeFin.addEventListener('change', function() {
                if (periodeDebut.value && this.value < periodeDebut.value) {
                    alert('La date de fin doit être postérieure à la date de début.');
                    this.value = '';
                    this.focus();
                }
            });

            // Gestion de la soumission
            consommationForm.addEventListener('submit', function(e) {
                const indexPrecedent = parseFloat(indexPrecedentInput.value) || 0;
                const indexActuel = parseFloat(indexActuelInput.value) || 0;

                if (indexActuel <= indexPrecedent) {
                    e.preventDefault();
                    alert('L\'index actuel doit être supérieur à l\'index précédent.');
                    indexActuelInput.focus();
                    indexActuelInput.classList.add('animate__animated', 'animate__shakeX');
                    setTimeout(() => {
                        indexActuelInput.classList.remove('animate__animated', 'animate__shakeX');
                    }, 1000);
                    return;
                }

                // Afficher le spinner
                submitBtn.querySelector('.btn-spinner').style.display = 'inline-block';
                submitBtn.disabled = true;
                submitText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Traitement...';

                // Animation
                submitBtn.classList.add('animate__animated', 'animate__pulse');

                // Récupérer les valeurs pour confirmation
                const consommation = parseFloat(indexActuelInput.value) - parseFloat(indexPrecedentInput
                    .value);
                const prixM3 = parseFloat(prixM3Input.value);
                const montant = Math.round(consommation * prixM3);
                const userName = userSelect.options[userSelect.selectedIndex].textContent;

                // Confirmation
                if (!confirm(
                        `Confirmez-vous l'enregistrement de ${consommation.toFixed(2)} m³ pour un montant de ${montant.toLocaleString('fr-FR')} FCFA pour ${userName} ?`
                    )) {
                    e.preventDefault();
                    submitBtn.querySelector('.btn-spinner').style.display = 'none';
                    submitBtn.disabled = false;
                    submitText.innerHTML = '<i class="fas fa-save me-2"></i>Enregistrer la consommation';
                    submitBtn.classList.remove('animate__animated', 'animate__pulse');
                }
            });

            // Animation d'entrée
            const animatedElements = document.querySelectorAll('.form-group');
            animatedElements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1 + 0.3}s`;
            });

            // Calcul initial si des valeurs existent déjà
            if (indexActuelInput.value && indexPrecedentInput.value) {
                calculateConsumption();
            }
        });
    </script>

    <script>
        document.getElementById('user_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];

            if (!selected.value) {
                document.getElementById('userInfo').style.display = 'none';
                return;
            }

            const property = selected.dataset.property;
            const lastIndex = selected.dataset.lastIndex;

            document.getElementById('propertyInfo').textContent =
                `Chambre : ${property}`;

            document.getElementById('lastIndexInfo').textContent =
                `Dernier index : ${lastIndex} m³`;

            document.getElementById('userInfo').style.display = 'block';
        });
    </script>
@endpush
