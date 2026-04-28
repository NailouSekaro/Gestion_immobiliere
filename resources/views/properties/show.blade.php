@extends('layouts.template')

@section('content')
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Détails de la Propriété</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary: #4361ee;
                --secondary: #3f37c9;
                --success: #4cc9f0;
                --info: #4895ef;
                --warning: #f72585;
                --light: #04080c;
                --dark: #212529;
                --gray: #050709;
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
                background-color: #f5f7fb;
                color: #333;
                line-height: 1.6;
                padding: 0;
                margin: 0;
            }

            .container-fluid {
                padding: 2rem;
                max-width: 1600px;
                margin: 0 auto;
            }

            @media (max-width: 768px) {
                .container-fluid {
                    padding: 1rem;
                }
            }

            .card {
                border: none;
                border-radius: 12px;
                box-shadow: var(--card-shadow);
                transition: var(--transition);
                overflow: hidden;
                margin-bottom: 1.5rem;
                background: rgb(249, 245, 245);
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            }

            .card-header {
                border-bottom: 1px solid rgba(0, 0, 0, 0.08);
                padding: 1.25rem 1.5rem;
                font-weight: 600;
            }

            .card-header.bg-info {
                background: linear-gradient(120deg, var(--info), var(--primary)) !important;
            }

            .card-body {
                padding: 1.5rem;
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
            .property-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.5rem 0;
            }

            .property-title {
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--dark);
                display: flex;
                align-items: center;
            }

            .property-title i {
                color: var(--info);
                margin-right: 12px;
                font-size: 1.5rem;
            }

            .btn-group {
                display: flex;
                gap: 12px;
            }

            .btn {
                padding: 0.6rem 1.2rem;
                border-radius: 8px;
                font-weight: 500;
                transition: var(--transition);
                display: flex;
                align-items: center;
                justify-content: center;
                border: none;
                cursor: pointer;
                text-decoration: none;
            }

            .btn i {
                margin-right: 8px;
            }

            .btn-warning {
                background: linear-gradient(to right, #ff9a3c, #ff6b6b);
                color: white;
            }

            .btn-warning:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
            }

            .btn-light {
                background: white;
                color: var(--gray);
                border: 1px solid #dee2e6;
            }

            .btn-light:hover {
                background: #f8f9fa;
                border-color: #ced4da;
            }

            .btn-success {
                background: linear-gradient(to right, #4facfe, #00f2fe);
                color: white;
            }

            .btn-success:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(79, 172, 254, 0.4);
            }

            .btn-outline-danger {
                background: transparent;
                color: #ff6b6b;
                border: 1px solid #ff6b6b;
            }

            .btn-outline-danger:hover {
                background: #ff6b6b;
                color: white;
            }

            /* Informations de base */
            .info-item {
                display: flex;
                align-items: flex-start;
                margin-bottom: 1rem;
                padding: 0.75rem;
                border-radius: 8px;
                transition: var(--transition);
            }

            .info-item:hover {
                background: rgba(67, 97, 238, 0.05);
            }

            .info-item i {
                font-size: 1.1rem;
                color: var(--info);
                min-width: 30px;
                padding-top: 3px;
            }

            .info-item strong {
                margin-right: 5px;
                color: var(--dark);
            }

            /* Badge moderne */
            .badge {
                padding: 0.35rem 0.75rem;
                border-radius: 50px;
                font-weight: 500;
                font-size: 0.85rem;
            }

            .bg-success {
                background: linear-gradient(to right, #42e695, #3bb2b8) !important;
            }

            .bg-primary {
                background: linear-gradient(to right, #4361ee, #3a0ca3) !important;
            }

            .bg-warning {
                background: linear-gradient(to right, #ff9a3c, #ff6b6b) !important;
            }

            /* Carte locataire */
            .tenant-card {
                text-align: center;
                transition: var(--transition);
            }

            .tenant-card:hover {
                transform: translateY(-3px);
            }

            .tenant-img {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                object-fit: cover;
                border: 4px solid #fff;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                margin: 0 auto 1rem;
                transition: var(--transition);
            }

            .tenant-card:hover .tenant-img {
                transform: scale(1.05);
            }

            /* Caractéristiques */
            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 12px;
            }

            .feature-item {
                display: flex;
                align-items: center;
                padding: 0.5rem;
                border-radius: 8px;
                transition: var(--transition);
            }

            .feature-item:hover {
                background: rgba(76, 201, 240, 0.1);
                transform: translateX(5px);
            }

            .feature-item i {
                color: #42e695;
                margin-right: 10px;
                font-size: 1rem;
            }

            /* Actions rapides */
            .quick-actions {
                display: grid;
                gap: 12px;
            }

            .action-btn {
                display: flex;
                align-items: center;
                padding: 0.75rem 1rem;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                color: var(--gray);
                text-decoration: none;
                transition: var(--transition);
            }

            .action-btn:hover {
                border-color: var(--info);
                color: var(--info);
                transform: translateX(5px);
            }

            .action-btn i {
                margin-right: 10px;
                font-size: 1.1rem;
            }

            /* Responsive */
            @media (max-width: 992px) {

                .col-md-8,
                .col-md-4 {
                    flex: 0 0 100%;
                    max-width: 100%;
                }

                .btn-group {
                    flex-direction: column;
                    width: 100%;
                }

                .btn {
                    width: 100%;
                    margin-bottom: 10px;
                }

                .property-header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .property-title {
                    margin-bottom: 1rem;
                }
            }

            /* Animations */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fadeIn {
                animation: fadeIn 0.5s ease forwards;
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

            /* Notes */
            .notes-container {
                background: linear-gradient(to right, #fdfcfb, #f5f7fb);
                border-left: 4px solid var(--info);
                padding: 1.25rem;
                border-radius: 0 8px 8px 0;
            }

            /* Formulaire */
            .form-group {
                margin-bottom: 1.25rem;
            }

            .form-label {
                font-weight: 500;
                margin-bottom: 0.5rem;
                color: var(--dark);
                display: block;
            }

            .form-control {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid #ced4da;
                border-radius: 8px;
                transition: var(--transition);
            }

            .form-control:focus {
                border-color: var(--info);
                box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
                outline: none;
            }

            /* Statut */
            .status-badge {
                padding: 0.35rem 1rem;
                border-radius: 50px;
                font-size: 0.85rem;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
            }

            .status-badge i {
                margin-right: 0.5rem;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card animate-fadeIn">
                        <div class="card-header bg-info text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="fas fa-home me-2"></i>
                                    {{ $property->nom ?: 'Propriété #' . $property->id }}
                                </h4>
                                <div class="btn-group"><br><br>
                                    <a href="{{ route('properties.edit', $property) }}" class="btn btn-warning">
                                        <i class="fas fa-edit me-1"></i> Modifier
                                    </a>
                                    <a href="{{ route('properties.index') }}" class="btn btn-light">
                                        <i class="fas fa-arrow-left me-1"></i> Retour
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4 delay-1">
                                        <div class="card-header bg-light">
                                            <i class="fas fa-info-circle me-2"></i>Informations de base
                                        </div>
                                        <div class="card-body">
                                            <div class="info-item">
                                                <i class="fas fa-building me-2"></i>
                                                <p><strong>Type:</strong> {{ ucfirst($property->type) }}</p>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                <p><strong>Adresse:</strong> {{ $property->adresse }}</p>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-city me-2"></i>
                                                <p><strong>Ville:</strong> {{ $property->ville }}, {{ $property->pays }}</p>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-door-open me-2"></i>
                                                <p><strong>Pièces:</strong> {{ $property->nombre_pieces }} pièces</p>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-vector-square me-2"></i>
                                                <p><strong>Surface:</strong> {{ $property->surface }} m²</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4 delay-2">
                                        <div class="card-header bg-light">
                                            <i class="fas fa-money-bill-wave me-2"></i>Informations financières
                                        </div>
                                        <div class="card-body">
                                            <div class="info-item">
                                                <i class="fas fa-money-bill me-2"></i>
                                                <p><strong>Loyer mensuel:</strong>
                                                    <span
                                                        class="text-success">{{ number_format($property->loyer_mensuel, 0, ',', ' ') }}
                                                        XAF</span>
                                                </p>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                <p><strong>Loyer annuel:</strong>
                                                    <span
                                                        class="text-success">{{ number_format($property->loyer_annuel, 0, ',', ' ') }}
                                                        XAF</span>
                                                </p>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-shield-alt me-2"></i>
                                                <p><strong>Caution:</strong>
                                                    {{ number_format($property->caution, 0, ',', ' ') }} XAF</p>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-calendar me-2"></i>
                                                <p><strong>Disponible depuis:</strong>
                                                    {{ $property->date_disponibilite->format('d/m/Y') }}</p>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-circle me-2"></i>
                                                <p><strong>Statut:</strong>
                                                    <span
                                                        class="status-badge bg-{{ $property->statut === 'libre' ? 'success' : ($property->statut === 'occupé' ? 'primary' : 'warning') }}">
                                                        {{ ucfirst($property->statut) }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Caractéristiques -->
                            @if ($property->caracteristiques)
                                <div class="card mb-4 delay-3">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-list me-2"></i>Caractéristiques
                                    </div>
                                    <div class="card-body">
                                        <div class="features-grid">
                                            @php
                                                $caracteristiquesLabels = [
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
                                            @foreach ($property->caracteristiques as $key => $value)
                                                @if ($value)
                                                    <div class="feature-item">
                                                        <i class="fas fa-check text-success me-2"></i>
                                                        {{ $caracteristiquesLabels[$key] ?? $key }}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Notes -->
                            @if ($property->notes)
                                <div class="card mb-4 delay-4">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-sticky-note me-2"></i>Notes
                                    </div>
                                    <div class="card-body">
                                        <div class="notes-container">
                                            {{ $property->notes }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar avec actions -->
                <div class="col-md-4">
                    <!-- Carte Locataire -->
                    @if ($property->locataireActuel)
                        <div class="card mb-4 animate-fadeIn">
                            <div class="card-header bg-success text-white">
                                <i class="fas fa-user me-2"></i>Locataire Actuel
                            </div>
                            <div class="card-body text-center tenant-card">
                                <img src="{{ $property->locataireActuel->photo_profil ? asset('storage/' . $property->locataireActuel->photo_profil) : asset('images/default-avatar.jpg') }}"
                                    class="tenant-img" alt="{{ $property->locataireActuel->prenom }}">
                                <h5>{{ $property->locataireActuel->prenom }} {{ $property->locataireActuel->nom }}</h5>
                                <p class="text-muted">{{ $property->locataireActuel->email }}</p>
                                <p class="text-muted">{{ $property->locataireActuel->telephone }}</p>

                                <form action="{{ route('properties.liberer', $property) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Libérer cette propriété?')">
                                        <i class="fas fa-door-open me-1"></i> Libérer la propriété
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="card mb-4 animate-fadeIn">
                            <div class="card-header bg-warning text-dark">
                                <i class="fas fa-user-plus me-2"></i>Assigner un Locataire
                            </div>
                            <div class="card-body">
                                <form action="{{ route('properties.assign-locataire', $property) }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="form-label">Sélectionner un locataire</label>
                                        <select class="form-control" name="user_id" required>
                                            <option value="">Choisir un locataire</option>
                                            @foreach ($locatairesSansPropriete as $locataire)
                                                <option value="{{ $locataire->id }}">
                                                    {{ $locataire->prenom }} {{ $locataire->nom }} -
                                                    {{ $locataire->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-link me-1"></i> Assigner
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Actions rapides -->
                    <div class="card animate-fadeIn">
                        <div class="card-header bg-light">
                            <i class="fas fa-bolt me-2"></i>Actions Rapides
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                <a href="#" class="action-btn">
                                    <i class="fas fa-file-invoice"></i> Générer un contrat
                                </a>
                                <a href="#" class="action-btn">
                                    <i class="fas fa-history"></i> Historique des locataires
                                </a>
                                <a href="#" class="action-btn">
                                    <i class="fas fa-chart-line"></i> Statistiques de paiement
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // document.addEventListener('DOMContentLoaded', function() {
            //     // Animation des éléments au défilement
            //     const animatedItems = document.querySelectorAll(
            //         '.animate-fadeIn, .delay-1, .delay-2, .delay-3, .delay-4');

            //     animatedItems.forEach(item => {
            //         item.style.opacity = '0';
            //     });

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

                animatedItems.forEach(item => {
                    observer.observe(item);
                });

                // Effet de survol amélioré pour les cartes
                const cards = document.querySelectorAll('.card');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-5px)';
                        this.style.boxShadow = '0 12px 30px rgba(0, 0, 0, 0.15)';
                    });

                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.08)';
                    });
                });
            // });
        </script>
    </body>

    </html>
@endsection

@push('scripts')
    <script>
        // Script pour gérer les actions rapides
        document.addEventListener('DOMContentLoaded', function() {
            // Ici tu peux ajouter des fonctionnalités JavaScript
        });
    </script>
@endpush
