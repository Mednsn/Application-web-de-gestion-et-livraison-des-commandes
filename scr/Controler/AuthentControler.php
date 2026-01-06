<?php

require_once __DIR__ . '/../Service/AuthService.php';
class AuthController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register()
    {
        try {
            $this->authService->signeUp($_POST['name'],$_POST['email'],$_POST['password'],$_POST['role']);

            header("Location: /../views/dashboard-client.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
