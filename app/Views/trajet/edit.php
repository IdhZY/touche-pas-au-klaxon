<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="mb-4">Modifier le trajet</h1>

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
        <form method="POST" action="/trajet/edit/<?= $trajet['id_trajet'] ?>">

            <!-- Agences -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id_agence_depart" class="form-label">Agence de départ</label>
                    <select class="form-select" id="id_agence_depart" name="id_agence_depart" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($agences as $agence): ?>
                            <option value="<?= $agence['id_agence'] ?>"
                                <?= (($_POST['id_agence_depart'] ?? $trajet['id_agence_depart']) == $agence['id_agence']) ? 'selected' : '' ?>>
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
                                <?= (($_POST['id_agence_arrivee'] ?? $trajet['id_agence_arrivee']) == $agence['id_agence']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($agence['ville']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Dates -->
            <?php
            $depart  = $_POST['date_heure_depart'] ?? date('Y-m-d\TH:i', strtotime($trajet['date_heure_depart']));
            $arrivee = $_POST['date_heure_arrivee'] ?? date('Y-m-d\TH:i', strtotime($trajet['date_heure_arrivee']));
            ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date_heure_depart" class="form-label">Date et heure de départ</label>
                    <input type="datetime-local"
                           class="form-control"
                           id="date_heure_depart"
                           name="date_heure_depart"
                           value="<?= htmlspecialchars($depart) ?>"
                           required>
                </div>
                <div class="col-md-6">
                    <label for="date_heure_arrivee" class="form-label">Date et heure d'arrivée</label>
                    <input type="datetime-local"
                           class="form-control"
                           id="date_heure_arrivee"
                           name="date_heure_arrivee"
                           value="<?= htmlspecialchars($arrivee) ?>"
                           required>
                </div>
            </div>

            <!-- Places -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="nb_places_total" class="form-label">Nombre total de places</label>
                    <input type="number"
                           class="form-control"
                           id="nb_places_total"
                           name="nb_places_total"
                           min="1"
                           max="9"
                           value="<?= htmlspecialchars($_POST['nb_places_total'] ?? $trajet['nb_places_total']) ?>"
                           required>
                </div>
                <div class="col-md-6">
                    <label for="nb_places_disponibles" class="form-label">Places disponibles</label>
                    <input type="number"
                           class="form-control"
                           id="nb_places_disponibles"
                           name="nb_places_disponibles"
                           min="0"
                           value="<?= htmlspecialchars($_POST['nb_places_disponibles'] ?? $trajet['nb_places_disponibles']) ?>"
                           required>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="/trajet" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
