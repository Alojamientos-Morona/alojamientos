<?php

require_once __DIR__ . '/../config/database.php';

class Permiso {

    public static function getAllPermisos() {
$conn = Database::getConnection();
$stmt = $conn->query("SELECT * FROM permiso");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPermisosByRolId($rolId) {
$conn = Database::getConnection();
$stmt = $conn->prepare("SELECT p.id, p.nombre
                                FROM permiso p
                                INNER JOIN permiso_rol pr ON p.id = pr.permiso_id
                                WHERE pr.rol_id = ?");
        $stmt->execute([$rolId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPermisosByUserId($userId) {
$conn = Database::getConnection();
$stmt = $conn->prepare("SELECT DISTINCT p.id, p.nombre
                                FROM permiso p
                                INNER JOIN permiso_rol pr ON p.id = pr.permiso_id
                                INNER JOIN usuario_rol ur ON pr.rol_id = ur.rol_id
                                WHERE ur.usuario_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function crear($nombre, $grupo = null, $descripcion = null) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO permiso (nombre, grupo, descripcion) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $grupo, $descripcion]);
    }

    public static function existePermisoNombre($nombre) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM permiso WHERE nombre = ?");
        $stmt->execute([$nombre]);
        return $stmt->fetchColumn() > 0;
    }

/*
    public static function existePermisoNombre($nombre) {
$conn = Database::getConnection();        $stmt = $conn->prepare("SELECT COUNT(*) FROM permiso WHERE nombre = ?");
        $stmt->execute([$nombre]);
        return $stmt->fetchColumn() > 0;
    }

    public static function crear($nombre) {
$conn = Database::getConnection();        $stmt = $conn->prepare("INSERT INTO permiso (nombre) VALUES (?)");
        return $stmt->execute([$nombre]);
    }
*/
    public static function obtenerPorNombre($nombre) {
$conn = Database::getConnection();
$stmt = $conn->prepare("SELECT * FROM permiso WHERE nombre = ?");
        $stmt->execute([$nombre]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function eliminar($id) {
$conn = Database::getConnection();
$stmt = $conn->prepare("DELETE FROM permiso WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function permisosEstanEnUso($permisoIds) {
$conn = Database::getConnection();        if (empty($permisoIds)) return false;
        $in  = str_repeat('?,', count($permisoIds) - 1) . '?';
        $stmt = $conn->prepare("SELECT COUNT(*) FROM permiso_rol WHERE permiso_id IN ($in)");
        $stmt->execute($permisoIds);
        return $stmt->fetchColumn() > 0;
    }

    public static function actualizarNombre($id, $nuevoNombre) {
$conn = Database::getConnection();        $stmt = $conn->prepare("UPDATE permiso SET nombre = ? WHERE id = ?");
        return $stmt->execute([$nuevoNombre, $id]);
    }

}
?>
