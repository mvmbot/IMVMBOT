<?php
session_start();


// Acces data
require_once("config.php");
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '12';
$DATABASE_NAME = 'IMVMBOT';

// Connection to the database
$conexion = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

if (mysqli_connect_error()) {

    // If it cant connect:
    exit('ERROR, CANT CONNECT:' . mysqli_connect_error());
}

// We check if the data is sent using the 'isset()' function
if (!isset($_POST['username'], $_POST['password'])) {

    // If there's no data, print the error and redirect
    header('Location: index.html');
}

// This will protect us from SQL injections
if ($stmt = $conexion->prepare('SELECT id,password FROM accounts WHERE username = ?')) {

    // Parameters of the 's' string
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
}


// We check if the data is stored on our database

$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $password);
    $stmt->fetch();

    // If the account exists, we check the password
    if ($_POST['password'] === $password) {

        // If all's alright, we create a session
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id'] = $id;
        header('Location: inicio.php');
    }
} else {

    // If the account doesnt exists, we tell 'em
    header('Location: index.html');
}

$stmt->close();