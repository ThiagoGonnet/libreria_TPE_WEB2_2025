<?php
class AuthHelper
{

    static function checkLoggedIn()
    {
        define('ADMIN_USER', 'webadmin');
        define('ADMIN_PASSWORD', 'admin'); // solo para pruebas

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['USER'])) {
            header("Location: " . BASE_URL . "login");
            die();
        }
    }
}
