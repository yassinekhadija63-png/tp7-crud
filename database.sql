-- TP7 : Centre de formation
CREATE DATABASE IF NOT EXISTS tp7_crud
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE tp7_crud;

DROP TABLE IF EXISTS modules;
DROP TABLE IF EXISTS etudiants;
DROP TABLE IF EXISTS formations;

CREATE TABLE formations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intitule VARCHAR(120) NOT NULL,
    duree_mois INT NOT NULL,
    tarif DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE etudiants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(80) NOT NULL,
    prenom VARCHAR(80) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    formation_id INT NOT NULL,
    FOREIGN KEY (formation_id) REFERENCES formations(id)
) ENGINE=InnoDB;

CREATE TABLE modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intitule VARCHAR(120) NOT NULL,
    volume_horaire INT NOT NULL,
    semestre INT NOT NULL,
    formation_id INT NOT NULL,
    FOREIGN KEY (formation_id) REFERENCES formations(id)
) ENGINE=InnoDB;

INSERT INTO formations (intitule, duree_mois, tarif) VALUES
('Développement Web Full Stack', 18, 18500.00),
('Cybersécurité', 24, 22000.00),
('Data Science et IA', 20, 20000.00),
('Réseaux et Systèmes', 12, 14000.00);

INSERT INTO etudiants (nom, prenom, email, formation_id) VALUES
('El Amrani', 'Yassine', 'yassine.elamrani@gmail.com', 1),
('Benali', 'Salma', 'salma.benali@gmail.com', 1),
('Idrissi', 'Omar', 'omar.idrissi@gmail.com', 2),
('Tazi', 'Khadija', 'khadija.tazi@gmail.com', 3),
('Chraibi', 'Anas', 'anas.chraibi@gmail.com', 3),
('Alaoui', 'Imane', 'imane.alaoui@gmail.com', 4);

INSERT INTO modules (intitule, volume_horaire, semestre, formation_id) VALUES
('PHP et MySQL', 80, 2, 1),
('Cryptographie appliquée', 50, 1, 2),
('Machine Learning', 90, 2, 3),
('Administration Linux', 60, 1, 4);
