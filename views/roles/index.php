<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Roles</title>
    <?php require 'views/layouts/start.php'; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<?php include 'views/partials/navbar.php'; ?>

<div class="container mt-5">
  <h2 class="mb-4">Listado de Roles</h2>

    <?php if (hasPermission('crear_roles')): ?>
  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createRoleModal"title="Crear Usuario"><i class="fa-solid fa-plus"></i> Crear</button>
    <?php endif; ?>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th width="10%">ID</th>
        <th width="30%">Nombre</th>
        <th width="50%">Descripción</th>
        <th width="10%">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($roles as $rol): ?>
      <tr>
        <td><?= htmlspecialchars($rol['id']) ?></td>
        <td><?= htmlspecialchars($rol['nombre']) ?></td>
          <td><?= htmlspecialchars($rol['descripcion']) ?></td>
          <td>
              <?php if (hasPermission('editar_roles')):?>
                  <button class="btn btn-warning btn-sm edit-role-btn" data-role-id="<?= $rol['id'] ?>" data-role-nombre="<?= htmlspecialchars($rol['nombre']) ?>" data-role-descripcion="<?= htmlspecialchars($rol['descripcion']) ?>" data-bs-toggle="modal" data-bs-target="#editRoleModal"title="Editar Rol"><i class="fa-sharp-duotone fa-regular fa-pen-field"></i>
                  </button>

            <?php endif; ?>

              <?php if (hasPermission('eliminar_roles')):?>
                  <button class="btn btn-danger btn-sm delete-role-btn" data-role-id="<?= $rol['id'] ?>" data-role-nombre="<?= htmlspecialchars($rol['nombre']) ?>" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" title="Eliminar Rol"><i class="fa-solid fa-trash-can"></i></button>

            <?php endif; ?>

        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- TOAST -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="toastMsg" class="toast align-items-center text-bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">Acción realizada correctamente.</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<!-- MODALES -->
<?php include __DIR__.'/modals.php'; ?>
<?php include __DIR__.'/roles.js'; ?>


<?php require 'views/layouts/end.php'; ?>

</body>
</html>
