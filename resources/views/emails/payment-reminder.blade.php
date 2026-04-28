<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .email-container { max-width: 600px; margin: 0 auto; background: #f4f4f4; padding: 20px; }
        .header { background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: white; padding: 30px; text-align: center; }
        .urgent { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); }
        .content { background: white; padding: 30px; border-radius: 10px; }
        .amount { font-size: 24px; color: #dc3545; font-weight: bold; }
        .footer { text-align: center; padding: 20px; color: #6c757d; font-size: 14px; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header {{ $payment->estEnRetard() ? 'urgent' : '' }}">
            <h2>{{ config('app.name') }}</h2>
            <h3>{{ $payment->estEnRetard() ? '⚠️ PAIEMENT EN RETARD' : '📅 RAPPEL DE PAIEMENT' }}</h3>
        </div>

        <div class="content">
            <h3>Bonjour {{ $payment->user->prenom }} {{ $payment->user->nom }} !</h3>

            @if($payment->estEnRetard())
            <div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <h4 style="color: #856404; margin: 0;">⚠️ VOTRE PAIEMENT EST EN RETARD DE {{ $daysOverdue }} JOURS</h4>
            </div>
            @else
            <p>Ceci est un rappel concernant votre prochain paiement de loyer.</p>
            @endif

            <div style="background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
                <h4>Détails du paiement :</h4>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin: 15px 0;">
                    <div><strong>Période:</strong></div>
                    <div>{{ $payment->periode }}</div>

                    <div><strong>Propriété:</strong></div>
                    <div>{{ $payment->property->adresse }}</div>

                    <div><strong>Montant initial:</strong></div>
                    <div>{{ number_format($payment->montant, 0, ',', ' ') }} XAF</div>

                    @if($payment->estEnRetard())
                    <div><strong>Pénalité de retard:</strong></div>
                    <div>{{ number_format($payment->montant_avec_penalite - $payment->montant, 0, ',', ' ') }} XAF</div>

                    <div><strong>Total à régler:</strong></div>
                    <div class="amount">{{ number_format($payment->montant_avec_penalite, 0, ',', ' ') }} XAF</div>
                    @endif

                    <div><strong>Date limite:</strong></div>
                    <div>{{ $payment->date_limite->format('d/m/Y') }}</div>
                </div>
            </div>

            <div style="background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <h4>📋 Méthodes de paiement acceptées :</h4>
                <ul>
                    <li>MTN Mobile Money</li>
                    <li>Orange Money</li>
                    <li>Virement bancaire</li>
                    <li>Espèces (au bureau)</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <p>Pour toute question, contactez-nous à :</p>
                <p><strong>{{ config('mail.from.address') }}</strong></p>
                <p><strong>{{ config('app.phone') }}</strong></p>
            </div>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
