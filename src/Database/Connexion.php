<?php

class Connexion{
    private string $host;
    private string $dbname;
    private string $charset;
    private string $root;
    private string $password;
    private ?PDO $pdo = NULL;
    

public function __construct()
{
    $this->host='localhost';
    $this->dbname='gestion_commandes';
    $this->charset='utf8';
    $this->root='root';
    $this->password='';
    
}

public function getConnexion():PDO
{
    if( $this->pdo === NULL ){
    try{
    $dns = ("mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}");
    $pdo = new PDO ($dns,$this->root,$this->password);
    
    }catch(PDOException $e){
die('Erreur dans database' . $e->getMessage());    }
}
return $pdo;
}
}
