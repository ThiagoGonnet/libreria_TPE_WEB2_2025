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
        $this->view->showLogin("", $request->user);
    }

    public function doLogin($request)
    {

        if (empty($_POST['user']) || empty($_POST['password'])) {
            return $this->view->showLogin("Faltan datos obligatorios", $request->user);
        }

        $user = trim($_POST['user']);
        $password = trim($_POST['password']);

        $userFromDB = $this->userModel->getByUser($user);

        var_dump($_POST['password']);      // password ingresada
        var_dump($userFromDB->password);   // hash desde DB
        var_dump(password_verify($_POST['password'], $userFromDB->password));
        if ($userFromDB && password_verify($password, $userFromDB->password)) {
            $_SESSION['USER_ID'] = $userFromDB->id;
            $_SESSION['USER_NAME'] = $userFromDB->username;
            header("Location: " . BASE_URL . "panel");
            return;
        } else {
            return $this->view->showLogin("Usuario o contraseña incorrecta", $request->user);
        }
    }

    public function logout($request)
    {
        session_destroy();
        header("Location: " . BASE_URL . "login");
        return;
    }
    function showPanel()
    {
        $this->view->showPanel($_SESSION['USER_NAME']);
    }
}
