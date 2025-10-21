<?php
require_once 'app/models/book.model.php';
require_once 'app/models/author.model.php';
require_once 'app/views/panel.view.php';

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

  public function showPanel($request)
  {
    $user = $request->user->username ?? 'Invitado';
    $books = (new BookModel())->getAllBooks();
    $authors = (new AuthorModel())->getAuthors();
    include "templates/admin/panel.phtml";
  }
}
