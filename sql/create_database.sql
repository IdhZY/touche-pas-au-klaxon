-- ============================================================
-- TOUCHE PAS AU KLAXON - Script de création de la base de données
-- ============================================================

DROP DATABASE IF EXISTS touche_pas_au_klaxon;
CREATE DATABASE touche_pas_au_klaxon
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE touche_pas_au_klaxon;

-- ------------------------------------------------------------
-- Table : utilisateur
-- Données importées depuis le système RH (pas de CRUD prévu)
-- ------------------------------------------------------------
CREATE TABLE utilisateur (
    id_utilisateur  INT             AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(100)    NOT NULL,
    prenom          VARCHAR(100)    NOT NULL,
    email           VARCHAR(255)    NOT NULL UNIQUE,
    mot_de_passe    VARCHAR(255)    NOT NULL,
    telephone       VARCHAR(20)     NOT NULL,
    role            ENUM('utilisateur', 'administrateur') NOT NULL DEFAULT 'utilisateur'
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Table : agence
-- Gérée uniquement par l'administrateur (CRUD admin)
-- ------------------------------------------------------------
CREATE TABLE agence (
    id_agence   INT             AUTO_INCREMENT PRIMARY KEY,
    ville       VARCHAR(100)    NOT NULL UNIQUE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Table : trajet
-- Deux clés étrangères vers agence (départ et arrivée)
-- Une clé étrangère vers utilisateur (celui qui propose)
-- ------------------------------------------------------------
CREATE TABLE trajet (
    id_trajet               INT         AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur          INT         NOT NULL,
    id_agence_depart        INT         NOT NULL,
    id_agence_arrivee       INT         NOT NULL,
    date_heure_depart       DATETIME    NOT NULL,
    date_heure_arrivee      DATETIME    NOT NULL,
    nb_places_total         INT         NOT NULL,
    nb_places_disponibles   INT         NOT NULL,

    -- Contraintes de clés étrangères
    CONSTRAINT fk_trajet_utilisateur
        FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE,

    CONSTRAINT fk_trajet_agence_depart
        FOREIGN KEY (id_agence_depart) REFERENCES agence(id_agence)
        ON DELETE RESTRICT,

    CONSTRAINT fk_trajet_agence_arrivee
        FOREIGN KEY (id_agence_arrivee) REFERENCES agence(id_agence)
        ON DELETE RESTRICT,

    -- Contraintes de cohérence
    CONSTRAINT chk_agences_differentes
        CHECK (id_agence_depart != id_agence_arrivee),

    CONSTRAINT chk_dates_coherentes
        CHECK (date_heure_arrivee > date_heure_depart),

    CONSTRAINT chk_places_positives
        CHECK (nb_places_total > 0),

    CONSTRAINT chk_places_disponibles
        CHECK (nb_places_disponibles >= 0 AND nb_places_disponibles <= nb_places_total)

) ENGINE=InnoDB;