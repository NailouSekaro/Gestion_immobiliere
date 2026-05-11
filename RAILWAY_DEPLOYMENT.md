# Deploiement Railway

## Plateforme recommandee

Railway est le choix le plus simple pour cette application Laravel, surtout avec un compte gratuit ou trial. Le projet utilise Laravel, Vite et MySQL.

## Services Railway a creer

1. Un service Web connecte au repo GitHub.
2. Un service MySQL dans le meme projet Railway.
3. Optionnel mais recommande : un volume persistant monte sur `storage/app/public` pour conserver les photos, fichiers et contrats PDF.

## Variables du service Web

Dans Railway, ouvrir le service Web, puis `Variables`, puis coller/adaper :

```env
APP_NAME="Gestion Loyer"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}

LOG_CHANNEL=stderr
LOG_LEVEL=info

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"

BROADCAST_DRIVER=log
VITE_APP_NAME="${APP_NAME}"
```

Generer `APP_KEY` localement avec :

```bash
php artisan key:generate --show
```

Puis coller la valeur dans Railway.

## Configuration Railway

Dans le service Web :

- Build command : `npm run build`
- Pre-deploy command : `chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh`
- Public Networking : `Generate Domain`

Railway detecte Laravel et lance le service PHP automatiquement.

## Apres le premier deploy

Verifier dans les logs :

- migrations terminees sans erreur ;
- `config cached successfully` ;
- `Blade templates cached successfully` ;
- service accessible depuis le domaine Railway.

## Notes importantes

- Ne pas utiliser `php artisan route:cache` pour l'instant : le projet a deux routes nommees `login`, ce qui bloque le cache des routes.
- Sans volume persistant, les fichiers uploades et les PDF generes dans `storage/app/public` peuvent disparaitre apres redeploiement.
- Le plan gratuit Railway donne peu de credits. Pour une demo, c'est OK. Pour une utilisation durable, surveiller l'usage ou passer en Hobby.
