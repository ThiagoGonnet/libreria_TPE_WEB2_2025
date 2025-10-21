<?php
require_once 'config.php';

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
    }

    // Devuelve todos los libros con el nombre del autor como 'autor_nombre'
    function getAllBooks()
    {
        $query = $this->db->prepare("
            SELECT libros.id, libros.titulo, libros.fecha_de_publicacion, autores.nombre AS autor_nombre
            FROM libros
            LEFT JOIN autores ON libros.autor_id = autores.id
        ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function getBooksByAuthor($authorId)
    {
        $query = $this->db->prepare("
            SELECT libros.id, libros.titulo, libros.fecha_de_publicacion, autores.nombre AS autor_nombre
            FROM libros
            LEFT JOIN autores ON libros.autor_id = autores.id
            WHERE autores.id = ?
        ");
        $query->execute([$authorId]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function addBook($data)
    {
        if (!empty($data['autor_nuevo'])) {
            $stmt = $this->db->prepare("SELECT id FROM autores WHERE nombre = ?");
            $stmt->execute([$data['autor_nuevo']]);
            $existing = $stmt->fetch(PDO::FETCH_OBJ);
            if ($existing) {
                $autor_id = $existing->id;
            } else {
                $stmt = $this->db->prepare("INSERT INTO autores (nombre) VALUES (?)");
                $stmt->execute([$data['autor_nuevo']]);
                $autor_id = $this->db->lastInsertId();
            }
        } else {
            $autor_id = $data['autor_id'];
        }

        $stmt = $this->db->prepare("INSERT INTO libros (titulo, fecha_de_publicacion, autor_id) VALUES (?, ?, ?)");
        $stmt->execute([$data['titulo'], $data['fecha_de_publicacion'], $autor_id]);
    }

    function getBookById($id)
    {
        $query = $this->db->prepare("
            SELECT libros.*, autores.nombre AS autor_nombre
            FROM libros
            LEFT JOIN autores ON libros.autor_id = autores.id
            WHERE libros.id = ?
        ");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    function editBookById($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE libros SET titulo = ?, fecha_de_publicacion = ?, autor_id = ?
            WHERE id = ?
        ");
        $stmt->execute([$data['titulo'], $data['fecha_de_publicacion'], $data['autor_id'], $id]);
    }

    function deleteBookById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM libros WHERE id = ?");
        $stmt->execute([$id]);
    }
}
