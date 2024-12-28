CREATE DATABASE IF NOT EXISTS pasteleria;

USE pasteleria;

-- Tabla de Pasteles
CREATE TABLE Pastel (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        nombre VARCHAR(255) NOT NULL,
                        descripcion TEXT,
                        preparado_por VARCHAR(255),
                        fecha_creacion DATE NOT NULL,
                        fecha_vencimiento DATE NOT NULL,
                        estado ENUM('activo', 'inactivo') DEFAULT 'activo',
                        CHECK (fecha_vencimiento > fecha_creacion)
);

-- Tabla de Ingredientes
CREATE TABLE Ingrediente (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             nombre VARCHAR(255) NOT NULL,
                             descripcion TEXT,
                             fecha_ingreso DATE NOT NULL,
                             fecha_vencimiento DATE NOT NULL,
                             inventario INT DEFAULT 0,
                             CHECK (fecha_vencimiento > fecha_ingreso)
);

-- Tabla de relación Pastel_ingredientes
CREATE TABLE Pastel_ingredientes (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     id_pastel INT NOT NULL,
                                     id_ingrediente INT NOT NULL,
                                     cantidad_usada VARCHAR(50),
                                     FOREIGN KEY (id_pastel) REFERENCES Pastel(id) ON DELETE CASCADE,
                                     FOREIGN KEY (id_ingrediente) REFERENCES Ingrediente(id) ON DELETE CASCADE
);