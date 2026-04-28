<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation de Paiement #{{ $payment->reference }}</title>
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
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #333;
            line-height: 1.4;
            font-size: 12px;
            background: #f5f7fa;
            min-height: 100vh;
            padding: 15px;
        }

        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        /* En-tête */
        .header {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .company-name {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .receipt-title {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 500;
        }

        .reference-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 10px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Corps du reçu */
        .content {
            padding: 20px;
        }

        .greeting {
            font-size: 13px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .greeting strong {
            color: #28a745;
        }

        /* Carte de réception */
        .receipt-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #dee2e6;
        }

        .receipt-icon {
            text-align: center;
            font-size: 28px;
            color: #28a745;
            margin-bottom: 15px;
        }

        /* Informations en grille */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-column {
            background: white;
            border-radius: 6px;
            padding: 12px;
            border: 1px solid #e9ecef;
        }

        .column-title {
            font-size: 11px;
            color: #28a745;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e9ecef;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .info-label {
            color: #666;
            font-weight: 500;
        }

        .info-value {
            color: #333;
            font-weight: 600;
            text-align: right;
        }

        /* Montant total */
        .amount-section {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
        }

        .amount-label {
            font-size: 11px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .amount-value {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .amount-subtitle {
            font-size: 10px;
            opacity: 0.8;
        }

        /* Informations propriété */
        .property-info {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }

        .property-title {
            font-size: 12px;
            color: #856404;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .property-title::before {
            content: '🏠';
            margin-right: 8px;
        }

        .property-address {
            font-size: 12px;
            color: #333;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .property-ville {
            font-size: 11px;
            color: #666;
        }

        /* Pied de page */
        .footer {
            text-align: center;
            padding: 20px 0 0;
            margin-top: 20px;
            border-top: 1px dashed #dee2e6;
            font-size: 10px;
            color: #666;
        }

        .footer-text {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .signature-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px dashed #ddd;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 120px;
            margin: 30px auto 5px;
        }

        .signature-label {
            font-size: 9px;
            color: #666;
            margin-top: 5px;
        }

        .contact-info {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
            font-size: 9px;
        }

        .status-badge {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Utilitaires */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .mb-10 { margin-bottom: 10px; }
        .mb-15 { margin-bottom: 15px; }

        /* Pour l'impression */
        @media print {
            body {
                padding: 5px;
                background: white;
            }

            .receipt-container {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- En-tête -->
        <div class="header">
            <div class="company-name">{{ config('app.name') }}</div>
            <div class="receipt-title">CONFIRMATION DE PAIEMENT</div>
            <div class="reference-badge">Référence : {{ $payment->reference }}</div>
        </div>

        <!-- Corps du reçu -->
        <div class="content">
            <!-- Salutation -->
            <div class="greeting">
                Bonjour <strong>{{ $user->prenom }} {{ $user->nom }}</strong>,<br>
                Voici la confirmation de votre paiement de loyer.
            </div>

            <!-- Carte de réception -->
            <div class="receipt-card">
                <div class="receipt-icon">🧾</div>

                <!-- Grille d'informations -->
                <div class="info-grid">
                    <div class="info-column">
                        <div class="column-title">Informations Paiement</div>
                        <div class="info-row">
                            <span class="info-label">Référence</span>
                            <span class="info-value">{{ $payment->reference }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Période</span>
                            <span class="info-value">{{ $payment->periode }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Statut</span>
                            <span class="info-value">
                                <span class="status-badge">Payé</span>
                            </span>
                        </div>
                    </div>

                    <div class="info-column">
                        <div class="column-title">Détails Transaction</div>
                        <div class="info-row">
                            <span class="info-label">Date</span>
                            <span class="info-value">{{ $payment->date_paiement->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Heure</span>
                            <span class="info-value">{{ $payment->date_paiement->format('H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Méthode</span>
                            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $payment->methode)) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Montant -->
                <div class="property-success">
                    <div class="amount-label">Montant payé</div>
                    <div class="amount-value">{{ number_format($payment->montant, 0, ',', ' ') }} F</div>
                    <div class="amount-subtitle">Transaction effectuée avec succès</div>
                </div>

                <!-- Informations propriété -->
                <div class="property-info">
                    <div class="property-title">Propriété concernée</div>
                    <div class="property-address">{{ $property->adresse }}</div>
                    <div class="property-ville">{{ $property->ville }}</div>
                </div>
            </div>
        </div>

        <!-- Pied de page -->
        {{-- <div class="footer">
            <div class="footer-text">
                Ce document constitue une confirmation officielle de paiement.<br>
                Conservez-le pour vos archives et en cas de réclamation.
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

            <div class="contact-info">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong>{{ config('app.name') }}</strong><br>
                        Service Client : {{ config('app.contact_email', 'contact@exemple.com') }}
                    </div>
                    <div>
                        Reçu généré le: {{ now()->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Bouton d'impression (visible uniquement à l'écran) -->
    {{-- <div class="no-print" style="position: fixed; top: 15px; right: 15px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 11px; font-weight: 600;">
            🖨️ Imprimer
        </button>
    </div> --}}

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
