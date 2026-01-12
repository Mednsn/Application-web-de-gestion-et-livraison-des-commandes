<?php
require_once __DIR__ . '/../Controler/CrudCommandController.php';
require_once __DIR__ . '/../Service/OfferService.php';
require_once __DIR__ . '/../Service/VehiculeService.php';

$email = $_SESSION['email'];
$commandServc = new CommandeService();
$offreServc = new OfferService();
$userServc = new UserService();
$vehiculeServc = new VehiculeService();

$userFull = $userServc->findUser($email);

if (isset($_POST['submit'])) {
   header('location: ../View/dashboard-livreur.php');
}

$arrayComnds = $commandServc->selectById($_POST['id_commande']);

if (!isset($_POST['offrs'])) {
   return $_POST['offrs'] = "indefined";
}
if ($_POST['offrs'] === 'Ajouter') {
   if (!isset($_POST['price'])) {
      header('location: ../View/dashboard-livreur.php');
   }
   if (!isset($_POST['duration'])) {
      header('location: ../View/dashboard-livreur.php');
   }
   if (!isset($_POST['option'])) {
      header('location: ../View/dashboard-livreur.php');
   }
   if (!isset($_POST['vehicle'])) {
      header('location: ../View/dashboard-livreur.php');
   }
   // if (!$vehiculeServc->selectVehicleByNmae($_POST['vehicle'])) {
   //    if ($_POST['vehicle'] === 'Moto') {
   //       $vehicule = new Vehicule('Moto', 1);
   //       $vehiculeServc->add($vehicule);
   //    } else {
   //       $vehicule = new Vehicule('Voiture', 2);
   //       $vehiculeServc->add($vehicule);
   //    }
   // }
   $vehicule = $vehiculeServc->selectVehicleByNmae($_POST['vehicle']);
   // echo $userFull->R_id;exit;
   $newvehicule = new Vehicule();
   $newvehicule->setId($vehicule->getId());
   $newvehicule->setName($vehicule->getName());
   $userRol = new Role();
   $userRol->setId($userFull->R_id);
   $userRol->setName($userFull->role);
   $date_creationUser = new DateTime($userFull->date_creation);
   $date_creationCommand = new DateTime($arrayComnds->date_creation);
   $user = new User($userFull->name, $userFull->email, $userFull->password, $userRol, $date_creationUser, $userFull->id);
   $statut = new StatutCommande($arrayComnds->etats, 'Commande est cree', $arrayComnds->statut_id);
   $command = new Commande($arrayComnds->description, $arrayComnds->adress_depart, $arrayComnds->adress_livraison, $user, $statut, $arrayComnds->is_deleted, $date_creationCommand,null,$arrayComnds->id);
   
   $offre = new Offre($_POST['price'], $_POST['duration'], $_POST['option'], $newvehicule, $user, $command, false);
  
   $offreServc->add($offre);
   header('location: ../View/dashboard-livreur.php');
}
