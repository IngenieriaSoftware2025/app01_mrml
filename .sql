-- Crear base de datos
CREATE DATABASE app_montoya;

-- Seleccionar base
DATABASE app_montoya;

-- Eliminar tablas si existen (opcional en pruebas)

-- Tabla de categorías
CREATE TABLE categorias (
    id_categoria SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Tabla de prioridades
CREATE TABLE prioridades (
    id_prioridad SERIAL PRIMARY KEY,
    nivel VARCHAR(20) NOT NULL
);

select * from categorias

-- Tabla de productos
CREATE TABLE productos (
    id_producto SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cantidad INTEGER NOT NULL,
    id_categoria INTEGER NOT NULL,
    id_prioridad INTEGER NOT NULL,
    notas_adicionales VARCHAR(250),
    situacion_comprado SMALLINT DEFAULT 0,
    situacion smallint default 1,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    FOREIGN KEY (id_prioridad) REFERENCES prioridades(id_prioridad)
);

-- Insertar categorías
INSERT INTO categorias (nombre) VALUES 
('Frutas'), ('Verduras'), ('Lácteos'), ('Carnes'), ('Bebidas'),
('Snacks'), ('Panadería'), ('Limpieza'), ('Higiene Personal'),
('Otros'), ('Cereales y Granos'), ('Enlatados'), ('Congelados'),
('Condimentos y Salsas'), ('Pastas y Arroces'), 
('Productos para Mascotas'), ('Electrónica'), 
('Papelería'), ('Ropa y Calzado'), ('Herramientas y Ferretería');

-- Insertar prioridades correctas
INSERT INTO prioridades (nivel) VALUES ('Alta');
INSERT INTO prioridades (nivel) VALUES ('Media');
INSERT INTO prioridades (nivel) VALUES ('Baja');

SELECT id_prioridad, nivel FROM prioridades;