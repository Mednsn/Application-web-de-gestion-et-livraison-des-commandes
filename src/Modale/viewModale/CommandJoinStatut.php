<?php 

class CommandeJoinStaut {
    public int $id;
    public string $description;
    public string $adress_depart;
    public string $adress_livraison;
    public string $etats;
    public int $statut_id;
    public ?string $date_creation ;
    public ?string $date_modification ;
    public int $client_id;
    public int $statut;
    public bool $is_deleted ;
}