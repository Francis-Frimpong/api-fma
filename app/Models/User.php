<?php
require_once __DIR__ .'/../Database/Database.php';

class User{
    private $pdo;

    public function __construct()
    {
      $this->pdo = Database::getConnection();
    }

    public function findUserByEmail($data)
    {
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function createUser($name, $email, $hashedPassword)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

        return $stmt->execute([$name, $email, $hashedPassword]);
    }
}