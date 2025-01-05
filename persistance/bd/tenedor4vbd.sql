-- Crear la base de datos y seleccionarlaç
CREATE DATABASE IF NOT EXISTS tenedor4vbd;
USE tenedor4vbd;

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    idUser INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL
);

-- Crear tabla de categorías
CREATE TABLE IF NOT EXISTS category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

-- Crear tabla de restaurantes
CREATE TABLE IF NOT EXISTS restaurant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(500) NOT NULL,
    minorprice INT NOT NULL,
    mayorprice INT NOT NULL,
    menu TEXT NOT NULL,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES category(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- Crear tabla de reservas
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    hora TIME NOT NULL,
    comensales INT NOT NULL,
    ip VARCHAR(255) NOT NULL
);

-- Insertar usuarios
INSERT IGNORE INTO users (email, password, type) VALUES
    ('admin', '1234', "Admin"),
    ('gestor', '12345', "Gestor");

-- Insertar categorías
INSERT IGNORE INTO category (name) VALUES
    ('Italiana'),
    ('Japonesa'),
    ('Mexicana'),
    ('Vegetariana'),
    ('Barbacoa');

-- Insertar restaurantes
INSERT IGNORE INTO restaurant (name, image, minorprice, mayorprice, menu, category_id) VALUES
    ('La Pasta Bella', 'https://example.com/images/lapastabella.jpg', 20, 30, 'Spaghetti, Lasagna, Ravioli', 1),
    ('Sushi Zen', 'https://example.com/images/sushizen.jpg', 25, 40, 'Sashimi, Nigiri, Maki Rolls', 2),
    ('El Sombrero Loco', 'https://example.com/images/elsombreroloco.jpg', 15, 25, 'Tacos, Enchiladas, Quesadillas', 3),
    ('Green Delight', 'https://example.com/images/greendelight.jpg', 10, 20, 'Vegetarian Burgers, Salads, Smoothies', 4),
    ('Asado Supremo', 'https://example.com/images/asadosupremo.jpg', 30, 50, 'Ribs, Steak, BBQ Chicken', 5);
