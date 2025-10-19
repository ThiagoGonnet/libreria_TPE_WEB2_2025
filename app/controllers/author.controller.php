<?php
require_once 'app/models/author.model.php';
require_once 'app/models/book.model.php';
require_once 'app/views/list.category.view.php';

class AuthorController
{
    private $view;
    private $authorModel;
    private $bookModel;

    function __construct()
    {
        $this->view = new ListCategoryView();
        $this->authorModel = new AuthorModel();
        $this->bookModel = new BookModel();
    }

    function ShowAuthors()
    {
        $authors = $this->authorModel->getAuthors();
        $this->view->ShowAuthors($authors);
    }

    function ShowHome()
    {
        $books = $this->bookModel->getAllBooks();
        $this->view->ShowHome($books);
    }
}
