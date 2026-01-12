<?php
require_once __DIR__ . '/../Modale/Entity/Commande.php';
require_once __DIR__ . '/../database/Connexion.php';
require_once __DIR__ . '/../Modale/viewModale/CommandJoinStatut.php';

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
    public function AsDeeleted(int $id,int $isdelt)
    {
        $sql = "UPDATE commandes SET
         is_deleted = :isdelete
          WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['isdelete'=>$isdelt,'id'=>$id]);

    }
    public function selectAll():array
    {
        $sql = "SELECT c.*,s.id AS statut,s.etats  FROM commandes c JOIN statutcommandes s ON c.statut_id=s.id WHERE is_deleted = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,CommandeJoinStaut::class);
        return $stmt->fetchAll();       
        
    }
     public function selectAllCmndClient(int $id)
    {
        $sql = "SELECT c.*,s.id AS statut,s.etats  
        FROM commandes c 
        JOIN statutcommandes s ON c.statut_id=s.id 
        WHERE is_deleted = 0 AND c.client_id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,CommandeJoinStaut::class);
        return $stmt->fetchAll();       
        
    }
     public function selectCmndById(int $cmnd_id,int $C_id)
    {
        $sql = "SELECT c.*,s.id AS statut,s.etats  FROM commandes c JOIN statutcommandes s ON c.statut_id=s.id WHERE c.id = :cmnd_id AND c.client_id=:C_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cmnd_id'=>$cmnd_id,'C_id'=>$C_id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,CommandeJoinStaut::class);
        var_dump($stmt->fetch());exit;       
        
    }
     public function selectById(int $cmnd_id)
    {
       
        $sql = "SELECT c.*,s.id AS statut,s.etats FROM commandes c JOIN statutcommandes s ON c.statut_id=s.id WHERE c.id = :cmnd_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cmnd_id'=>$cmnd_id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,CommandeJoinStaut::class);
        return $stmt->fetch();       
        
    }
    public function delete(int $id):void
    {
        $sql = "DELETE FROM commandes WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);        
    }
    
}