<?php
class AuthHelper
{
    static function checkLoggedIn()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['USER'])) {
            header("Location: " . BASE_URL . "login");
            die();
        }
    }
}
