<?php
class BookView
{
  function ShowBooksAdmin($books)
  {
    include "templates/layout/header.phtml";
    echo "<h2>Lista de libros</h2>";
    echo "<ul>";

    foreach ($books as $book) {
      echo "<li>";
      echo $book->titulo . " — " . $book->autor;

      if (isset($_SESSION['USER']) && $_SESSION['USER']->rol === 'admin') {
        echo " <a href='?action=panel/editBook/" . $book->id . "'>Editar</a>";
        echo " <a href='?action=panel/deleteBook/" . $book->id . "' onclick=\"return confirm('¿Seguro que querés eliminar este libro?');\">Eliminar</a>";
      }

      echo "</li>";
    }

    echo "</ul>";
  }

  function ShowBooksHome($books)
  {
    echo "<h2>Libros disponibles</h2>";
    echo "<ul>";
    foreach ($books as $book) {
      echo "<li>$book->titulo — $book->autor</li>";
    }
    echo "</ul>";
  }

  function ShowEditForm($book, $authors)
  {
    include "templates/layout/header.phtml";
    echo "<h2>Editar libro</h2>";
    echo "<form action='?action=panel/editBook/" . $book->id . "' method='POST'>";
    echo "<label>Título:</label>";
    echo "<input type='text' name='titulo' value='" . $book->titulo . "' required><br>";

    echo "<label>Fecha de publicación:</label>";
    echo "<input type='text' name='fecha_de_publicacion' value='" . $book->fecha_de_publicacion . "' required><br>";

    echo "<label>Autor:</label>";
    echo "<select name='autor_id'>";
    foreach ($authors as $author) {
      $selected = $author->id == $book->autor_id ? "selected" : "";
      echo "<option value='" . $author->id . "' $selected>" . $author->nombre . "</option>";
    }
    echo "</select><br>";

    echo "<button type='submit'>Guardar cambios</button>";
    echo "</form>";
  }
}
