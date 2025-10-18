<?php
require_once __DIR__ . '/../../config.php';

class BookModel
{
    private $db;

    function __construct()
    {
        // Creamos nuestra propia conexión usando las constantes
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function getBooks()
    {
        $query = $this->db->prepare("
            SELECT libros.*, autores.nombre AS autor
            FROM libros
            JOIN autores ON libros.autor_id = autores.id
        ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function getBooksByAuthor($idAutor)
    {
        $query = $this->db->prepare("
            SELECT libros.*, autores.nombre AS autor
            FROM libros
            JOIN autores ON libros.autor_id = autores.id
            WHERE autor_id = ?
        ");
        $query->execute([$idAutor]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function addBook($data) {}
}
