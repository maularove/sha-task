DROP TABLE IF EXISTS tareas;
DROP TABLE IF EXISTS listas;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL DEFAULT '',
    usuario VARCHAR(255) NOT NULL DEFAULT '',
    password VARCHAR(255) NOT NULL DEFAULT ''
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

CREATE TABLE listas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL DEFAULT '',
    descripcion VARCHAR(255) NOT NULL DEFAULT '',
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lista_id INT NOT NULL,
    titulo VARCHAR(100) NOT NULL DEFAULT '',
    descripcion VARCHAR(300) NOT NULL DEFAULT '',
    estado TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (lista_id) REFERENCES listas(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

-- Datos de ejemplo
INSERT INTO usuarios (nombre, usuario, password)
VALUES ('prueba', 'prueba', '1234');

INSERT INTO listas (user_id, nombre, descripcion)
VALUES (1, 'prueba', 'esta es la descripcion');

INSERT INTO tareas (lista_id, titulo, descripcion, estado)
VALUES (1, 'Tarea 1', 'Descripción de tarea 1', 0);
