@extends('layouts.template')

@section('title', 'Mes Paiements')

@section('content')
    <style>
        :root {
            --brand-primary: #10b981;
            --brand-secondary: #059669;
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --border: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.04);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.08), 0 4px 8px rgba(0,0,0,0.04);
            --transition: all 0.25s ease;
        }

        .payments-page {
            padding: 1.75rem 2rem;
            max-width: 1400px;
            font-family: 'Poppins', sans-serif;
        }

        .page-title {
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        /* Cartes statistiques */
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.6rem;
        }

        /* Tableau */
        .results-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .payments-table th {
            background: var(--surface-alt);
            padding: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .payments-table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .payments-table tbody tr:hover {
            background: var(--surface-hover);
        }

        .badge-paye {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-en-attente {
            background: #fef3c7;
            color: #92400e;
        }
    </style>

    <div class="payments-page">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Mes Paiements</h1>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <span class="text-muted small">
                <i class="fas fa-clock me-1"></i>
                Dernière mise à jour : {{ now()->format('d/m/Y') }}
            </span>
        </div>

        <!-- Statistiques -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(16,185,129,0.15); color: var(--success);">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <p class="text-sm text-muted mb-1">Total payé</p>
                    <h2 class="text-3xl font-bold text-success mb-0">
                        {{ number_format($totalPaye, 0, ',', ' ') }} <span class="fs-5">FCFA</span>
                    </h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(245,158,11,0.15); color: var(--warning);">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <p class="text-sm text-muted mb-1">Paiements en attente</p>
                    <h2 class="text-3xl font-bold text-warning mb-0">{{ $enAttente }}</h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(239,68,68,0.15); color: var(--danger);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <p class="text-sm text-muted mb-1">Paiements en retard</p>
                    <h2 class="text-3xl font-bold text-danger mb-0">{{ $enRetard }}</h2>
                </div>
            </div>
        </div>

        <!-- Tableau des paiements -->
        <div class="results-card">
            <div class="results-header">
                <h5 class="mb-2"> &nbsp&nbsp Historique des paiements</h5>
            </div>

            <div class="table-responsive">
                <table class="payments-table table mb-0">
                    <thead>
                        <tr>
                            <th>Période</th>
                            <th>Bien</th>
                            <th class="text-end">Montant</th>
                            <th>Statut</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="fw-medium">{{ $payment->periode }}</td>
                                <td>{{ $payment->property->nom ?? '—' }}</td>
                                <td class="text-end fw-medium">
                                    {{ number_format($payment->montant, 0, ',', ' ') }} FCFA
                                </td>
                                <td>
                                    <span class="badge {{ $payment->statut === 'paye' ? 'badge-paye' : 'badge-en-attente' }}">
                                        {{ ucfirst(str_replace('_', ' ', $payment->statut)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('paiements.show', $payment) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>

                                        @if ($payment->statut !== 'paye')
                                            <form method="POST" action="{{ route('locataire.payments.fedapay', $payment) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-credit-card"></i> Payer
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('paiements.receipt', $payment) }}"
                                               class="btn btn-sm btn-success">
                                                <i class="fas fa-download"></i> Reçu
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-receipt fa-3x mb-3 d-block"></i>
                                    Aucun paiement enregistré pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-top">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection
