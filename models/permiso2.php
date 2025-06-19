<?php
class Permiso {
    public static function getAllPermisos() {
$conn = Database::getConnection();        $stmt = $conn->query("SELECT * FROM permiso");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPermisosByRolId($rolId) {
$conn = Database::getConnection();        $stmt = $conn->prepare("SELECT p.id, p.nombre
                                FROM permiso p
                                INNER JOIN permiso_rol pr ON p.id = pr.permiso_id
                                WHERE pr.rol_id = ?");
        $stmt->execute([$rolId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPermisosByUserId($userId) {
$conn = Database::getConnection();        $stmt = $conn->prepare("SELECT DISTINCT p.id, p.nombre
                                FROM permiso p
                                INNER JOIN permiso_rol pr ON p.id = pr.permiso_id
                                INNER JOIN usuario_rol ur ON pr.rol_id = ur.rol_id
                                WHERE ur.usuario_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
