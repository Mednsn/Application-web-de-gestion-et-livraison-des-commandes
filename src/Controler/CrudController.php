<?php
require_once __DIR__ . '/../Service/CommandeService.ph';

$conn = new Connexion();

$pdo = $conn->getConnexion($conn);
var_dump($pdo);exit;
$comndRepo = new CommandeRepository($pdo);
$userRepo = new UserRepository($pdo);

$User = $userRepo->findByEmail($email);

if(!isset($_POST['submit'])){
    $statut=new StatutCommande("Cree","command est cree",1);
    $command = new Commande($_POST['description'],$_POST['lieuRamassage'],$_POST['lieuLivraison'],$User,$statut,"false");
    $comndRepo->add($command);
    header('location: ../views/dashboard-client.php');
    exit;
}else{
    header('location: ../views/dashboard-client.php');
    exit;
}