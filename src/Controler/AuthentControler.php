<?php
require_once __DIR__ . '/../Modale/Entity/Role.php';
require_once __DIR__ . '/../Service/userService.php';


class AuthentControler
{
    private UserService $user_service;

    public function __construct()
    {
        $this->user_service = new UserService();
    }

    public function register(string $name,string $email,string $password,string $role)
    {
        // var_dump($role);exit;
        try {
            $this->user_service->signeUp($name,$email,$password,$role);

           if ($role=== "Client") {
            header("Location: View/dashboard-client.php");
            exit;
        } else {
            if ($role=== "Livreur") {
                header("Location: View/dashboard-livreur.php");
                exit;
            }
        }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function connection(string $email,string $password)
    {
        
        try {

        $row = $this->user_service->login($email,$password);
        if ($row->role === "Client") {
            
            header("Location: View/dashboard-client.php");
            // var_dump($row->getRole()->getName());
            
        }
        if ($row->role=== "Livreur") {
                 
            header("Location: View/dashboard-livreur.php");
            exit;
        }
        if ($row['role']=== "Admin") {
                    
            header("Location: View/dashboard-admin.php");
            exit;
        }
        
    } catch (Exception $e) {
        echo "<p style='color:red'>Erreur: " . $e->getMessage() . "</p>";
    }
    }
    

}
