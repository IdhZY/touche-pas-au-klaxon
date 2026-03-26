<?php

/**
 * Modèle Trajet
 *
 * Gère les opérations CRUD pour les trajets de covoiturage.
 * Les employés peuvent créer et modifier leurs propres trajets.
 * L'administrateur peut tout supprimer.
 *
 * @package TouchePasAuKlaxon
 */
class Trajet
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
     * Récupère les trajets disponibles (places > 0, date future)
     *
     * Triés par date de départ croissante.
     * Utilisé pour la page d'accueil.
     *
     * @return array La liste des trajets disponibles
     */
    public function findAvailable(): array
    {
        $stmt = $this->db->query(
            'SELECT t.*, 
                    ad.ville AS ville_depart,
                    aa.ville AS ville_arrivee,
                    u.nom, u.prenom, u.email, u.telephone
             FROM trajet t
             JOIN agence ad ON t.id_agence_depart = ad.id_agence
             JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
             JOIN utilisateur u ON t.id_utilisateur = u.id_utilisateur
             WHERE t.nb_places_disponibles > 0
               AND t.date_heure_depart > NOW()
             ORDER BY t.date_heure_depart ASC'
        );
        return $stmt->fetchAll();
    }

    /**
     * Récupère tous les trajets (pour l'admin)
     *
     * @return array La liste de tous les trajets
     */
    public function findAll(): array
    {
        $stmt = $this->db->query(
            'SELECT t.*, 
                    ad.ville AS ville_depart,
                    aa.ville AS ville_arrivee,
                    u.nom, u.prenom, u.email, u.telephone
             FROM trajet t
             JOIN agence ad ON t.id_agence_depart = ad.id_agence
             JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
             JOIN utilisateur u ON t.id_utilisateur = u.id_utilisateur
             ORDER BY t.date_heure_depart ASC'
        );
        return $stmt->fetchAll();
    }

    /**
     * Recherche un trajet par son identifiant
     *
     * @param int $id L'identifiant du trajet
     * @return array|false Les données du trajet ou false
     */
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT t.*, 
                    ad.ville AS ville_depart,
                    aa.ville AS ville_arrivee,
                    u.nom, u.prenom, u.email, u.telephone
             FROM trajet t
             JOIN agence ad ON t.id_agence_depart = ad.id_agence
             JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
             JOIN utilisateur u ON t.id_utilisateur = u.id_utilisateur
             WHERE t.id_trajet = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Crée un nouveau trajet
     *
     * @param array $data Les données du trajet
     * @return bool True si la création a réussi
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO trajet 
                (id_utilisateur, id_agence_depart, id_agence_arrivee,
                 date_heure_depart, date_heure_arrivee,
                 nb_places_total, nb_places_disponibles)
             VALUES 
                (:id_utilisateur, :id_agence_depart, :id_agence_arrivee,
                 :date_heure_depart, :date_heure_arrivee,
                 :nb_places_total, :nb_places_disponibles)'
        );

        return $stmt->execute([
            'id_utilisateur'      => $data['id_utilisateur'],
            'id_agence_depart'    => $data['id_agence_depart'],
            'id_agence_arrivee'   => $data['id_agence_arrivee'],
            'date_heure_depart'   => $data['date_heure_depart'],
            'date_heure_arrivee'  => $data['date_heure_arrivee'],
            'nb_places_total'     => $data['nb_places_total'],
            'nb_places_disponibles' => $data['nb_places_disponibles'],
        ]);
    }

    /**
     * Met à jour un trajet existant
     *
     * @param int   $id   L'identifiant du trajet
     * @param array $data Les nouvelles données
     * @return bool True si la mise à jour a réussi
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE trajet SET
                id_agence_depart      = :id_agence_depart,
                id_agence_arrivee     = :id_agence_arrivee,
                date_heure_depart     = :date_heure_depart,
                date_heure_arrivee    = :date_heure_arrivee,
                nb_places_total       = :nb_places_total,
                nb_places_disponibles = :nb_places_disponibles
             WHERE id_trajet = :id'
        );

        return $stmt->execute([
            'id_agence_depart'      => $data['id_agence_depart'],
            'id_agence_arrivee'     => $data['id_agence_arrivee'],
            'date_heure_depart'     => $data['date_heure_depart'],
            'date_heure_arrivee'    => $data['date_heure_arrivee'],
            'nb_places_total'       => $data['nb_places_total'],
            'nb_places_disponibles' => $data['nb_places_disponibles'],
            'id'                    => $id,
        ]);
    }

    /**
     * Supprime un trajet
     *
     * @param int $id L'identifiant du trajet
     * @return bool True si la suppression a réussi
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM trajet WHERE id_trajet = :id');
        return $stmt->execute(['id' => $id]);
    }
}
