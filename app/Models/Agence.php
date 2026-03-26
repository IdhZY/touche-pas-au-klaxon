<?php

/**
 * Modèle Agence
 *
 * Gère les opérations CRUD pour les agences (villes).
 * Seul l'administrateur peut créer, modifier et supprimer.
 *
 * @package TouchePasAuKlaxon
 */
class Agence
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
     * Récupère toutes les agences triées par ville
     *
     * @return array La liste des agences
     */
    public function findAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM agence ORDER BY ville');
        return $stmt->fetchAll();
    }

    /**
     * Recherche une agence par son identifiant
     *
     * @param int $id L'identifiant de l'agence
     * @return array|false Les données de l'agence ou false
     */
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM agence WHERE id_agence = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Crée une nouvelle agence
     *
     * @param string $ville Le nom de la ville
     * @return bool True si la création a réussi
     */
    public function create(string $ville): bool
    {
        $stmt = $this->db->prepare('INSERT INTO agence (ville) VALUES (:ville)');
        return $stmt->execute(['ville' => $ville]);
    }

    /**
     * Met à jour le nom d'une agence
     *
     * @param int    $id    L'identifiant de l'agence
     * @param string $ville Le nouveau nom de la ville
     * @return bool True si la mise à jour a réussi
     */
    public function update(int $id, string $ville): bool
    {
        $stmt = $this->db->prepare('UPDATE agence SET ville = :ville WHERE id_agence = :id');
        return $stmt->execute(['ville' => $ville, 'id' => $id]);
    }

    /**
     * Supprime une agence
     *
     * La suppression échouera si des trajets sont liés (RESTRICT).
     *
     * @param int $id L'identifiant de l'agence
     * @return bool True si la suppression a réussi
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM agence WHERE id_agence = :id');
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Vérifie si une ville existe déjà
     *
     * @param string   $ville Le nom de la ville
     * @param int|null $excludeId ID à exclure (pour la modification)
     * @return bool True si la ville existe déjà
     */
    public function existsByVille(string $ville, ?int $excludeId = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM agence WHERE ville = :ville';
        $params = ['ville' => $ville];

        if ($excludeId !== null) {
            $sql .= ' AND id_agence != :id';
            $params['id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn() > 0;
    }
}
