<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation de Paiement - {{ config('app.name') }}</title>
    <style>
        /* Styles de base */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f8f9fa;
            padding: 20px;
        }

        /* En-tête */
        .header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 35px 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .company-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .email-title {
            font-size: 18px;
            font-weight: 500;
            opacity: 0.95;
            margin: 0;
        }

        /* Corps de l'email */
        .content {
            background: white;
            padding: 35px 30px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Salutation */
        .greeting {
            font-size: 16px;
            color: #333333;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .greeting strong {
            color: #28a745;
        }

        /* Carte de réception */
        .receipt-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
            border: 1px solid #dee2e6;
        }

        .receipt-title {
            font-size: 16px;
            color: #28a745;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Grille d'informations */
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info-column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 15px;
        }

        /* Sur mobile */
        @media screen and (max-width: 480px) {
            .info-column {
                display: block;
                width: 100%;
                padding: 0;
                margin-bottom: 20px;
            }
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-size: 13px;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .info-value {
            font-size: 14px;
            color: #333333;
            font-weight: 600;
            display: block;
        }

        /* Montant */
        .amount-container {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
            color: white;
        }

        .amount-label {
            font-size: 13px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .amount-value {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .amount-subtitle {
            font-size: 12px;
            opacity: 0.8;
        }

        /* Propriété */
        .property-card {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 18px;
            margin: 20px 0;
        }

        .property-title {
            font-size: 14px;
            color: #856404;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .property-details {
            font-size: 13px;
            color: #333333;
        }

        /* Détails transaction */
        .transaction-details {
            background: #e8f4fd;
            border: 1px solid #bee1fa;
            border-radius: 8px;
            padding: 18px;
            margin: 20px 0;
        }

        .transaction-title {
            font-size: 14px;
            color: #0c5460;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .transaction-row {
            margin-bottom: 12px;
            font-size: 13px;
        }

        .transaction-label {
            color: #6c757d;
            font-weight: 500;
            display: inline-block;
            width: 130px;
        }

        .transaction-value {
            color: #333333;
            font-weight: 500;
        }

        /* Contact */
        .contact-section {
            text-align: center;
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .contact-icon {
            font-size: 24px;
            color: #28a745;
            margin-bottom: 10px;
        }

        .contact-title {
            font-size: 14px;
            color: #333333;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .contact-info {
            font-size: 14px;
            color: #28a745;
            font-weight: 700;
            margin: 0;
        }

        /* Badge statut */
        .status-badge {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Pied de page */
        .footer {
            text-align: center;
            padding: 25px 0 0;
            margin-top: 30px;
            border-top: 1px dashed #dee2e6;
            color: #6c757d;
            font-size: 12px;
        }

        .footer-text {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .copyright {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
            font-size: 11px;
            color: #999;
        }

        /* Utilitaires */
        .text-center { text-align: center; }
        .mt-20 { margin-top: 20px; }
        .mb-20 { margin-bottom: 20px; }
        .mb-10 { margin-bottom: 10px; }
        .mb-15 { margin-bottom: 15px; }

        /* Support email */
        .hide-on-desktop { display: none; }

        @media screen and (max-width: 480px) {
            .email-wrapper {
                padding: 10px;
            }
            .header {
                padding: 25px 20px;
            }
            .content {
                padding: 25px 20px;
            }
            .company-name {
                font-size: 20px;
            }
            .email-title {
                font-size: 16px;
            }
            .hide-on-desktop { display: block; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- En-tête -->
        <div class="header">
            <div class="company-name">{{ config('app.name') }}</div>
            <div class="email-title">CONFIRMATION DE PAIEMENT</div>
            <div style="margin-top: 12px; font-size: 13px; opacity: 0.9;">
                Reçu #{{ $payment->reference }}
            </div>
        </div>

        <!-- Corps de l'email -->
        <div class="content">
            <!-- Salutation -->
            <div class="greeting">
                Bonjour <strong>{{ $user->prenom }} {{ $user->nom }}</strong>,<br>
                Nous confirmons la bonne réception de votre paiement de loyer.
            </div>

            <!-- Carte de réception -->
            <div class="receipt-card">
                <div class="receipt-title">🧾 DÉTAIL DE LA TRANSACTION</div>

                <!-- Grille d'informations -->
                <div class="info-grid">
                    <div class="info-column">
                        <div class="info-group">
                            <span class="info-label">Référence</span>
                            <span class="info-value">{{ $payment->reference }}</span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Période concernée</span>
                            <span class="info-value">{{ $payment->periode }}</span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Propriété</span>
                            <span class="info-value">{{ $property->adresse }}</span>
                        </div>
                    </div>

                    <div class="info-column">
                        <div class="info-group">
                            <span class="info-label">Date du paiement</span>
                            <span class="info-value">{{ $payment->date_paiement->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Heure</span>
                            <span class="info-value">{{ $payment->date_paiement->format('H:i') }}</span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Méthode de paiement</span>
                            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $payment->methode)) }}</span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Statut</span>
                            <span class="info-value">
                                <span class="status-badge">✅ Payé</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Montant -->
                <div class="amount-container">
                    <div class="amount-label">Montant payé</div>
                    <div class="amount-value">{{ number_format($payment->montant, 0, ',', ' ') }} XAF</div>
                    <div class="amount-subtitle">Transaction validée avec succès</div>
                </div>

                <!-- Informations propriété -->
                <div class="property-card">
                    <div class="property-title">📍 Propriété concernée</div>
                    <div class="property-details">
                        {{ $property->adresse }}, {{ $property->ville }}<br>
                        @if($property->type)
                        <span style="font-size: 12px; color: #666;">Type: {{ $property->type }}</span>
                        @endif
                    </div>
                </div>

                <!-- Détails supplémentaires -->
                @if($payment->operateur || $payment->numero_transaction || $payment->notes)
                <div class="transaction-details">
                    <div class="transaction-title">📋 Détails supplémentaires</div>

                    @if($payment->operateur)
                    <div class="transaction-row">
                        <span class="transaction-label">Opérateur :</span>
                        <span class="transaction-value">{{ $payment->operateur }}</span>
                    </div>
                    @endif

                    @if($payment->numero_transaction)
                    <div class="transaction-row">
                        <span class="transaction-label">N° de transaction :</span>
                        <span class="transaction-value">{{ $payment->numero_transaction }}</span>
                    </div>
                    @endif

                    @if($payment->notes)
                    <div class="transaction-row">
                        <span class="transaction-label">Notes :</span>
                        <span class="transaction-value">{{ $payment->notes }}</span>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Section contact -->
            <div class="contact-section">
                <div class="contact-icon">💼</div>
                <div class="contact-title">Besoin d'aide ?</div>
                <div class="contact-info">0161581258</div>
                {{-- <div style="margin-top: 8px; font-size: 13px; color: #6c757d;">
                    Notre équipe est à votre disposition du lundi au vendredi, de 9h à 18h.
                </div> --}}
                {{-- <div style="margin-top: 12px; font-size: 12px; color: #28a745;">
                    📧 {{ config('app.contact_email', 'contact@example.com') }}
                </div> --}}
            </div>

            <!-- Section mobile friendly -->
            <div class="hide-on-desktop" style="margin-top: 20px; padding: 15px; background: #f0f8ff; border-radius: 8px; border: 1px solid #d1ecf1;">
                <div style="font-size: 13px; color: #0c5460; margin-bottom: 5px; font-weight: 600;">📱 Sur mobile ?</div>
                <div style="font-size: 12px; color: #6c757d;">Conservez cet email dans votre boîte de réception pour consultation ultérieure.</div>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <div class="footer-text">
                Cet email vous a été envoyé automatiquement suite à votre paiement.<br>
                Conservez-le pour vos archives et en cas de réclamation.
            </div>

            <div class="copyright">
                © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.<br>
                Cet email a été généré automatiquement, merci de ne pas y répondre.<br>
                <span style="font-size: 10px; color: #999;">ID: {{ $payment->id }}-{{ now()->format('YmdHis') }}</span>
            </div>
        </div>
    </div>
</body>
</html>
