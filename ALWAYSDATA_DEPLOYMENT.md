# Deploiement gratuit avec alwaysdata

## Pourquoi alwaysdata

alwaysdata est plus adapte que Render/Railway pour cette application Laravel si l'objectif est de rester gratuit :

- offre gratuite sans carte bancaire ;
- offre gratuite sans limite de temps ;
- PHP, Composer, Node.js et bases MariaDB/MySQL disponibles ;
- HTTPS inclus ;
- SSH disponible.

Le projet Laravel peut donc etre heberge comme une application PHP classique, avec le dossier `public` comme racine web.

## Etapes dans alwaysdata

### 1. Creer le compte

Creer un compte gratuit sur alwaysdata, puis noter le nom du compte. Il donnera une adresse du type :

```text
https://nomducompte.alwaysdata.net
```

### 2. Creer la base de donnees

Dans l'administration alwaysdata :

1. Aller dans `Databases`.
2. Creer une base MariaDB/MySQL.
3. Noter :
   - nom de base ;
   - utilisateur ;
   - mot de passe ;
   - host.

### 3. Cloner le projet en SSH

Se connecter en SSH :

```bash
ssh nomducompte@ssh-nomducompte.alwaysdata.net
```

Puis cloner le depot :

```bash
git clone https://github.com/NailouSekaro/Gestion_immobiliere.git
cd Gestion_immobiliere
```

### 4. Installer les dependances

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

### 5. Configurer Laravel

```bash
cp .env.example .env
php artisan key:generate
```

Modifier `.env` :

```env
APP_NAME="Gestion Loyer"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://nomducompte.alwaysdata.net

LOG_CHANNEL=stack
LOG_LEVEL=info

DB_CONNECTION=mysql
DB_HOST=HOST_ALWAYSDATA
DB_PORT=3306
DB_DATABASE=NOM_BASE
DB_USERNAME=UTILISATEUR_BASE
DB_PASSWORD=MOT_DE_PASSE_BASE

FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
SESSION_DRIVER=file
CACHE_DRIVER=file

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

### 6. Finaliser Laravel

```bash
php artisan storage:link
php artisan migrate --force
php artisan config:cache
php artisan view:cache
```

Ne pas lancer `php artisan route:cache` pour l'instant : le projet contient encore deux routes nommees `login`, ce qui bloque le cache des routes.

### 7. Configurer le site web

Dans l'administration alwaysdata :

1. Aller dans `Web > Sites`.
2. Creer ou modifier le site.
3. Type : Apache/PHP.
4. Racine du site :

```text
/home/nomducompte/Gestion_immobiliere/public
```

5. Version PHP : 8.2 ou plus recent.
6. Activer HTTPS.

## Commandes de mise a jour

Pour redeployer apres un push GitHub :

```bash
cd ~/Gestion_immobiliere
git pull origin main
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan view:cache
```

## Limites a garder en tete

- L'offre gratuite a peu de ressources, donc c'est tres bien pour demo/test, mais pas pour beaucoup d'utilisateurs.
- Les fichiers generes comme photos, messages audio et contrats PDF occupent l'espace disque.
- Si l'envoi d'emails est important, il faudra configurer un vrai SMTP.
