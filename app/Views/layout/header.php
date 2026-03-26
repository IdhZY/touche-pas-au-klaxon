<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-palette">
    <div class="container">

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'administrateur'): ?>
            <a class="navbar-brand fw-bold fst-italic" href="/admin/dashboard">Touche pas au klaxon</a>
        <?php else: ?>
            <a class="navbar-brand fw-bold fst-italic" href="/trajet">Touche pas au klaxon</a>
        <?php endif; ?>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">

                <?php if (!isset($_SESSION['user'])): ?>
                    <!-- VISITEUR NON CONNECTÉ -->
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="/auth/login">Connexion</a>
                    </li>

                <?php elseif ($_SESSION['user']['role'] === 'administrateur'): ?>
                    <!-- ADMINISTRATEUR -->
                    <li class="nav-item">
                        <a class="btn btn-nav-admin" href="/admin/users">Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav-admin" href="/admin/agences">Agences</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav-admin" href="/admin/trajets">Trajets</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-light mb-0">
                            Bonjour <?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="/auth/logout">Déconnexion</a>
                    </li>

                <?php else: ?>
                    <!-- UTILISATEUR CONNECTÉ -->
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="/trajet/create">Créer un trajet</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-light mb-0">
                            Bonjour <?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="/auth/logout">Déconnexion</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">
