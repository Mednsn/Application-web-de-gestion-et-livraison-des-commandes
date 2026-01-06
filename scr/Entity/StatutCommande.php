<?php

class StatutCommande{
    private ?int $id;
    private string $etats;
    private string $libelle;
    public function __construct(string $etats, string $libelle, ?int $id = NULL)
    {
        $this->etats = $etats;
        $this->libelle = $libelle;
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getEtats()
    {
        return $this->etats;
    }
    public function getLibelle()
    {
        return $this->libelle;
    }
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function setEtats($etats)
    {
        return $this->etats = $etats;
    }
    public function setLibelle($libelle)
    {
        return $this->libelle = $libelle;
    }

}