<?php

/**
 * Contrôleur du tableau de bord administrateur
 *
 * Gère les pages de listing pour l'admin :
 * utilisateurs, agences, trajets.
 *
 * @package TouchePasAuKlaxon
 */
class AdminController
{
    /** @var Utilisateur Le modèle utilisateur */
    private Utilisateur $utilisateurModel;

    /** @var Agence Le modèle agence */
    private Agence $agenceModel;

    /** @var Trajet Le modèle trajet */
    private Trajet $trajetModel;

    /**
     * Constructeur - initialise les modèles
     */
    public function __construct()
    {
        $this->utilisateurModel = new Utilisateur();
        $this->agenceModel      = new Agence();
        $this->trajetModel      = new Trajet();
    }

    /**
     * Tableau de bord principal
     *
     * @return void
     */
    public function dashboard(): void
    {
        $this->requireAdmin();
        require __DIR__ . '/../Views/admin/dashboard.php';
    }

    /**
     * Liste des utilisateurs
     *
     * @return void
     */
    public function users(): void
    {
        $this->requireAdmin();
        $users = $this->utilisateurModel->findAll();
        require __DIR__ . '/../Views/admin/users.php';
    }

    /**
     * Liste des agences
     *
     * @return void
     */
    public function agences(): void
    {
        $this->requireAdmin();
        $agences = $this->agenceModel->findAll();
        require __DIR__ . '/../Views/admin/agences.php';
    }

    /**
     * Liste de tous les trajets
     *
     * @return void
     */
    public function trajets(): void
    {
        $this->requireAdmin();
        $trajets = $this->trajetModel->findAll();
        require __DIR__ . '/../Views/admin/trajets.php';
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
