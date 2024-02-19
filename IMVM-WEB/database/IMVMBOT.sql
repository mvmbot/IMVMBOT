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
    passwordUsers VARCHAR(255) NOT NULL,
    acceptNewsletter BIT NOT NULL
);

-- Tabla para almacenar la información de los tickets.
CREATE TABLE ticket (
    idTicket INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    typeTicket ENUM('Help & Support', 'Bug Reporting', 'Feature Request', 'Abuse Report', 'General Inquiry', 'Improvement Suggestions', 'Grammar/Translation Issues', 'Collaboration/Development', 'Information Update', 'Other') NOT NULL
    attachmentTicket VARCHAR(225);
    affairTicket VARCHAR(100) NOT NULL,
    descriptionTicket TEXT NOT NULL,
    bugTicket1 TEXT NOT NULL,
    bugTicket2 TEXT NOT NULL,
    bugTicket3 TEXT NOT NULL,
    stateTicket ENUM('Open', 'In progress', 'Closed') DEFAULT 'In progress',
    createDateTicket TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    idUsers INT,
    FOREIGN KEY (idUsers) REFERENCES users(idUsers)
);

-- Tabla para las respuestas de los admins y usuarios
CREATE TABLE response (
    idResponse INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idTicket INT NOT NULL,
    idUser INT NOT NULL,
    idAdmin INT,
    textResponse TEXT NOT NULL,
    createDateResponse TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    attachmentResponse VARCHAR(255),
    FOREIGN KEY (idTicket) REFERENCES ticket(idTicket),
    FOREIGN KEY (idUser) REFERENCES users(idUsers),
    FOREIGN KEY (idAdmin) REFERENCES admin(idAdmin)
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