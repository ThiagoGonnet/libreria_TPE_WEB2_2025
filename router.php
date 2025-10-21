<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';
require_once 'app/controllers/author.controller.php';
require_once 'app/controllers/book.controller.php';
require_once 'app/controllers/auth.controller.php';
require_once 'app/middlewares/session.middleware.php';
require_once 'app/middlewares/guard.middleware.php';
require_once 'app/controllers/panel.controller.php';


$action = $_GET['action'] ?? 'home';
$params = explode('/', $action);

$request = new StdClass();
$request = (new SessionMiddleware())->run($request);


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
        $authorId = $params[1];
        $controller = new BookController();
        $controller->ShowBooksByAuthor($authorId);
        break;
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
    // panel adm
    case 'panel':
        $request = (new GuardMiddleware())->run($request);
        $controller = new PanelController();
        $controller->showPanel();
        break;
    case 'panel/addBook':
        $request = (new GuardMiddleware())->run($request);
        $controller = new BookController();
        $controller->AddBook($_POST);
        break;

    case 'panel/deleteBook':
        $request = (new GuardMiddleware())->run($request);
        $id = $params[1] ?? null;
        if (!$id) die("ID de libro no proporcionado");
        $controller = new BookController();
        $controller->DeleteBook($id);
        break;

    case 'panel/editBook':
        $request = (new GuardMiddleware())->run($request);
        $id = $params[1] ?? null;
        if (!$id) die("ID de libro no proporcionado");
        $controller = new BookController();
        $controller->EditBook($id);
        break;
    case 'panel/addAuthor':
        $request = (new GuardMiddleware())->run($request);
        $controller = new AuthorController();
        $controller->AddAuthor($request);
        break;
    case 'panel/deleteAuthor':
        $request = (new GuardMiddleware())->run($request);
        $controller = new AuthorController();
        $controller->DeleteAuthor($request);
        break;
    case 'panel/editAuthor':
        $request = (new GuardMiddleware())->run($request);
        $controller = new AuthorController();
        $controller->EditAuthor($request);
        break;

    default:
        echo "404 - Página no encontrada";
        break;
}
