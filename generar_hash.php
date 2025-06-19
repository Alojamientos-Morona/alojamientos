<?php
// Cambia 'TuContraseñaSegura' por la contraseña que quieres hashear
echo password_hash('admin', PASSWORD_DEFAULT);
?>