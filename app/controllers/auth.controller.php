<?php
require_once 'config.php';
require_once 'app/middlewares/auth.helper.php';
require_once 'app/models/book.model.php';

class AuthController
{
    function showLogin($error = "")
    {
        include __DIR__ . '/../../templates/admin/login.phtml';
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

    function showPanel()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['USER'])) {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        $user = $_SESSION['USER'];

        require_once 'app/models/author.model.php';
        $authorModel = new AuthorModel();
        $authors = $authorModel->getAuthors();

        include __DIR__ . '/../../templates/admin/panel.phtml';
    }
}
