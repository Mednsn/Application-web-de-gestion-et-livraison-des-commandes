<?php



require_once __DIR__ . '/Controler/AuthentControler.php';


session_start();



$authcontroler = new AuthentControler();

$_SESSION['email']=$_POST['email'];

if (isset($_POST['submit'])) {
    header('location: Authents/login.html');
    exit;
}
if($_GET['page']==="signeUp"){
    try {
        
        // $role_tab = new Role();
        // var_dump($role_tab->getName());exit;
        $authcontroler->register(trim($_POST['name']), trim($_POST['email']), trim($_POST['password']), trim($_POST['roles']));

    } catch (Exception $e) {
        echo "<p style='color:red'>Erreur: " . $e->getMessage() . "</p>";
    }
}


if ($_GET['page']==="login") {
    try {
        
        $authcontroler->connection( trim($_POST['email']), trim($_POST['password']) );
    } catch (Exception $e) {
        echo "<p style='color:red'>Erreur: " . $e->getMessage() . "</p>";
    }
}








?>




?>