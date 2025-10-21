<?php
require_once 'config.php';

class AuthorModel
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

    // Obtener todos los autores
    function getAuthors()
    {
        $stmt = $this->db->prepare("SELECT * FROM autores");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Obtener autor por ID
    function getAuthorById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM autores WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Agregar un nuevo autor
    function addAuthor($data)
    {
        $stmt = $this->db->prepare("INSERT INTO autores (nombre, nacionalidad, fecha_de_nacimiento) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['nombre'],
            $data['nacionalidad'] ?? null,
            $data['fecha_de_nacimiento'] ?? null
        ]);
    }

    // Editar autor existente
    function editAuthorById($id, $data)
    {
        $stmt = $this->db->prepare(
            "UPDATE autores SET nombre = ?, nacionalidad = ?, fecha_de_nacimiento = ? WHERE id = ?"
        );
        $stmt->execute([
            $data['nombre'],
            $data['nacionalidad'] ?? null,
            $data['fecha_de_nacimiento'] ?? null,
            $id
        ]);
    }

    function deleteAuthorById($id)
    {
        // Verificar si el autor tiene libros asociados
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM libros WHERE autor_id = ?");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            throw new Exception("No se puede eliminar el autor: tiene libros asociados.");
        }

        // Eliminar el autor
        $stmt = $this->db->prepare("DELETE FROM autores WHERE id = ?");
        $stmt->execute([$id]);
    }
}
