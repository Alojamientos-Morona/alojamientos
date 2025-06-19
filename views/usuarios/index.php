<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios</title>
    <?php require 'views/layouts/start.php'; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .pagination { justify-content: center; }
    </style>
</head>
<body class="bg-light">

<?php include 'views/partials/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Listado de Usuarios</h2>
    <!-- Botón Crear Usuario -->
    <?php if (hasPermission('crear_usuarios')): ?>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal" title="Crear Usuario"><i class="fa-solid fa-plus"></i> Crear</button>
    <?php endif; ?>


    <!-- Filtro -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por Email o Rol...">
    </div>

    <!-- Botón Exportar CSV -->
    <div class="mb-3">
        <a href="index.php?url=exportUsersCSV" class="btn btn-secondary" title="Exportar a archivo CSV">Exportar <i class="fa-solid fa-file-csv"></i></a>
    </div>

    <!-- Tabla Usuarios -->
    <table class="table table-bordered table-striped" id="usuariosTable">
        <thead class="table-dark">
            <tr>
                <th width="10%">ID</th>
                <th width="50%">Email</th>
                <th width="30%">Rol</th>
                <th width="10%">Acciones</th>

            </tr>
        </thead>
        <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr data-user-id="<?= $usuario['id'] ?>" data-user-email="<?= htmlspecialchars($usuario['email']) ?>">
                <td><?= htmlspecialchars($usuario['id']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td>
                    <?php foreach ($usuario['roles'] as $rol): ?>
                        <?= htmlspecialchars($rol['nombre']) ?><br>
                    <?php endforeach; ?>
                </td>
                <td>
                    <?php if (hasPermission('editar_usuarios')): ?>
                        <button class="btn btn-sm btn-warning edit-user-btn" data-bs-toggle="modal" data-bs-target="#editUserModal"
                                data-user-id="<?= $usuario['id'] ?>"
                                data-user-email="<?= htmlspecialchars($usuario['email']) ?>"
                                data-user-role="<?= isset($usuario['roles'][0]['id']) ? $usuario['roles'][0]['id'] : '' ?>"
                            title="Editar / Asignar Rol"><i class="fa-sharp-duotone fa-regular fa-pen-field"></i>
                        </button>
                    <?php endif; ?>
                    <?php if (hasPermission('clave_usuarios')):?>

                        <button class="btn btn-sm btn-info change-password-btn"
                                data-user-id="<?= $usuario['id'] ?>"
                                data-user-email="<?= htmlspecialchars($usuario['email']) ?>"
                                data-bs-toggle="modal" data-bs-target="#changePasswordModal" title="Cambiar Contraseña">
                            <i class="fa-solid fa-asterisk"></i>
                        </button>




                    <?php endif; ?>


                    <?php if (hasPermission('eliminar_usuarios')): ?>
                        <button class="btn btn-sm btn-danger delete-user-btn" data-user-id="<?= $usuario['id'] ?>" data-user-email="<?= htmlspecialchars($usuario['email']) ?>"
                        title="Eliminar">
                             <i class="fa-solid fa-trash-can"></i>
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toastMsg" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Acción realizada correctamente.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
    </div>
</div>

<!-- MODALES -->
<?php include __DIR__.'/modals.php'; ?>

    <!-- Pagination -->
    <nav>
        <ul class="pagination"></ul>
    </nav>
</div>


<?php include __DIR__.'/usuarios.js'; ?>


<?php require 'views/layouts/end.php'; ?>

</body>
</html>
