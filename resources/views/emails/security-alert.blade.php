<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .alert { background: #fff3cd; border: 1px solid #ffeaa7; padding: 20px; margin: 20px 0; }
        .info-box { background: #e3f2fd; padding: 15px; margin: 15px 0; }
    </style>
</head>
<body>
    <h2>🚨 Alerte de Sécurité</h2>

    @if($alertType === 'nouvelle_connexion')
    <div class="alert">
        <h3>Nouvelle connexion détectée</h3>
        <p>Une connexion à votre compte a été détectée depuis un nouvel appareil.</p>
    </div>

    <div class="info-box">
        <p><strong>📍 Adresse IP :</strong> {{ $ipAddress }}</p>
        <p><strong>🖥️ Appareil :</strong> {{ $deviceInfo }}</p>
        <p><strong>⏰ Date/Heure :</strong> {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    @endif

    <p>Si vous n'êtes pas à l'origine de cette action, veuillez :</p>
    <ol>
        <li>Changer votre mot de passe immédiatement</li>
        <li>Contacter l'administrateur</li>
        <li>Vérifier vos activités récentes</li>
    </ol>
</body>
</html>
