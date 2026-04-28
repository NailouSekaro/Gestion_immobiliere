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
            max-width: 1400px;
            margin: 0 auto;
        }

        .travaux-list-container {
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
            align-items: center;
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

        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-success {
            background: transparent;
            border: 2px solid var(--success);
            color: var(--success-dark);
        }

        .btn-outline-success:hover {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
            color: white;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            border-radius: 8px;
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

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .empty-icon i {
            color: var(--primary);
            font-size: 2rem;
        }

        .empty-state h5 {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead {
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.1) 100%);
        }

        .data-table th {
            padding: 1.2rem 1rem;
            font-weight: 600;
            color: var(--primary-dark);
            text-align: left;
            border-bottom: 2px solid var(--primary-light);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table th:first-child {
            border-radius: 10px 0 0 0;
        }

        .data-table th:last-child {
            border-radius: 0 10px 0 0;
        }

        .data-table tbody tr {
            transition: var(--transition);
            animation: fadeInRow 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInRow {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .data-table tbody tr:hover {
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.03) 0%, rgba(67, 97, 238, 0.05) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .data-table td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: var(--dark);
            vertical-align: middle;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .property-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .property-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .property-icon i {
            color: var(--primary);
            font-size: 1rem;
        }

        .property-details h6 {
            margin: 0;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .property-details small {
            color: var(--gray);
            font-size: 0.85rem;
        }

        .type-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.1) 0%, rgba(76, 201, 240, 0.2) 100%);
            color: var(--success-dark);
            border: 1px solid rgba(76, 201, 240, 0.3);
        }

        .date-cell {
            font-weight: 500;
            color: var(--primary-dark);
        }

        .amount-cell {
            font-weight: 700;
            color: var(--danger);
            font-size: 1.1rem;
        }

        .actions-cell {
            text-align: center;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        /* Modal styling */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-hover-shadow);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.1) 100%);
            border-bottom: 2px solid var(--primary-light);
            padding: 1.5rem;
        }

        .modal-title {
            color: var(--primary-dark);
            font-weight: 600;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
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
        }

        .modal-footer {
            border-top: 2px solid #e2e8f0;
            padding: 1.5rem;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #475569 0%, #64748b 100%);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .container-fluid {
                padding: 1rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .card-body {
                padding: 1rem;
                overflow-x: auto;
            }

            .data-table {
                min-width: 800px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        /* Animation delays for rows */
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        .animate-delay-5 { animation-delay: 0.5s; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="travaux-list-container">
        <!-- En-tête -->
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-tools me-2"></i>Gestion des Travaux
                </h1>
                <p class="page-subtitle">Consultez et gérez toutes les interventions de maintenance</p>
            </div>
            <a href="{{ route('travaux.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-2"></i>Nouveau Travail
            </a>
        </div>

        <!-- Carte principale -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list-check me-2"></i>Liste des Interventions
                </h5>
            </div>

            <div class="card-body">
                @if($travaux->isEmpty())
                    <!-- État vide -->
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h5>Aucun travail enregistré</h5>
                        <p class="text-muted">Commencez par créer votre première intervention de maintenance</p>
                        <a href="{{ route('travaux.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Créer un travail
                        </a>
                    </div>
                @else
                    <!-- Tableau -->
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width: 15%">Date</th>
                                    <th style="width: 20%">Propriété</th>
                                    <th style="width: 20%">Type d'intervention</th>
                                    <th style="width: 15%">Prestataire</th>
                                    <th style="width: 15%">Total dépenses</th>
                                    <th style="width: 15%" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($travaux as $index => $travail)
                                <tr class="animate-delay-{{ ($index % 5) + 1 }}">
                                    <td class="date-cell">
                                        <i class="far fa-calendar-alt me-2"></i>
                                        {{ \Carbon\Carbon::parse($travail->date_travail)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <div class="property-info">
                                            <div class="property-icon">
                                                <i class="fas fa-home"></i>
                                            </div>
                                            <div class="property-details">
                                                <h6>{{ $travail->property->nom ?? 'Non spécifié' }}</h6>
                                                <small>{{ $travail->property->adresse ?? '—' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="type-badge">
                                            <i class="fas fa-wrench me-1"></i>
                                            {{ $travail->type_travail }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($travail->prestataire)
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-tie me-2 text-muted"></i>
                                                <span>{{ $travail->prestataire }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="amount-cell">
                                        <i class="fas fa-money-bill-wave me-2"></i>
                                        {{ number_format($travail->total_depense, 0, ',', ' ') }} FCFA
                                    </td>
                                    <td class="actions-cell">
                                        <div class="action-buttons">
                                            <!-- Bouton détails -->
                                            <a href="{{ route('travaux.show', $travail) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Bouton ajouter dépense -->
                                            <button class="btn btn-sm btn-outline-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#depenseModal{{ $travail->id }}"
                                                    title="Ajouter une dépense">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL AJOUT DÉPENSE -->
                                <div class="modal fade" id="depenseModal{{ $travail->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-money-bill-wave me-2"></i>
                                                    Ajouter une dépense
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('travaux.depenses.store', $travail) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-semibold">
                                                            <i class="fas fa-tag me-1"></i>Libellé
                                                        </label>
                                                        <input type="text"
                                                               name="libelle"
                                                               class="form-control"
                                                               placeholder="ex: Achat de matériel, Main d'œuvre..."
                                                               required>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-semibold">
                                                            <i class="fas fa-money-bill me-1"></i>Montant
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="number"
                                                                   name="montant"
                                                                   class="form-control"
                                                                   placeholder="0"
                                                                   required>
                                                            <span class="input-group-text">FCFA</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-semibold">
                                                            <i class="far fa-calendar-alt me-1"></i>Date
                                                        </label>
                                                        <input type="date"
                                                               name="date_depense"
                                                               class="form-control"
                                                               value="{{ date('Y-m-d') }}"
                                                               required>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-2"></i>Annuler
                                                    </button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save me-2"></i>Enregistrer
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIN MODAL -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
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
    // Animation sur les lignes du tableau
    const tableRows = document.querySelectorAll('.data-table tbody tr');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${(index % 5 + 1) * 0.1}s`;
        row.classList.add('animate__animated', 'animate__fadeInLeft');
    });

    // Animation sur les boutons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__pulse');
            }, 500);
        });
    });

    // Gestion des modals
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            const modalContent = this.querySelector('.modal-content');
            modalContent.classList.add('animate__animated', 'animate__fadeInUp');
        });
    });

    // Validation des formulaires dans les modals
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Ajouter un spinner
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Enregistrement...
            `;
            submitBtn.disabled = true;

            // Simuler un traitement (à adapter selon ton backend)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1500);
        });
    });
});
</script>
@endpush
