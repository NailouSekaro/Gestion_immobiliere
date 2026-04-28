<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .title { text-align: center; margin-bottom: 20px; }
        .amount { font-size: 20px; font-weight: bold; }
    </style>
</head>
<body>

<h2 class="title">Reçu de paiement</h2>

<p><strong>Client :</strong> {{ $user->prenom }} {{ $user->nom }}</p>
<p><strong>Référence :</strong> {{ $payment->reference }}</p>
<p><strong>Période :</strong> {{ $payment->periode }}</p>
<p><strong>Propriété :</strong> {{ $property->adresse }} - {{ $property->ville }}</p>
<p><strong>Date :</strong> {{ $payment->date_paiement->format('d/m/Y H:i') }}</p>

<hr>

<p class="amount">
    Montant payé : {{ number_format($payment->montant, 0, ',', ' ') }} XAF
</p>

<p><strong>Méthode :</strong> {{ ucfirst(str_replace('_', ' ', $payment->methode)) }}</p>

</body>
</html>
