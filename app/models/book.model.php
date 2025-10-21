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

    function getAllBooks()
    {
        $query = $this->db->prepare("
        SELECT
            libros.id,
            libros.titulo,
            libros.fecha_de_publicacion,
            autores.nombre AS autor,
            libros.autor_id,
            libros.genero,
            libros.disponible
        FROM libros
        LEFT JOIN autores ON libros.autor_id = autores.id
    ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }


    function getBooksByAuthor($authorId)
    {
        $query = $this->db->prepare("
            SELECT libros.id, libros.titulo, libros.fecha_de_publicacion, autores.nombre AS autor
            FROM libros
            LEFT JOIN autores ON libros.autor_id = autores.id
            WHERE autores.id = ?
        ");
        $query->execute([$authorId]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function getBookById($id)
    {
        $query = $this->db->prepare("
            SELECT libros.*, autores.nombre AS autor
            FROM libros
            LEFT JOIN autores ON libros.autor_id = autores.id
            WHERE libros.id = ?
        ");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    function getAuthorsList()
    {
        $query = $this->db->prepare("SELECT id, nombre FROM autores");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function addBook($data)
    {
        $autor_id = $data['autor_id'] ?? null;

        // Validar que el autor exista
        $stmt = $this->db->prepare("SELECT id FROM autores WHERE id = ?");
        $stmt->execute([$autor_id]);
        $existing = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$existing) {
            throw new Exception("No se puede agregar el libro: el autor seleccionado no está registrado.");
        }

        // Insertar el libro
        $stmt = $this->db->prepare("
        INSERT INTO libros (titulo, fecha_de_publicacion, disponible, genero, autor_id)
        VALUES (?, ?, ?, ?, ?)
    ");
        $stmt->execute([
            $data['titulo'],
            $data['fecha_de_publicacion'],
            isset($data['disponible']) ? 1 : 0, // checkbox
            $data['genero'],
            $autor_id
        ]);
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
