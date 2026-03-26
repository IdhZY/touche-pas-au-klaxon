# Touche Pas Au Klaxon

Application web de covoiturage inter-sites permettant aux employes de proposer et trouver des trajets entre les differentes agences de l'entreprise.

## Prerequis

- PHP 8.1 ou superieur
- MySQL 8.0 ou MariaDB 10.6+
- Apache avec mod_rewrite active
- Composer

## Installation

### 1. Cloner le depot

```bash
git clone https://github.com/IdhZY/touche-pas-au-klaxon.git
cd touche-pas-au-klaxon
```

### 2. Installer les dependances

```bash
composer install
```

### 3. Creer la base de donnees

```bash
mysql -u root -p < sql/create_database.sql
mysql -u root -p < sql/seed_database.sql
```

### 4. Configurer la connexion

Modifier le fichier `config/database.php` avec vos identifiants MySQL :

```php
return [
    'host'    => 'localhost',
    'dbname'  => 'touche_pas_au_klaxon',
    'user'    => 'root',
    'pass'    => 'votre_mot_de_passe',
    'charset' => 'utf8mb4',
];
```

### 5. Configurer Apache

Le DocumentRoot doit pointer vers le dossier `public/` du projet.

Exemple de VirtualHost :

```apache
<VirtualHost *:80>
    ServerName klaxon.local
    DocumentRoot /chemin/vers/touche-pas-au-klaxon/public

    <Directory /chemin/vers/touche-pas-au-klaxon/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 6. Lancer l'application

Ouvrir votre navigateur a l'adresse configuree (ex : http://klaxon.local).

## Comptes de test

| Role           | Email                     | Mot de passe |
| -------------- | ------------------------- | ------------ |
| Administrateur | admin@klaxon.fr           | admin123     |
| Utilisateur    | alexandre.martin@email.fr | password123  |

## Architecture

Le projet suit une architecture **MVC** (Modele - Vue - Controleur) :

```
app/
├── Controllers/    Logique metier et routage
├── Models/         Acces aux donnees (PDO)
└── Views/          Templates PHP + Bootstrap
```

## Technologies

- **PHP 8.1+** : Langage back-end
- **MySQL / MariaDB** : Base de donnees
- **Bootstrap 5.3** : Framework CSS
- **Sass** : Preprocesseur CSS (variables de couleurs)
- **PHPUnit** : Tests unitaires
- **PHPStan** : Analyse statique du code
- **DocBlock** : Documentation du code

## Tests

```bash
# Tests unitaires
composer test

# Analyse statique
composer analyse
```

## Palette de couleurs

| Couleur    | Hex     | Usage            |
| ---------- | ------- | ---------------- |
| Bleu clair | #f1f8fc | Fond de page     |
| Bleu       | #0074c7 | Couleur primaire |
| Bleu fonce | #00497c | Liens, accents   |
| Gris-bleu  | #384050 | Texte, footer    |
| Rouge      | #cd2c2e | Danger, alertes  |
| Vert       | #82b864 | Succes, badges   |

## Licence

Projet realise dans le cadre d'une formation au Centre Europeen de Formation.
