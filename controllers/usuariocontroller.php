<?php
require_once 'models/rol.php';
require_once 'config/database.php';

class UsuarioController {
    public function index() {
$conn = Database::getConnection();
        $stmt = $conn->query("SELECT * FROM usuarios");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Corregimos: no usamos &$usuario
        foreach ($usuarios as $key => $usuario) {
            $usuarios[$key]['roles'] = Rol::getRolesByUserId($usuario['id']);
        }

        $roles = Rol::getAllRoles();

        require 'views/usuarios/index.php';
    }

    public function assignRolesForm() {
$conn = Database::getConnection();
        $userId = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$userId]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        $roles = Rol::getAllRoles();
        $userRoles = Rol::getRolesByUserId($userId);

        require 'views/usuarios/assign_roles.php';
    }

    public function assignRolesSubmit() {
$conn = Database::getConnection();
        $userId = $_POST['user_id'];
        $roleId = $_POST['role_id'];

        Rol::assignRoleToUser($userId, $roleId);

        header("Location: index.php?url=usuarios");
    }

    public function updateUserAndRole() {
$conn = Database::getConnection();
        $userId = $_POST['user_id'];
        $email = $_POST['email'];
        $roleId = $_POST['role_id'];

        $stmt = $conn->prepare("UPDATE usuarios SET email = ? WHERE id = ?");
        $stmt->execute([$email, $userId]);

        $stmt = $conn->prepare("DELETE FROM usuario_rol WHERE usuario_id = ?");
        $stmt->execute([$userId]);

        $stmt = $conn->prepare("INSERT INTO usuario_rol (usuario_id, rol_id) VALUES (?, ?)");
        $stmt->execute([$userId, $roleId]);

        echo json_encode(['success' => true]);
        exit;
    }

    public function createUser() {
$conn = Database::getConnection();
        $email = $_POST['email'];
        $password = $_POST['password'];
        $roleId = $_POST['role_id'];

        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            echo 'duplicate';
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
        $stmt->execute([$email, $hashedPassword]);

        $userId = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO usuario_rol (usuario_id, rol_id) VALUES (?, ?)");
        $stmt->execute([$userId, $roleId]);

        echo json_encode(['success' => true]);
        exit;
    }

    public function deleteUser() {
$conn = Database::getConnection();
        $userId = $_POST['user_id'];

        $stmt = $conn->prepare("DELETE FROM usuario_rol WHERE usuario_id = ?");
        $stmt->execute([$userId]);

        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$userId]);

        echo json_encode(['success' => true]);
        exit;
    }




    public function changeUserPassword() {
        $conn = Database::getConnection();
        $userId2 = $_POST['user_id'] ?? null;
        $newPassword2 = $_POST['new_password2'] ?? '';

        if ($userId2 && $newPassword2) {
            $hashedPassword2 = password_hash($newPassword2, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            $stmt->execute([$hashedPassword2, $userId2]);
            echo "ok";
        } else {
            http_response_code(400);
            echo "Datos inválidos";
        }
    }



}
?>