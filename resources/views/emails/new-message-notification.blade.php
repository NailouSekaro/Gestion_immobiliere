<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .email-container { max-width: 600px; margin: 0 auto; background: #f4f4f4; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; }
        .content { background: white; padding: 20px; border-radius: 5px; }
        .btn-primary { background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>{{ config('app.name') }}</h2>
            <p>Nouveau message reçu</p>
        </div>

        <div class="content">
            <h3>Bonjour {{ $destinataire->prenom }} !</h3>

            <p>Vous avez reçu un nouveau message de <strong>{{ $expediteur->prenom }} {{ $expediteur->nom }}</strong>.</p>

            @if($sujet)
            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <strong>Sujet :</strong> {{ $sujet }}
            </div>
            @endif

            <div style="background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <strong>Message :</strong><br>
                {{ $contenu }}
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $messageUrl }}" class="btn-primary">
                    Voir le message
                </a>
            </div>

            <p style="color: #6c757d; font-size: 14px;">
                Vous recevez cet email parce que vous avez reçu un nouveau message sur {{ config('app.name') }}.
            </p>
        </div>
    </div>
</body>
</html>
