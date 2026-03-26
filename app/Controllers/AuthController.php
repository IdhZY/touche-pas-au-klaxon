<?php

/**
 * Contrôleur d'authentification
 *
 * Gère la connexion et la déconnexion des utilisateurs.
 *
 * @package TouchePasAuKlaxon
 */
class AuthController
{
    /** @var Utilisateur Le modèle utilisateur */
    private Utilisateur $utilisateurModel;

    /**
     * Constructeur - initialise le modèle
     */
    public function __construct()
    {
        $this->utilisateurModel = new Utilisateur();
    }

    /**
     * Affiche le formulaire de connexion
     *
     * @return void
     */
    public function login(): void
    {
        // Si déjà connecté, rediriger vers l'accueil
        if (isset($_SESSION['user'])) {
            header('Location: /trajet');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Veuillez remplir tous les champs.';
            } else {
                $user = $this->utilisateurModel->authenticate($email, $password);

                if ($user) {
                    // Stocker les infos en session (sans le mot de passe)
                    unset($user['mot_de_passe']);
                    $_SESSION['user'] = $user;

                    // Rediriger admin vers dashboard, utilisateur vers accueil
                    if ($user['role'] === 'administrateur') {
                        header('Location: /admin/dashboard');
                    } else {
                        header('Location: /trajet');
                    }
                    exit;
                }

                $error = 'Email ou mot de passe incorrect.';
            }
        }

        require __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * Déconnecte l'utilisateur
     *
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: /trajet');
        exit;
    }
}
