<?php
require_once 'config.php';

class AuthorModel {
    private $db;

    function __construct() {
        $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
    }

    function getAuthors() {
        $query = $this->db->prepare("SELECT * FROM autores");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}


