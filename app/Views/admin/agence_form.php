<?php require __DIR__ . '/../layout/header.php'; ?>

<?php
$isEdit = isset($agence);
$title  = $isEdit ? 'Modifier l\'agence' : 'Ajouter une agence';
$action = $isEdit ? '/agence/edit/' . $agence['id_agence'] : '/agence/create';
$ville  = $_POST['ville'] ?? ($agence['ville'] ?? '');
?>

<h1 class="mb-4"><?= $title ?></h1>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="<?= $action ?>">
                    <div class="mb-3">
                        <label for="ville" class="form-label">Nom de la ville</label>
                        <input type="text"
                               class="form-control"
                               id="ville"
                               name="ville"
                               value="<?= htmlspecialchars($ville) ?>"
                               required
                               autofocus>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <?= $isEdit ? 'Enregistrer' : 'Ajouter' ?>
                        </button>
                        <a href="/admin/agences" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
