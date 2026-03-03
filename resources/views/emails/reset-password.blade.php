<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe - HOMIQIO</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo h1 { color: #000; font-size: 28px; font-weight: 700; margin: 0; }
        h2 { color: #000; font-size: 24px; margin-bottom: 20px; }
        p { color: #555; font-size: 16px; margin-bottom: 20px; }
        .button {
            display: inline-block;
            background-color: #000;
            color: #fff !important;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #888;
            text-align: center;
        }
        .link-fallback { font-size: 12px; color: #888; word-break: break-all; }
        .warning { background: #fff8e1; border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 4px; font-size: 14px; color: #92400e; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>HOMIQIO</h1>
        </div>

        <h2>Bonjour {{ $user->first_name }},</h2>

        <p>
            Vous avez demandé la réinitialisation de votre mot de passe HOMIQIO.
            Cliquez sur le bouton ci-dessous pour choisir un nouveau mot de passe.
        </p>

        <p style="text-align: center;">
            <a href="{{ $resetUrl }}" class="button">
                Réinitialiser mon mot de passe
            </a>
        </p>

        <p>
            Si le bouton ne fonctionne pas, copiez et collez le lien suivant dans votre navigateur :
        </p>
        <p class="link-fallback">{{ $resetUrl }}</p>

        <div class="warning">
            ⚠️ Ce lien est valable pendant <strong>60 minutes</strong>.
            Si vous n'avez pas demandé cette réinitialisation, ignorez cet email — votre mot de passe ne sera pas modifié.
        </div>

        <div class="footer">
            <p>
                © {{ date('Y') }} HOMIQIO. Tous droits réservés.<br>
                Cet email a été envoyé automatiquement, merci de ne pas y répondre.
            </p>
        </div>
    </div>
</body>
</html>
