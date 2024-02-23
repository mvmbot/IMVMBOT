CREATE DATABASE IF NOT EXISTS IMVMBOT;

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
    typeTicket ENUM('Help & Support', 'Bug Reporting', 'Feature Request', 'Abuse Report', 'General Inquiry', 'Improvement Suggestions', 'Grammar', 'Information Update', 'Other') NOT NULL,
    creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modificationDate DATE NULL,
    resolvedDate TIMESTAMP,
    stateTicket ENUM('Open', 'In progress', 'Closed') DEFAULT 'In progress',
    idUsers INT,
    FOREIGN KEY (idUsers) REFERENCES users(idUsers)
);

-- Help & Support
CREATE TABLE helpSupport (
    ticketID INT NOT NULL,
    typeTicket VARCHAR(50) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    file VARCHAR(255)
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Bug Reporting
CREATE TABLE bugReport (
    ticketID INT NOT NULL,
    impactedPart ENUM('HOME', 'ABOUT', 'FAQ', 'CHANGELOG', 'SIGN-IN', 'SIGN-UP', 'LOG-OUT', 'CREATE-TICKET', 'VIEW-TICKET', 'COOKIES'),
    operativeSystem ENUM('Android','iOS','Windows','MACos','Linux', 'Browser'),
    subject VARCHAR(255),
    description TEXT,
    stepsToReproduce VARCHAR(255),
    expectedResult VARCHAR(255),
    receivedResult VARCHAR(255),
    discordClient VARCHAR(255),
    image VARCHAR(255),
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Feature Request
CREATE TABLE featureRequest (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    section ENUM('HOME', 'ABOUT', 'FAQ', 'CHANGELOG', 'SIGN-IN', 'SIGN-UP', 'LOG-OUT', 'CREATE-TICKET', 'VIEW-TICKET', 'COOKIES'),
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Grammar Issues
CREATE TABLE grammarIssues (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    image VARCHAR(255),
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Information Update
CREATE TABLE informationUpdate (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    FOREIGN KEY (ticketID) REFERENCES ticket(idTicket)
);

-- Other
CREATE TABLE other (
    ticketID INT NOT NULL,
    subject VARCHAR(255),
    description TEXT,
    extraText VARCHAR(255),
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
CREATE TABLE collaborationDevelopment (
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