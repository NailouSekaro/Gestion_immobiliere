@extends('layouts.template')

@section('title', 'Détail du Paiement')

@section('content')
    <style>
        :root {
            --brand-primary: #667eea;
            --brand-secondary: #764ba2;
            --brand-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        }

        .payment-detail-page {
            padding: 1.75rem 2rem;
            max-width: 800px;
            margin: 0 auto;
            font-family: 'Poppins', sans-serif;
        }

        .detail-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .card-header {
            background: var(--brand-gradient);
            color: white;
            padding: 1.5rem 2rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            padding: 2rem;
        }

        .info-item {
            background: var(--surface-alt);
            padding: 1rem 1.25rem;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
        }

        .info-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .btn-pay {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 0.9rem 2rem;
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: 1.05rem;
            width: 100%;
            transition: all 0.25s ease;
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
    </style>

    <div class="payment-detail-page">

        <div class="detail-card">

            <!-- En-tête -->
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">Paiement - {{ $payment->periode }}</h1>
                        <p class="opacity-90 mt-1">
                            {{ $payment->property->nom ?? 'Bien immobilier' }}
                        </p>
                    </div>
                    <span class="status-badge {{ $payment->statut === 'paye' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst(str_replace('_', ' ', $payment->statut)) }}
                    </span>
                </div>
            </div>

            <!-- Informations -->
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Montant à payer</div>
                    <div class="info-value text-3xl font-bold text-green-600">
                        {{ number_format($payment->montant, 0, ',', ' ') }} FCFA
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Date limite</div>
                    <div class="info-value">
                        {{ $payment->date_limite ? $payment->date_limite->format('d/m/Y') : '—' }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Statut</div>
                    <div class="info-value">
                        @if($payment->statut === 'paye')
                            <span class="text-success">Payé</span>
                        @else
                            <span class="text-warning">En attente</span>
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Référence</div>
                    <div class="info-value font-mono text-sm">
                        #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="p-8 border-t">
                @if ($payment->statut !== 'paye')
                    <form method="POST" action="{{ route('locataire.payments.fedapay', $payment) }}">
                        @csrf
                        <button type="submit" class="btn-pay">
                            <i class="fas fa-credit-card me-2"></i>
                            Payer maintenant avec FedaPay
                        </button>
                    </form>
                @else
                    <a href="{{ route('paiements.receipt', $payment) }}"
                       class="block text-center bg-green-600 hover:bg-green-700 text-white py-4 rounded-2xl font-semibold text-lg">
                        <i class="fas fa-download me-2"></i>
                        Télécharger le reçu
                    </a>
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('paiements.index') }}" class="text-gray-500 hover:text-gray-700">
                ← Retour à mes paiements
            </a>
        </div>

    </div>
@endsection
