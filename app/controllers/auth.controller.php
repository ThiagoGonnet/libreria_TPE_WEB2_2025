<?php
require_once './app/models/user.model.php';
require_once './app/views/auth.view.php';

class AuthController
{
    private $userModel;
    private $view;

    function __construct()
    {
        $this->userModel = new UserModel();
        $this->view = new AuthView();
    }

    public function showLogin($request)
    {
        $this->view->showLogin("", $request->user ?? null);
    }

    public function doLogin($request)
    {
        if (empty($_POST['user']) || empty($_POST['password'])) {
            return $this->view->showLogin("Faltan datos obligatorios", $request->user ?? null);
        }

        $user = trim($_POST['user']);
        $password = trim($_POST['password']);

        $userFromDB = $this->userModel->getByUser($user);

        if ($userFromDB && password_verify($password, $userFromDB->password)) {
            $_SESSION['USER_ID'] = $userFromDB->id;
            $_SESSION['USER_NAME'] = $userFromDB->username;
            header("Location: " . BASE_URL . "panel");
            exit;
        } else {
            return $this->view->showLogin("Usuario o contraseña incorrecta", $request->user ?? null);
        }
    }

    public function logout($request)
    {
        session_destroy();
        header("Location: " . BASE_URL . "login");
        exit;
    }
}
