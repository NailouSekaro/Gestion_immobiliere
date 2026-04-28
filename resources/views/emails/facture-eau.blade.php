<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture d'Eau #{{ $consommationEau->id }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            font-family: 'Poppins', 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.6;
            font-size: 12px;
            background: #f0f9ff;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* En-tête de la facture */
        .invoice-header {
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .invoice-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .invoice-subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .reference-badge {
            display: inline-block;
            background: white;
            color: #0ea5e9;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        /* Corps de la facture */
        .invoice-body {
            padding: 40px;
        }

        /* Informations */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }

        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #0ea5e9;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .info-card h3 {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            font-weight: 500;
            color: #555;
            font-size: 13px;
        }

        .info-value {
            font-weight: 600;
            color: #333;
            font-size: 13px;
        }

        /* Détails de consommation */
        .consumption-details {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 40px;
            border: 2px solid #e2e8f0;
        }

        .consumption-details h3 {
            font-size: 16px;
            color: #0ea5e9;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
        }

        .consumption-details h3 i {
            margin-right: 10px;
        }

        .consumption-items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
        }

        .consumption-item {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .consumption-item:hover {
            transform: translateY(-5px);
        }

        .consumption-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(3, 105, 161, 0.1));
        }

        .consumption-icon i {
            font-size: 20px;
            color: #0ea5e9;
        }

        .consumption-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .consumption-value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .consumption-unit {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
        }

        /* Section total */
        .total-section {
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
            color: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }

        .total-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .total-label {
            font-size: 14px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .total-amount {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .total-subtitle {
            font-size: 12px;
            opacity: 0.8;
            position: relative;
            z-index: 1;
        }

        /* Calcul détaillé */
        .calculation-card {
            background: #fef3c7;
            border: 1px solid #facc15;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 40px;
        }

        .calculation-card h3 {
            color: #92400e;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .calculation-card h3 i {
            margin-right: 10px;
        }

        .calculation-formula {
            font-size: 14px;
            color: #854d0e;
            background: white;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            margin: 0;
            text-align: center;
        }

        /* Informations de paiement */
        .payment-info {
            background: #e8f4fd;
            border: 1px solid #bee1fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 40px;
        }

        .payment-info h3 {
            color: #0c5460;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .payment-info h3 i {
            margin-right: 10px;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .payment-item {
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .payment-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .payment-value {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        /* Pied de page */
        .invoice-footer {
            text-align: center;
            padding: 30px;
            border-top: 2px solid #e2e8f0;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
        }

        .footer-title {
            font-size: 14px;
            font-weight: 600;
            color: #0ea5e9;
            margin-bottom: 15px;
        }

        .footer-text {
            font-size: 11px;
            color: #666;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .signature-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px dashed #ddd;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            border-top: 2px solid #0ea5e9;
            width: 200px;
            margin: 40px auto 10px;
        }

        .signature-label {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }

        .contact-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            font-size: 10px;
            color: #999;
        }

        /* Pour l'impression */
        @media print {
            body {
                padding: 0;
                background: white;
            }

            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }

            .no-print {
                display: none;
            }

            .invoice-header {
                -webkit-print-color-adjust: exact;
            }

            .total-section {
                -webkit-print-color-adjust: exact;
            }

            .consumption-item:hover {
                transform: none;
            }
        }

        /* Utilitaires */
        .text-center { text-align: center; }
        .mb-20 { margin-bottom: 20px; }
        .mb-30 { margin-bottom: 30px; }
        .mt-30 { margin-top: 30px; }
        .d-flex { display: flex; }
        .align-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .w-100 { width: 100%; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- En-tête -->
        <div class="invoice-header">
            <h1 class="invoice-title">FACTURE DE CONSOMMATION D'EAU</h1>
            <div class="invoice-subtitle">Facture officielle de consommation d'eau</div>

            <div class="reference-badge">
                Facture #{{ $consommationEau->id }} |
                {{ \Carbon\Carbon::parse($consommationEau->periode_fin)->format('m/Y') }}
            </div>
        </div>

        <!-- Corps de la facture -->
        <div class="invoice-body">
            <!-- Informations principales -->
            <div class="info-grid">
                <div class="info-card">
                    <h3><i class="fas fa-user"></i> Informations Locataire</h3>
                    <div class="info-row">
                        <span class="info-label">Nom complet:</span>
                        <span class="info-value">{{ $consommationEau->user->prenom }} {{ $consommationEau->user->nom ?? '' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $consommationEau->user->email ?? 'Non renseigné' }}</span>
                    </div>
                    @if($consommationEau->user->telephone ?? false)
                    <div class="info-row">
                        <span class="info-label">Téléphone:</span>
                        <span class="info-value">{{ $consommationEau->user->telephone }}</span>
                    </div>
                    @endif
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-home"></i> Informations Location</h3>
                    <div class="info-row">
                        <span class="info-label">Chambre:</span>
                        <span class="info-value">{{ $consommationEau->property->nom ?? 'Non spécifiée' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Période:</span>
                        <span class="info-value">
                            {{ \Carbon\Carbon::parse($consommationEau->periode_debut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($consommationEau->periode_fin)->format('d/m/Y') }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date d'émission</span>
                        <span class="info-value">{{ now()->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Détails de consommation -->
            <div class="consumption-details">
                <h3><i class="fas fa-tint"></i> DÉTAILS DE LA CONSOMMATION</h3>
                <div class="consumption-items">
                    <div class="consumption-item">
                        <div class="consumption-icon">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                        <div class="consumption-label">Index précédent</div>
                        <div class="consumption-value">{{ $consommationEau->index_precedent }}</div>
                        <div class="consumption-unit">mètres cubes</div>
                    </div>

                    <div class="consumption-item">
                        <div class="consumption-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <div class="consumption-label">Index actuel</div>
                        <div class="consumption-value">{{ $consommationEau->index_compteur }}</div>
                        <div class="consumption-unit">mètres cubes</div>
                    </div>

                    <div class="consumption-item">
                        <div class="consumption-icon">
                            <i class="fas fa-water"></i>
                        </div>
                        <div class="consumption-label">Consommation</div>
                        <div class="consumption-value">{{ $consommationEau->consommation }}</div>
                        <div class="consumption-unit">mètres cubes</div>
                    </div>

                    <div class="consumption-item">
                        <div class="consumption-icon">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="consumption-label">Prix unitaire</div>
                        <div class="consumption-value">550</div>
                        <div class="consumption-unit">FCFA / m³</div>
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="total-section">
                <div class="total-label">Montant total à payer</div>
                <div class="total-amount">{{ number_format($consommationEau->montant, 0, ' ', ' ') }} FCFA</div>
                <div class="total-subtitle">TTC - Toutes taxes comprises</div>
            </div>

            <!-- Calcul détaillé -->
            <div class="calculation-card">
                <h3><i class="fas fa-calculator"></i> CALCUL DÉTAILLÉ</h3>
                <div class="calculation-formula">
                    ({{ $consommationEau->index_compteur }} - {{ $consommationEau->index_precedent }}) × 550 FCFA = {{ number_format($consommationEau->montant, 0, ' ', ' ') }} FCFA
                </div>
            </div>

            <!-- Informations de paiement -->
            @if($consommationEau->paiementEau ?? false)
            <div class="payment-info">
                <h3><i class="fas fa-credit-card"></i> INFORMATIONS DE PAIEMENT</h3>
                <div class="payment-grid">
                    <div class="payment-item">
                        <div class="payment-label">Statut</div>
                        <div class="payment-value" style="color: #10b981;">
                            <i class="fas fa-check-circle me-1"></i>Payé
                        </div>
                    </div>
                    <div class="payment-item">
                        <div class="payment-label">Date paiement</div>
                        <div class="payment-value">
                            {{ \Carbon\Carbon::parse($consommationEau->paiementEau->date_paiement)->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <div class="payment-item">
                        <div class="payment-label">Méthode</div>
                        <div class="payment-value">
                            {{ ucfirst($consommationEau->paiementEau->methode ?? 'Non spécifiée') }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Pied de page -->
        <div class="invoice-footer">
            <div class="footer-title">CONDITIONS DE PAIEMENT</div>
            <div class="footer-text">
                Cette facture est payable dans les 15 jours suivant sa réception.<br>
                Tout retard de paiement entraînera l'application d'intérêts de retard au taux légal.
            </div>

            <!-- Signatures -->
            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Signature du Locataire</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Signature du Gestionnaire</div>
                </div>
            </div>

            <!-- Informations de contact -->
            <div class="contact-info">
                <div class="d-flex justify-between align-center">
                    <div>
                        <strong>{{ config('app.name', 'Gestion Immobilière') }}</strong><br>
                        123 Avenue de la Paix, Douala<br>
                        Tél: +237 6 XX XX XX XX<br>
                        Email: contact@gestion-immobilière.com
                    </div>
                    <div class="text-center">
                        <div style="font-size: 20px; color: #0ea5e9; margin-bottom: 5px;">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div>Facture originale</div>
                    </div>
                    <div class="text-right">
                        Facture émise le: {{ now()->format('d/m/Y à H:i') }}<br>
                        N° de facture: EAU{{ $consommationEau->id }}-{{ now()->format('YmdHis') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton d'impression (caché à l'impression) -->
    <div class="no-print" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <button onclick="window.print()" style="padding: 12px 24px; background: #0ea5e9; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
            <i class="fas fa-print me-2"></i>Imprimer la facture
        </button>
    </div>

    <script>
        // Impression automatique après un court délai
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        };

        // Masquer le bouton pendant l'impression
        window.onbeforeprint = function() {
            document.querySelector('.no-print').style.display = 'none';
        };

        window.onafterprint = function() {
            document.querySelector('.no-print').style.display = 'block';
        };
    </script>
</body>
</html>
