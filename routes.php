<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';
require_once 'helpers/permisos.php';

function isAdmin() {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    require_once 'models/rol.php';
    $roles = Rol::getRolesByUserId($_SESSION['user_id']);
    foreach ($roles as $rol) {
        if ($rol['nombre'] === 'Admin') {
            return true;
        }
    }
    return false;
}

function route($url) {
    switch ($url) {
        case 'login':
            require_once 'controllers/AuthController.php';
            $conn = Database::getConnection();
            $controller = new AuthController($conn);
            $controller->login();
            break;

        case 'registrer':
            require_once 'controllers/AuthController.php';
            $conn = Database::getConnection();
            $controller = new AuthController($conn);
            $controller->registrer();
            break;

        case 'logout':
            require_once 'controllers/AuthController.php';
            $conn = Database::getConnection();
            $controller = new AuthController($conn);
            $controller->logout();
            break;

        case 'usuarios':
           // if (!hasPermission('crear_roles')) { echo 'Acceso denegado'; exit; }

            if (!hasPermission('ver_usuarios')) { // corregido: 'view_users' → 'ver_usuarios'
                echo "Acceso denegado";
                exit;
            }

            require_once 'controllers/usuariocontroller.php';
            $conn = Database::getConnection();
            $controller = new UsuarioController();
            $controller->index();
            break;

        case 'assignRolesForm':
            if (!hasPermission('assign_roles')) {
                echo "Acceso denegado";
                exit;
            }
            require_once 'controllers/usuariocontroller.php';
            $conn = Database::getConnection();
            $controller = new UsuarioController();
            $controller->assignRolesForm();
            break;

        case 'assignRolesSubmit':
            if (!hasPermission('assign_roles')) {
                echo "Acceso denegado";
                exit;
            }
            require_once 'controllers/usuariocontroller.php';
            $conn = Database::getConnection();
            $controller = new UsuarioController();
            $controller->assignRolesSubmit();
            break;

        case 'dashboard':
            require 'views/dashboard/index.php';
            break;

        case 'updateUserAndRole':
            require_once 'controllers/usuariocontroller.php';
            $conn = Database::getConnection();
            $controller = new UsuarioController();
            $controller->updateUserAndRole();
            break;

        case 'createUser':
            require_once 'controllers/usuariocontroller.php';
            $conn = Database::getConnection();
            $controller = new UsuarioController();
            $controller->createUser();
            break;

        case 'deleteUser':
            require_once 'controllers/usuariocontroller.php';
            $conn = Database::getConnection();
            $controller = new UsuarioController();
            $controller->deleteUser();
            break;

        case 'roles':
            if (!hasPermission('ver_roles')) {
                echo "Acceso denegado";
                exit;
            }
            require_once 'controllers/rolcontroller.php';
            $conn = Database::getConnection();
            $controller = new RolController();
            $controller->index();
            break;

        case 'createRole':
            require_once 'controllers/rolcontroller.php';
            $conn = Database::getConnection();
            $controller = new RolController();
            $controller->createRole();
            break;

        case 'updateRole':
            require_once 'controllers/rolcontroller.php';
            $conn = Database::getConnection();
            $controller = new RolController();
            $controller->updateRole();
            break;

        case 'deleteRole':
            require_once 'controllers/rolcontroller.php';
            $conn = Database::getConnection();
            $controller = new RolController();
            $controller->deleteRole();
            break;

        case 'rolesPermisos':
            require_once 'controllers/rolcontroller.php';
            $conn = Database::getConnection();
            $controller = new RolController();
            $controller->rolesPermisos();
            break;

        case 'getPermisosPorRol':
            require_once 'controllers/rolcontroller.php';
            $conn = Database::getConnection();
            $controller = new RolController();
            $controller->getPermisosPorRol();
            break;

        case 'savePermisosPorRol':
            require_once 'controllers/rolcontroller.php';
            $conn = Database::getConnection();
            $controller = new RolController();
            $controller->savePermisosPorRol();
            break;
        case 'permisos':
            require_once 'controllers/PermisoController.php';
            $conn = Database::getConnection();
            $controller = new PermisoController();
            $controller->index();
            break;

        case 'createPermisoGrupo':
            require_once 'controllers/PermisoController.php';
            $conn = Database::getConnection();
            $controller = new PermisoController();
            $controller->createPermisoGrupo();
            break;

        case 'deletePermisoGrupo':
            require_once 'controllers/PermisoController.php';
            $conn = Database::getConnection();
            $controller = new PermisoController();
            $controller->deletePermisoGrupo();
            break;
        case 'updatePermisoGrupo':
            require_once 'controllers/PermisoController.php';
            $conn = Database::getConnection();
            $controller = new PermisoController();
            $controller->updateGrupo();
            break;

        case 'createPermisoEspecial':
            require_once 'controllers/PermisoController.php';
            $conn = Database::getConnection();
            $controller = new PermisoController();
            $controller->createPermisoEspecial();
            break;
        case 'syncPermisos':
            require_once 'controllers/PermisoController.php';
            $controller = new PermisoController();
            $controller->syncPermisos();
            break;

        case 'exportPermisos':
            require_once 'controllers/PermisoController.php';
            $controller = new PermisoController();
            $controller->exportPermisos();
            break;

        case 'changeUserPassword':

            require_once 'controllers/usuariocontroller.php';
            $conn = Database::getConnection();
            $controller = new UsuarioController();
            $controller->changeUserPassword();
            break;

        case 'sendResetLink':
            require_once 'controllers/AuthController.php';
            $conn = Database::getConnection();
            $controller = new AuthController($conn);
            $controller->sendResetLink();
            break;

        case 'resetPassword':
            require_once 'controllers/AuthController.php';
            $conn = Database::getConnection();
            $controller = new AuthController($conn);
            $controller->mostrarFormularioReset();
            break;

        case 'submitNewPassword':
            require_once 'controllers/AuthController.php';
            $conn = Database::getConnection();
            $controller = new AuthController($conn);
            $controller->actualizarNuevaPassword();
            break;

        default:
            echo "404 - Página no encontrada";
            break;
    }
}
?>
