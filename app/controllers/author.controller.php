<?php
require_once 'app/models/author.model.php';
require_once 'app/views/list.category.view.php';

class AuthorController {
    private $view;
    private $model;

    function __construct() {
        $this->view = new ListCategoryView();
        $this->model = new AuthorModel();
    }

    function ShowAuthors() {
        $authors = $this->model->getAuthors();
        $this->view->ShowAuthors($authors);
    }

    function ShowHome() {
        $this->view->ShowHome();
    }
}
?>


