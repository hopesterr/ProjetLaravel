# TaskFlow — Gestionnaire de tâches collaboratif

Application web Laravel permettant de gérer des tâches organisées par tableaux,
avec tags, filtres de statut et gestion des rôles (admin / utilisateur).

---

## Fonctionnalités

- Authentification complète (connexion, inscription, profil)
- Création et gestion de tableaux de travail
- Création et gestion de tâches avec statut, description et date d'échéance
- Association de tags colorés aux tâches (relation N:N)
- Filtres de tâches par statut
- Dashboard avec statistiques
- Gestion des droits : admin vs utilisateur classique
- Interface Bootstrap 5 responsive

---

## Stack technique

- PHP 8.2+
- Laravel 11
- Laravel Breeze (authentification Blade)
- Eloquent ORM
- MySQL
- Bootstrap 5.3
- Bootstrap Icons

---

## Installation

### Prérequis

- PHP >= 8.2
- Composer
- Node.js + npm
- MySQL

### Étapes

```bash
# 1. Cloner le dépôt
git clone https://github.com/votre-repo/taskflow.git
cd taskflow

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install && npm run build

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Générer la clé d'application
php artisan key:generate
```

### Configuration de la base de données

Éditer `.env` :
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=

Créer la base de données :

```sql
CREATE DATABASE taskflow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Migration et seed

```bash
php artisan migrate:fresh --seed
```

### Lancer le serveur

```bash
php artisan serve
```

L'application est accessible sur : http://localhost:8000

---

## Comptes de test

| Rôle | Email | Mot de passe |
|---|---|---|
| Admin | admin@taskflow.test | password |
| Utilisateur | user@taskflow.test | password |

---

## Structure du projet
```plaintext
app/
├── Http/
│   ├── Controllers/
│   │   ├── BoardController.php
│   │   ├── TaskController.php
│   │   └── DashboardController.php
│   └── Requests/
│       ├── StoreBoardRequest.php
│       ├── UpdateBoardRequest.php
│       ├── StoreTaskRequest.php
│       └── UpdateTaskRequest.php
├── Models/
│   ├── User.php
│   ├── Board.php
│   ├── Task.php
│   └── Tag.php
database/
├── factories/
├── migrations/
└── seeders/
resources/views/
├── layouts/app.blade.php
├── components/flash-messages.blade.php
├── dashboard.blade.php
├── boards/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── show.blade.php
│   └── edit.blade.php
└── tasks/
├── index.blade.php
├── create.blade.php
├── show.blade.php
└── edit.blade.php
routes/web.php

---

## Choix techniques

- **Breeze** : solution officielle simple, légère, adaptée à un projet Blade
- **Contrôle d'accès manuel** : méthode `isAdmin()` + vérification `user_id` dans les contrôleurs, plus lisible qu'une Policy complète pour ce périmètre
- **Resource Controllers** : conformes aux conventions Laravel RESTful
- **Form Requests** : validation découplée, réutilisable, testable
- **Cascade delete** : suppression automatique des tâches et tags liés
- **Bootstrap CDN** : pas de compilation Sass, démarrage immédiat
