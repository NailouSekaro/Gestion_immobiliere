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
                --danger-light: #fee2e2;
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

            .travail-detail-container {
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
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
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
                margin: 0;
                background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .page-subtitle {
                color: var(--gray);
                font-size: 1rem;
                margin-top: 0.5rem;
            }

            .btn {
                padding: 0.75rem 1.5rem;
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
                font-size: 0.95rem;
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

            .btn-success {
                background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
                color: white;
            }

            .btn-success:hover {
                background: linear-gradient(135deg, var(--success-dark) 0%, var(--success) 100%);
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(76, 201, 240, 0.3);
            }

            .btn-outline-secondary {
                background: transparent;
                border: 2px solid #64748b;
                color: #64748b;
            }

            .btn-outline-secondary:hover {
                background: linear-gradient(135deg, #64748b 0%, #475569 100%);
                color: white;
                transform: translateY(-2px);
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

            .card-header {
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border-bottom: 2px solid var(--primary-light);
                padding: 1.5rem 2rem;
            }

            .card-body {
                padding: 2rem;
            }

            .info-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .info-card {
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border: 2px solid #e2e8f0;
                border-radius: 12px;
                padding: 1.5rem;
                transition: var(--transition);
                position: relative;
                overflow: hidden;
            }

            .info-card:hover {
                border-color: var(--primary);
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(67, 97, 238, 0.1);
            }

            .info-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: linear-gradient(180deg, var(--primary), var(--primary-dark));
            }

            .info-card:nth-child(2)::before {
                background: linear-gradient(180deg, #4cc9f0, #3a8fb8);
            }

            .info-card:nth-child(3)::before {
                background: linear-gradient(180deg, #facc15, #d97706);
            }

            .info-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: rgba(67, 97, 238, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
            }

            .info-icon i {
                color: var(--primary);
                font-size: 1.25rem;
            }

            .info-card:nth-child(2) .info-icon {
                background: rgba(76, 201, 240, 0.1);
            }

            .info-card:nth-child(2) .info-icon i {
                color: #4cc9f0;
            }

            .info-card:nth-child(3) .info-icon {
                background: rgba(250, 204, 21, 0.1);
            }

            .info-card:nth-child(3) .info-icon i {
                color: #facc15;
            }

            .info-label {
                font-size: 0.9rem;
                color: var(--gray);
                margin-bottom: 0.5rem;
                font-weight: 500;
            }

            .info-value {
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--dark);
                margin: 0;
            }

            .warning-alert {
                background: linear-gradient(135deg, rgba(250, 204, 21, 0.1) 0%, rgba(250, 204, 21, 0.2) 100%);
                border: 2px solid rgba(250, 204, 21, 0.3);
                border-left: 4px solid var(--warning);
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 2rem;
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

            .warning-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: rgba(250, 204, 21, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1rem;
            }

            .warning-icon i {
                color: var(--warning-dark);
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

            .form-control {
                width: 100%;
                padding: 0.9rem 1.2rem;
                border: 2px solid #e2e8f0;
                border-radius: 10px;
                transition: var(--transition);
                font-size: 1rem;
                background-color: #f9fafc;
            }

            .form-control:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
                outline: none;
                background-color: white;
                transform: translateY(-2px);
            }

            .input-group {
                position: relative;
            }

            .input-group-text {
                background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.1) 100%);
                border: 2px solid #e2e8f0;
                border-left: none;
                border-radius: 0 10px 10px 0;
                color: var(--primary);
                font-size: 1rem;
                padding: 0 1.2rem;
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
                content: '💰';
                font-size: 1.2rem;
            }

            .depenses-list {
                margin-top: 2rem;
            }

            .depense-item {
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border: 2px solid #e2e8f0;
                border-radius: 10px;
                padding: 1.2rem 1.5rem;
                margin-bottom: 1rem;
                transition: var(--transition);
                display: flex;
                justify-content: space-between;
                align-items: center;
                animation: fadeInUp 0.5s ease forwards;
                opacity: 0;
            }

            .depense-item:hover {
                border-color: var(--primary-light);
                transform: translateX(5px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            }

            .depense-info h6 {
                margin: 0;
                font-weight: 600;
                color: var(--dark);
                font-size: 0.95rem;
            }

            .depense-date {
                color: var(--gray);
                font-size: 0.85rem;
                margin-top: 0.25rem;
            }

            .depense-amount {
                font-weight: 700;
                color: var(--danger);
                font-size: 1.1rem;
                text-align: right;
            }

            .empty-state {
                text-align: center;
                padding: 3rem 2rem;
                background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
                border: 2px dashed #e2e8f0;
                border-radius: 12px;
                margin: 2rem 0;
            }

            .empty-icon {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
            }

            .empty-icon i {
                color: var(--primary);
                font-size: 1.5rem;
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

                .page-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                }

                .info-grid {
                    grid-template-columns: 1fr;
                }

                .depense-item {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.75rem;
                }

                .depense-amount {
                    text-align: left;
                    width: 100%;
                    padding-top: 0.75rem;
                    border-top: 1px solid #e2e8f0;
                }
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="travail-detail-container">
                <!-- En-tête -->
                <div class="page-header">
                    <div>
                        <h1 class="page-title">
                            <i class="fas fa-tools me-2"></i>{{ $travail->type_travail }}
                        </h1>
                        <p class="page-subtitle">Détails de l'intervention et gestion des dépenses</p>
                    </div>
                    <a href="{{ route('travaux.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>

                <!-- Message de succès -->
                @if (session('success'))
                    <div class="alert-success animate__animated animate__slideInDown">
                        <i class="fas fa-check-circle"></i>
                        <div class="alert-content">
                            <h5>Succès !</h5>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Carte informations principales -->
                <div class="card animate-delay-1">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informations Générales
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <!-- Propriété -->
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="info-label">Propriété concernée</div>
                                @if ($travail->property)
                                    <h4 class="info-value">{{ $travail->property->nom }}</h4>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $travail->property->adresse ?? 'Adresse non renseignée' }}
                                    </small>
                                @else
                                    <div class="warning-alert mt-2">
                                        <div class="d-flex align-items-center">
                                            <div class="warning-icon">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                            <div>
                                                <strong class="text-warning-dark">Aucune propriété associée</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Date -->
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div class="info-label">Date prévue</div>
                                <h4 class="info-value">
                                    {{ \Carbon\Carbon::parse($travail->date_travail)->format('d/m/Y') }}
                                </h4>
                            </div>

                            <!-- Prestataire -->
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="info-label">Prestataire / Artisan</div>
                                @if ($travail->prestataire)
                                    {{ $travail->prestataire->prenom }} {{ $travail->prestataire->nom }}
                                    <span class="text-muted">
                                        ({{ $travail->prestataire->specialite }})
                                    </span>
                                @else
                                    <span class="text-danger">Non assigné</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte total dépenses -->
                <div class="card animate-delay-2">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-money-bill-wave me-2"></i>Total des Dépenses
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-3">
                            <h1 class="display-4 fw-bold text-danger">
                                {{ number_format($travail->total_depense, 0, ',', ' ') }} FCFA
                            </h1>
                            <p class="text-muted">
                                <i class="fas fa-chart-line me-1"></i>
                                Total cumulé de toutes les dépenses liées à cette intervention
                            </p>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Carte ajout dépense -->
                <div class="card animate-delay-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Ajouter une Dépense
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('travaux.depenses.store', ['travail' => $travail->id]) }}"
                            id="depenseForm">
                            @csrf

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>Libellé de la dépense <span class="required">*</span>
                                </label>
                                <input type="text" name="libelle" class="form-control"
                                    placeholder="ex: Achat de matériel, Main d'œuvre, Transport..." required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-money-bill"></i>Montant <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="montant" class="form-control" placeholder="0" min="0"
                                        step="100" required>
                                    <span class="input-group-text">FCFA</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="far fa-calendar-alt"></i>Date de la dépense <span class="required">*</span>
                                </label>
                                <input type="date" name="date_depense" class="form-control" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>

                            <div class="form-footer mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    <span>Ajouter la dépense</span>
                                    <span class="btn-spinner ms-2" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Carte liste des dépenses -->
                <div class="card animate-delay-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list-check me-2"></i>Historique des Dépenses
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="depenses-list">
                            @if ($travail->depenses->isEmpty())
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                    <h5>Aucune dépense enregistrée</h5>
                                    <p class="text-muted">Commencez par ajouter votre première dépense</p>
                                </div>
                            @else
                                @foreach ($travail->depenses as $index => $depense)
                                    <div class="depense-item animate-delay-{{ ($index % 5) + 1 }}">
                                        <div class="depense-info">
                                            <h6>
                                                <i class="fas fa-receipt me-2 text-primary"></i>
                                                {{ $depense->libelle }}
                                            </h6>
                                            <div class="depense-date">
                                                <i class="far fa-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($depense->date_depense)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                        <div class="depense-amount">
                                            {{ number_format($depense->montant, 0, ',', ' ') }} FCFA
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Total résumé -->
                                <div class="info-card mt-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="info-label">Total des dépenses</div>
                                            <h4 class="info-value">
                                                {{ number_format($travail->total_depense, 0, ',', ' ') }} FCFA</h4>
                                        </div>
                                        <div>
                                            <div class="info-label">Nombre de dépenses</div>
                                            <h4 class="info-value">{{ $travail->depenses->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
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
            const form = document.getElementById('depenseForm');
            const submitBtn = form.querySelector('.btn-success');
            const btnSpinner = submitBtn.querySelector('.btn-spinner');

            // Définir la date minimale à aujourd'hui
            const dateInput = document.querySelector('input[name="date_depense"]');
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;

            // Animation d'entrée des éléments
            const animatedElements = document.querySelectorAll('.form-group, .card, .depense-item');
            animatedElements.forEach((element, index) => {
                element.style.animationDelay = `${(index * 0.1) + 0.3}s`;
                element.classList.add('animate__animated');

                if (element.classList.contains('form-group')) {
                    element.classList.add('animate__fadeInRight');
                } else if (element.classList.contains('card')) {
                    element.classList.add('animate__fadeInUp');
                } else if (element.classList.contains('depense-item')) {
                    element.classList.add('animate__fadeInUp');
                }
            });

            // Gestion de la soumission du formulaire
            form.addEventListener('submit', function(e) {
                const libelle = document.querySelector('input[name="libelle"]').value.trim();
                const montant = document.querySelector('input[name="montant"]').value;

                // Validation
                if (!libelle) {
                    e.preventDefault();
                    showError('Veuillez saisir un libellé pour la dépense');
                    return;
                }

                if (!montant || parseFloat(montant) <= 0) {
                    e.preventDefault();
                    showError('Veuillez saisir un montant valide');
                    return;
                }

                // Afficher le spinner
                btnSpinner.style.display = 'inline-block';
                submitBtn.disabled = true;
                submitBtn.classList.add('animate__animated', 'animate__pulse');

                // Formatage du montant
                const formattedMontant = new Intl.NumberFormat('fr-FR').format(montant);

                // Confirmation
                if (!confirm(
                        `Confirmez-vous l'ajout de la dépense "${libelle}" d'un montant de ${formattedMontant} FCFA ?`
                    )) {
                    e.preventDefault();
                    btnSpinner.style.display = 'none';
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('animate__animated', 'animate__pulse');
                }
            });

            // Animation sur les inputs
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        this.classList.remove('animate__animated', 'animate__pulse');
                    }, 500);
                });
            });

            function showError(message) {
                // Créer une alerte temporaire
                const alertDiv = document.createElement('div');
                alertDiv.className = 'warning-alert animate__animated animate__shakeX';
                alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div>
                    <strong style="color: var(--warning-dark);">Erreur</strong>
                    <p class="mb-0" style="color: var(--warning-dark);">${message}</p>
                </div>
            </div>
        `;

                // Insérer avant le formulaire
                form.parentNode.insertBefore(alertDiv, form);

                // Supprimer après 5 secondes
                setTimeout(() => {
                    alertDiv.classList.add('animate__animated', 'animate__fadeOut');
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
@endpush
