<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Création de compte</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .email-body {
            padding: 30px;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .btn-primary {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .credentials-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .password-warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .role-badge {
            display: inline-block;
            padding: 8px 16px;
            background-color: #e9ecef;
            border-radius: 20px;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>{{ config('app.name') }}</h1>
            <p>Création de votre compte</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Bonjour {{ $user->prenom }} {{ $user->nom }} !</h2>

            <p>Votre compte sur <strong>{{ config('app.name') }}</strong> a été créé avec succès.</p>

            <div class="credentials-box">
                <h3>🧭 Vos identifiants de connexion :</h3>
                <p><strong>Email :</strong> {{ $user->email }}</p>
                <p><strong>Mot de passe temporaire :</strong>
                    <span style="font-family: monospace; background: #e9ecef; padding: 4px 8px; border-radius: 3px;">
                        {{ $tempPassword }}
                    </span>
                </p>
            </div>

            <div class="password-warning">
                <h3>🔒 Sécurité importante :</h3>
                <p>• Vous serez obligé de changer ce mot de passe lors de votre première connexion</p>
                <p>• Ce mot de passe est temporaire et doit être changé immédiatement</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $loginUrl }}" class="btn-primary">
                    Se connecter maintenant
                </a>
            </div>

            <div style="text-align: center;">
                <h3>🎯 Rôle attribué :</h3>
                <div class="role-badge">
                    {{ ucfirst($user->role) }}
                    @if($user->specialite)
                    - {{ ucfirst($user->specialite) }}
                    @endif
                </div>
            </div>

            <div style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
                <p><strong>⚠️ Important :</strong></p>
                <p>• Pour des raisons de sécurité, ne partagez jamais vos identifiants</p>
                <p>• Si vous n'êtes pas à l'origine de cette demande, contactez immédiatement l'administrateur</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
