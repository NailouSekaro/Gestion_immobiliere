<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Paiement de Caution - {{ config('app.name') }}</title>
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
            background-color: #f8f9fa;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f8f9fa;
            padding: 20px;
        }

        /* En-tête */
        .header {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
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

        .reference-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
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
            color: #4361ee;
        }

        /* Détails de la caution */
        .caution-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
            border: 1px solid #dee2e6;
        }

        .caution-title {
            font-size: 16px;
            color: #4361ee;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Grille des cautions */
        .caution-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .caution-item {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
            padding: 0 10px;
            text-align: center;
        }

        /* Sur mobile */
        @media screen and (max-width: 480px) {
            .caution-item {
                display: block;
                width: 100%;
                padding: 0;
                margin-bottom: 20px;
            }
        }

        .caution-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(58, 12, 163, 0.1));
        }

        .caution-icon i {
            font-size: 20px;
            color: #4361ee;
        }

        .caution-label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .caution-amount {
            font-size: 16px;
            font-weight: 700;
            color: #333333;
            margin-bottom: 5px;
        }

        .caution-status {
            display: inline-block;
            padding: 3px 10px;
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

        /* Total */
        .total-section {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
            color: white;
        }

        .total-label {
            font-size: 13px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .total-amount {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .total-subtitle {
            font-size: 12px;
            opacity: 0.8;
        }

        /* Informations de paiement */
        .payment-info {
            background: #e8f4fd;
            border: 1px solid #bee1fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .payment-title {
            font-size: 14px;
            color: #0c5460;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .payment-row {
            margin-bottom: 12px;
            font-size: 13px;
        }

        .payment-label {
            color: #6c757d;
            font-weight: 500;
            display: inline-block;
            width: 150px;
        }

        .payment-value {
            color: #333333;
            font-weight: 500;
        }

        /* Bouton de téléchargement */
        .download-section {
            text-align: center;
            margin: 25px 0;
            padding: 20px;
            background: #f0f9ff;
            border-radius: 8px;
            border: 1px solid #b3e0ff;
        }

        .download-icon {
            font-size: 32px;
            color: #4361ee;
            margin-bottom: 15px;
        }

        .download-title {
            font-size: 15px;
            color: #333333;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .download-description {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .download-button {
            display: inline-block;
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .download-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        /* Section contact */
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
            color: #4361ee;
            margin-bottom: 10px;
        }

        .contact-title {
            font-size: 14px;
            color: #333333;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .contact-info {
            font-size: 16px;
            color: #4361ee;
            font-weight: 700;
            margin: 0 0 5px 0;
        }

        .contact-hours {
            font-size: 12px;
            color: #6c757d;
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
            .download-button {
                padding: 12px 25px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- En-tête -->
        <div class="header">
            <div class="company-name">{{ config('app.name') }}</div>
            <div class="email-title">CONFIRMATION DE PAIEMENT DE CAUTION</div>
            <div class="reference-badge">Référence : {{ $caution->reference ?? 'CAU-' . $caution->id }}</div>
        </div>

        <!-- Corps de l'email -->
        <div class="content">
            <!-- Salutation -->
            <div class="greeting">
                Bonjour <strong>{{ $caution->user->prenom }}</strong>,<br>
                Nous confirmons la bonne réception de votre paiement de caution.
            </div>

            <!-- Carte de caution -->
            <div class="caution-card">
                <div class="caution-title">🛡️ DÉTAIL DES CAUTIONS PAYÉES</div>

                <!-- Grille des cautions -->
                <div class="caution-grid">
                    <!-- Caution chambre -->
                    <div class="caution-item">
                        <div class="caution-icon">
                            <i>🛏️</i>
                        </div>
                        <div class="caution-label">Caution Chambre</div>
                        <div class="caution-amount">60,000 FCFA</div>
                        <span class="caution-status status-paid">Payée</span>
                    </div>

                    <!-- Caution eau -->
                    <div class="caution-item">
                        <div class="caution-icon">
                            <i>💧</i>
                        </div>
                        <div class="caution-label">Caution Eau</div>
                        <div class="caution-amount">
                            {{ $caution->caution_eau > 0 ? '10,000 FCFA' : '0 FCFA' }}
                        </div>
                        <span class="caution-status {{ $caution->caution_eau > 0 ? 'status-paid' : 'status-not-paid' }}">
                            {{ $caution->caution_eau > 0 ? 'Payée' : 'Non payée' }}
                        </span>
                    </div>

                    <!-- Caution électricité -->
                    <div class="caution-item">
                        <div class="caution-icon">
                            <i>⚡</i>
                        </div>
                        <div class="caution-label">Caution Électricité</div>
                        <div class="caution-amount">
                            {{ $caution->caution_electricite > 0 ? '10,000 FCFA' : '0 FCFA' }}
                        </div>
                        <span class="caution-status {{ $caution->caution_electricite > 0 ? 'status-paid' : 'status-not-paid' }}">
                            {{ $caution->caution_electricite > 0 ? 'Payée' : 'Non payée' }}
                        </span>
                    </div>
                </div>

                <!-- Total -->
                <div class="total-section">
                    <div class="total-label">Total de la caution</div>
                    <div class="total-amount">{{ number_format($caution->total_caution, 0, ',', ' ') }} FCFA</div>
                    <div class="total-subtitle">Montant total encaissé</div>
                </div>

                <!-- Informations de paiement -->
                <div class="payment-info">
                    <div class="payment-title">📋 INFORMATIONS DE PAIEMENT</div>
                    <div class="payment-row">
                        <span class="payment-label">Méthode :</span>
                        <span class="payment-value">
                            @php
                                $methodNames = [
                                    'especes' => 'Espèces',
                                    'mtn_momo' => 'MTN Mobile Money',
                                    'orange_money' => 'Orange Money',
                                    'wave' => 'Wave'
                                ];
                            @endphp
                            {{ $methodNames[$caution->methode] ?? ucfirst($caution->methode) }}
                        </span>
                    </div>
                    <div class="payment-row">
                        <span class="payment-label">Date du paiement :</span>
                        <span class="payment-value">{{ \Carbon\Carbon::parse($caution->date_paiement)->format('d/m/Y') }}</span>
                    </div>
                    {{-- <div class="payment-row">
                        <span class="payment-label">Heure :</span>
                        <span class="payment-value">{{ \Carbon\Carbon::parse($caution->date_paiement)->format('H:i') }}</span>
                    </div> --}}
                    @if($caution->property)
                    <div class="payment-row">
                        <span class="payment-label">Propriété :</span>
                        <span class="payment-value">{{ $caution->property->adresse ?? 'Non spécifié' }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Section téléchargement -->
            {{-- <div class="download-section">
                <div class="download-icon">📄</div>
                <div class="download-title">Télécharger le reçu officiel</div>
                <div class="download-description">
                    Conservez ce reçu pour vos archives et pour la restitution de votre caution à la fin du contrat.
                </div>
                <a href="{{ route('cautions.receipt', $caution) }}" class="download-button">
                    📥 Télécharger le reçu
                </a>
            </div> --}}

            <!-- Section contact -->
            <div class="contact-section">
                <div class="contact-icon">📞</div>
                <div class="contact-title">Besoin d'aide ?</div>
                <div class="contact-info">0161 58 12 58</div>
                {{-- <div class="contact-hours">Disponible du lundi au vendredi, de 9h à 18h</div>
                <div style="margin-top: 10px; font-size: 13px; color: #6c757d;">
                    📧 {{ config('app.contact_email', 'contact@example.com') }}
                </div> --}}
            </div>

            <!-- Note importante -->
            <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-radius: 8px; border: 1px solid #ffc107;">
                <div style="font-size: 13px; color: #856404; margin-bottom: 5px; font-weight: 600;">📝 Note importante</div>
                <div style="font-size: 12px; color: #856404; line-height: 1.5;">
                    Cette caution vous sera restituée à la fin de votre contrat, sous réserve de l'état des lieux de sortie.
                    Conservez ce reçu pour toute réclamation.
                </div>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <div class="footer-text">
                Cet email vous a été envoyé automatiquement suite au paiement de votre caution.<br>
                Il constitue une confirmation officielle de votre transaction.
            </div>

            <div class="copyright">
                © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.<br>
                Cet email a été généré automatiquement, merci de ne pas y répondre.<br>
                <span style="font-size: 10px; color: #999;">ID: CAU{{ $caution->id }}-{{ now()->format('YmdHis') }}</span>
            </div>
        </div>
    </div>
</body>
</html>
