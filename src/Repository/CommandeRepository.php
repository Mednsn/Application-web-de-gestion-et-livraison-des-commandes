<?php
require_once __DIR__ . '/../Entity/Commande.php';
require_once __DIR__ . '/../database/Connexion.php';


class CommandeRepository
{
    private PDO $pdo;


    public function __construct()
    {
        $db = new Connexion();
        $this->pdo = $db->getConnexion();
    }
    public function add(Commande $commande):void
    {
        $sql = "INSERT INTO commandes (description, adress_depart, adress_livraison,client_id,statut_id)
        VALUES(:descrip,:ad_dep,:ad_liv,:cl_id,:stt_id)";
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute([
            'descrip'=>$commande->getDescription(),
            'ad_dep'=>$commande->getAdressDepart(),
            'ad_liv'=>$commande->getAdressLivraison(),
            'cl_id'=>$commande->getClient()->getId(),
            'stt_id'=>$commande->getStatus()->getId()
        ]);
    }
    public function update(int $id,Commande $cmd)
    {
        $sql = "UPDATE commandes SET
         description = :discrpt,
         adress_depart = :ad_dep,
         adress_livraison = :ad_liv
          WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['discrpt'=>$cmd->getDescription(),'ad_dep'=>$cmd->getAdressDepart(),'ad_liv'=>$cmd->getAdressLivraison(),'id'=>$id]);

    }
    public function AsDeeleted(int $id,int $isdelt=1)
    {
        $sql = "UPDATE commandes SET
         is_deleted = :isdelete
          WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['isdelete'=>$isdelt,'id'=>$id]);

    }
    public function selectAll():array
    {
        $sql = "SELECT c.*,s.id AS status,s.etats FROM commandes c JOIN statutcommandes s ON c.statut_id=s.id WHERE is_deleted = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
    }
    public function delete(int $id):void
    {
        $sql = "DELETE FROM commandes WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);        
    }
    
}