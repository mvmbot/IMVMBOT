CREATE DATABASE IMVMBOT;

-- Tabla para almacenar administradores
CREATE TABLE admin (
    idAdmin INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usernameAdmin VARCHAR(50) NOT NULL UNIQUE,
    nameAdmin VARCHAR(50) NOT NULL,
    surnameAdmin VARCHAR(50) NOT NULL UNIQUE,
    emailAdmin VARCHAR(100) NOT NULL UNIQUE,
    passwordAdmin VARCHAR(255) NOT NULL
);

-- Tabla para almacenar la información de los usuarios.
CREATE TABLE users (
    idUsers INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usernameUsers VARCHAR(50) NOT NULL UNIQUE,
    nameUsers VARCHAR(50) NOT NULL,
    surnameUsers VARCHAR(50) NOT NULL,
    emailUsers VARCHAR(100) NOT NULL UNIQUE,
    passwordUsers VARCHAR(255) NOT NULL
);

-- Tabla para almacenar la información de los tickets.
CREATE TABLE ticket (
    idTicket INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    typeTicket ENUM('Help & Support', 'Bug Reporting', 'Feature Request','General Inquiry','', 'Other') NOT NULL, 
    affairTicket VARCHAR(100) NOT NULL,
    descriptionTicket TEXT NOT NULL,
    stateTicket ENUM('Open', 'In progress', 'Closed') DEFAULT 'Open',
    createDateTicket TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    idUsers INT,
    FOREIGN KEY (idUsers) REFERENCES users(idUsers)
);

-- Tabla para almacenar todo lo relacionado a los tickets.
CREATE TABLE trouble (
    idTrouble INT AUTO_INCREMENT PRIMARY KEY,
    descriptionTrouble TEXT NOT NULL,
    sendDateTrouble TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    idTicket INT,
    idUsers INT,
    idAdmin INT,
    FOREIGN KEY (idAdmin) REFERENCES admin(idAdmin),
    FOREIGN KEY (idTicket) REFERENCES ticket(idTicket),
    FOREIGN KEY (idUsers) REFERENCES users(idUsers)
);

-- Tabla para llevar un registro sobre los cambios en los tickets.
CREATE TABLE log (
    idLog INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    idTicket INT,
    stateBeforeLog ENUM('Open', 'In progress', 'Closed'),
    stateAfterLog ENUM('Open', 'In progress', 'Closed'),
    logDateLog TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idTicket) REFERENCES ticket (idTicket)
);