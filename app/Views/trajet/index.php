<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if (isset($_SESSION['flash_success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php if (!isset($_SESSION['user'])): ?>
    <p class="fs-4 mb-4">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</p>
<?php endif; ?>

<h2 class="mb-4">Trajets propos&eacute;s</h2>

<?php if (empty($trajets)): ?>
    <div class="alert alert-info">Aucun trajet disponible pour le moment.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="thead-palette">
                <tr>
                    <th>D&eacute;part</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Places</th>
                    <?php if (isset($_SESSION['user'])): ?>
                        <th></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trajets as $trajet): ?>
                    <tr>
                        <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>
                        <td><?= date('d/m/Y', strtotime($trajet['date_heure_depart'])) ?></td>
                        <td><?= date('H:i', strtotime($trajet['date_heure_depart'])) ?></td>
                        <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
                        <td><?= date('d/m/Y', strtotime($trajet['date_heure_arrivee'])) ?></td>
                        <td><?= date('H:i', strtotime($trajet['date_heure_arrivee'])) ?></td>
                        <td><?= $trajet['nb_places_disponibles'] ?></td>

                        <?php if (isset($_SESSION['user'])): ?>
                            <td class="text-nowrap">
                                <!-- Bouton d&eacute;tails (modale) -->
                                <a href="#" class="text-dark me-1"
                                   data-bs-toggle="modal"
                                   data-bs-target="#modal-<?= $trajet['id_trajet'] ?>"
                                   title="D&eacute;tails">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <?php if ((int) $trajet['id_utilisateur'] === (int) $_SESSION['user']['id_utilisateur']): ?>
                                    <a href="/trajet/edit/<?= $trajet['id_trajet'] ?>"
                                       class="text-dark me-1"
                                       title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form method="POST"
                                          action="/trajet/delete/<?= $trajet['id_trajet'] ?>"
                                          class="d-inline"
                                          onsubmit="return confirm('Supprimer ce trajet ?')">
                                        <button type="submit" class="btn btn-link text-dark p-0"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>

                    <?php if (isset($_SESSION['user'])): ?>
                        <!-- Modale de d&eacute;tails -->
                        <div class="modal fade" id="modal-<?= $trajet['id_trajet'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Auteur :</strong>
                                            <?= htmlspecialchars($trajet['prenom'] . ' ' . $trajet['nom']) ?>
                                        </p>
                                        <p><strong>T&eacute;l&eacute;phone :</strong>
                                            <?= htmlspecialchars($trajet['telephone']) ?>
                                        </p>
                                        <p><strong>Email :</strong>
                                            <?= htmlspecialchars($trajet['email']) ?>
                                        </p>
                                        <p><strong>Nombre total de places :</strong>
                                            <?= $trajet['nb_places_total'] ?>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Fermer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
