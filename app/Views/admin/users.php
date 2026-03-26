<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="mb-4">Liste des utilisateurs</h1>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="thead-palette">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Rôle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['nom']) ?></td>
                    <td><?= htmlspecialchars($u['prenom']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['telephone']) ?></td>
                    <td>
                        <span class="badge <?= $u['role'] === 'administrateur' ? 'bg-danger' : 'bg-secondary' ?>">
                            <?= htmlspecialchars($u['role']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
