<?php

/**
 * Modèle Utilisateur
 *
 * Gère les opérations en base de données pour les utilisateurs.
 * Pas de création/modification/suppression (données RH importées).
 *
 * @package TouchePasAuKlaxon
 */
class Utilisateur
{
    /** @var PDO Connexion à la base de données */
    private PDO $db;

    /**
     * Constructeur - initialise la connexion BDD
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Recherche un utilisateur par son adresse email
     *
     * @param string $email L'adresse email de l'utilisateur
     * @return array|false Les données de l'utilisateur ou false
     */
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM utilisateur WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Recherche un utilisateur par son identifiant
     *
     * @param int $id L'identifiant de l'utilisateur
     * @return array|false Les données de l'utilisateur ou false
     */
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Récupère la liste de tous les utilisateurs
     *
     * @return array La liste des utilisateurs
     */
    public function findAll(): array
    {
        $stmt = $this->db->query(
            'SELECT id_utilisateur, nom, prenom, email, telephone, role
             FROM utilisateur
             ORDER BY nom, prenom'
        );
        return $stmt->fetchAll();
    }

    /**
     * Vérifie les identifiants de connexion
     *
     * @param string $email    L'adresse email
     * @param string $password Le mot de passe en clair
     * @return array|false Les données utilisateur si valide, false sinon
     */
    public function authenticate(string $email, string $password): array|false
    {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }

        return false;
    }
}
