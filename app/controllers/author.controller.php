<?php
require_once 'app/models/author.model.php';
require_once 'app/models/book.model.php';
require_once 'app/views/list.category.view.php';
require_once 'app/views/panel.view.php';

class AuthorController
{
    private $publicView;
    private $panelView;
    private $authorModel;
    private $bookModel;

    function __construct()
    {
        $this->publicView = new ListCategoryView();
        $this->panelView = new PanelView();
        $this->authorModel = new AuthorModel();
        $this->bookModel = new BookModel();
    }

    // === Vistas públicas ===
    function ShowAuthors()
    {
        $authors = $this->authorModel->getAuthors();
        $this->publicView->ShowAuthors($authors);
    }

    function ShowHome()
    {
        $books = $this->bookModel->getAllBooks();
        $this->publicView->ShowHome($books);
    }

    function ShowBooksByAuthor($authorId)
    {
        $books = $this->bookModel->getBooksByAuthor($authorId);
        $this->publicView->ShowBooksByAuthor($books);
    }

    function ShowAuthorDetail($id)
    {
        $author = $this->authorModel->getAuthorById($id);
        $books = $this->bookModel->getBooksByAuthor($id);
        $this->publicView->ShowAuthorDetail($author, $books);
    }

    // === Panel administrador ===
    function AddAuthor($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->authorModel->addAuthor($data);
            header("Location: " . BASE_URL . "panel");
            exit;
        }
    }

    function EditAuthor($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->authorModel->editAuthorById($id, $_POST);
            header("Location: " . BASE_URL . "panel");
            exit;
        } else {
            $author = $this->authorModel->getAuthorById($id);
            $this->panelView->ShowEditAuthorForm($author);
        }
    }

    function DeleteAuthor($id)
    {
        $this->authorModel->deleteAuthorById($id);
        header("Location: " . BASE_URL . "panel");
        exit;
    }
}
