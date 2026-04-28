<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de paiement d'eau</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        .header {
            background-color: #28a745;
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .content {
            padding: 20px;
        }

        .receipt {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .amount {
            font-size: 20px;
            color: #28a745;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h2>Confirmation de paiement d'eau</h2>
        </div>

        <div class="content">
            <p>Bonjour {{ $consommationEau->user->prenom }},</p>

            <p>Nous confirmons la réception de votre paiement pour la consommation d’eau :</p>

            <div class="receipt">
                <p><strong>Chambre :</strong> {{ $consommationEau->property->libelle ?? '—' }}</p>
                <p><strong>Période :</strong> {{ $consommationEau->periode_debut->format('d/m/Y') ?? '—' }}
                    au {{ $consommationEau->periode_fin->format('d/m/Y') ?? '—' }}</p>
                <p><strong>Consommation :</strong> {{ $consommationEau->consommation }} m³</p>
                <p class="amount"><strong>Montant payé :</strong> {{ number_format($consommationEau->montant, 0, ',', ' ') }} FCFA</p>
                <p><strong>Méthode de paiement :</strong> {{ $consommationEau->paiementEau->methode ?? '—' }}</p>
                <p><strong>Date du paiement :</strong> {{ $consommationEau->paiementEau->date_paiement ?? '—' }}</p>
            </div>

            <p>Merci de votre prompt paiement.</p>

            <p>Cordialement,<br>L’équipe de gestion des loyers</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Gestion Loyer. Tous droits réservés.
        </div>
    </div>
</body>

</html>
