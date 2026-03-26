<?php

/**
 * Contrôleur des trajets
 *
 * Gère l'affichage, la création, la modification
 * et la suppression des trajets de covoiturage.
 *
 * @package TouchePasAuKlaxon
 */
class TrajetController
{
    /** @var Trajet Le modèle trajet */
    private Trajet $trajetModel;

    /** @var Agence Le modèle agence */
    private Agence $agenceModel;

    /**
     * Constructeur - initialise les modèles
     */
    public function __construct()
    {
        $this->trajetModel = new Trajet();
        $this->agenceModel = new Agence();
    }

    /**
     * Page d'accueil - liste des trajets disponibles
     *
     * Affiche les trajets avec places disponibles,
     * triés par date de départ croissante.
     *
     * @return void
     */
    public function index(): void
    {
        $trajets = $this->trajetModel->findAvailable();
        require __DIR__ . '/../Views/trajet/index.php';
    }

    /**
     * Formulaire de création d'un trajet
     *
     * Accessible uniquement aux utilisateurs connectés.
     *
     * @return void
     */
    public function create(): void
    {
        $this->requireAuth();

        $agences = $this->agenceModel->findAll();
        $user    = $_SESSION['user'];
        $errors  = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitizeTrajetData($_POST);
            $errors = $this->validateTrajetData($data);

            if (empty($errors)) {
                $data['id_utilisateur'] = $user['id_utilisateur'];
                $data['nb_places_disponibles'] = $data['nb_places_total'];

                $this->trajetModel->create($data);
                $_SESSION['flash_success'] = 'Le trajet a été créé';
                header('Location: /trajet');
                exit;
            }
        }

        require __DIR__ . '/../Views/trajet/create.php';
    }

    /**
     * Formulaire de modification d'un trajet
     *
     * Accessible uniquement à l'auteur du trajet.
     *
     * @param string $id L'identifiant du trajet
     * @return void
     */
    public function edit(string $id): void
    {
        $this->requireAuth();

        $trajet = $this->trajetModel->findById((int) $id);

        if (!$trajet) {
            http_response_code(404);
            echo '<h1>Trajet introuvable</h1>';
            exit;
        }

        // Vérifier que l'utilisateur est l'auteur
        if ((int) $trajet['id_utilisateur'] !== (int) $_SESSION['user']['id_utilisateur']) {
            http_response_code(403);
            echo '<h1>Accès interdit</h1>';
            exit;
        }

        $agences = $this->agenceModel->findAll();
        $errors  = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitizeTrajetData($_POST);
            $errors = $this->validateTrajetData($data);

            if (empty($errors)) {
                $this->trajetModel->update((int) $id, $data);
                $_SESSION['flash_success'] = 'Le trajet a été modifié';
                header('Location: /trajet');
                exit;
            }
        }

        require __DIR__ . '/../Views/trajet/edit.php';
    }

    /**
     * Suppression d'un trajet
     *
     * Accessible à l'auteur du trajet ou à l'administrateur.
     *
     * @param string $id L'identifiant du trajet
     * @return void
     */
    public function delete(string $id): void
    {
        $this->requireAuth();

        $trajet = $this->trajetModel->findById((int) $id);

        if (!$trajet) {
            http_response_code(404);
            echo '<h1>Trajet introuvable</h1>';
            exit;
        }

        $isAuthor = (int) $trajet['id_utilisateur'] === (int) $_SESSION['user']['id_utilisateur'];
        $isAdmin  = $_SESSION['user']['role'] === 'administrateur';

        if (!$isAuthor && !$isAdmin) {
            http_response_code(403);
            echo '<h1>Accès interdit</h1>';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->trajetModel->delete((int) $id);
            $_SESSION['flash_success'] = 'Le trajet a été supprimé';

            if ($isAdmin) {
                header('Location: /admin/trajets');
            } else {
                header('Location: /trajet');
            }
            exit;
        }
    }

    /**
     * Vérifie que l'utilisateur est connecté
     *
     * @return void
     */
    private function requireAuth(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }
    }

    /**
     * Nettoie les données du formulaire trajet
     *
     * @param array $post Les données POST brutes
     * @return array Les données nettoyées
     */
    private function sanitizeTrajetData(array $post): array
    {
        return [
            'id_agence_depart'      => (int) ($post['id_agence_depart'] ?? 0),
            'id_agence_arrivee'     => (int) ($post['id_agence_arrivee'] ?? 0),
            'date_heure_depart'     => trim($post['date_heure_depart'] ?? ''),
            'date_heure_arrivee'    => trim($post['date_heure_arrivee'] ?? ''),
            'nb_places_total'       => (int) ($post['nb_places_total'] ?? 0),
            'nb_places_disponibles' => (int) ($post['nb_places_disponibles'] ?? 0),
        ];
    }

    /**
     * Valide les données du formulaire trajet
     *
     * @param array $data Les données nettoyées
     * @return array Les erreurs de validation (vide si OK)
     */
    private function validateTrajetData(array $data): array
    {
        $errors = [];

        if ($data['id_agence_depart'] === 0 || $data['id_agence_arrivee'] === 0) {
            $errors[] = 'Veuillez sélectionner les agences de départ et d\'arrivée.';
        }

        if ($data['id_agence_depart'] === $data['id_agence_arrivee']) {
            $errors[] = 'L\'agence de départ et d\'arrivée doivent être différentes.';
        }

        if (empty($data['date_heure_depart']) || empty($data['date_heure_arrivee'])) {
            $errors[] = 'Veuillez renseigner les dates de départ et d\'arrivée.';
        } elseif ($data['date_heure_arrivee'] <= $data['date_heure_depart']) {
            $errors[] = 'La date d\'arrivée doit être postérieure à la date de départ.';
        }

        if ($data['nb_places_total'] < 1) {
            $errors[] = 'Le nombre de places doit être au minimum 1.';
        }

        if ($data['nb_places_disponibles'] < 0 || $data['nb_places_disponibles'] > $data['nb_places_total']) {
            $errors[] = 'Le nombre de places disponibles est incohérent.';
        }

        return $errors;
    }
}
