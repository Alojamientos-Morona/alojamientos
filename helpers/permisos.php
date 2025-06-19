<?php
require_once 'models/permiso.php';

function hasPermission($permisoNombre) {
    return in_array($permisoNombre, $_SESSION['permisos']);
}

function loadUserPermissions($userId) {
    $permisos = Permiso::getPermisosByUserId($userId);
    return array_column($permisos, 'nombre');
}
?>
