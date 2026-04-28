@extends('layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --success: #4cc9f0;
            --success-dark: #3a8fb8;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --danger: #dc2626;
            --warning: #facc15;
            --info: #60a5fa;
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
            max-width: 1400px;
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
            background: linear-gradient(120deg, var(--primary), var(--primary-dark)) !important;
            color: white;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            margin: 0;
        }

        .page-title i {
            margin-right: 12px;
            font-size: 1.5rem;
            color: var(--primary);
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

        .action-btn {
            padding: 0.4rem 0.8rem; /* Réduit pour boutons plus compacts */
            font-size: 0.85rem; /* Taille de police réduite */
            line-height: 1;
            opacity: 1 !important;
            color: white !important;
            border-radius: 6px;
            margin: 0 0.1rem;
            transition: var(--transition);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-info {
            background: linear-gradient(to right, #60a5fa, #3b82f6);
        }

        .btn-warning {
            background: linear-gradient(to right, #facc15, #d97706);
        }

        .btn-success {
            background: linear-gradient(to right, #34d399, #059669);
        }

        .btn-danger {
            background: linear-gradient(to right, #f87171, #dc2626);
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
        }

        .stats-card {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .stats-card .card-body {
            padding: 1.5rem;
            text-align: center;
        }

        .stats-card h6 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stats-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
            position: relative;
        }

        .table {
            margin-bottom: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background: #2d3748;
            color: white;
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            position: sticky;
            top: 0;
            z-index: 10;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .table td {
            padding: 0.8rem; /* Réduit pour plus de compacité */
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tr {
            transition: var(--transition);
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInUp 0.5s ease forwards;
        }

        .table tr:nth-child(1) { animation-delay: 0.1s; }
        .table tr:nth-child(2) { animation-delay: 0.2s; }
        .table tr:nth-child(3) { animation-delay: 0.3s; }
        .table tr:nth-child(4) { animation-delay: 0.4s; }
        .table tr:nth-child(5) { animation-delay: 0.5s; }

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

        .table tr:hover {
            background-color: #f0f9ff;
            transform: scale(1.01);
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
        }

        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .form-group {
            margin-bottom: 1.5rem;
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
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
            background-color: white;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px;
            padding-right: 3rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: #f9fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--gray);
            margin-bottom: 1rem;
        }

        .tooltip {
            position: relative;
        }

        .tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #2d3748;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            white-space: nowrap;
            z-index: 1000;
        }

        .scroll-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .scroll-btn {
            padding: 0.5rem;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .scroll-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .scroll-btn:disabled {
            background: var(--gray);
            cursor: not-allowed;
            opacity: 0.6;
        }

        @media (max-width: 992px) {
            .table-responsive {
                overflow-x: auto;
            }

            .table {
                min-width: 800px;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 10px;
            }

            .card-body {
                padding: 1.5rem;
            }

            .filters {
                flex-direction: column;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-title {
                margin-bottom: 1rem;
            }

            .stats-card {
                margin-bottom: 1rem;
            }

            .btn-group {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .action-btn {
                flex: 1;
                text-align: center;
                padding: 0.3rem 0.6rem;
                font-size: 0.8rem;
            }

            .scroll-btn {
                width: 35px;
                height: 35px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="page-header">
                            <h4 class="page-title">
                                <i class="fas fa-money-bill-wave me-2"></i>Gestion des Paiements
                            </h4>
                            <div class="btn-group">
                                <a href="{{ route('payments.create') }}" class="btn btn-light tooltip" data-tooltip="Créer un nouveau paiement">
                                    <i class="fas fa-plus me-1"></i> Nouveau
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div style="background: #28a745; color: #fff; padding: 12px; border-radius: 8px; margin: 10px 0; font-weight: bold;">
                                ✅ {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div style="background: #dc3545; color: #fff; padding: 12px; border-radius: 8px; margin: 10px 0; font-weight: bold;">
                                ❌ {{ session('error') }}
                            </div>
                        @endif

                        <!-- Statistiques rapides -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card stats-card bg-primary text-white">
                                    <div class="card-body">
                                        <h6><i class="fas fa-money-bill me-2"></i>Total Payé</h6>
                                        <h3 data-total-paye>{{ number_format($totalPaye, 0, ',', ' ') }} XAF</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card stats-card bg-warning text-dark">
                                    <div class="card-body">
                                        <h6><i class="fas fa-clock me-2"></i>En Attente</h6>
                                        <h3 data-en-attente>{{ $enAttente }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card stats-card bg-info text-white">
                                    <div class="card-body">
                                        <h6><i class="fas fa-calendar me-2"></i>Ce Mois</h6>
                                        <h3 data-mois-cours>{{ number_format($moisEnCours, 0, ',', ' ') }} XAF</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="filters">
                            <div class="form-group">
                                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par locataire ou propriété...">
                            </div>
                            <div class="form-group">
                                <select id="statusFilter" class="form-control">
                                    <option value="">Tous les statuts</option>
                                    <option value="paye">Payé</option>
                                    <option value="en_attente">En attente</option>
                                    <option value="echec">Échec</option>
                                    <option value="annule">Annulé</option>
                                    <option value="rembourse">Remboursé</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select id="methodFilter" class="form-control">
                                    <option value="">Toutes les méthodes</option>
                                    <option value="mtn_momo">MTN MoMo</option>
                                    <option value="orange_money">Orange Money</option>
                                    <option value="wave">Wave</option>
                                    <option value="feda_pay">FedaPay</option>
                                    <option value="virement">Virement</option>
                                    <option value="especes">Espèces</option>
                                    <option value="autre">Autre</option>
                                </select>
                            </div>
                        </div>

                        <div class="scroll-buttons">
                            <button class="scroll-btn" id="scrollLeft" title="Défiler vers la gauche">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="scroll-btn" id="scrollRight" title="Défiler vers la droite">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th><i class="fas fa-hashtag me-1"></i> Référence</th>
                                        <th><i class="fas fa-user me-1"></i> Locataire</th>
                                        <th><i class="fas fa-home me-1"></i> Propriété</th>
                                        <th><i class="fas fa-money-bill me-1"></i> Montant</th>
                                        <th><i class="fas fa-calendar me-1"></i> Période</th>
                                        <th><i class="fas fa-credit-card me-1"></i> Méthode</th>
                                        <th><i class="fas fa-circle me-1"></i> Statut</th>
                                        <th><i class="fas fa-calendar-day me-1"></i> Date</th>
                                        <th><i class="fas fa-cogs me-1"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="paymentTable">
                                    @forelse($payments as $payment)
                                        <tr data-status="{{ $payment->statut }}" data-method="{{ $payment->methode }}">
                                            <td>
                                                <small class="text-muted">{{ $payment->reference }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $payment->user->photo_profil ? asset('storage/' . $payment->user->photo_profil) : asset('images/default-avatar.jpg') }}"
                                                         class="rounded-circle me-2" width="30" height="30"
                                                         alt="{{ $payment->user->prenom }}">
                                                    <div>
                                                        {{ $payment->user->prenom }} {{ $payment->user->nom }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $payment->property->nom ?: 'Propriété #' . $payment->property->id }}
                                                <br>
                                                <small class="text-muted">{{ $payment->property->ville }}</small>
                                            </td>
                                            <td>
                                                <strong class="text-success">{{ number_format($payment->montant, 0, ',', ' ') }} XAF</strong>
                                            </td>
                                            <td>
                                                {{ $payment->periode }}
                                                @if($payment->estEnRetard())
                                                    <br>
                                                    <span class="badge bg-danger">Retard: {{ $payment->jours_retard }}j</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $methodes = [
                                                        'mtn_momo' => ['MTN MoMo', 'primary'],
                                                        'orange_money' => ['Orange Money', 'warning'],
                                                        'wave' => ['Wave', 'info'],
                                                        'feda_pay' => ['FedaPay', 'success'],
                                                        'virement' => ['Virement', 'secondary'],
                                                        'especes' => ['Espèces', 'dark'],
                                                        'autre' => ['Autre', 'light'],
                                                        'pending' => ['En attente', 'warning']
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $methodes[$payment->methode][1] }}">
                                                    {{ $methodes[$payment->methode][0] }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $statutColors = [
                                                        'paye' => 'success',
                                                        'en_attente' => 'warning',
                                                        'echec' => 'danger',
                                                        'annule' => 'secondary',
                                                        'rembourse' => 'info',
                                                        'pending' => 'warning'
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statutColors[$payment->statut] }}">
                                                    {{ ucfirst(str_replace('_', ' ', $payment->statut)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $payment->date_paiement ? $payment->date_paiement->format('d/m/Y') : '-' }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('payments.show', $payment) }}"
                                                       class="action-btn btn-info tooltip" data-tooltip="Voir les détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('payments.edit', $payment) }}"
                                                       class="action-btn btn-warning tooltip" data-tooltip="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('payments.receipt', $payment) }}"
                                                       class="action-btn btn-primary tooltip" data-tooltip="Voir le reçu" target="_blank">
                                                        <i class="fas fa-receipt"></i>
                                                    </a>
                                                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-btn btn-danger tooltip"
                                                                data-tooltip="Supprimer"
                                                                onclick="return confirm('Supprimer ce paiement ?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="empty-state">
                                                <i class="fas fa-money-bill-wave fa-3x mb-3"></i>
                                                <p>Aucun paiement enregistré</p>
                                                <a href="{{ route('payments.create') }}" class="btn btn-success">
                                                    <i class="fas fa-plus me-1"></i> Enregistrer un paiement
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($payments->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $payments->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

@push('scripts')
<script>
    // Actualiser les statistiques toutes les minutes
    function updateStats() {
        fetch('{{ route('payments.statistiques') }}')
            .then(response => response.json())
            .then(data => {
                document.querySelector('[data-total-paye]').textContent =
                    new Intl.NumberFormat().format(data.total_paye) + ' XAF';
                document.querySelector('[data-en-attente]').textContent = data.en_attente;
                document.querySelector('[data-mois-cours]').textContent =
                    new Intl.NumberFormat().format(data.mois_cours) + ' XAF';
            });
    }

    setInterval(updateStats, 60000);

    // Filtrage dynamique
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const methodFilter = document.getElementById('methodFilter');
        const rows = document.querySelectorAll('#paymentTable tr:not(.empty-state)');
        const tableContainer = document.querySelector('.table-responsive');
        const scrollLeftBtn = document.getElementById('scrollLeft');
        const scrollRightBtn = document.getElementById('scrollRight');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            const methodValue = methodFilter.value;

            rows.forEach(row => {
                const locataire = row.querySelector('td:nth-child(2) div div').textContent.toLowerCase();
                const propriete = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const status = row.getAttribute('data-status');
                const method = row.getAttribute('data-method');

                const matchesSearch = locataire.includes(searchText) || propriete.includes(searchText);
                const matchesStatus = !statusValue || status === statusValue;
                const matchesMethod = !methodValue || method === methodValue;

                row.style.display = matchesSearch && matchesStatus && matchesMethod ? '' : 'none';
            });
        }

        // Gestion du défilement
        function updateScrollButtons() {
            const maxScroll = tableContainer.scrollWidth - tableContainer.clientWidth;
            scrollLeftBtn.disabled = tableContainer.scrollLeft === 0;
            scrollRightBtn.disabled = tableContainer.scrollLeft >= maxScroll - 1;
        }

        scrollLeftBtn.addEventListener('click', () => {
            tableContainer.scrollBy({ left: -200, behavior: 'smooth' });
            updateScrollButtons();
        });

        scrollRightBtn.addEventListener('click', () => {
            tableContainer.scrollBy({ left: 200, behavior: 'smooth' });
            updateScrollButtons();
        });

        tableContainer.addEventListener('scroll', updateScrollButtons);
        window.addEventListener('resize', updateScrollButtons);
        updateScrollButtons(); // Initialisation

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
        methodFilter.addEventListener('change', filterTable);
    });
</script>
@endpush
@endsection
