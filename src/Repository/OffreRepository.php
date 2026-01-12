<?php
require_once __DIR__ . '/../Modale/Entity/Offre.php';
require_once __DIR__ . '/../Modale/viewModale/OffresJoinCommand.php';
require_once __DIR__ . '/../Modale/viewModale/UserJoinOffreJoinRole.php';
require_once __DIR__ . '/../database/Connexion.php';



class OffreRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $db = new Connexion();
        $this->pdo = $db->getConnexion();
    }

    public function add(Offre $offre): void
    {
        // print_r($offre);exit;
        $sql = "INSERT INTO offers (prix,duree_estimee,options,vehicle_id , livreur_id, commande_id)VALUES(?,?,?,?,?,?) ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$offre->getPrix(), $offre->getDureeEstimee(), $offre->getOption(), $offre->getVehicule()->getId(), $offre->getLivreur()->getId(), $offre->getCommande()->getId()]);
    }
    public function selectAll()
    {
        $sql = "SELECT * FROM offers ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Offre::class);
        return $stmt->fetchAll();
    }
    public function selectAllByOffre(int $id):array

    {
        $sql = "SELECT o.*,c.description,c.adress_depart,c.adress_livraison,c.date_creation AS commande_date_creation,
        c.statut_id, c.is_deleted,count(o.id) AS count
        FROM offers o 
        JOIN commandes c ON o.commande_id = c.id 
        WHERE c.id = ? ORDER BY o.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, OffresJoinCommand::class);
        $result = $stmt->fetchAll();
        return $result ?: null;
    }
    public function selectLivreurOffresByid(int $id)
    {
        $sql = "SELECT o.id,o.prix,o.duree_estimee,o.is_accepted,v.name AS vehicule,u.name AS username,u.id AS id_user,u.email
        FROM offers o 
        JOIN users u ON o.livreur_id = u.id 
        JOIN vehicles v ON v.id=o.vehicle_id
        WHERE u.id = ? LIMIT 1 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, UserJoinOffreJoinRole::class);
        return $stmt->fetch();
    }
    public function update(int $id, Offre $offre): void
    {
        $sql = "UPDATE offers SET prix = ?, duree_estimee = ?,option = ?,vehicle_id = :vehi,livreur_id = :liv_id ,commande_id = :cmnd_id WHERE id = ?) ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$offre->getprix(), $offre->getDureeEstimee(), $offre->getOption()], 'cmnd_id', $id);
    }
    public function delete(int $id): void
    {
        $sql = "DELETE FROM offers WHERE id = ? ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
