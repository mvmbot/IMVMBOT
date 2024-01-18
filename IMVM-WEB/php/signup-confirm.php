<?php
include("config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check connection
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
/*echo "Connected successfully <br>";*/


// Gets the data from every input form the form
$username = isset($_POST['username']) ? $_POST['username'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$surname = isset($_POST['surname']) ? $_POST['surname'] : '';
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

if (!isset($_POST['privacyCheckbox'])) {
    header('Location: ../signup.php');
    exit;
}
// If something's empty, it ends.
if (empty($username) || empty($name) || empty($surname) || empty($mail) || empty($password) || empty($confirmPassword)) {
    header('Location: ../signup.php');
    exit;
}
// If passwords doesn't match, it ends.
if ($password !== $confirmPassword) {
    header('Location: ../signup.php');
    exit;
}

if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../signup.php');
    exit;
}



// We're printing those to check if it works

/*
echo 'Username: ' . $username . '<br>';
echo 'Name: ' . $name . '<br>';
echo 'Surname: ' . $surname . '<br>';
echo 'Mail: ' . $mail . '<br>';
echo 'Password: ' . $password . '<br>';
echo 'Confirmed Password: ' . $confirmPassword . '<br>';
*/

//First of all, we gotta check our database to see if the user is trying to create an account with an already used email or username
//We do a lil query to check it
$checkExisting = "SELECT id_users FROM users WHERE username_users = ? OR email_users = ?";
//We prepare the statement
$stmtCheck = $conn->prepare($checkExisting);
//Then we bind the parameters (thx manu for the tip, it's actually quite easy to do it this way)
$stmtCheck->bind_param("ss", $username, $mail);
//And then we execute the query
$stmtCheck->execute();
//Finaly, we store the result so we can use it
$stmtCheck->store_result();

//If there are no results in the database with that user or mail, we go on. If not, we show an error message and stop everything
if ($stmtCheck->num_rows > 0) {
    echo "Username or email already on use!";
} else {
    //If everything is fine, we go ahead and insert the data into our database
    $insertSQL = "INSERT INTO users (username_users, name_users, surname_users, email_users, password_users) VALUES (?, ?, ?, ?, ?)";
    //We prepare the query again...
    $stmt = $conn->prepare($insertSQL);
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    //Bind the parameters
    $stmt->bind_param("sssss", $username, $name, $surname, $mail, $hashedPassword);
    //And execute it!
    $stmt->execute();

    //We check if the query worked
    if ($stmt->affected_rows > 0) {
        //If it worked, we tell the user everything's allright
        //echo "User created correctly";
        header('Location: ../index.php');
        exit();
    } else {
        //Otherwise, we tell him that something went wrong
        echo "Couldn't create the user!";
    }
}
//We close the conn and statements since we're not using them anymore
$stmtCheck->close();
$stmt->close();
$conn->close();
