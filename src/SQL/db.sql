CREATE DATABASE gestion_commandes;
USE gestion_commandes;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE

)ENGINE=INNODB;

CREATE TABLE users (
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200),
    email VARCHAR(200) NOT NULL UNIQUE,
    password VARCHAR(200) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id)

)ENGINE=INNODB;

CREATE TABLE statutCommandes(
    id int AUTO_INCREMENT PRIMARY KEY,
    etats VARCHAR(200),
    libelle VARCHAR(200)

)ENGINE=INNODB;

CREATE TABLE commandes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    adress_depart VARCHAR(200),
    adress_livraison VARCHAR(200),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP NULL,
    client_id INT NOT NULL,
    FOREIGN KEY (client_id) REFERENCES users(id),
    statut_id INT NOT NULL,
    FOREIGN KEY (statut_id) REFERENCES statutCommandes(id),
    is_deleted BOOLEAN DEFAULT FALSE

)ENGINE=INNODB;

CREATE TABLE vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
)ENGINE=INNODB;

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)ENGINE=INNODB;

CREATE TABLE offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prix DECIMAL(10,2) NOT NULL,
    duree_estimee VARCHAR(50),
    options VARCHAR(100),
    is_accepted BOOLEAN DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    vehicle_id INT NOT NULL,
    livreur_id INT NOT NULL,
    commande_id INT NOT NULL,
    FOREIGN KEY (client_id) REFERENCES commandes(id),
    FOREIGN KEY (livreur_id) REFERENCES users(id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id)
)ENGINE=INNODB;
