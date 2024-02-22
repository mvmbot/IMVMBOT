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
    typeTicket ENUM('Help & Support', 'Bug Reporting', 'Feature Request', 'Abuse Report', 'General Inquiry', 'Improvement Suggestions', 'Grammar/Translation Issues', 'Information Update', 'Other') NOT NULL,
    creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modificationDate DATE NULL,
    resolvedDate TIMESTAMP,
    stateTicket ENUM('Open', 'In progress', 'Closed') DEFAULT 'In progress',
    idUsers INT,
    FOREIGN KEY (idUsers) REFERENCES users(idUsers)
);

-- Help & Support
CREATE TABLE `Help & Support` (
    ticketID INT NOT NULL,
    typeTicket VARCHAR(50),
    subject VARCHAR(255),
    description TEXT,
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Bug Reporting
CREATE TABLE `Bug Reporting` (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    image VARCHAR(255),
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Feature Request
CREATE TABLE `Feature Request` (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Abuse Report
CREATE TABLE `Abuse Report` (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT.
    image VARCHAR(255),
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- General Inquiry
CREATE TABLE `General Inquiry` (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Improvement Suggestions
CREATE TABLE `Improvement Suggestions` (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Grammar/Translation Issues
CREATE TABLE `Grammar/Translation Issues` (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    image VARCHAR(255),
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Information Update
CREATE TABLE `Information Update` (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Other
CREATE TABLE `Other` (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
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

-- Jobs Page
CREATE TABLE `Collaboration/Development` (
    collaborationID INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30),
    surname VARCHAR(30),
    email VARCHAR(50),
    phone VARCHAR(20),
    address VARCHAR(255),
    positionApplied ENUM ('Web Developer','Back-end Developer','JS Programming','Community Manager'),
    experience TEXT, 
    skills TEXT, 
    coverLetter TEXT, 
    cvFile VARCHAR(255) 
);