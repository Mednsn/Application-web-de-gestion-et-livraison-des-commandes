<?php
require_once __DIR__ . '/../database/Connexion.php';
require_once __DIR__ . '/../Modale/Entity/Vehicule.php';


class Vehicule_repository
{
    private PDO $pdo;

    public function __construct()
    {
        $db = new Connexion();
        $this->pdo = $db->getConnexion();
    }

    public function add(Vehicule $vehicule): void
    {
        $sql = "INSERT INTO vehicles (name)
             VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['name' => $vehicule->getName()]);
    }
    public function selectVehiculeByNmae(string $name) 
    {
        $sql = "SELECT * FROM vehicles WHERE name= ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Vehicule::class);
        return $stmt->fetch();       
    }
}
