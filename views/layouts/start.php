<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Panel') ?></title>
    <link rel="stylesheet" href="iconos/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            min-width: 200px;
            max-width: 200px;
            background-color: #343a40;
            color: white;
            min-height: 100vh;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-center py-3">Menú</h4>
    <a href="index.php?url=dashboard">Dashboard</a>
    <a href="index.php?url=usuarios">Usuarios</a>
    <a href="index.php?url=roles">Roles</a>
    <a href="index.php?url=rolesPermisos">Asignar Permisos</a>
    <a class="nav-link" href="index.php?url=permisos">Configurar Permisos</a>
    <a href="index.php?url=logout">Cerrar sesión</a>
</div>

<div class="content">
