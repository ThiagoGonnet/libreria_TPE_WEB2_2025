<?php
require_once __DIR__ . '/../../config.php';

class BookModel
{
    private $db;

    function __construct()
    {
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

    function addBook($data)
    {
        $query = $this->db->prepare("INSERT INTO libros (titulo, fecha_de_publicacion, disponible, autor_id) VALUES (?, ?, ?, ?)");
        $query->execute([
            $data['titulo'],
            $data['fecha_de_publicacion'],
            1,
            $data['autor_id']
        ]);
    }

    function deleteBookById($id)
    {
        $query = $this->db->prepare("DELETE FROM libros WHERE id = ?");
        return $query->execute([$id]);
    }

    function getBookById($id)
    {
        $query = $this->db->prepare("SELECT * FROM libros WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    function editBookById($id, $data)
    {
        $query = $this->db->prepare("
        UPDATE libros
        SET titulo = ?,
            fecha_de_publicacion = ?,
            autor_id = ?
        WHERE id = ?
    ");
        return $query->execute([
            $data['titulo'],
            $data['fecha_de_publicacion'],
            $data['autor_id'],
            $id
        ]);
    }
}
