<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Permisos a Roles</title>
    <?php require 'views/layouts/start.php'; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<?php include 'views/partials/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Asignar Permisos a Roles</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($roles as $rol): ?>
            <tr>
                <td><?= htmlspecialchars($rol['id']) ?></td>
                <td><?= htmlspecialchars($rol['nombre']) ?></td>
                <td>
                    <button class="btn btn-primary btn-sm assign-permissions-btn"
                            data-role-id="<?= $rol['id'] ?>"
                            data-role-nombre="<?= htmlspecialchars($rol['nombre']) ?>"
                            data-bs-toggle="modal" data-bs-target="#assignPermissionsModal">Asignar Permisos</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Asignar Permisos -->
<div class="modal fade" id="assignPermissionsModal" tabindex="-1" aria-labelledby="assignPermissionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asignar Permisos a <span id="assign_role_name"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="assignPermissionsForm">
                    <input type="hidden" name="role_id" id="assign_role_id">

                    <?php
                    // Agrupar permisos automáticamente
                    $grupos = [];
                    foreach ($permisos as $permiso) {
                        $partes = explode('_', $permiso['nombre'], 2);
                        if (count($partes) == 2) {
                            $accion = $partes[0];
                            $grupo = ucfirst($partes[1]); // Ej: Usuarios, Roles, Productos

                            if (in_array($accion, ['ver', 'crear', 'editar', 'eliminar'])) {
                                $grupos[$grupo][$accion] = $permiso;
                            } else {
                                $grupos[$grupo]['especiales'][] = $permiso;
                            }
                        }
                    }
                    ?>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Ver</th>
                            <th>Crear</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                            <th>Especiales</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($grupos as $grupoNombre => $acciones): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($grupoNombre) ?></strong></td>
                                <?php foreach (['ver', 'crear', 'editar', 'eliminar'] as $accion): ?>
                                    <td>
                                        <?php if (isset($acciones[$accion])): ?>
                                            <?php $permisoId = $acciones[$accion]['id']; ?>
                                            <input class="form-check-input permiso-checkbox" type="checkbox"
                                                   name="permisos[]" value="<?= $permisoId ?>" id="permiso<?= $permisoId ?>" title="<?= htmlspecialchars($acciones[$accion]['descripcion']) ?>">
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>

                                <!-- Columna Especiales -->
                                <td>
                                    <?php if (isset($acciones['especiales'])): ?>
                                        <!-- Botón collapse -->
                                        <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseEspecial<?= md5($grupoNombre) ?>" aria-expanded="false"
                                                aria-controls="collapseEspecial<?= md5($grupoNombre) ?>">
                                             OTROS PERMISOS
                                        </button>

                                        <!-- Card collapse -->
                                        <div class="collapse mt-2" id="collapseEspecial<?= md5($grupoNombre) ?>">
                                            <div class="card card-body p-2">
                                                <?php foreach ($acciones['especiales'] as $permisoEspecial): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                                               name="permisos[]" value="<?= $permisoEspecial['id'] ?>" id="permiso<?= $permisoEspecial['id'] ?>">
                                                        <label class="form-check-label" for="permiso<?= $permisoEspecial['id'] ?>" title="<?= htmlspecialchars($permisoEspecial['descripcion']) ?>">
                                                            <?= htmlspecialchars($permisoEspecial['nombre']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar Permisos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__.'/roles.js'; ?>
<?php require 'views/layouts/end.php'; ?>

</body>
</html>
