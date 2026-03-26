-- ============================================================
-- TOUCHE PAS AU KLAXON - Script d'alimentation (jeu d'essais)
-- ============================================================
-- Mots de passe : hachés avec password_hash() de PHP (bcrypt)
-- Mot de passe par défaut pour tous : "password123"
-- Compte admin : admin@klaxon.fr / admin123
-- ============================================================

USE touche_pas_au_klaxon;

-- ------------------------------------------------------------
-- Insertion des agences (données fournies dans agences.txt)
-- ------------------------------------------------------------
INSERT INTO agence (ville) VALUES
    ('Paris'),
    ('Lyon'),
    ('Marseille'),
    ('Toulouse'),
    ('Nice'),
    ('Nantes'),
    ('Strasbourg'),
    ('Montpellier'),
    ('Bordeaux'),
    ('Lille'),
    ('Rennes'),
    ('Reims');

-- ------------------------------------------------------------
-- Insertion du compte administrateur
-- Email : admin@klaxon.fr | Mot de passe : admin123
-- Hash bcrypt généré via password_hash('admin123', PASSWORD_BCRYPT)
-- ------------------------------------------------------------
INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, role) VALUES
    ('Admin', 'Super', 'admin@klaxon.fr',
     '$2y$10$YE3kPVOIBQHjKNGmGJzVOeZZ9F1qJ5R8HxKqV3mWpN4a0VdDrDmWG',
     '0600000000', 'administrateur');

-- ------------------------------------------------------------
-- Insertion des utilisateurs (données fournies dans users.txt)
-- Mot de passe par défaut : password123
-- Hash bcrypt généré via password_hash('password123', PASSWORD_BCRYPT)
-- ------------------------------------------------------------
INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, role) VALUES
    ('Martin',    'Alexandre', 'alexandre.martin@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0612345678', 'utilisateur'),
    ('Dubois',    'Sophie',    'sophie.dubois@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0698765432', 'utilisateur'),
    ('Bernard',   'Julien',    'julien.bernard@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0622446688', 'utilisateur'),
    ('Moreau',    'Camille',   'camille.moreau@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0611223344', 'utilisateur'),
    ('Lefèvre',   'Lucie',     'lucie.lefevre@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0777889900', 'utilisateur'),
    ('Leroy',     'Thomas',    'thomas.leroy@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0655443322', 'utilisateur'),
    ('Roux',      'Chloé',     'chloe.roux@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0633221199', 'utilisateur'),
    ('Petit',     'Maxime',    'maxime.petit@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0766778899', 'utilisateur'),
    ('Garnier',   'Laura',     'laura.garnier@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0688776655', 'utilisateur'),
    ('Dupuis',    'Antoine',   'antoine.dupuis@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0744556677', 'utilisateur'),
    ('Lefebvre',  'Emma',      'emma.lefebvre@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0699887766', 'utilisateur'),
    ('Fontaine',  'Louis',     'louis.fontaine@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0655667788', 'utilisateur'),
    ('Chevalier', 'Clara',     'clara.chevalier@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0788990011', 'utilisateur'),
    ('Robin',     'Nicolas',   'nicolas.robin@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0644332211', 'utilisateur'),
    ('Gauthier',  'Marine',    'marine.gauthier@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0677889922', 'utilisateur'),
    ('Fournier',  'Pierre',    'pierre.fournier@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0722334455', 'utilisateur'),
    ('Girard',    'Sarah',     'sarah.girard@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0688665544', 'utilisateur'),
    ('Lambert',   'Hugo',      'hugo.lambert@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0611223366', 'utilisateur'),
    ('Masson',    'Julie',     'julie.masson@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0733445566', 'utilisateur'),
    ('Henry',     'Arthur',    'arthur.henry@email.fr',
     '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQd1IC1VkFo2PzNsVZtSZn8h3J6OGy',
     '0666554433', 'utilisateur');

-- ------------------------------------------------------------
-- Insertion de trajets de test (jeu d'essais)
-- Trajets futurs avec des places disponibles variées
-- ------------------------------------------------------------
INSERT INTO trajet (id_utilisateur, id_agence_depart, id_agence_arrivee, date_heure_depart, date_heure_arrivee, nb_places_total, nb_places_disponibles) VALUES
    -- Alexandre Martin : Paris → Lyon
    (2, 1, 2, '2026-04-10 08:00:00', '2026-04-10 12:00:00', 4, 3),
    -- Sophie Dubois : Marseille → Toulouse
    (3, 3, 4, '2026-04-12 09:30:00', '2026-04-12 13:00:00', 3, 2),
    -- Julien Bernard : Lyon → Nice
    (4, 2, 5, '2026-04-14 07:00:00', '2026-04-14 11:30:00', 5, 4),
    -- Camille Moreau : Nantes → Bordeaux
    (5, 6, 9, '2026-04-15 10:00:00', '2026-04-15 13:30:00', 3, 1),
    -- Thomas Leroy : Lille → Paris
    (7, 10, 1, '2026-04-16 06:30:00', '2026-04-16 10:00:00', 4, 4),
    -- Chloé Roux : Strasbourg → Reims
    (8, 7, 12, '2026-04-18 08:00:00', '2026-04-18 12:00:00', 2, 2),
    -- Laura Garnier : Rennes → Nantes
    (10, 11, 6, '2026-04-20 14:00:00', '2026-04-20 15:30:00', 4, 3),
    -- Nicolas Robin : Bordeaux → Montpellier
    (15, 9, 8, '2026-04-22 07:30:00', '2026-04-22 13:00:00', 3, 0),
    -- Marine Gauthier : Paris → Strasbourg
    (16, 1, 7, '2026-04-25 09:00:00', '2026-04-25 14:00:00', 5, 5),
    -- Hugo Lambert : Toulouse → Lyon
    (19, 4, 2, '2026-04-28 11:00:00', '2026-04-28 15:30:00', 4, 2);