<?php
require_once __DIR__ . '/../Entity/Offre.php';
require_once __DIR__ . '/../database/Connexion.php';


class OffreRepository
{
private PDO $pdo;

public function __construct()
{
    $db = new Connexion();
    $this->pdo = $db->getConnexion();
}

public function add(Offre $offre):void
{
    $sql = "INSERT INTO offres (prix,duree_estimee,option)VALUES(?,?,?) ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$offre->getprix(),$offre->getDureeEstimee(),$offre->getOption()]);
}
public function selectAll():array
{
    $sql = "SELECT *FROM offres ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_CLASS);
}
public function update(int $id, Offre $offre):void
{
    $sql = "UPDATE offres SET prix = ?, duree_estimee = ?,option = ?,vehicle_id = :vehi,livreur_id = :liv_id ,commande_id = :cmnd_id WHERE id = ?) ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$offre->getprix(),$offre->getDureeEstimee(),$offre->getOption()],'cmnd_id',$id);
}
public function delete(int $id):void
{
    $sql = "DELETE FROM offres WHERE id = ? ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);
}







}

?>