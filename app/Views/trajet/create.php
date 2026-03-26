<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="mb-4">Proposer un trajet</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="/trajet/create">

            <!-- Infos utilisateur (pré-renseignées, non modifiables) -->
            <h5 class="mb-3">Vos informations</h5>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['nom']) ?>" disabled>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['prenom']) ?>" disabled>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['telephone']) ?>" disabled>
                </div>
            </div>

            <hr>
            <h5 class="mb-3">Détails du trajet</h5>

            <!-- Agences -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id_agence_depart" class="form-label">Agence de départ</label>
                    <select class="form-select" id="id_agence_depart" name="id_agence_depart" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($agences as $agence): ?>
                            <option value="<?= $agence['id_agence'] ?>"
                                <?= (($_POST['id_agence_depart'] ?? '') == $agence['id_agence']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($agence['ville']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="id_agence_arrivee" class="form-label">Agence d'arrivée</label>
                    <select class="form-select" id="id_agence_arrivee" name="id_agence_arrivee" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($agences as $agence): ?>
                            <option value="<?= $agence['id_agence'] ?>"
                                <?= (($_POST['id_agence_arrivee'] ?? '') == $agence['id_agence']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($agence['ville']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Dates -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date_heure_depart" class="form-label">Date et heure de départ</label>
                    <input type="datetime-local"
                           class="form-control"
                           id="date_heure_depart"
                           name="date_heure_depart"
                           value="<?= htmlspecialchars($_POST['date_heure_depart'] ?? '') ?>"
                           required>
                </div>
                <div class="col-md-6">
                    <label for="date_heure_arrivee" class="form-label">Date et heure d'arrivée</label>
                    <input type="datetime-local"
                           class="form-control"
                           id="date_heure_arrivee"
                           name="date_heure_arrivee"
                           value="<?= htmlspecialchars($_POST['date_heure_arrivee'] ?? '') ?>"
                           required>
                </div>
            </div>

            <!-- Places -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="nb_places_total" class="form-label">Nombre de places</label>
                    <input type="number"
                           class="form-control"
                           id="nb_places_total"
                           name="nb_places_total"
                           min="1"
                           max="9"
                           value="<?= htmlspecialchars($_POST['nb_places_total'] ?? '4') ?>"
                           required>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Créer le trajet</button>
                <a href="/trajet" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
