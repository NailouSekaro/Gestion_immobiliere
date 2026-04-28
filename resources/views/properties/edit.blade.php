@extends('layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Propriété</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --warning: #ff9e16;
            --warning-dark: #e58900;
            --light: #050506;
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
            background: linear-gradient(120deg, var(--warning), var(--warning-dark)) !important;
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

        .col-md-8, .col-md-6 {
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
            color: rgb(5, 5, 5);
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

        .btn-warning {
            background: linear-gradient(to right, var(--warning), var(--warning-dark));
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 158, 22, 0.4);
            background: linear-gradient(to right, var(--warning-dark), var(--warning));
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
            display: block;
            transition: var(--transition);
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
            border-color: var(--warning);
            box-shadow: 0 0 0 3px rgba(255, 158, 22, 0.2);
            outline: none;
            background-color: white;
        }

        .form-control:hover {
            border-color: #cbd5e0;
        }

        .form-section {
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .form-section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--warning-dark);
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
        }

        .form-section-title i {
            margin-right: 10px;
            font-size: 1.1rem;
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

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }

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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="page-header">
                            <h4 class="page-title text-dark">
                                Modifier la Propriété
                            </h4>
                            <a href="{{ route('properties.show', $property) }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-1"></i> Retour aux détails
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('properties.update', $property) }}" method="POST" id="propertyForm">
                            @csrf
                            @method('PUT')

                            <div class="form-section">
                                <h5 class="form-section-title"><i class="fas fa-info-circle"></i> Informations générales</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group delay-1">
                                            <label for="nom" class="form-label">Nom de la propriété</label>
                                            <input type="text" class="form-control" id="nom" name="nom"
                                                   value="{{ old('nom', $property->nom) }}"
                                                   placeholder="Ex: Villa des Roses">
                                            <small class="form-text">Donnez un nom unique à votre propriété</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group delay-2">
                                            <label for="type" class="form-label required">Type de propriété</label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="maison" {{ old('type', $property->type) == 'maison' ? 'selected' : '' }}>Maison</option>
                                                <option value="appartement" {{ old('type', $property->type) == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                                <option value="studio" {{ old('type', $property->type) == 'studio' ? 'selected' : '' }}>Studio</option>
                                                <option value="bureau" {{ old('type', $property->type) == 'bureau' ? 'selected' : '' }}>Bureau</option>
                                                <option value="commerce" {{ old('type', $property->type) == 'commerce' ? 'selected' : '' }}>Local Commercial</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group delay-3">
                                            <label for="adresse" class="form-label required">Adresse complète</label>
                                            <input type="text" class="form-control" id="adresse" name="adresse"
                                                   value="{{ old('adresse', $property->adresse) }}" required
                                                   placeholder="Ex: 123 Avenue de la République">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group delay-4">
                                            <label for="ville" class="form-label required">Ville</label>
                                            <input type="text" class="form-control" id="ville" name="ville"
                                                   value="{{ old('ville', $property->ville) }}" required
                                                   placeholder="Ex: Paris">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group delay-4">
                                            <label for="code_postal" class="form-label">Code postal</label>
                                            <input type="text" class="form-control" id="code_postal" name="code_postal"
                                                   value="{{ old('code_postal', $property->code_postal) }}"
                                                   placeholder="Ex: 75001">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group delay-4">
                                            <label for="pays" class="form-label required">Pays</label>
                                            <input type="text" class="form-control" id="pays" name="pays"
                                                   value="{{ old('pays', $property->pays) }}" required
                                                   placeholder="Ex: France">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="form-section-title"><i class="fas fa-expand-arrows-alt"></i> Caractéristiques physiques</h5>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group delay-1">
                                            <label for="surface" class="form-label required">Surface (m²)</label>
                                            <input type="number" class="form-control" id="surface" name="surface"
                                                   value="{{ old('surface', $property->surface) }}" required
                                                   min="1" step="0.5">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group delay-2">
                                            <label for="nombre_pieces" class="form-label required">Nombre de pièces</label>
                                            <input type="number" class="form-control" id="nombre_pieces" name="nombre_pieces"
                                                   value="{{ old('nombre_pieces', $property->nombre_pieces) }}" required
                                                   min="1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group delay-3">
                                            <label for="nombre_chambres" class="form-label">Nombre de chambres</label>
                                            <input type="number" class="form-control" id="nombre_chambres" name="nombre_chambres"
                                                   value="{{ old('nombre_chambres', $property->nombre_chambres) }}"
                                                   min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="form-section-title"><i class="fas fa-euro-sign"></i> Informations financières</h5>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group delay-1">
                                            <label for="loyer_mensuel" class="form-label required">Loyer mensuel (€)</label>
                                            <input type="number" class="form-control" id="loyer_mensuel" name="loyer_mensuel"
                                                   value="{{ old('loyer_mensuel', $property->loyer_mensuel) }}" required
                                                   min="0" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group delay-2">
                                            <label for="charges" class="form-label">Charges incluses (€)</label>
                                            <input type="number" class="form-control" id="charges" name="charges"
                                                   value="{{ old('charges', $property->charges) }}"
                                                   min="0" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group delay-3">
                                            <label for="caution" class="form-label required">Caution (€)</label>
                                            <input type="number" class="form-control" id="caution" name="caution"
                                                   value="{{ old('caution', $property->caution) }}" required
                                                   min="0" step="0.01">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="form-section-title"><i class="fas fa-calendar-alt"></i> Disponibilité</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group delay-1">
                                            <label for="date_disponibilite" class="form-label required">Date de disponibilité</label>
                                            <input type="date" class="form-control" id="date_disponibilite" name="date_disponibilite"
                                                   value="{{ old('date_disponibilite', $property->date_disponibilite->format('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group delay-2">
                                            <label for="statut" class="form-label required">Statut</label>
                                            <select class="form-control" id="statut" name="statut" required>
                                                <option value="libre" {{ old('statut', $property->statut) == 'libre' ? 'selected' : '' }}>Libre</option>
                                                <option value="occupé" {{ old('statut', $property->statut) == 'occupé' ? 'selected' : '' }}>Occupé</option>
                                                <option value="en_entretien" {{ old('statut', $property->statut) == 'en_entretien' ? 'selected' : '' }}>En entretien</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <a href="{{ route('properties.show', $property) }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i> Mettre à jour la propriété
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des éléments au défilement
            const formGroups = document.querySelectorAll('.form-group');

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
            }, { threshold: 0.1 });

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
                            field.style.borderColor = '#e53e3e';
                        } else {
                            field.style.borderColor = '';
                        }
                    });

                    if (!valid) {
                        e.preventDefault();
                        alert('Veuillez remplir tous les champs obligatoires.');
                    }
                });
            }
        });
    </script>
</body>
</html>
@endsection
