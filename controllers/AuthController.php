<?php

require_once 'models/usuario.php';

class AuthController {
    private $usuarioModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->usuarioModel = new Usuario($conn);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $usuario = $this->usuarioModel->obtenerPorEmail($email);

            if ($usuario && password_verify($password, $usuario['password'])) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'] ?? $usuario['email'];

                require_once 'helpers/permisos.php';
                $_SESSION['permisos'] = loadUserPermissions($usuario['id']);

                header("Location: index.php?url=dashboard");
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

    public function logout() {
        session_destroy();
        header("Location: index.php?url=login");
        exit;
    }

    public function sendResetLink() {
        require 'vendor/autoload.php'; // Composer autoload

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

        // CONFIGURACIÓN ZIMBRA (PHPMailer)
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USER'];
            $mail->Password   = $_ENV['MAIL_PASS'];
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['MAIL_PORT'];

            $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
            $mail->addAddress($email); // destinatario

            $mail->isHTML(true);
            $mail->Subject = 'Recuperar contraseña';
            $mail->Body    = "
            <p>Hola,</p>
            <p>Haz clic en el siguiente enlace para cambiar tu contraseña:</p>
            <p><a href='$enlace'>$enlace</a></p>
            <p>Este enlace expirará en 1 hora.</p>
        ";

            $mail->send();
            echo "Correo enviado correctamente";
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }



    public function mostrarFormularioReset() {
        $token = $_GET['token'] ?? '';
        require 'views/auth/reset_password.php';
    }

    public function actualizarNuevaPassword() {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm) {
            echo "Las contraseñas no coinciden.";
            return;
        }

        $stmt = $this->conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
        $stmt->execute([$token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo "Token inválido o expirado.";
            return;
        }

        $email = $row['email'];
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $update = $this->conn->prepare("UPDATE usuarios SET password = ? WHERE email = ?");
        $update->execute([$newHash, $email]);

        $this->conn->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

        echo "<script>alert('Contraseña actualizada correctamente'); window.location='index.php?url=login';</script>";
    }
}
?>
