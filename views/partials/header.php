<?php
session_start();

// Redireccionar si no está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?url=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Alojamientos</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php?url=usuarios">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?url=roles">Roles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?url=rolesPermisos">Permisos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="index.php?url=logout">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
