<?php

use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires pour le modèle Trajet
 *
 * Couvre les opérations d'écriture en base de données :
 * création, modification et suppression de trajets.
 *
 * @package TouchePasAuKlaxon\Tests
 */
class TrajetTest extends TestCase
{
    /** @var Trajet Le modèle trajet */
    private Trajet $trajetModel;

    /** @var PDO La connexion BDD pour le nettoyage */
    private PDO $db;

    /**
     * Initialisation avant chaque test
     */
    protected function setUp(): void
    {
        require_once __DIR__ . '/../app/Models/Database.php';
        require_once __DIR__ . '/../app/Models/Trajet.php';

        $this->trajetModel = new Trajet();
        $this->db = Database::getInstance();
    }

    /**
     * Teste la création d'un trajet valide
     *
     * @return void
     */
    public function testCreateTrajet(): void
    {
        $data = [
            'id_utilisateur'      => 2,
            'id_agence_depart'    => 1,
            'id_agence_arrivee'   => 2,
            'date_heure_depart'   => '2026-12-01 08:00:00',
            'date_heure_arrivee'  => '2026-12-01 12:00:00',
            'nb_places_total'     => 4,
            'nb_places_disponibles' => 4,
        ];

        $result = $this->trajetModel->create($data);
        $this->assertTrue($result);

        // Nettoyage
        $lastId = $this->db->lastInsertId();
        $this->trajetModel->delete((int) $lastId);
    }

    /**
     * Teste la modification d'un trajet
     *
     * @return void
     */
    public function testUpdateTrajet(): void
    {
        // Créer un trajet de test
        $data = [
            'id_utilisateur'      => 2,
            'id_agence_depart'    => 1,
            'id_agence_arrivee'   => 3,
            'date_heure_depart'   => '2026-12-10 09:00:00',
            'date_heure_arrivee'  => '2026-12-10 14:00:00',
            'nb_places_total'     => 3,
            'nb_places_disponibles' => 3,
        ];
        $this->trajetModel->create($data);
        $id = (int) $this->db->lastInsertId();

        // Modifier le trajet
        $updateData = [
            'id_agence_depart'      => 1,
            'id_agence_arrivee'     => 4,
            'date_heure_depart'     => '2026-12-10 10:00:00',
            'date_heure_arrivee'    => '2026-12-10 15:00:00',
            'nb_places_total'       => 5,
            'nb_places_disponibles' => 4,
        ];
        $result = $this->trajetModel->update($id, $updateData);
        $this->assertTrue($result);

        // Vérifier les modifications
        $trajet = $this->trajetModel->findById($id);
        $this->assertNotFalse($trajet);
        $this->assertEquals(4, $trajet['id_agence_arrivee']);
        $this->assertEquals(5, $trajet['nb_places_total']);
        $this->assertEquals(4, $trajet['nb_places_disponibles']);

        // Nettoyage
        $this->trajetModel->delete($id);
    }

    /**
     * Teste la suppression d'un trajet
     *
     * @return void
     */
    public function testDeleteTrajet(): void
    {
        // Créer un trajet de test
        $data = [
            'id_utilisateur'      => 2,
            'id_agence_depart'    => 2,
            'id_agence_arrivee'   => 5,
            'date_heure_depart'   => '2026-12-20 07:00:00',
            'date_heure_arrivee'  => '2026-12-20 12:00:00',
            'nb_places_total'     => 2,
            'nb_places_disponibles' => 2,
        ];
        $this->trajetModel->create($data);
        $id = (int) $this->db->lastInsertId();

        // Supprimer
        $result = $this->trajetModel->delete($id);
        $this->assertTrue($result);

        // Vérifier la suppression
        $trajet = $this->trajetModel->findById($id);
        $this->assertFalse($trajet);
    }

    /**
     * Teste que findAvailable ne retourne pas les trajets complets
     *
     * @return void
     */
    public function testFindAvailableExcludesFullTrips(): void
    {
        // Créer un trajet sans places disponibles
        $data = [
            'id_utilisateur'      => 2,
            'id_agence_depart'    => 1,
            'id_agence_arrivee'   => 6,
            'date_heure_depart'   => '2026-12-25 08:00:00',
            'date_heure_arrivee'  => '2026-12-25 12:00:00',
            'nb_places_total'     => 3,
            'nb_places_disponibles' => 0,
        ];
        $this->trajetModel->create($data);
        $id = (int) $this->db->lastInsertId();

        // Vérifier qu'il n'apparaît pas dans les disponibles
        $available = $this->trajetModel->findAvailable();
        $ids = array_column($available, 'id_trajet');
        $this->assertNotContains($id, $ids);

        // Nettoyage
        $this->trajetModel->delete($id);
    }
}