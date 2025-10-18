<?php
require_once 'config.php';

class UserModel {
    private $db;

    function __construct() {
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
    }

    function getUserByUsername($username) {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE username = ?");
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}

