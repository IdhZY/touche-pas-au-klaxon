<?php

use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires pour le modèle Agence
 *
 * Couvre les opérations d'écriture en base de données :
 * création, modification et suppression d'agences.
 *
 * @package TouchePasAuKlaxon\Tests
 */
class AgenceTest extends TestCase
{
    /** @var Agence Le modèle agence */
    private Agence $agenceModel;

    /** @var PDO La connexion BDD pour le nettoyage */
    private PDO $db;

    /**
     * Initialisation avant chaque test
     */
    protected function setUp(): void
    {
        require_once __DIR__ . '/../app/Models/Database.php';
        require_once __DIR__ . '/../app/Models/Agence.php';

        $this->agenceModel = new Agence();
        $this->db = Database::getInstance();
    }

    /**
     * Teste la création d'une agence
     *
     * @return void
     */
    public function testCreateAgence(): void
    {
        $result = $this->agenceModel->create('TestVille');
        $this->assertTrue($result);

        // Vérifier l'existence
        $exists = $this->agenceModel->existsByVille('TestVille');
        $this->assertTrue($exists);

        // Nettoyage
        $id = (int) $this->db->lastInsertId();
        $this->agenceModel->delete($id);
    }

    /**
     * Teste la modification d'une agence
     *
     * @return void
     */
    public function testUpdateAgence(): void
    {
        // Créer une agence de test
        $this->agenceModel->create('VilleAvant');
        $id = (int) $this->db->lastInsertId();

        // Modifier
        $result = $this->agenceModel->update($id, 'VilleAprès');
        $this->assertTrue($result);

        // Vérifier
        $agence = $this->agenceModel->findById($id);
        $this->assertNotFalse($agence);
        $this->assertEquals('VilleAprès', $agence['ville']);

        // Nettoyage
        $this->agenceModel->delete($id);
    }

    /**
     * Teste la suppression d'une agence
     *
     * @return void
     */
    public function testDeleteAgence(): void
    {
        // Créer une agence de test
        $this->agenceModel->create('VilleSuppr');
        $id = (int) $this->db->lastInsertId();

        // Supprimer
        $result = $this->agenceModel->delete($id);
        $this->assertTrue($result);

        // Vérifier
        $agence = $this->agenceModel->findById($id);
        $this->assertFalse($agence);
    }

    /**
     * Teste la détection de doublons
     *
     * @return void
     */
    public function testExistsByVille(): void
    {
        $this->agenceModel->create('VilleUnique');
        $id = (int) $this->db->lastInsertId();

        // Doit détecter le doublon
        $this->assertTrue($this->agenceModel->existsByVille('VilleUnique'));

        // Ne doit pas détecter si on exclut l'ID courant (cas modification)
        $this->assertFalse($this->agenceModel->existsByVille('VilleUnique', $id));

        // Nettoyage
        $this->agenceModel->delete($id);
    }
}