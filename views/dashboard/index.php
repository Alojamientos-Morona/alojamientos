<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <?php require 'views/layouts/start.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include 'views/partials/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Usuarios</h5>
                    <p class="card-text">Gestionar usuarios y roles.</p>
                    <a href="index.php?url=usuarios" class="btn btn-light">Ver Usuarios</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dashboard</h5>
                    <p class="card-text">Resumen del sistema.</p>
                    <a href="index.php?url=dashboard" class="btn btn-light">Actualizar</a>
                </div>
            </div>
        </div>

        <!-- Puedes agregar más tarjetas aquí -->
    </div>
</div>
</body>
</html>
<?php require 'views/layouts/end.php'; ?>
