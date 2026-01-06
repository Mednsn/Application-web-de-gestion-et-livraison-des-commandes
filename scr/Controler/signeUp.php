<?php

require_once __DIR__ . '/../Entity/Role.php';
require_once __DIR__ . '/../Service/AuthService.php';

$conn = new Connexion();
$pdo = $conn->getConnexion($conn);
$role_tab = new Role($_POST['roles']);
$roleRepo = new RoleRepository($pdo);
$userRepo = new UserRepository($pdo);
$authService = new AuthService($userRepo,$roleRepo);
if (!isset($_POST['submit'])) {
   
    try {


        $authService->signeUp(trim($_POST['name']), trim($_POST['email']), trim($_POST['password']), $role_tab);
            header("Location: ../Service/AuthService.php");

        if ($_POST['roles'] === "Client") {
            header("Location: ../views/dashboard-client.php");
            exit;
        } else {
            if ($_POST['roles'] === "Livreur") {
                header("Location: ../views/dashboard-livreur.php");
                exit;
            }
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>Erreur: " . $e->getMessage() . "</p>";
    }
}
