<?php

require_once __DIR__ . '/../Repository/CommandeRepository.php';
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Entity/StatutCommande.php';
require_once __DIR__ . '/../database/Connexion.php';



class StatutRapository
{
    private PDO $pdo;

    public function __construct()
    {
        $db = new Connexion();
        $this->pdo = $db->getConnexion();
    }
     public function add(StatutCommande $statut): void
    {
        $sql = "INSERT INTO statutcommandes (etats, libelle)
             VALUES (:etats, :libelle)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['etats' => $statut->getEtats(),'libelle' => $statut->getLibelle()]);
    }
    public function selectStatuByEtats(string $etats): ?StatutCommande
    {
        $sql = "SELECT * FROM statutcommandes WHERE etats= ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$etats]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row){
            return NULL;
        }else{
            return new StatutCommande($row['etats'],$row['libelle'],$row['id']);
        }
    }


}


