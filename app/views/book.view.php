<?php
class BookView
{
  function ShowBooks($books)
{
    include_once "templates/layout/header.phtml";
    echo "<h2>Lista de libros</h2><ul>";
    foreach ($books as $book) {
        echo "<li>" . htmlspecialchars($book->titulo) . " — " . htmlspecialchars($book->autor);
        // Solo mostrar botones si el usuario inició sesión
        if (!empty($_SESSION['USER'])) {
            echo " <a href='?action=panel/editBook/" . $book->id . "'>Editar</a>";
            echo " <a href='?action=panel/deleteBook/" . $book->id . "' onclick=\"return confirm('¿Seguro que querés eliminar este libro?');\">Eliminar</a>";
        }
        echo "</li>";
    }
    echo "</ul>";
}

  function ShowEditForm($book, $authors)
  {
    include "templates/layout/header.phtml";
    echo "<h2>Editar libro</h2>";
    echo "<form method='POST' class='form'>";
    echo "<label>Título:</label><input type='text' name='titulo' value='" . htmlspecialchars($book->titulo) . "' required><br>";
    echo "<label>Fecha de publicación:</label><input type='date' name='fecha_de_publicacion' value='" . htmlspecialchars($book->fecha_de_publicacion) . "' required><br>";
    echo "<label>Autor:</label><select name='autor_id'>";
    foreach ($authors as $author) {
      $selected = $author->id == $book->autor_id ? "selected" : "";
      echo "<option value='" . $author->id . "' $selected>" . htmlspecialchars($author->nombre) . "</option>";
    }
    echo "</select><br>";
    echo "<button type='submit'>Guardar cambios</button>";
    echo "</form>";
  }

  function ShowBooksHome($books)
  {
    include_once "templates/layout/header.phtml";
    echo "<h2>Libros disponibles</h2><ul>";
    foreach ($books as $book) {
      echo "<li>" . htmlspecialchars($book->titulo) . " — " . htmlspecialchars($book->autor) . "</li>";
    }
    echo "</ul>";
  }
}
