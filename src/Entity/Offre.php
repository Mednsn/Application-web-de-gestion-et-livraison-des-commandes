<?php

require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Commande.php';
require_once __DIR__ . '/Vehicule.php';

class Offre {
    private ?int $id;
    private float $prix;
    private string $duree_estimee;
    private string $option;
    private ?bool $is_accept;
    private ?DATETIME $date_creation;
    private Vehicule $vehicule;
    private User $livreur;
    private Commande $commande;

    public function __construct(float $prix, string $duree_estimee, string $option, ?bool $is_accept, ?DATETIME $date_creation=NULL, Vehicule $vehicule, User $livreur, Commande $commande,  ?int $id=NULL)
    {
        $this->prix = $prix;
        $this->duree_estimee = $duree_estimee;
        $this->option = $option;
        $this->is_accept = $is_accept;
        $this->date_creation = $date_creation;
        $this->vehicule = $vehicule;
        $this->livreur = $livreur;
        $this->commande = $commande;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getprix()
    {
        return $this->prix;
    }
    public function getDureeEstimee()
    {
        return $this->duree_estimee;
    }
    public function getOption()
    {
        return $this->option;
    }
    public function getIsAccept()
    {
        return $this->is_accept;
    }
     public function getDateCreation()
    {
        return $this->date_creation;
    }
     public function getVehicule()
    {
        return $this->vehicule;
    }
     public function getLivreur()
    {
        return $this->livreur;
    }
    public function getCommande()
    {
        return $this->commande;
    }
 
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function setPrix($prix)
    {
        return $this->prix = $prix;
    }
    public function setDureeEstimee($duree_estimee)
    {
        return $this->duree_estimee = $duree_estimee;
    }
    public function setOption($option)
    {
        return $this->option = $option;
    }
    public function setIsAccept($is_accept)
    {
        return $this->is_accept = $is_accept;
    }
    public function setDateCreation($date_creation)
    {
        return $this->date_creation = $date_creation;
    }
    public function setVehicule($vehicule)
    {
        return $this->vehicule = $vehicule;
    }
    public function setLivreur($livreur)
    {
        return $this->livreur = $livreur;
    }
    public function setCommande($commande)
    {
        return $this->commande = $commande;
    }
}
