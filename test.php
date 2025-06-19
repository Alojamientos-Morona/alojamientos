<?php
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\AuthController;

$authController = new AuthController(null); // Pasa null o una conexión de prueba si es necesario

echo "Autoload funciona correctamente!";
?>