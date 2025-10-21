<?php
require_once './app/models/book.model.php';
require_once './app/models/author.model.php';
require_once './app/views/panel.view.php';

class PanelController
{
  private $bookModel;
  private $authorModel;
  private $view;

  function __construct()
  {
    $this->bookModel = new BookModel();
    $this->authorModel = new AuthorModel();
    $this->view = new PanelView();
  }

  public function showPanel()
  {
    $user = $_SESSION['USER_NAME'] ?? null;
    $books = $this->bookModel->getAllBooks();
    $authors = $this->authorModel->getAuthors();

    $this->view->showPanel($user, $books, $authors);
  }
}
