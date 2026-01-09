<?php
require_once __DIR__ . '/../Entity/Role.php';
require_once __DIR__ . '/../Service/userService.php';


class AuthentControler
{
    private UserService $user_service;

    public function __construct()
    {
        $this->user_service = new UserService();
    }

    public function register(string $name,string $email,string $password,Role $role)
    {
        try {
            $this->user_service->signeUp($name,$email,$password,$role);

           if ($role->getName() === "Client") {
            header("Location: ../View/dashboard-client.php");
            exit;
        } else {
            if ($role->getName()=== "Livreur") {
                header("Location: ../View/dashboard-livreur.php");
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
   
        if ($row->getRole()->getName() === "Client") {
            
            header("Location: View/dashboard-client.php");
            // var_dump($row->getRole()->getName());
            
        }
        if ($row->getRole()->getName()=== "Livreur") {
                 
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
