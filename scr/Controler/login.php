<?php
session_start();
require_once __DIR__ . '/../Entity/Role.php';
require_once __DIR__ . '/../Service/AuthService.php';

$conn = new Connexion();
$pdo = $conn->getConnexion($conn);
$roleRepo = new RoleRepository($pdo);
$userRepo = new UserRepository($pdo);
$authService = new AuthService($userRepo,$roleRepo);
if (!isset($_POST['submit'])) {
   
    try {

        $row = $authService->login( trim($_POST['email']), trim($_POST['password']) );
        
        if ($row['role'] === "Client") {
            header("Location: ../views/dashboard-client.php");
            exit;
        }
        if ($row['role']=== "Livreur") {
            header("Location: ../views/dashboard-livreur.php");
            exit;
        }
        if ($row['role']=== "Admin") {
            header("Location: ../views/dashboard-admin.php");
            exit;
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>Erreur: " . $e->getMessage() . "</p>";
    }
}
