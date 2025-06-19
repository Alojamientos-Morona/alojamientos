<?php

require_once 'models/usuario.php';

class AuthController {
    private $usuarioModel;
    private $conn; // <- Agrega esta línea
    public function __construct($conn) {
        $this->usuarioModel = new Usuario($conn);
    }

    public function login() {
$conn = Database::getConnection();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $usuario = $this->usuarioModel->obtenerPorEmail($email);

            if ($usuario && password_verify($password, $usuario['password'])) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'] ?? $usuario['email'];

                require_once 'helpers/permisos.php';
                $_SESSION['permisos'] = loadUserPermissions($usuario['id']); // CORREGIDO

                header("Location: index.php?url=dashboard"); // puedes cambiar a dashboard si quieres
                exit;
            } else {
                $_SESSION['error'] = 'Credenciales incorrectas';
                header("Location: index.php?url=login");
                exit;
            }
        } else {
            require 'views/auth/login.php';
        }
    }

    public function registrer() {
        require 'views/auth/registrer.php';
    }



    /*
    public function register($nombre, $email, $password) {
        if ($this->usuarioModel->obtenerPorEmail($email)) {
            return false;
        }

        $usuario_id = $this->usuarioModel->crear($nombre, $email, $password);
        return $usuario_id ? true : false;
    }
*/
    public function logout() {
        session_destroy();
        header("Location: index.php?url=login");
        exit;
    }

    public function sendResetLink() {
        $email = $_POST['email'] ?? '';

        $usuario = $this->usuarioModel->obtenerPorEmail($email);
        if (!$usuario) {
            echo "Correo no registrado";
            return;
        }

        $token = bin2hex(random_bytes(32));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $this->conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$email, $token, $expira]);

        $enlace = "http://localhost/alojamientos/index.php?url=resetPassword&token=$token";

        // Usa mail() o una librería como PHPMailer en producción
        mail($email, "Recuperar contraseña", "Haz clic aquí para cambiar tu contraseña:\n$enlace");

        echo "Correo enviado correctamente";
    }

    public function mostrarFormularioReset() {
        $token = $_GET['token'] ?? '';
        require 'views/auth/reset_password.php';
    }

    public function actualizarNuevaPassword() {
        require 'config/database.php';
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm) {
            echo "Las contraseñas no coinciden.";
            return;
        }

        $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
        $stmt->execute([$token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo "Token inválido o expirado.";
            return;
        }

        $email = $row['email'];
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE usuarios SET password = ? WHERE email = ?");
        $update->execute([$newHash, $email]);

        $conn->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

        echo "<script>alert('Contraseña actualizada correctamente'); window.location='index.php?url=login';</script>";
    }


}
?>
