<?php
require_once 'models/rol.php';
require_once 'models/permiso.php';
require_once 'config/database.php';

class rolcontroller {
    public function rolesPermisos() {
$conn = Database::getConnection();        $roles = Rol::getAllRoles();
        $permisos = Permiso::getAllPermisos();
        require 'views/roles/roles_permisos.php';
    }

    public function getPermisosPorRol() {
$conn = Database::getConnection();        $roleId = $_GET['role_id'];
        $permisos = Permiso::getPermisosByRolId($roleId);
        echo json_encode(array_column($permisos, 'id'));
        exit;
    }

    public function savePermisosPorRol() {
$conn = Database::getConnection();        $roleId = $_POST['role_id'];
        $permisosSeleccionados = isset($_POST['permisos']) ? $_POST['permisos'] : [];

        $stmt = $conn->prepare("DELETE FROM permiso_rol WHERE rol_id = ?");
        $stmt->execute([$roleId]);

        $stmt = $conn->prepare("INSERT INTO permiso_rol (rol_id, permiso_id) VALUES (?, ?)");
        foreach ($permisosSeleccionados as $permisoId) {
            $stmt->execute([$roleId, $permisoId]);
        }

        echo json_encode(['success' => true]);
        exit;
    }
}
?>
