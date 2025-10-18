<?php

class BookView
{
  function ShowBooks($books)
  {
    include_once "templates/layout/header.phtml";
    echo "<ul>";
    foreach ($books as $book) {
      echo "<li>" . $book->titulo  . "</li>";
    }
    echo "</ul>";
  }
}
