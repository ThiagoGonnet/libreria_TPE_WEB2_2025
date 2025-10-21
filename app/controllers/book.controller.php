<?php
require_once 'app/models/book.model.php';
require_once 'app/views/book.view.php';

class BookController
{
    private $model;
    private $view;

    function __construct()
    {
        $this->model = new BookModel();
        $this->view = new BookView();
    }

function ShowBooks()
{
    $books = $this->model->getAllBooks();
    $this->view->ShowBooks($books);
}

    function ShowBooksByAuthor($authorId)
    {
        $books = $this->model->getBooksByAuthor($authorId);
        $this->view->ShowBooksHome($books);
    }

    function AddBook($data)
    {
        $this->model->addBook($data);
        header("Location: " . BASE_URL . "panel");
        exit;
    }



    function EditBook($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->editBookById($id, $_POST);
            header("Location: " . BASE_URL . "panel");
            exit;
        } else {
            $book = $this->model->getBookById($id);
            $authors = $this->model->getAuthors();
            $this->view->ShowEditForm($book, $authors);
        }
    }

    function DeleteBook($id)
    {
        $this->model->deleteBookById($id);
        header("Location: " . BASE_URL . "panel");
    }
}
