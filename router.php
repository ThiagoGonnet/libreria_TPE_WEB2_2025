<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';
require_once 'app/controllers/author.controller.php';
require_once 'app/controllers/book.controller.php';
require_once 'app/controllers/auth.controller.php';
require_once 'app/controllers/panel.controller.php';
require_once 'app/middlewares/session.middleware.php';
require_once 'app/middlewares/guard.middleware.php';

$action = $_GET['action'] ?? 'home';
$params = explode('/', $action);

$request = new StdClass();
$request = (new SessionMiddleware())->run($request);

switch ($params[0]) {

    // === PÚBLICO ===
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
        if (!$authorId) die("ID de autor no proporcionado");
        $controller = new BookController();
        $controller->ShowBooksByAuthor($authorId);
        break;

    // === LOGIN / LOGOUT ===
    case 'login':
        $controller = new AuthController();
        $controller->showLogin($request);
        break;

    case 'do_login':
        $controller = new AuthController();
        $controller->doLogin($request);
        break;

    case 'logout':
        $request = (new GuardMiddleware())->run($request);
        $controller = new AuthController();
        $controller->logout($request);
        break;

    // === PANEL ADMIN ===
    case 'panel':
        $request = (new GuardMiddleware())->run($request);
        $controller = new PanelController();
        $controller->showPanel($request);
        break;


    case 'panel/addBook':
        $request = (new GuardMiddleware())->run($request);
        $controller = new BookController();
        $controller->AddBook($_POST);
        break;

    case 'panel/editBook':
        $request = (new GuardMiddleware())->run($request);
        $id = $params[1] ?? null;
        if (!$id) die("ID de libro no proporcionado");
        $controller = new BookController();
        $controller->EditBook($id);
        break;

    case 'panel/deleteBook':
        $request = (new GuardMiddleware())->run($request);
        $id = $params[2] ?? null;
        if (!$id) die("ID de libro no proporcionado");
        $controller = new BookController();
        $controller->DeleteBook($id);
        break;

    case 'panel/addAuthor':
        $request = (new GuardMiddleware())->run($request);
        $controller = new AuthorController();
        $controller->AddAuthor($_POST);
        break;

    case 'panel/editAuthor':
        $request = (new GuardMiddleware())->run($request);
        $id = $params[1] ?? null;
        if (!$id) die("ID de autor no proporcionado");
        $controller = new AuthorController();
        $controller->EditAuthor($id);
        break;

    case 'panel/deleteAuthor':
        $request = (new GuardMiddleware())->run($request);
        $id = $params[1] ?? null;
        if (!$id) die("ID de autor no proporcionado");
        $controller = new AuthorController();
        $controller->DeleteAuthor($id);
        break;

    default:
        echo "404 - Página no encontrada";
        break;
}
