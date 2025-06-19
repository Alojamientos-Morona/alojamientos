
CREATE DATABASE IF NOT EXISTS alojamientos DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE alojamientos;

DROP TABLE IF EXISTS usuario_rol;
DROP TABLE IF EXISTS permiso_rol;
DROP TABLE IF EXISTS permisos;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuario_rol (
    usuario_id INT NOT NULL,
    rol_id INT NOT NULL,
    PRIMARY KEY (usuario_id, rol_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255)
);

CREATE TABLE permiso_rol (
    rol_id INT NOT NULL,
    permiso_id INT NOT NULL,
    PRIMARY KEY (rol_id, permiso_id),
    FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permiso_id) REFERENCES permisos(id) ON DELETE CASCADE
);

INSERT INTO usuarios (email, password) VALUES
('admin@example.com', '$2y$10$0L1JErVVjdXG43PkpB0L7OR27RUXi9R0VoKyRQheNgxe9snKvH20q');

INSERT INTO roles (nombre, descripcion) VALUES
('Admin', 'Acceso total al sistema');

INSERT INTO usuario_rol (usuario_id, rol_id) VALUES
(1, 1);

INSERT INTO permisos (nombre, descripcion) VALUES
('view_users', 'Ver listado de usuarios'),
('assign_roles', 'Asignar roles a usuarios'),
('view_dashboard', 'Acceder al dashboard');

INSERT INTO permiso_rol (rol_id, permiso_id)
SELECT 1, id FROM permisos;
