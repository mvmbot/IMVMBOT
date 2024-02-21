CREATE DATABASE IMVMBOT;

-- Tabla para almacenar administradores
CREATE TABLE admin (
    idAdmin INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usernameAdminC VARCHAR(50) NOT NULL UNIQUE,
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
    attachmentTicket VARCHAR(225),
    affairTicket VARCHAR(100) NOT NULL,
    descriptionTicket TEXT NOT NULL,
    bugTicket1 TEXT NOT NULL,
    bugTicket2 TEXT NOT NULL,
    bugTicket3 TEXT NOT NULL,
    idUsers INT,
    FOREIGN KEY (idUsers) REFERENCES users(idUsers)
);

-- Help & Support
CREATE TABLE `Help & Support` (
    ticketID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    typeTicket VARCHAR(50),
    subject VARCHAR(255),
    description TEXT
);

-- Bug Reporting
CREATE TABLE `Bug Reporting` (
    bugReportID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    subject VARCHAR(255),
    description TEXT,
    image BLOB
);


-- Feature Request
CREATE TABLE `Feature Request` (
    featureRequestID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    subject VARCHAR(255),
    description TEXT
);

-- Abuse Report
CREATE TABLE `Abuse Report` (
    abuseReportID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    subject VARCHAR(255),
    description TEXT.
    image BLOB
);

-- General Inquiry
CREATE TABLE `General Inquiry` (
    generalInquiryID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    subject VARCHAR(255),
    description TEXT
);

-- Improvement Suggestions
CREATE TABLE `Improvement Suggestions` (
    improvementID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    subject VARCHAR(255),
    description TEXT
);

-- Grammar/Translation Issues
CREATE TABLE `Grammar/Translation Issues` (
    grammarTranslationID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    subject VARCHAR(255),
    description TEXT,
    image BLOB
);

-- Information Update
CREATE TABLE `Information Update` (
    informationUpdateID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    subject VARCHAR(255),
    description TEXT
);

-- Other
CREATE TABLE `Other` (
    otherID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    subject VARCHAR(255),
    description TEXT
    
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
    userID INT,
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