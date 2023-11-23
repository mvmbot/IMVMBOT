CREATE DATABASE IMVMBOT;

-- Tabla para almacenar roles y decir si el usuario es cliente o administrador
CREATE TABLE rol (
    id_rol INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type_rol VARCHAR(50) NOT NULL
);

-- Tabla para almacenar información de los usuarios
CREATE TABLE user (
    id_user INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username_user VARCHAR(50) NOT NULL UNIQUE,
    email_user VARCHAR(100) NOT NULL UNIQUE,
    password_user VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES rol(id_rol)
);

-- Tabla para almacenar información de los tickets
CREATE TABLE ticket (
    id_ticket INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    affair_ticket VARCHAR(100) NOT NULL,
    description_ticket TEXT NOT NULL,
    state_ticket ENUM('Open', 'In progress', 'Closed') DEFAULT 'Open',
    createDate_ticket TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

-- Tabla para almacenar la conversación relacionada con un ticket
CREATE TABLE trouble (
    id_trouble INT AUTO_INCREMENT PRIMARY KEY,
    description_trouble TEXT NOT NULL,
    sendDate_trouble TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_ticket INT,
    user_id INT,
    FOREIGN KEY (id_ticket) REFERENCES ticket(id_ticket),
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

-- Tabla para llevar un registro sobre los cambios en los tickets
CREATE TABLE log (
    id_log INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    id_ticket INT,
    stateBefore_log ENUM('Open', 'In progress', 'Closed'),
    stateAfter_log ENUM('Open', 'In progress', 'Closed'),
    logDate_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ticket) REFERENCES ticket (id_ticket)
);