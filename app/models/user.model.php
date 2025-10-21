<?php

class UserModel
{
  private $db;

  function __construct()
  {
    $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
  }

  public function get($id)
  {
    $query = $this->db->prepare('SELECT * FROM usuarios WHERE id = ?');
    $query->execute([$id]);
    $user = $query->fetch(PDO::FETCH_OBJ);

    return $user;
  }

  public function getByUser($user)
  {
    $query = $this->db->prepare('SELECT * FROM usuarios WHERE username = ?');
    $query->execute([$user]);
    $user = $query->fetch(PDO::FETCH_OBJ);

    return $user;
  }

  public function getAll()
  {
    $query = $this->db->prepare('SELECT * FROM usuarios');
    $query->execute();

    $users = $query->fetchAll(PDO::FETCH_OBJ);

    return $users;
  }

  function insert($name, $password)
  {
    $query = $this->db->prepare("INSERT INTO usuarios(username, password) VALUES(?,?)");
    $query->execute([$name, $password]);

    return $this->db->lastInsertId();
  }
}
