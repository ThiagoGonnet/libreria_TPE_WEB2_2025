<?php
require_once './app/models/book.model.php';
require_once './app/views/book.view.php';

class BookController
{
    private $model;
    private $view;
    private $authorModel;

    function __construct()
    {
        $this->model = new BookModel();
        $this->view = new BookView();
        $this->authorModel = new AuthorModel();
    }

    function ShowBooks()
    {
        $books = $this->model->getBooks();
        $this->view->ShowBooksAdmin($books);
    }

    function ShowBooksByAuthor($idAutor)
    {
        $books = $this->model->getBooksByAuthor($idAutor);
        $this->view->ShowBooksAdmin($books);
    }
    function AddBook($data)
    {
        $this->model->addBook($data);
        header("Location: " . BASE_URL . "panel");
    }

    function DeleteBook($id)
    {
        $ok = $this->model->deleteBookById($id);
        if ($ok) {
            header("Location: " . BASE_URL . "libros?msg=deleted");
        } else {
            header("Location: " . BASE_URL . "libros?msg=error");
        }
        exit;
    }
    function EditBook($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $this->model->editBookById($id, $data);
            header("Location: " . BASE_URL . "panel");
            exit;
        } else {
            $book = $this->model->getBookById($id);
            $authors = $this->authorModel->getAuthors();
            $this->view->ShowEditForm($book, $authors);
        }
    }
    function ShowBooksAdmin()
    {
        $books = $this->model->getBooks();
        $this->view->ShowBooksAdmin($books);
    }
}
