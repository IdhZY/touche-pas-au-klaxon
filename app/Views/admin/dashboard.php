<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="mb-4">Tableau de bord</h1>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h5 class="card-title">Utilisateurs</h5>
                <p class="card-text text-muted">Consulter la liste des employés</p>
                <a href="/admin/users" class="btn btn-primary">Voir</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h5 class="card-title">Agences</h5>
                <p class="card-text text-muted">Gérer les villes / agences</p>
                <a href="/admin/agences" class="btn btn-primary">Gérer</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h5 class="card-title">Trajets</h5>
                <p class="card-text text-muted">Consulter et supprimer les trajets</p>
                <a href="/admin/trajets" class="btn btn-primary">Voir</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
