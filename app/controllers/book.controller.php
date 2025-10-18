<?php
require_once './app/models/book.model.php';
require_once './app/views/book.view.php';

class BookController
{
    private $model;
    private $view;

    function __construct()
    {
        $this->model = new BookModel(); // crea su propia conexión
        $this->view = new BookView();
    }

    function ShowBooks()
    {
        $books = $this->model->getBooks();
        $this->view->ShowBooks($books);
    }

    function ShowBooksByAuthor($idAutor)
    {
        $books = $this->model->getBooksByAuthor($idAutor);
        $this->view->ShowBooks($books);
    }
    function AddBook($data)
    {
        $this->model->addBook($data);  // addBook lo tenés que crear en BookModel
        header("Location: " . BASE_URL . "panel"); // redirige al panel después
    }
}
