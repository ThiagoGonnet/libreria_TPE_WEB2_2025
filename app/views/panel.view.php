<?php
class PanelView
{
  function ShowPanel($user, $books, $authors)
  {
    // Estas variables estarán disponibles dentro de panel.phtml
    include "templates/admin/panel.phtml";
  }

  function ShowEditBookForm($book, $authors)
  {
    include "templates/admin/edit_book.phtml";
  }

  function ShowEditAuthorForm($author)
  {
    include "templates/admin/edit_author.phtml";
  }
}
