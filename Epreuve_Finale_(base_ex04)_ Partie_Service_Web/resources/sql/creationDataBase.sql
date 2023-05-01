
-- Créer la base de données gestion_contacts 
CREATE DATABASE IF NOT EXISTS gestion_contacts;

-- Sélectionner la base de données gestion_contacts
USE gestion_contacts;

-- Créer la table usager
CREATE TABLE usager (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codeusager VARCHAR(255) NOT NULL,
    motdepasse VARCHAR(255) NOT NULL,
    cle VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL
);

-- Insérer des données dans la table usager
INSERT INTO usager (codeusager, motdepasse, cle)
VALUES ('user1', 'password1', '$2y$10$aBhUrdMIfZHDX4x5tJLkqe0alq5kbnpFPPtlgjmkxqUWuoopPvBXm'),
       ('user2', 'password2', 'apikey2'),
       ('user3', 'password3', 'apikey3'),
       ('user4', 'password4', 'apikey4'),
       ('user5', 'password5', 'apikey5');

-- Insérer des données dans la table contact
INSERT INTO contact (nom, prenom, email, message)
VALUES ('DiCaprio', 'Leonardo', 'leonardo.dicaprio@example.com', 'Bonjour, je suis intéressé par vos produits.'),
       ('Streep', 'Meryl', 'meryl.streep@example.com', 'Pouvez-vous me donner des informations sur les tarifs ?'),
       ('Pitt', 'Brad', 'brad.pitt@example.com', 'Je souhaiterais prendre rendez-vous pour une démonstration.'),
       ('Roberts', 'Julia', 'julia.roberts@example.com', 'Avez-vous des offres promotionnelles en ce moment ?'),
       ('Hanks', 'Tom', 'tom.hanks@example.com', 'Quels sont vos délais de livraison ?'),
       ('Johansson', 'Scarlett', 'scarlett.johansson@example.com', 'Pourriez-vous me transmettre la documentation technique ?'),
       ('Damon', 'Matt', 'matt.damon@example.com', 'Je voudrais connaître les conditions de garantie.'),
       ('Portman', 'Natalie', 'natalie.portman@example.com', 'Existe-t-il des formations pour vos produits ?'),
       ('Washington', 'Denzel', 'denzel.washington@example.com', 'Avez-vous un réseau de revendeurs ?'),
       ('Theron', 'Charlize', 'charlize.theron@example.com', 'Je voudrais passer une commande, comment procéder ?');