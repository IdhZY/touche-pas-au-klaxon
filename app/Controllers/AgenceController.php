<?php

/**
 * Contrôleur des agences
 *
 * Gère le CRUD des agences (réservé à l'administrateur).
 *
 * @package TouchePasAuKlaxon
 */
class AgenceController
{
    /** @var Agence Le modèle agence */
    private Agence $agenceModel;

    /**
     * Constructeur - initialise le modèle
     */
    public function __construct()
    {
        $this->agenceModel = new Agence();
    }

    /**
     * Crée une nouvelle agence
     *
     * @return void
     */
    public function create(): void
    {
        $this->requireAdmin();

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ville = trim($_POST['ville'] ?? '');

            if (empty($ville)) {
                $error = 'Le nom de la ville est obligatoire.';
            } elseif ($this->agenceModel->existsByVille($ville)) {
                $error = 'Cette ville existe déjà.';
            } else {
                $this->agenceModel->create($ville);
                $_SESSION['flash_success'] = 'L\'agence a été créée';
                header('Location: /admin/agences');
                exit;
            }
        }

        require __DIR__ . '/../Views/admin/agence_form.php';
    }

    /**
     * Modifie une agence existante
     *
     * @param string $id L'identifiant de l'agence
     * @return void
     */
    public function edit(string $id): void
    {
        $this->requireAdmin();

        $agence = $this->agenceModel->findById((int) $id);

        if (!$agence) {
            http_response_code(404);
            echo '<h1>Agence introuvable</h1>';
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ville = trim($_POST['ville'] ?? '');

            if (empty($ville)) {
                $error = 'Le nom de la ville est obligatoire.';
            } elseif ($this->agenceModel->existsByVille($ville, (int) $id)) {
                $error = 'Cette ville existe déjà.';
            } else {
                $this->agenceModel->update((int) $id, $ville);
                $_SESSION['flash_success'] = 'L\'agence a été modifiée';
                header('Location: /admin/agences');
                exit;
            }
        }

        require __DIR__ . '/../Views/admin/agence_form.php';
    }

    /**
     * Supprime une agence
     *
     * @param string $id L'identifiant de l'agence
     * @return void
     */
    public function delete(string $id): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->agenceModel->delete((int) $id);
            } catch (PDOException $e) {
                // L'agence est liée à des trajets (RESTRICT)
                $_SESSION['flash_error'] = 'Impossible de supprimer cette agence : des trajets y sont associés.';
            }
            header('Location: /admin/agences');
            exit;
        }
    }

    /**
     * Vérifie que l'utilisateur est administrateur
     *
     * @return void
     */
    private function requireAdmin(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrateur') {
            http_response_code(403);
            echo '<h1>Accès interdit</h1>';
            exit;
        }
    }
}
