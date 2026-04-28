<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reçu de Caution #{{ $caution->reference }}</title>
    <style>
        @page {
            margin: 0.5cm;
            size: A4 portrait;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.4;
            font-size: 12px;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4361ee;
        }

        .logo {
            font-size: 24px;
            color: #4361ee;
            margin-bottom: 5px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 11px;
            color: #666;
        }

        /* Informations principales */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
        }

        .card-title {
            font-size: 11px;
            color: #4361ee;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .info-label {
            font-weight: 500;
            color: #666;
        }

        .info-value {
            font-weight: 600;
            color: #333;
            text-align: right;
        }

        /* Détails des cautions */
        .caution-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }

        .caution-table th {
            background: #4361ee;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .caution-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #dee2e6;
            font-size: 11px;
        }

        .caution-table tr:last-child td {
            border-bottom: none;
        }

        .caution-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .amount {
            text-align: right;
            font-weight: 600;
        }

        .status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .status-not-paid {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Section total */
        .total-section {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
        }

        .total-label {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .total-amount {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .total-subtitle {
            font-size: 10px;
            opacity: 0.8;
        }

        /* Méthode de paiement */
        .method-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fef3c7;
            border: 1px solid #facc15;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .method-label {
            font-size: 11px;
            color: #92400e;
            font-weight: 600;
            text-transform: uppercase;
        }

        .method-value {
            font-size: 13px;
            font-weight: 700;
            color: #333;
        }

        /* Pied de page */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed #ddd;
        }

        .footer-text {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .signature-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-top: 30px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 150px;
            margin: 40px auto 5px;
        }

        .signature-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        /* Référence */
        .reference-badge {
            display: inline-block;
            background: white;
            color: #4361ee;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 10px;
            margin-top: 10px;
            border: 1px solid #4361ee;
        }

        /* Utilitaires */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .mb-10 { margin-bottom: 10px; }
        .mb-15 { margin-bottom: 15px; }

        /* Pour l'impression */
        @media print {
            body {
                padding: 10px;
                font-size: 11px;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <div class="header">
        <div class="logo">🏠</div>
        <h1 class="title">Reçu de Paiement de Caution</h1>
        <div class="subtitle">Reçu officiel de caution locative</div>
        <div class="reference-badge">Référence : {{ $caution->reference }}</div>
    </div>

    <!-- Informations principales -->
    <div class="info-grid">
        <div class="info-card">
            <div class="card-title">Informations Locataire</div>
            <div class="info-row">
                <span class="info-label">Nom complet</span>
                <span class="info-value">{{ $caution->user->prenom }} {{ $caution->user->nom }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $caution->user->email }}</span>
            </div>
            @if($caution->user->telephone)
            <div class="info-row">
                <span class="info-label">Téléphone</span>
                <span class="info-value">{{ $caution->user->telephone }}</span>
            </div>
            @endif
        </div>

        <div class="info-card">
            <div class="card-title">Informations Location</div>
            <div class="info-row">
                <span class="info-label">Adresse</span>
                <span class="info-value">{{ $caution->property->adresse }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Date</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($caution->date_paiement)->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Heure</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($caution->date_paiement)->format('H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Détails des cautions -->
    <table class="caution-table">
        <thead>
            <tr>
                <th>Type de caution</th>
                <th class="text-right">Montant</th>
                <th class="text-center">Statut</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Caution chambre</td>
                <td class="amount">60,000 FCFA</td>
                <td class="text-center">
                    <span class="status status-paid">Payée</span>
                </td>
            </tr>
            <tr>
                <td>Caution eau</td>
                <td class="amount">
                    {{ $caution->caution_eau ? number_format($caution->caution_eau, 0, ',', ' ') . ' FCFA' : '0 FCFA' }}
                </td>
                <td class="text-center">
                    <span class="status {{ $caution->caution_eau ? 'status-paid' : 'status-not-paid' }}">
                        {{ $caution->caution_eau ? 'Payée' : 'Non payée' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td>Caution électricité</td>
                <td class="amount">
                    {{ $caution->caution_electricite ? number_format($caution->caution_electricite, 0, ',', ' ') . ' FCFA' : '0 FCFA' }}
                </td>
                <td class="text-center">
                    <span class="status {{ $caution->caution_electricite ? 'status-paid' : 'status-not-paid' }}">
                        {{ $caution->caution_electricite ? 'Payée' : 'Non payée' }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Total -->
    <div class="total-section">
        <div class="total-label">Total de la Caution</div>
        <div class="total-amount">{{ number_format($caution->total_caution, 0, ',', ' ') }} FCFA</div>
        <div class="total-subtitle">Montant total encaissé</div>
    </div>

    <!-- Méthode de paiement -->
    <div class="method-section">
        <div>
            <div class="method-label">Méthode de paiement</div>
            <div class="method-value">
                @php
                    $methodNames = [
                        'especes' => 'Espèces',
                        'mtn_momo' => 'MTN Mobile Money',
                        'orange_money' => 'Orange Money',
                        'wave' => 'Wave'
                    ];
                @endphp
                {{ $methodNames[$caution->methode] ?? ucfirst($caution->methode) }}
            </div>
        </div>
        <div class="text-right">
            <div class="method-label">Date du paiement</div>
            <div class="method-value">{{ \Carbon\Carbon::parse($caution->date_paiement)->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <div class="footer-text">
            Ce reçu est généré électroniquement et a une valeur légale.<br>
            La caution sera restituée à la fin du contrat sous réserve de l'état des lieux de sortie.
        </div>

        <div class="signature-grid">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">Signature du Locataire</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">Signature du Gestionnaire</div>
            </div>
        </div>

        <div style="margin-top: 20px; font-size: 9px; color: #999;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong>Gestion Immobilière</strong><br>
                    Tél: +229 0161581258
                </div>
                <div>
                    Reçu généré le: {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton d'impression (visible uniquement à l'écran) -->
    <div class="no-print" style="position: fixed; top: 20px; right: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4361ee; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 12px;">
            📄 Imprimer
        </button>
    </div>

    <script>
        // Impression automatique après un court délai
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
