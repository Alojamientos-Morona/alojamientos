<?php
require_once 'models/permiso.php';

class PermisoController {

    public function index() {
        $permisos = Permiso::getAllPermisos();

        // Agrupar permisos por grupo
        $grupos = [];
        foreach ($permisos as $permiso) {
            $partes = explode('_', $permiso['nombre'], 2);
            if (count($partes) == 2) {
                $grupo = ucfirst($partes[1]);
                $grupos[$grupo][] = $permiso;
            }
        }

        require 'views/permisos/index.php';
    }


    public function createPermisoGrupo() {
        if (!empty($_POST['grupo_nombre'])) {
            $grupo = strtolower(trim($_POST['grupo_nombre']));
            $acciones = ['ver', 'crear', 'editar', 'eliminar'];

            foreach ($acciones as $accion) {
                $permisoNombre = $accion . '_' . $grupo;
                $descripcion = "Permite " . $accion ." ". ucfirst($grupo);

                if (!Permiso::existePermisoNombre($permisoNombre)) {
                    Permiso::crear($permisoNombre, $grupo, $descripcion);
                }
            }

            header("Location: index.php?url=permisos");
            exit;
        }
    }

    public function createGrupo() {
        if (isset($_POST['grupo_nombre']) && !empty($_POST['grupo_nombre'])) {
            $grupo = strtolower(trim($_POST['grupo_nombre']));

            // Crear los 4 permisos
            $acciones = ['ver', 'crear', 'editar', 'eliminar'];

            foreach ($acciones as $accion) {
                $permisoNombre = $accion . '_' . $grupo;

                // Verificar si ya existe
                if (!Permiso::existePermisoNombre($permisoNombre)) {
                    Permiso::crear($permisoNombre);
                }
            }

            header("Location: index.php?url=permisos");
            exit;
        }
    }

    public function deletePermisoGrupo() {
        if (!empty($_POST['grupo_nombre'])) {
            $grupo = trim($_POST['grupo_nombre']);
            $conn = Database::getConnection();

            // 1. Obtener todos los permisos del grupo
            $stmt = $conn->prepare("SELECT id, nombre FROM permiso WHERE grupo = ?");
            $stmt->execute([$grupo]);
            $permisos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 2. Verificar si alguno está en uso
            foreach ($permisos as $permiso) {
                $permisoId = $permiso['id'];

                $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM permiso_rol WHERE permiso_id = ?");
                $stmtCheck->execute([$permisoId]);

                if ($stmtCheck->fetchColumn() > 0) {
                    echo "<script>alert('No se puede eliminar el grupo. El permiso \"{$permiso['nombre']}\" está asignado a un rol.'); window.location='index.php?url=permisos';</script>";
                    exit;
                }
            }

            // 3. Si todos están libres, eliminar
            $stmtDelete = $conn->prepare("DELETE FROM permiso WHERE grupo = ?");
            $stmtDelete->execute([$grupo]);

            echo "<script>alert('Grupo eliminado correctamente.'); window.location='index.php?url=permisos';</script>";
            exit;
        }
    }
/*
    public function deleteGrupo() {
        if (isset($_POST['grupo_nombre']) && !empty($_POST['grupo_nombre'])) {
            $grupo = strtolower(trim($_POST['grupo_nombre']));

            $acciones = ['ver', 'crear', 'editar', 'eliminar'];
            $permisoIds = [];

            foreach ($acciones as $accion) {
                $permisoNombre = $accion . '_' . $grupo;
                $permiso = Permiso::obtenerPorNombre($permisoNombre);
                if ($permiso) {
                    $permisoIds[] = $permiso['id'];
                }
            }

            // Verificar si alguno de los permisos está en uso
            if (Permiso::permisosEstanEnUso($permisoIds)) {
                echo "<script>alert('No se puede eliminar. Algunos permisos están en uso.'); window.location='index.php?url=permisos';</script>";
                exit;
            }

            // Eliminar permisos
            foreach ($permisoIds as $permisoId) {
                Permiso::eliminar($permisoId);
            }

            header("Location: index.php?url=permisos");
            exit;
        }
    }
*/
    public function updateGrupo() {
        if (isset($_POST['grupo_nombre_actual']) && isset($_POST['grupo_nombre_nuevo'])
            && !empty($_POST['grupo_nombre_actual']) && !empty($_POST['grupo_nombre_nuevo'])) {

            $grupoActual = strtolower(trim($_POST['grupo_nombre_actual']));
            $grupoNuevo  = strtolower(trim($_POST['grupo_nombre_nuevo']));

            $acciones = ['ver', 'crear', 'editar', 'eliminar'];

            foreach ($acciones as $accion) {
                $permisoNombreActual = $accion . '_' . $grupoActual;
                $permisoNombreNuevo  = $accion . '_' . $grupoNuevo;

                $permiso = Permiso::obtenerPorNombre($permisoNombreActual);

                if ($permiso) {
                    Permiso::actualizarNombre($permiso['id'], $permisoNombreNuevo);
                }
            }

            header("Location: index.php?url=permisos");
            exit;
        }
    }

