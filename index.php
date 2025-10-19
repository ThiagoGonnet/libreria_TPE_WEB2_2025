<?php
require_once 'config.php';
require_once 'app/controllers/author.controller.php';
require_once 'app/controllers/book.controller.php';
require_once 'app/controllers/auth.controller.php';
require_once 'app/middlewares/auth.helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
        $authorId = $params[1] ?? null;
        $controller = new BookController();
        $controller->ShowBooksByAuthor($authorId);
        break;

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

    case 'panel':
        AuthHelper::checkLoggedIn();
        $user = $_SESSION['USER'] ?? null;
        if (!$user || $user->rol !== 'admin') {
            header("Location: " . BASE_URL . "login");
            exit;
        }
        $controller = new AuthController();
        $controller->showPanel();
        break;

    case 'panel/addBook':
        AuthHelper::checkLoggedIn();
        $controller = new BookController();
        $controller->AddBook($_POST);
        break;

    case 'panel/deleteBook':
        AuthHelper::checkLoggedIn();
        $id = $params[1] ?? null;
        if (!$id) die("ID de libro no proporcionado");
        $controller = new BookController();
        $controller->DeleteBook($id);
        break;

    case 'panel/editBook':
        AuthHelper::checkLoggedIn();
        $id = $params[1] ?? null;
        if (!$id) die("ID de libro no proporcionado");
        $controller = new BookController();
        $controller->EditBook($id);
        break;

    default:
        echo "404 - Página no encontrada";
        break;
}
