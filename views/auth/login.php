<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Login de Usuario</div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?url=login">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Iniciar Sesión</button> <br>
                    </form>
                    <div class="text-center mt-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">¿Olvidaste tu contraseña?</a>
                    </div>

                    <div class="mt-3">
                        ¿No tienes cuenta? <a href="index.php?url=registrer">Regístrate aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__.'/modals.php'; ?>
<?php include __DIR__.'/login.js'; ?>

</body>
</html>


