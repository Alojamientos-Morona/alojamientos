<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Grupos de Permisos</title>
    <?php require 'views/layouts/start.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<?php include 'views/partials/navbar.php'; ?>

<div class="container mt-5">

    <div class="row">
        <div class="col-md-10">
    <h2 class="mb-4">Administrar Grupos de Permisos</h2>
        </div>
            <div class="col-md-1">
    <!-- Botón para sincronizar permisos -->
    <form action="index.php?url=syncPermisos" method="POST" class="mb-3">
        <!-- Botones de sincronización y exportación -->
        <div class="mb-4 d-flex gap-3">
            <a href="index.php?url=syncPermisos" class="btn btn-warning" title="Del json a la base de datos"><i class="fa-solid fa-2x fa-download"></i></a>
            <a href="index.php?url=exportPermisos" class="btn btn-info" title="De la base de datos al json"><i class="fa-solid fa-2x fa-upload"></i></a>
        </div>

            </div>

    </div>

    </form>


    <!-- Formulario Crear Grupo -->
    <form action="index.php?url=createPermisoGrupo" method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" name="grupo_nombre" class="form-control" placeholder="Nombre del Grupo (Ej: usuarios, roles, productos)" required>
            <button type="submit" class="btn btn-success">Crear Grupo</button>
        </div>
    </form>

    <!-- Formulario Crear Permiso Especial -->
    <form action="index.php?url=createPermisoEspecial" method="POST" class="mb-4">

    <card class="card bg-50 p-3">
        <h3>Permisos Especiales</h3>
        <div class="row">
            <div class="col-md-4">
                <select name="grupo_nombre" class="form-select" required>
                    <option value="">-- Seleccionar Grupo --</option>
                    <?php foreach (array_keys($grupos) as $grupoNombre): ?>
                        <option value="<?= strtolower($grupoNombre) ?>"><?= htmlspecialchars($grupoNombre) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="permiso_especial" class="form-control" id="permiso_especial_input"
                       placeholder="Nombre del Permiso Especial (ej: reporte)" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="descripcion" class="form-control"
                       placeholder="Descripción del permiso (ej: Ver reporte de usuarios)" required>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col text-end">
                <button type="submit" class="btn btn-primary">Crear Permiso Especial</button>
            </div>
        </div>
    </card>
    </form>


    <!--


    < !-- Formulario Crear Permiso Especial - ->
    <form action="index.php?url=createPermisoEspecial" method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="grupo_nombre" class="form-select" required>
                    <option value="">-- Seleccionar Grupo --</option>
                    <?php foreach (array_keys($grupos) as $grupoNombre): ?>
                        <option value="<?= strtolower($grupoNombre) ?>"><?= htmlspecialchars($grupoNombre) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                < !-- Aquí agrego el ID - ->
                <input type="text" name="permiso_especial" class="form-control" id="permiso_especial_input"
                       placeholder="Nombre del Permiso Especial (ej: reporte)" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Crear Permiso Especial</button>
            </div>
        </div>
    </form>
    -->


    <!-- Tabla de Grupos -->
    <table class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th>Grupo</th>
            <th>Permisos</th>
            <th>Permisos Especiales</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($grupos as $grupoNombre => $permisosGrupo): ?>
            <tr>
                <td><strong><?= htmlspecialchars($grupoNombre) ?></strong>
<br>

                </td>
                <td>
                    <?php foreach ($permisosGrupo as $permiso): ?>
                        <?php
                        $partes = explode('_', $permiso['nombre'], 2);
                        if (count($partes) == 2 && in_array($partes[0], ['ver','crear','editar','eliminar'])): ?>
                            <?= htmlspecialchars($permiso['nombre']) ?><br>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>
<td>
    <?php foreach ($permisosGrupo as $permiso): ?>
        <?php
        $partes = explode('_', $permiso['nombre'], 2);
        if (count($partes) == 2 && !in_array($partes[0], ['ver','crear','editar','eliminar'])): ?>
            <?= htmlspecialchars($permiso['nombre']) ?><br>
        <?php endif; ?>
    <?php endforeach; ?>

</td>




                <td>
                    <form action="index.php?url=deletePermisoGrupo" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar este grupo?');" class="mb-2">
                        <input type="hidden" name="grupo_nombre" value="<?= strtolower($grupoNombre) ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar Grupo</button>
                    </form>


                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        // Evitar que se escriba _ en el campo permiso_especial
        $('#permiso_especial_input').on('keypress', function(e) {
            if (e.key === '_') {
                e.preventDefault();
                alert('No se permite usar el carácter "_" en el nombre del permiso especial.');
            }
        });
    });
</script>

<script>
    document.getElementById("permiso_especial_input").addEventListener("input", function() {
        this.value = this.value.replace(/_/g, ""); // Elimina guiones bajos
    });
</script>

<?php require 'views/layouts/end.php'; ?>
</body>
</html>