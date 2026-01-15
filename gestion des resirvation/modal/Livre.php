<?php
// namespace App\modal;

// use App\modal\Categorer;

require_once __DIR__ . '/Auteur.php';
require_once __DIR__ . '/Categorer.php';

echo __DIR__ . '/Categorer.php';


class Livre
{
    private ?int $id;

    private string $titre;

    private ?DATETIME $date_creation ;

    private Auteur $auteur;

    private Categorer $categorer;

    public function __construct(string $titre, Auteur $auteur, Categorer $categorer, ?DATETIME $date_creation = null, int $id = null)
    {
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->categorer = $categorer;
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }
    public function getAuteur(){
        return $this->auteur;
    }
    public function getTitre(){
        return $this->titre;
    }
    public function getDateCreation(){
        return $this->date_creation;
    }
    public function getCategorer(){
        return $this->categorer;
    }
}
