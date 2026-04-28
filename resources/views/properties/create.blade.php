@extends('layouts.template')

@section('content')
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nouvelle Propriété</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary: #4361ee;
                --secondary: #3f37c9;
                --success: #4cc9f0;
                --success-dark: #3a8fb8;
                --light: #060d14;
                --dark: #212529;
                --gray: #6c757d;
                --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
                --transition: all 0.3s ease;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }

            body {
                background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
                color: #333;
                line-height: 1.6;
                min-height: 100vh;
                padding: 2rem 0;
            }

            .container-fluid {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 15px;
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
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                border-bottom: 1px solid rgba(0, 0, 0, 0.06);
                padding: 1.5rem 2rem;
                font-weight: 600;
                background: linear-gradient(120deg, var(--success), var(--success-dark)) !important;
                color: white;
            }

            .card-body {
                padding: 2rem;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -12px;
            }

            .col-md-8,
            .col-md-6,
            .col-md-4 {
                padding: 12px;
            }

            /* En-tête améliorée */
            .page-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .page-title {
                font-size: 1.75rem;
                font-weight: 700;
                color: rgb(15, 15, 15);
                display: flex;
                align-items: center;
                margin: 0;
            }

            .page-title i {
                margin-right: 12px;
                font-size: 1.5rem;
            }

            /* Boutons */
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
            }

            .btn i {
                margin-right: 8px;
            }

            .btn-light {
                background: white;
                color: var(--gray);
                border: 1px solid #dee2e6;
            }

            .btn-light:hover {
                background: #f8f9fa;
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            }

            .btn-success {
                background: linear-gradient(to right, var(--success), var(--success-dark));
                color: white;
            }

            .btn-success:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(76, 201, 240, 0.4);
                background: linear-gradient(to right, var(--success-dark), var(--success));
            }

            .btn-secondary {
                background: linear-gradient(to right, #6c757d, #5a6268);
                color: white;
            }

            .btn-secondary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(108, 117, 125, 0.4);
                background: linear-gradient(to right, #5a6268, #6c757d);
            }

            /* Formulaire */
            .form-group {
                margin-bottom: 1.5rem;
                position: relative;
            }

            .form-label {
                font-weight: 500;
                margin-bottom: 0.5rem;
                color: var(--dark);
                display: flex;
                align-items: center;
                transition: var(--transition);
            }

            .form-label i {
                margin-right: 10px;
                font-size: 1.1rem;
                color: var(--success);
                width: 20px;
            }

            .form-control {
                width: 100%;
                padding: 0.9rem 1.2rem;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                transition: var(--transition);
                font-size: 1rem;
                background-color: #f9fafc;
            }

            .form-control:focus {
                border-color: var(--success);
                box-shadow: 0 0 0 3px rgba(76, 201, 240, 0.2);
                outline: none;
                background-color: white;
            }

            .form-control:hover {
                border-color: #cbd5e0;
            }

            textarea.form-control {
                min-height: 100px;
                resize: vertical;
            }

            .form-section {
                margin-bottom: 2.5rem;
                padding-bottom: 1.5rem;
                border-bottom: 1px solid #e2e8f0;
            }

            .form-section-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--success-dark);
                margin-bottom: 1.2rem;
                display: flex;
                align-items: center;
                padding-left: 10px;
                border-left: 4px solid var(--success);
            }

            .form-section-title i {
                margin-right: 10px;
                font-size: 1.1rem;
            }

            /* Checkboxes modernes */
            .form-check {
                margin-bottom: 0.75rem;
                padding-left: 2rem;
            }

            .form-check-input {
                width: 1.2em;
                height: 1.2em;
                margin-top: 0.15em;
                margin-left: -2rem;
                border: 2px solid #cbd5e0;
                border-radius: 4px;
                transition: var(--transition);
            }

            .form-check-input:checked {
                background-color: var(--success);
                border-color: var(--success);
            }

            .form-check-input:focus {
                box-shadow: 0 0 0 3px rgba(76, 201, 240, 0.2);
                border-color: var(--success);
            }

            .form-check-label {
                font-weight: 500;
                color: var(--dark);
                transition: var(--transition);
            }

            .form-check:hover .form-check-label {
                color: var(--success-dark);
            }

            /* Actions du formulaire */
            .form-actions {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 2rem;
                padding-top: 1.5rem;
                border-top: 1px solid #e2e8f0;
            }

            /* Animation des éléments du formulaire */
            .form-group {
                opacity: 0;
                transform: translateY(10px);
                animation: fadeInUp 0.5s ease forwards;
            }

            .delay-1 {
                animation-delay: 0.1s;
            }

            .delay-2 {
                animation-delay: 0.2s;
            }

            .delay-3 {
                animation-delay: 0.3s;
            }

            .delay-4 {
                animation-delay: 0.4s;
            }

            .delay-5 {
                animation-delay: 0.5s;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Validation */
            .is-invalid {
                border-color: #e53e3e !important;
            }

            .is-invalid:focus {
                box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.2) !important;
            }

            .invalid-feedback {
                color: #e53e3e;
                font-size: 0.85rem;
                margin-top: 0.4rem;
                display: block;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .container-fluid {
                    padding: 0 10px;
                }

                .card-body {
                    padding: 1.5rem;
                }

                .form-actions {
                    flex-direction: column;
                    gap: 1rem;
                }

                .btn {
                    width: 100%;
                }

                .page-header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .page-title {
                    margin-bottom: 1rem;
                }
            }

            /* Style pour les selects */
            select.form-control {
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 1rem center;
                background-size: 16px;
                padding-right: 3rem;
            }

            /* Indicateur de champ requis */
            .required::after {
                content: '*';
                color: #e53e3e;
                margin-left: 4px;
            }

            /* Message d'aide */
            .form-text {
                font-size: 0.85rem;
                color: var(--gray);
                margin-top: 0.4rem;
                display: block;
            }

            /* Caractéristiques grid */
            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 12px;
            }

            /* Placeholder styling */
            ::placeholder {
                color: #a0aec0 !important;
                opacity: 1;
            }

            :-ms-input-placeholder {
                color: #a0aec0 !important;
            }

            ::-ms-input-placeholder {
                color: #a0aec0 !important;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="page-header">
                                <h4 class="page-title">
                                    <i class="fas fa-plus-circle me-2"></i>Nouvelle Propriété
                                </h4>
                                <a href="{{ route('properties.index') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('properties.store') }}" method="POST" id="propertyForm">
                                @csrf

                                <div class="form-section">
                                    <h5 class="form-section-title"><i class="fas fa-info-circle"></i> Informations générales
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group delay-1">
                                                <label for="nom" class="form-label">
                                                    <i class="fas fa-tag"></i>Nom de la propriété (optionnel)
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('nom') is-invalid @enderror" id="nom"
                                                    name="nom" value="{{ old('nom') }}"
                                                    placeholder="Ex: Villa Belle, Appartement 12B...">
                                                @error('nom')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group delay-2">
                                                <label for="type" class="form-label">
                                                    <i class="fas fa-building"></i>Type de propriété
                                                </label>
                                                <select class="form-control @error('type') is-invalid @enderror"
                                                    id="type" name="type" required>
                                                    <option value="">Sélectionner un type</option>
                                                    <option value="maison" {{ old('type') == 'maison' ? 'selected' : '' }}>
                                                        Maison</option>
                                                    <option value="appartement"
                                                        {{ old('type') == 'appartement' ? 'selected' : '' }}>Appartement
                                                    </option>
                                                    <option value="studio" {{ old('type') == 'studio' ? 'selected' : '' }}>
                                                        Studio</option>
                                                    <option value="bureau" {{ old('type') == 'bureau' ? 'selected' : '' }}>
                                                        Bureau</option>
                                                    <option value="commerce"
                                                        {{ old('type') == 'commerce' ? 'selected' : '' }}>Local Commercial
                                                    </option>
                                                </select>
                                                @error('type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group delay-3">
                                        <label for="adresse" class="form-label">
                                            <i class="fas fa-map-marker-alt"></i>Adresse complète
                                        </label>
                                        <textarea class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" rows="2"
                                            required placeholder="Adresse complète de la propriété">{{ old('adresse') }}</textarea>
                                        @error('adresse')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group delay-4">
                                                <label for="ville" class="form-label">
                                                    <i class="fas fa-city"></i>Ville
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('ville') is-invalid @enderror" id="ville"
                                                    name="ville" value="{{ old('ville') }}" required
                                                    placeholder="Ex: Cotonou">
                                                @error('ville')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group delay-4">
                                                <label for="pays" class="form-label">
                                                    <i class="fas fa-globe"></i>Pays
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('pays') is-invalid @enderror" id="pays"
                                                    name="pays" value="{{ old('pays', 'Bénin') }}" required>
                                                @error('pays')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h5 class="form-section-title"><i class="fas fa-expand-arrows-alt"></i> Caractéristiques
                                        physiques</h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group delay-1">
                                                <label for="nombre_pieces" class="form-label">
                                                    <i class="fas fa-door-open"></i>Nombre de pièces
                                                </label>
                                                <input type="number"
                                                    class="form-control @error('nombre_pieces') is-invalid @enderror"
                                                    id="nombre_pieces" name="nombre_pieces"
                                                    value="{{ old('nombre_pieces') }}" min="1" required
                                                    placeholder="Ex: 3">
                                                @error('nombre_pieces')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group delay-2">
                                                <label for="surface" class="form-label">
                                                    <i class="fas fa-vector-square"></i>Surface (m²)
                                                </label>
                                                <input type="number"
                                                    class="form-control @error('surface') is-invalid @enderror"
                                                    id="surface" name="surface" value="{{ old('surface') }}"
                                                    min="1" step="0.01" required placeholder="Ex: 85.5">
                                                @error('surface')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h5 class="form-section-title"><i class="fas fa-euro-sign"></i> Informations
                                        financières</h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group delay-1">
                                                <label for="loyer_mensuel" class="form-label">
                                                    <i class="fas fa-money-bill-wave"></i>Loyer mensuel (XAF)
                                                </label>
                                                <input type="number"
                                                    class="form-control @error('loyer_mensuel') is-invalid @enderror"
                                                    id="loyer_mensuel" name="loyer_mensuel"
                                                    value="{{ old('loyer_mensuel') }}" min="0" step="100"
                                                    required placeholder="Ex: 75000">
                                                @error('loyer_mensuel')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group delay-2">
                                                <label for="caution" class="form-label">
                                                    <i class="fas fa-shield-alt"></i>Caution (XAF)
                                                </label>
                                                <input type="number"
                                                    class="form-control @error('caution') is-invalid @enderror"
                                                    id="caution" name="caution" value="{{ old('caution', 0) }}"
                                                    min="0" step="100" placeholder="Ex: 150000">
                                                @error('caution')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h5 class="form-section-title"><i class="fas fa-calendar-alt"></i> Disponibilité</h5>

                                    <div class="form-group delay-1">
                                        <label for="date_disponibilite" class="form-label">
                                            <i class="fas fa-calendar"></i>Date de disponibilité
                                        </label>
                                        <input type="date"
                                            class="form-control @error('date_disponibilite') is-invalid @enderror"
                                            id="date_disponibilite" name="date_disponibilite"
                                            value="{{ old('date_disponibilite') }}" required>
                                        @error('date_disponibilite')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h5 class="form-section-title"><i class="fas fa-list"></i> Caractéristiques</h5>

                                    <div class="features-grid">
                                        @php
                                            $caracteristiques = [
                                                'eau_courante' => 'Eau courante',
                                                'electricite' => 'Électricité',
                                                'internet' => 'Internet',
                                                'meuble' => 'Meublé',
                                                'climatiseur' => 'Climatiseur',
                                                'chauffe_eau' => 'Chauffe-eau',
                                                'garage' => 'Garage',
                                                'jardin' => 'Jardin',
                                                'piscine' => 'Piscine',
                                                'gardien' => 'Gardien',
                                            ];
                                        @endphp
                                        @foreach ($caracteristiques as $key => $label)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="caracteristiques[{{ $key }}]"
                                                    id="caract_{{ $key }}" value="1"
                                                    {{ old('caracteristiques.' . $key) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="caract_{{ $key }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h5 class="form-section-title"><i class="fas fa-sticky-note"></i> Notes
                                        supplémentaires</h5>

                                    <div class="form-group delay-1">
                                        <label for="notes" class="form-label">
                                            <i class="fas fa-edit"></i>Informations supplémentaires
                                        </label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"
                                            placeholder="Informations supplémentaires sur la propriété">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="fas fa-undo me-1"></i> Réinitialiser
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Créer la propriété
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Animation des éléments au défilement
                const formGroups = document.querySelectorAll('.form-group, .form-check');

                formGroups.forEach(group => {
                    group.style.opacity = '0';
                });

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.animationPlayState = 'running';
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                });

                formGroups.forEach(group => {
                    observer.observe(group);
                });

                // Calcul automatique du loyer annuel
                const loyerMensuelInput = document.getElementById('loyer_mensuel');
                if (loyerMensuelInput) {
                    loyerMensuelInput.addEventListener('input', function() {
                        const loyerMensuel = parseFloat(this.value) || 0;
                        // Vous pouvez ajouter un champ pour le loyer annuel si nécessaire
                        // document.getElementById('loyer_annuel').value = (loyerMensuel * 12).toFixed(2);
                    });
                }

                // Validation du formulaire
                const form = document.getElementById('propertyForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        let valid = true;
                        const requiredFields = form.querySelectorAll('[required]');

                        requiredFields.forEach(field => {
                            if (!field.value.trim()) {
                                valid = false;
                                field.classList.add('is-invalid');

                                // Animation de secousse pour le champ invalide
                                field.style.animation = 'shake 0.5s ease';
                                setTimeout(() => {
                                    field.style.animation = '';
                                }, 500);
                            } else {
                                field.classList.remove('is-invalid');
                            }
                        });

                        if (!valid) {
                            e.preventDefault();

                            // Scroll to the first invalid field
                            const firstInvalid = form.querySelector('.is-invalid');
                            if (firstInvalid) {
                                firstInvalid.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }
                        }
                    });
                }

                // Ajout d'une animation de secousse
                const style = document.createElement('style');
                style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
            `;
                document.head.appendChild(style);
            });
        </script> --}}
    </body>

    </html>
@endsection
