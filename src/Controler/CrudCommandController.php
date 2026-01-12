<?php
session_start();
require_once __DIR__ . '/../Service/CommandeService.php';
require_once __DIR__ . '/../Service/userService.php';


$email = $_SESSION['email'];
$commandServc = new CommandeService();
$userServc = new UserService();

$userFull = $userServc->findUser($email);
if (!isset($_POST['crud'])) {
    return $_POST['crud'] = "indefined";
}
if ($_POST['crud'] === 'ajouter') {
    try {
        if (empty($_POST['description']) || empty($_POST['lieuRamassage']) || empty($_POST['lieuLivraison'])) {
            echo " aucune valeur ";
            exit;
        }
        $userRol = new Role();
        $userRol->setId($userFull->R_id);
        $userRol->setName($userFull->role);
        $date_creation = new DateTime($userFull->date_creation);
        $user = new User($userFull->name, $userFull->email, $userFull->password, $userRol, $date_creation, $userFull->id);
        $statut = new StatutCommande('Cree', 'Commande est cree', 1);
        $command = new Commande(trim($_POST['description']), trim($_POST['lieuRamassage']), trim($_POST['lieuLivraison']), $user, $statut, false);
        $commandServc->add($command);
        header('location: ../View/dashboard-client.php');
    } catch (PDOException $e) {
        echo "<p style='color:red'>chof: " . $e->getMessage() . "</p>";
    }
}


if ($_POST['crud'] === 'delete') {

    try {

        $comndfinded = $commandServc->selectCmndById($_POST['id'], $userFull->id);
        if ($comndfinded->etats !== "Terminée") {
            echo "<script> alert(\" vous devez supprimer commande \");</>script";
            $commandServc->delete($_POST['id']);
        } else {
            echo "<script> alert(\" vous devez supprimer commande \");</>script";

            $commandServc->AsDeeleted($_POST['id'], 1);
        }


        header('location: ../View/dashboard-client.php ');
    } catch (PDOException $e) {
        echo "<p style='color:red'>chof: " . $e->getMessage() . "</p>";
    }
}
// $comndRepo = new CommandeRepository($pdo);
// $userRepo = new UserRepository($pdo);

// $User = $userRepo->findByEmail($email);

// if(!isset($_POST['submit'])){
//     $statut=new StatutCommande("Cree","command est cree",1);
//     $command = new Commande($_POST['description'],$_POST['lieuRamassage'],$_POST['lieuLivraison'],$User,$statut,"false");
//     $comndRepo->add($command);
//     header('location: ../views/dashboard-client.php');
//     exit;
// }else{
//     header('location: ../views/dashboard-client.php');
//     exit;
// }