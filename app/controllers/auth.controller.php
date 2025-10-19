<?php
require_once 'config.php';
require_once 'app/middlewares/auth.helper.php';

class AuthController
{
    function showLogin($error = "")
    {
        require_once 'templates/admin/login.phtml';
    }

    function doLogin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'webadmin' && $password === 'admin') {
            $_SESSION['USER'] = (object)[
                'username' => $username,
                'rol' => 'admin'
            ];
            header("Location: " . BASE_URL . "panel");
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos";
            $this->showLogin($error);
        }
    }

    function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header("Location: " . BASE_URL . "login");
        exit;
    }
}
