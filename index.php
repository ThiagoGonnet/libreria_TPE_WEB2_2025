<?php
require_once 'config.php';
require_once 'app/controllers/author.controller.php';
require_once 'app/controllers/book.controller.php';
require_once 'app/controllers/auth.controller.php';
require_once 'app/middlewares/auth.helper.php';

$action = $_GET['action'] ?? 'home';
$params = explode('/', $action);

switch ($params[0]) {
    case 'home':
        $controller = new AuthorController();
        $controller->ShowHome();
        break;

    case 'autores':
        $controller = new AuthorController();
        $controller->ShowAuthors();
        break;

    case 'libros':
        $controller = new BookController();
        $controller->ShowBooks();
        break;

    case 'librosPorAutor':
        $controller = new BookController();
        $controller->ShowBooksByAuthor($params[1]); // el "1" de la URL
        break;

    // --- LOGIN / LOGOUT ---
    case 'login':
        $controller = new AuthController();
        $controller->showLogin();
        break;
    case 'do_login':
        $controller = new AuthController();
        $controller->doLogin();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    // --- PANEL ADMIN ---
    case 'panel':
        AuthHelper::checkLoggedIn();
        $controller = new AuthController();
        $controller->showPanel($_SESSION['USER']);
        break;
    case 'panel/addBook':
        AuthHelper::checkLoggedIn();
        $controller = new BookController();
        $controller->AddBook($_POST);
    default:
        echo "404 - Página no encontrada";
        break;
}
