<?php
require_once 'app/models/book.model.php';
require_once 'app/views/book.view.php';
require_once 'app/views/panel.view.php';

class BookController
{
    private $model;
    private $publicView;
    private $panelView;

    function __construct()
    {
        $this->model = new BookModel();
        $this->publicView = new BookView();
        $this->panelView = new PanelView();
    }

    // === Vistas públicas ===
    function ShowBooks()
    {
        $books = $this->model->getAllBooks();
        $this->publicView->ShowBooks($books);
    }

    function ShowBooksByAuthor($authorId)
    {
        $books = $this->model->getBooksByAuthor($authorId);
        $this->publicView->ShowBooksHome($books);
    }

    // === Panel administrador ===
    function AddBook($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->addBook($data);
            header("Location: " . BASE_URL . "panel");
            exit;
        }
    }

    function EditBook($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->editBookById($id, $_POST);
            header("Location: " . BASE_URL . "panel");
            exit;
        } else {
            $book = $this->model->getBookById($id);
            $authors = $this->model->getAuthorsList();
            $this->panelView->ShowEditBookForm($book, $authors);
        }
    }

    function DeleteBook($id)
    {
        // Llamamos al modelo
        $deletedRows = $this->model->deleteBookById($id);

        // Depuración: mostramos qué pasó
        if ($deletedRows > 0) {
            echo "El libro con ID $id fue eliminado correctamente.";
        } else {
            echo "No se pudo eliminar el libro con ID $id. Verificá que exista en la base.";
        }

        exit; // Detenemos ejecución para ver el mensaje
    }
}