    public function createPermisoEspecial() {
        if (isset($_POST['grupo_nombre'], $_POST['permiso_especial'], $_POST['descripcion'])
            && !empty($_POST['grupo_nombre']) && !empty($_POST['permiso_especial'])) {

            $grupo = strtolower(trim($_POST['grupo_nombre']));
            $permisoEspecial = strtolower(trim($_POST['permiso_especial']));
            $descripcion = trim($_POST['descripcion']);

            // Validación: no permitir guion bajo en nombre del permiso especial
            if (strpos($permisoEspecial, '_') !== false) {
                echo "<script>alert('No se permite usar el carácter \"_\" en el nombre del permiso especial.'); window.location='index.php?url=permisos';</script>";
                exit;
            }

            $permisoNombre = $permisoEspecial . '_' . $grupo;

            if (!Permiso::existePermisoNombre($permisoNombre)) {
                Permiso::crear($permisoNombre, $grupo, $descripcion);
            }

            header("Location: index.php?url=permisos");
            exit;
        }
    }


    /*
    public function createPermisoEspecial() {
        if (isset($_POST['grupo_nombre']) && isset($_POST['permiso_especial'])
            && !empty($_POST['grupo_nombre']) && !empty($_POST['permiso_especial'])) {

            $grupo = strtolower(trim($_POST['grupo_nombre']));
            $permisoEspecial = strtolower(trim($_POST['permiso_especial']));

            // Crear permiso con formato: permiso_grupo
            $permisoNombre = $permisoEspecial . '_' . $grupo;

            if (!Permiso::existePermisoNombre($permisoNombre)) {
                Permiso::crear($permisoNombre);
            }

            header("Location: index.php?url=permisos");
            exit;
        }
    }

    */


    public function syncPermisos() {
        require_once 'models/permiso.php';

        $jsonPath = __DIR__ . '/../config/permisos_base.json'; // ajusta si el archivo está en otra ruta
        if (!file_exists($jsonPath)) {
            echo "<script>alert('Archivo permisos_base.json no encontrado'); window.location='index.php?url=permisos';</script>";
            exit;
        }

        $json = file_get_contents($jsonPath);
        $permisosBase = json_decode($json, true);
        if (!is_array($permisosBase)) {
            echo "<script>alert('El archivo JSON no tiene un formato válido'); window.location='index.php?url=permisos';</script>";
            exit;
        }

        $conn = Database::getConnection();
        $creados = 0;
        $actualizados = 0;

        foreach ($permisosBase as $permiso) {
            $stmt = $conn->prepare("SELECT id FROM permiso WHERE nombre = ?");
            $stmt->execute([$permiso['nombre']]);
            $existe = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existe) {
                $stmtUpdate = $conn->prepare("UPDATE permiso SET grupo = ?, descripcion = ? WHERE id = ?");
                $stmtUpdate->execute([$permiso['grupo'], $permiso['descripcion'], $existe['id']]);
                $actualizados++;
            } else {
                $stmtInsert = $conn->prepare("INSERT INTO permiso (nombre, grupo, descripcion) VALUES (?, ?, ?)");
                $stmtInsert->execute([$permiso['nombre'], $permiso['grupo'], $permiso['descripcion']]);
                $creados++;
            }
        }

        echo "<script>alert('Permisos sincronizados. Creados: {$creados}, Actualizados: {$actualizados}'); window.location='index.php?url=permisos';</script>";
        exit;
    }

    public function exportPermisos() {
        require_once 'models/permiso.php';

        $conn = Database::getConnection();
        $stmt = $conn->query("SELECT nombre, grupo, descripcion FROM permiso ORDER BY grupo, nombre");
        $permisos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $jsonData = json_encode($permisos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $filePath = __DIR__ . '/../config/permisos_base.json';

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        file_put_contents($filePath, $jsonData);

        echo "<script>alert('Permisos exportados correctamente a permisos_base.json'); window.location='index.php?url=permisos';</script>";
        exit;
    }

}
?>
