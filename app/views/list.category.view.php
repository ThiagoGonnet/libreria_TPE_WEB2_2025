<?php
require_once __DIR__ . "/book.view.php";

class ListCategoryView
{
    function ShowAuthors($authors)
    {
        include_once "templates/layout/header.phtml";

        echo "<h1>Autores</h1>";
        echo "<ul>";

        foreach ($authors as $author) {
            echo "<li>
            $author->nombre | $author->nacionalidad
            <a href='librosPorAutor/$author->id'>Ver libros</a>
            </li>";
        }

        echo "</ul>";
    }

    function ShowHome($books)
    {
        include_once "templates/layout/header.phtml";

        echo "<h1>Bienvenido a la Libreria Digital!</h1>";

        $this->showBooksHome($books);
    }

    function showBooksHome($books)
    {
        if (!empty($books)) {
            echo "<h2>Libros disponibles</h2>";
            echo "<ul>";
            foreach ($books as $book) {
                echo "<li>$book->titulo | Autor: $book->autor | Publicado: $book->fecha_de_publicacion</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No hay libros disponibles.</p>";
        }
    }

    function showBooksByAuthor($books)
    {
        include_once "templates/layout/header.phtml";

        if (!empty($books)) {
            echo "<h2>Libros del autor: " . $books[0]->autor . "</h2>";
            echo "<ul>";
            foreach ($books as $book) {
                echo "<li>$book->titulo | Género: $book->genero | Publicado: $book->fecha_de_publicacion</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No hay libros de este autor.</p>";
        }
    }
}
