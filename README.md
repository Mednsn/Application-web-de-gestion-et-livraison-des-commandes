# 📦 Application Web de Livraison de Commandes

## 📖 Description du projet

Cette application web est développée dans le cadre d’un projet full-stack.  
Elle permet de mettre en relation **des clients**, **des livreurs** et **un administrateur** afin de gérer le **cycle de vie complet d’une commande de livraison**.

L’application couvre toutes les étapes :
- création d’une commande,
- réception et gestion des offres de livraison,
- suivi de l’état de la commande,
- livraison et validation finale.

Elle intègre également un **système de notifications**, une **gestion des rôles** et un **tableau de supervision administrateur**.

---

## 👥 Rôles de l’application

- 👤 **Client**
- 🚚 **Livreur**
- 🛠️ **Administrateur**

Chaque rôle dispose de fonctionnalités spécifiques et d’un accès sécurisé.

---

## 🔐 Authentification & Sécurité

- Inscription et connexion des utilisateurs
- Gestion des rôles (Client / Livreur / Admin)
- Contrôle d’accès selon le rôle
- Sessions sécurisées

---

## ⚙️ Fonctionnalités principales (MVP)

### 👤 Client

#### Gestion des commandes
- Créer une commande
- Modifier une commande (avant acceptation)
- Annuler une commande
- Supprimer une commande (soft delete)
- Consulter ses commandes
- Voir le détail d’une commande

#### Cycle de vie d’une commande
- Créée
- En attente d’offres
- En cours de traitement
- Expédiée
- Terminée
- Annulée

#### Offres & notifications
- Recevoir une notification lors de la réception d’une offre
- Consulter les offres reçues
- Accepter une offre
- Valider la livraison finale

---

### 🚚 Livreur

#### Consultation des commandes
- Voir les commandes disponibles
- Consulter le détail d’une commande
- Voir les offres des autres livreurs (sans les prix)

#### Offres de livraison
- Envoyer une offre avec :
  - prix proposé
  - durée estimée
  - type de véhicule
  - options (express, fragile, etc.)

#### Suivi & notifications
- Recevoir une notification lorsqu’une offre est acceptée
- Passer une commande à l’état **Expédiée**

---

### 🛠️ Administrateur

#### Gestion des utilisateurs
- Lister les utilisateurs
- Activer / désactiver un compte
- Attribuer ou modifier un rôle

#### Supervision & statistiques
- Nombre total de commandes
- Commandes terminées / annulées
- Nombre d’offres envoyées
- Activité des livreurs

---

## 🔔 Système de notifications

- Notifications client :
  - réception d’une offre
  - commande en cours de traitement
- Notifications livreur :
  - offre acceptée
  - commande prise en charge

---

## ⭐ Fonctionnalités bonus (facultatives)

### Bonus 1 – Intermédiaire
- Historique des notifications
- Filtrage des commandes
- Système de notation des livreurs

### Bonus 2 – Avancé
- Chat client ↔ livreur
- Géolocalisation (simulation)
- Export des statistiques en CSV

---

## 🧱 Entités métier

- Utilisateur
- Rôle
- Commande
- Offre
- Notification
- Véhicule

---

## 🛠️ Technologies utilisées

- **Backend**
  - PHP 8+ (Programmation Orientée Objet)
  - PDO
  - MySQL ou PostgreSQL

- **Frontend**
  - HTML5 / CSS3
  - Bootstrap 5 ou Tailwind CSS
  - JavaScript ES6+

---

## 📁 Architecture du projet:

src/
│
├── Authents/
│   ├── images          
│   ├── js            
│   |── login.html    
|   └── signeUp.html           
│
├── controller/
│   ├── autentification.php             
│   ├── crudController.php          
│
├── database/
│   └── connexion.php              
│
├── repository/
│   ├── Userrepository.php
│   ├── roleRepository.php
│   ├── Commanderepository.php
│   ├── Offrerepository.php
│   └── Notificationrepository.php
│
├── Entity/
│   ├── User.php
│   ├── Role.php
│   ├── Commande.php
│   ├── Offre.php
│   ├── Notification.php
│   └── Vehicule.php
│
├── service/
│   ├── Userservice.php
│   ├── Roleservice.php
│   ├── Commandeservice.php
│   ├── Offreservice.php
│   ├── Notificationservice.php
│
├── SQL/
│   ├── db.php 
│
├── view/
│      ├── dashboard-client.php
│      ├── dashboard-admin.php
│      ├── dashboard-livreur.php
│ 
└── README.md


