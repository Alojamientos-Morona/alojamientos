<?php

class Usuario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerPorEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
        $stmt->execute([$email, $passwordHash]);

        return $this->conn->lastInsertId();
    }

    public function obtenerTodos() {
        $stmt = $this->conn->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
