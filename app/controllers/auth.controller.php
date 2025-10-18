<?php
require_once 'app/models/user.model.php';
require_once 'app/views/admin.view.php';

class AuthController
{
    private $model;
    private $view;

    function __construct()
    {
        $this->model = new UserModel();
        $this->view = new AdminView();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    function showLogin()
    {
        $this->view->showLogin();
    }

    function doLogin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->model->getUserByUsername($username);

        if ($user && $password == $user->password) {
            $_SESSION['USER'] = $user;
            header("Location: " . BASE_URL . "panel");
        } else {
            $this->view->showLogin("Usuario o contraseña incorrectos");
        }
    }

    function logout()
    {
        session_destroy();
        header("Location: " . BASE_URL . "login");
    }

    function showPanel()
    {
        $this->view->showPanel($_SESSION['USER']);
    }
}
