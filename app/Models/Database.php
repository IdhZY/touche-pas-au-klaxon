<?php

/**
 * Classe Database - Singleton PDO
 *
 * Gère la connexion à la base de données MySQL/MariaDB.
 * Utilise le pattern Singleton pour n'avoir qu'une seule connexion.
 * Réutilisable pour les futurs projets (CE, billetterie, etc.).
 *
 * @package TouchePasAuKlaxon
 */
class Database
{
    /** @var PDO|null Instance unique de la connexion */
    private static ?PDO $instance = null;

    /**
     * Constructeur privé (pattern Singleton)
     */
    private function __construct()
    {
    }

    /**
     * Retourne l'instance unique de la connexion PDO
     *
     * @return PDO La connexion à la base de données
     * @throws PDOException Si la connexion échoue
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/database.php';

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['dbname'],
                $config['charset']
            );

            self::$instance = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }

        return self::$instance;
    }
}
