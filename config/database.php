<?php
require_once __DIR__ . '/env.php'; // Asegúrate de que esto cargue el .env correctamente

if (!class_exists('Database')) {
    class Database {
        public static function getConnection() {
            try {
                return new PDO(
                    "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8",
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASS']
                );
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
    }
}
