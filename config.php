<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'db_library');
define('DB_USER', 'root');
define('DB_PASS', '');

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear la base si no existe
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    $pdo->exec("USE " . DB_NAME);

    // Crear tablas si no existen
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS autores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(150) NOT NULL,
            nacionalidad VARCHAR(80),
            fecha_de_nacimiento DATE
        );

        CREATE TABLE IF NOT EXISTS libros (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(150) NOT NULL,
            fecha_de_publicacion DATE,
            disponible TINYINT(1) DEFAULT 1,
            genero VARCHAR(100),
            autor_id INT,
            FOREIGN KEY (autor_id) REFERENCES autores(id) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE,
            password VARCHAR(255)
        );
    ");

    // Insertar autores si no hay
    $countAutores = $pdo->query("SELECT COUNT(*) FROM autores")->fetchColumn();
    if ($countAutores == 0) {
        $pdo->exec("
            INSERT INTO autores (nombre, nacionalidad, fecha_de_nacimiento) VALUES
            ('Gabriel García Márquez', 'Colombiana', '1927-03-06'),
            ('Jorge Luis Borges', 'Argentina', '1899-08-24'),
            ('Isabel Allende', 'Chilena', '1942-08-02');
        ");
    }

    // Insertar libros si no hay
    $countLibros = $pdo->query("SELECT COUNT(*) FROM libros")->fetchColumn();
    if ($countLibros == 0) {
        $pdo->exec("
            INSERT INTO libros (titulo, fecha_de_publicacion, disponible, genero, autor_id) VALUES
            ('Cien años de soledad', '1967-06-05', 1, 'Realismo mágico', 1),
            ('El Aleph', '1945-01-01', 1, 'Ficción', 2),
            ('La casa de los espíritus', '1982-01-01', 1, 'Novela', 3);
        ");
    }

    // Insertar usuario webadmin si no existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE username = ?");
    $stmt->execute(['webadmin']);
    $countUser = $stmt->fetchColumn();

    if ($countUser == 0) {
        $hash = password_hash('admin', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        $stmt->execute(['webadmin', $hash]);
    } else {
        // Si existe, asegurarse que la contraseña sea la correcta (opcional)
        $hash = password_hash('admin', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE username = ?");
        $stmt->execute([$hash, 'webadmin']);
    }
} catch (PDOException $e) {
    die("Error al conectar o crear la base: " . $e->getMessage());
}
