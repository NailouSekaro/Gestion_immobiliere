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
                --light: #f8f9fa;
                --dark: #212529;
                --gray: #6c757d;
                --danger: #dc2626;
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

            .travaux-form-container {
                max-width: 900px;
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
                margin-bottom: 1.8rem;
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
                margin-bottom: 0.75rem;
                display: flex;
                align-items: center;
                font-size: 0.95rem;
            }

            .form-label i {
                margin-right: 0.5rem;
                color: var(--primary);
                font-size: 0.9rem;
            }

            .required {
                color: var(--danger);
                margin-left: 0.25rem;
            }

            .input-group {
                position: relative;
            }

            .input-group-prepend {
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                z-index: 4;
            }

            .input-group-text {
                background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.1) 100%);
                border: 2px solid #e2e8f0;
                border-right: none;
                border-radius: 10px 0 0 10px;
                color: var(--primary);
                font-size: 1rem;
                padding: 0 1.2rem;
                transition: var(--transition);
            }

            .form-control,
            .form-select {
                width: 100%;
                padding: 0.9rem 1.2rem;
                padding-left: 4rem;
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

            .error-message {
                color: var(--danger);
                font-size: 0.85rem;
                margin-top: 0.5rem;
                padding-left: 1rem;
                animation: shake 0.5s ease-in-out;
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

            .divider {
                height: 1px;
                background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
                margin: 2.5rem 0;
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
                content: '🔧';
                font-size: 1.2rem;
            }

            .info-card {
                background: linear-gradient(135deg, rgba(76, 201, 240, 0.05) 0%, rgba(76, 201, 240, 0.1) 100%);
                border: 2px solid rgba(76, 201, 240, 0.2);
                border-radius: 12px;
                padding: 1.5rem;
                margin: 2rem 0;
                animation: fadeInUp 0.6s ease forwards;
                opacity: 0;
            }

            .info-card i {
                color: var(--success);
                margin-right: 0.75rem;
                font-size: 1.2rem;
            }

            .btn {
                padding: 0.9rem 2.5rem;
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

            .btn-primary {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                color: white;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
            }

            .btn-outline-secondary {
                background: transparent;
                border: 2px solid #64748b;
                color: #64748b;
                padding: 0.7rem 1.5rem;
            }

            .btn-outline-secondary:hover {
                background: linear-gradient(135deg, #64748b 0%, #475569 100%);
                color: white;
                transform: translateY(-2px);
                border-color: transparent;
            }

            .form-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 3rem;
                padding-top: 2rem;
                border-top: 2px solid #e2e8f0;
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

                .card-body {
                    padding: 1.5rem;
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

                .page-header {
                    flex-direction: column;
                    text-align: center;
                    gap: 1rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="travaux-form-container">
                <!-- En-tête -->
                <div class="page-header">
                    <div>
                        <h1 class="page-title">
                            <i class="fas fa-tools me-2"></i>Nouveau Travail / Intervention
                        </h1>
                        <p class="page-subtitle">Planifiez une maintenance, réparation ou amélioration</p>
                    </div>
                    <a href="{{ route('travaux.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>

                <!-- Formulaire principal -->
                <form method="POST" action="{{ route('travaux.store') }}" id="travauxForm" class="card">
                    @csrf

                    <div class="card-body">
                        <!-- Section Propriété -->
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <h3 class="section-title">Propriété concernée</h3>
                        </div>

                        <div class="form-group animate-delay-1">
                            <label class="form-label">
                                <i class="fas fa-building"></i>Propriété <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-home"></i>
                                    </span>
                                </div>
                                <select name="property_id" id="property_id" class="form-select" required>
                                    <option value="" disabled selected>Choisir une propriété...</option>
                                    @foreach ($properties as $property)
                                        <option value="{{ $property->id }}"
                                            {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                            {{ $property->nom ?: 'Propriété #' . $property->id }}
                                            — {{ $property->adresse ?? 'Adresse non renseignée' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('property_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="divider"></div>

                        <!-- Section Intervention -->
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-wrench"></i>
                            </div>
                            <h3 class="section-title">Détails de l'intervention</h3>
                        </div>

                        <div class="form-group animate-delay-2">
                            <label class="form-label">
                                <i class="fas fa-tools"></i>Type d'intervention <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-tools"></i>
                                    </span>
                                </div>
                                <input type="text" name="type_travail" id="type_travail" class="form-control"
                                    placeholder="ex: Plomberie, Électricité, Peinture, Toiture..." required
                                    value="{{ old('type_travail') }}">
                            </div>
                            @error('type_travail')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group animate-delay-3">
                            <label class="form-label">
                                <i class="far fa-calendar-alt"></i>Date prévue <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="date" name="date_travail" id="date_travail" class="form-control" required
                                    value="{{ old('date_travail') }}">
                            </div>
                            @error('date_travail')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- <div class="form-group animate-delay-4">
                    <label class="form-label">
                        <i class="fas fa-user-tie"></i>Prestataire / Artisan
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-user-tie"></i>
                            </span>
                        </div>
                        <input type="text"
                               name="prestataire"
                               id="prestataire"
                               class="form-control"
                               placeholder="Nom de l'entreprise ou de l'artisan"
                               value="{{ old('prestataire') }}">
                    </div>
                    @error('prestataire')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div> --}}

                        <div class="form-group animate-delay-4">
                            <label class="form-label">
                                <i class="fas fa-user-tie"></i> Prestataire / Artisan
                            </label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user-tie"></i>
                                    </span>
                                </div>

                                <select name="prestataire_id"
                                    class="form-control @error('prestataire_id') is-invalid @enderror">
                                    <option value="">— Sélectionner un prestataire —</option>

                                    @foreach ($prestataires as $prestataire)
                                        <option value="{{ $prestataire->id }}"
                                            {{ old('prestataire_id') == $prestataire->id ? 'selected' : '' }}>
                                            {{ $prestataire->prenom }} {{ $prestataire->nom }}
                                            @if ($prestataire->specialite)
                                                — {{ ucfirst($prestataire->specialite) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @error('prestataire_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>


                        <!-- Informations complémentaires -->
                        <div class="info-card animate-delay-5">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle"></i>
                                <div>
                                    <strong>Information :</strong> Vous pourrez ajouter le coût, le statut et les photos
                                    après l'enregistrement initial.
                                </div>
                            </div>
                        </div>

                        <!-- Pied de formulaire -->
                        <div class="form-footer">
                            <a href="{{ route('travaux.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>

                            <div style="flex-grow: 1;"></div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                <span>Enregistrer l'intervention</span>
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
            const form = document.getElementById('travauxForm');
            const submitBtn = form.querySelector('.btn-primary');
            const btnSpinner = submitBtn.querySelector('.btn-spinner');
            const today = new Date().toISOString().split('T')[0];

            // Définir la date minimale à aujourd'hui
            const dateInput = document.getElementById('date_travail');
            dateInput.min = today;

            // Si aucune date n'est définie, mettre aujourd'hui par défaut
            if (!dateInput.value) {
                dateInput.value = today;
            }

            // Animation d'entrée des éléments
            const animatedElements = document.querySelectorAll('.form-group, .info-card');
            animatedElements.forEach((element, index) => {
                element.style.animationDelay = `${(index * 0.1) + 0.3}s`;
                element.classList.add('animate__animated');

                if (element.classList.contains('form-group')) {
                    element.classList.add('animate__fadeInRight');
                } else if (element.classList.contains('info-card')) {
                    element.classList.add('animate__fadeInUp');
                }
            });

            // Gestion de la soumission
            form.addEventListener('submit', function(e) {
                const propertySelect = document.getElementById('property_id');
                const typeTravail = document.getElementById('type_travail');
                const dateTravail = document.getElementById('date_travail');

                // Validation basique
                if (!propertySelect.value) {
                    e.preventDefault();
                    showError(propertySelect, 'Veuillez sélectionner une propriété');
                    return;
                }

                if (!typeTravail.value.trim()) {
                    e.preventDefault();
                    showError(typeTravail, 'Veuillez saisir le type d\'intervention');
                    return;
                }

                // Afficher le spinner
                btnSpinner.style.display = 'inline-block';
                submitBtn.disabled = true;
                submitBtn.classList.add('animate__animated', 'animate__pulse');

                // Récupérer les informations pour la confirmation
                const propertyName = propertySelect.options[propertySelect.selectedIndex].text;
                const interventionType = typeTravail.value;
                const interventionDate = dateTravail.value;

                const formattedDate = new Date(interventionDate).toLocaleDateString('fr-FR', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                // Confirmation
                if (!confirm(
                        `Confirmez-vous la planification de l'intervention "${interventionType}" pour le ${formattedDate} sur la propriété : ${propertyName} ?`
                        )) {
                    e.preventDefault();
                    btnSpinner.style.display = 'none';
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('animate__animated', 'animate__pulse');
                }
            });

            // Animation sur les champs au focus
            const formControls = document.querySelectorAll('.form-control, .form-select');
            formControls.forEach(control => {
                control.addEventListener('focus', function() {
                    this.parentElement.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        this.parentElement.classList.remove('animate__animated',
                            'animate__pulse');
                    }, 500);
                });
            });

            function showError(element, message) {
                // Créer ou mettre à jour le message d'erreur
                let errorDiv = element.parentElement.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    element.parentElement.appendChild(errorDiv);
                }
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i>${message}`;

                // Animation sur l'élément en erreur
                element.style.borderColor = 'var(--danger)';
                element.classList.add('animate__animated', 'animate__shakeX');
                setTimeout(() => {
                    element.classList.remove('animate__animated', 'animate__shakeX');
                }, 500);

                // Focus sur l'élément
                element.focus();
            }
        });
    </script>
@endpush
