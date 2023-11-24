CREATE DATABASE IMVMBOT;

-- Tabla para almacenar administradores
CREATE TABLE admin (
    id_admin INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username_admin VARCHAR(50) NOT NULL UNIQUE,
    email_admin VARCHAR(100) NOT NULL UNIQUE,
    password_admin VARCHAR(255) NOT NULL
);

-- Tabla para almacenar la información de los usuarios.
CREATE TABLE user (
    id_user INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username_user VARCHAR(50) NOT NULL UNIQUE,
    email_user VARCHAR(100) NOT NULL UNIQUE,
    password_user VARCHAR(255) NOT NULL
);

-- Tabla para almacenar la información de los tickets.
CREATE TABLE ticket (
    id_ticket INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    affair_ticket VARCHAR(100) NOT NULL,
    description_ticket TEXT NOT NULL,
    state_ticket ENUM('Open', 'In progress', 'Closed') DEFAULT 'Open',
    createDate_ticket TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

-- Tabla para almacenar todo lo relacionado a los tickets.
CREATE TABLE trouble (
    id_trouble INT AUTO_INCREMENT PRIMARY KEY,
    description_trouble TEXT NOT NULL,
    sendDate_trouble TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_ticket INT,
    user_id INT,
    admin_id INT,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id),
    FOREIGN KEY (id_ticket) REFERENCES ticket(id_ticket),
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

-- Tabla para llevar un registro sobre los cambios en los tickets.
CREATE TABLE log (
    id_log INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    id_ticket INT,
    stateBefore_log ENUM('Open', 'In progress', 'Closed'),
    stateAfter_log ENUM('Open', 'In progress', 'Closed'),
    logDate_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ticket) REFERENCES ticket (id_ticket)
);