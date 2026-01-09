<?php
require_once __DIR__ . '/StatutCommande.php';
require_once __DIR__ . '/User.php';

class Commande {
    private ?int $id ;
    private string $description ;
    private string  $adress_depart ;
    private string $adress_livraison ;
    private ?DATETIME $date_creation ;
    private ?DATETIME $date_modification ;
    private User $client;
    private StatutCommande $status;
    private bool $is_deleted ;

public function __construct(string $description ,string  $adress_depart ,
string $adress_livraison,User $client, StatutCommande $status,bool $is_deleted,?DATETIME $date_creation= NULL,
?DATETIME $date_modification = NULL,?int $id=NULL)
{
    $this->description = $description;
    $this->adress_depart = $adress_depart;
    $this->adress_livraison = $adress_livraison;
    $this->date_creation = $date_creation;
    $this->date_modification = $date_modification;
    $this->client = $client;
    $this->status = $status;
    $this->is_deleted = $is_deleted;
    $this->id = $id;
    
} 
public function getId(){
     return $this->id;
}
public function setId($id){
     return $this->id=$id;
}
public function getDescription(){
     return $this->description;
}
public function getAdressDepart(){
     return $this->adress_depart;
}
public function getAdressLivraison(){
     return $this->adress_livraison;
}
public function getDateCreation(){
     return $this->date_creation;
}
public function getDateModification(){
     return $this->date_modification;
}
public function getClient(){
     return $this->client;
}
public function getStatus(){
     return $this->status;
}
public function getIsDelete(){
     return $this->is_deleted;
}
public function setDescription($description){
     return $this->description=$description;
}
public function setAdressDepart($adress_depart){
     return $this->description=$adress_depart;
}
public function setAdressLivraison($adress_livraison){
     return $this->adress_livraison=$adress_livraison;
}
public function setDateCreation($date_creation){
     return $this->date_creation=$date_creation;
}
public function setDateModification($date_modification){
     return $this->date_modification=$date_modification;
}
public function setClient($client){
     return $this->client=$client;
}
public function setStatus($status){
     return $this->status=$status;
}
public function setIsDelete($is_deleted){
     return $this->is_deleted=$is_deleted;
}


}