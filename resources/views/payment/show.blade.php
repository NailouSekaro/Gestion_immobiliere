@extends('layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Paiement</title>
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
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInUp 0.5s ease forwards;
        }

        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }

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

        .card-header.bg-light {
            background: #f9fafc !important;
            color: var(--dark);
            border-bottom: 1px solid #e2e8f0;
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
            padding: 0.6rem 1.2rem; /* Réduit légèrement pour harmoniser */
            border-radius: 8px;
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

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .action-btn {
            padding: 0.7rem 1.5rem;
            font-size: 1rem;
            opacity: 1 !important;
            color: white !important;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: var(--transition);
            width: 100%;
            text-align: center;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-warning {
            background: linear-gradient(to right, #facc15, #d97706);
        }

        .btn-danger {
            background: linear-gradient(to right, #f87171, #dc2626);
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .user-details {
            line-height: 1.3;
        }

        .user-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
        }

        .user-email {
            font-size: 0.9rem;
            color: var(--gray);
        }

        .info-item {
            margin-bottom: 1.2rem;
            font-size: 0.95rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            background: #f9fafc;
        }

        .info-item strong {
            color: var(--dark);
            font-weight: 500;
            flex: 0 0 40%;
        }

        .info-item span, .info-item .badge {
            flex: 0 0 60%;
            text-align: right;
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

        @media (max-width: 992px) {
            .col-md-8, .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .card {
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 10px;
            }

            .card-body {
                padding: 1.5rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-title {
                margin-bottom: 1rem;
            }

            .btn-group {
                flex-wrap: wrap;
                gap: 0.5rem;
                width: 100%;
            }

            .btn {
                flex: 1;
                text-align: center;
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }

            .action-btn {
                font-size: 0.9rem;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 0.8rem;
            }

            .info-item strong {
                flex: none;
                margin-bottom: 0.5rem;
            }

            .info-item span, .info-item .badge {
                text-align: left;
                flex: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="page-header">
                            <h4 class="page-title">
                                <i class="fas fa-receipt me-2"></i>Détails du Paiement
                            </h4>
                            <div class="btn-group">
                                <a href="{{ route('payments.receipt', $payment) }}" class="btn btn-light tooltip" target="_blank" data-tooltip="Imprimer le reçu">
                                    <i class="fas fa-print me-1"></i> Imprimer
                                </a>
                                <a href="{{ route('payments.index') }}" class="btn btn-primary tooltip" data-tooltip="Retour à la liste">
                                    <i class="fas fa-arrow-left me-1"></i> Retour
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-info-circle me-2"></i>Informations du Paiement
                                    </div>
                                    <div class="card-body">
                                        <div class="info-item">
                                            <strong>Référence:</strong>
                                            <span>{{ $payment->reference }}</span>
                                        </div>
                                        <div class="info-item">
                                            <strong>Période:</strong>
                                            <span>{{ $payment->periode }}</span>
                                        </div>
                                        <div class="info-item">
                                            <strong>Montant:</strong>
                                            <span class="text-success fw-bold">{{ number_format($payment->montant, 0, ',', ' ') }} XAF</span>
                                        </div>
                                        <div class="info-item">
                                            <strong>Méthode:</strong>
                                            <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $payment->methode)) }}</span>
                                        </div>
                                        <div class="info-item">
                                            <strong>Statut:</strong>
                                            @php
                                                $statutColors = [
                                                    'paye' => 'success',
                                                    'en_attente' => 'warning',
                                                    'echec' => 'danger',
                                                    'annule' => 'secondary',
                                                    'rembourse' => 'info',
                                                    'pending' => 'primary',
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $statutColors[$payment->statut] }}">
                                                {{ ucfirst(str_replace('_', ' ', $payment->statut)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-user me-2"></i>Informations du Locataire
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ $payment->user->photo_profil ? asset('storage/' . $payment->user->photo_profil) : asset('images/default-avatar.jpg') }}"
                                                 class="user-avatar me-3" alt="{{ $payment->user->prenom }}">
                                            <div class="user-details">
                                                <div class="user-name">{{ $payment->user->prenom }} {{ $payment->user->nom }}</div>
                                                <div class="user-email">{{ $payment->user->email }}</div>
                                            </div>
                                        </div>
                                        <div class="info-item">
                                            <strong>Téléphone:</strong>
                                            <span>{{ $payment->user->telephone ?? 'Non renseigné' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <strong>Propriété:</strong>
                                            <span>{{ $payment->property->adresse }}, {{ $payment->property->ville }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Détails de la transaction -->
                        <div class="card">
                            <div class="card-header bg-light">
                                <i class="fas fa-credit-card me-2"></i>Détails de la Transaction
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <strong>Date de paiement:</strong>
                                            <span>{{ $payment->date_paiement ? $payment->date_paiement->format('d/m/Y H:i') : 'Non payé' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <strong>Opérateur:</strong>
                                            <span>{{ $payment->operateur ?? 'Non spécifié' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <strong>N° Transaction:</strong>
                                            <span>{{ $payment->numero_transaction ?? 'Non spécifié' }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if($payment->preuve_paiement)
                                    <div class="mt-3">
                                        <strong>Preuve de paiement:</strong>
                                        <br>
                                        <a href="{{ asset('storage/' . $payment->preuve_paiement) }}"
                                           target="_blank" class="btn btn-primary btn-sm mt-2 tooltip" data-tooltip="Télécharger la preuve">
                                            <i class="fas fa-download me-1"></i> Télécharger
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Notes -->
                        @if($payment->notes)
                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fas fa-sticky-note me-2"></i>Notes
                                </div>
                                <div class="card-body">
                                    {{ $payment->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar avec actions -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <i class="fas fa-bolt me-2"></i>Actions
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('payments.edit', $payment) }}"
                               class="action-btn btn-warning tooltip" data-tooltip="Modifier le paiement">
                                <i class="fas fa-edit me-1"></i> Modifier
                            </a>
                            <a href="{{ route('payments.receipt', $payment) }}"
                               class="action-btn btn-primary tooltip" target="_blank" data-tooltip="Générer le reçu">
                                <i class="fas fa-receipt me-1"></i> Reçu
                            </a>
                            <form action="{{ route('payments.destroy', $payment) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-danger tooltip"
                                        data-tooltip="Supprimer le paiement"
                                        onclick="return confirm('Supprimer définitivement ce paiement ?')">
                                    <i class="fas fa-trash me-1"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Historique -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <i class="fas fa-history me-2"></i>Historique
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <strong>Créé le:</strong>
                            <span>{{ $payment->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <strong>Modifié le:</strong>
                            <span>{{ $payment->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($payment->paye_le)
                            <div class="info-item">
                                <strong>Payé le:</strong>
                                <span>{{ $payment->paye_le->format('d/m/Y H:i') }}</span>
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
