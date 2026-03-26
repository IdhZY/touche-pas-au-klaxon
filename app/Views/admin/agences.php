<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Liste des agences</h1>
    <a href="/agence/create" class="btn btn-primary">+ Ajouter une agence</a>
</div>

<?php if (isset($_SESSION['flash_success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['flash_error']) ?>
    </div>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="thead-palette">
            <tr>
                <th>ID</th>
                <th>Ville</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agences as $agence): ?>
                <tr>
                    <td><?= $agence['id_agence'] ?></td>
                    <td><?= htmlspecialchars($agence['ville']) ?></td>
                    <td>
                        <a href="/agence/edit/<?= $agence['id_agence'] ?>"
                           class="btn btn-sm btn-warning">Modifier</a>

                        <form method="POST"
                              action="/agence/delete/<?= $agence['id_agence'] ?>"
                              class="d-inline"
                              onsubmit="return confirm('Supprimer l\'agence <?= htmlspecialchars($agence['ville']) ?> ?')">
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
