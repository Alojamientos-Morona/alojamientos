<?php
//require_once __DIR__ . '/../config/database.php';


class Rol {
    public static function getRolesByUserId($userId) {
$conn = Database::getConnection();
$stmt = $conn->prepare("SELECT r.* FROM roles r
                                INNER JOIN usuario_rol ur ON r.id = ur.rol_id
                                WHERE ur.usuario_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function getAllRoles() {
$conn = Database::getConnection();
$stmt = $conn->query("SELECT * FROM roles");
        return $stmt->fetchAll();
    }

    public static function assignRoleToUser($userId, $roleId) {
$conn = Database::getConnection();
$stmt = $conn->prepare("INSERT IGNORE INTO usuario_rol (usuario_id, rol_id) VALUES (?, ?)");
        $stmt->execute([$userId, $roleId]);
    }

    public static function getPermissionsByUserId($userId) {
$conn = Database::getConnection();
$stmt = $conn->prepare("SELECT p.nombre FROM permisos p
            INNER JOIN permiso_rol rp ON p.id = rp.permiso_id
            INNER JOIN usuario_rol ur ON rp.rol_id = ur.rol_id
            WHERE ur.usuario_id = ?");
        $stmt->execute([$userId]);
        return array_column($stmt->fetchAll(), 'nombre');
    }
}
?>