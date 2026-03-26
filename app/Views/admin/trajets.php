<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="mb-4">Liste des trajets</h1>

<?php if (isset($_SESSION['flash_success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php if (empty($trajets)): ?>
    <div class="alert alert-info">Aucun trajet enregistré.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-palette">
                <tr>
                    <th>ID</th>
                    <th>Départ</th>
                    <th>Date départ</th>
                    <th>Arrivée</th>
                    <th>Date arrivée</th>
                    <th>Proposé par</th>
                    <th>Places</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trajets as $trajet): ?>
                    <tr class="<?= strtotime($trajet['date_heure_depart']) < time() ? 'table-secondary' : '' ?>">
                        <td><?= $trajet['id_trajet'] ?></td>
                        <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($trajet['date_heure_depart'])) ?></td>
                        <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($trajet['date_heure_arrivee'])) ?></td>
                        <td><?= htmlspecialchars($trajet['prenom'] . ' ' . $trajet['nom']) ?></td>
                        <td>
                            <?= $trajet['nb_places_disponibles'] ?> / <?= $trajet['nb_places_total'] ?>
                        </td>
                        <td>
                            <form method="POST"
                                  action="/trajet/delete/<?= $trajet['id_trajet'] ?>"
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer ce trajet ?')">
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
