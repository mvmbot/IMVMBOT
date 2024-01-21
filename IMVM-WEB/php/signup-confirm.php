<?php

// Let's get the database stuff ready!
require("config.php");
require("databaseFunctions.php");

// Grab some tools for our code!
require("redirectFunctions.php");
require("dataValidationFunctions.php");
require("errorAlerts.php");

// Turn on the lights to see any coding errors!
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Now, let's connect to our incredible database!
connectToDatabase();

// Hey, give me the data from the user's form, okay? Thanks!
$username = $_POST['username'] ?? '';
$name = $_POST['name'] ?? '';
$surname = $_POST['surname'] ?? '';
$mail = $_POST['mail'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

// Oops! Did they forget to check the privacy box?
if (!isset($_POST['privacyCheckbox'])) {
    redirectToSignup();
}

// We need to make sure they filled out all the important fields!
$fieldsToCheck = ['username', 'name', 'surname', 'mail', 'password', 'confirmPassword'];

// If any of these is empty, we kindly ask them to try again!
if (areFieldsEmpty($fieldsToCheck)) {
    redirectToSignup();
}

// Uh-oh! The passwords don't match. Let's guide them back!
if ($password != $confirmPassword) {
    redirectToSignup();
}

// Checking if the email is a valid one! We really need them to exist!
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    redirectToSignup();
}

// Now, let's peek into the database and see if the chosen username or email is already taken!
try {

    // Preparing a tiny query to check that!
    $checkExisting = "SELECT id_users FROM users WHERE username_users = ? OR email_users = ?";
    $stmtCheck = $conn->prepare($checkExisting);

    // Oops, did we mess up in preparing the query? It happens to the best of us!
    if ($stmtCheck === false) {
        throw new Exception("Oh no! Something went wrong: " . $conn->error);
    }

    // No mistakes so far! Let's move on and check the results.

    // Thumbs up for binding parameters and executing the query!
    $stmtCheck->bind_param("ss", $username, $mail);
    $stmtCheck->execute();
    $stmtCheck->store_result();

} catch (Exception $e) {

    // Oh boy! We inted there to be honest. Let's be honest about it.
    showError("Error: " . $e->getMessage());
}

// If we found any matches in the database, let them know the chosen username or email is taken!
if ($stmtCheck->num_rows > 0) {
    redirectToSignin();
} else {

    // Looks like they're in the clear! Let's add them to our cool users' club!
    try {

        // Preparing the magic query to insert the user into the database!
        $insertSQL = "INSERT INTO users (username_users, name_users, surname_users, email_users, password_users) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSQL);

        // Uh-oh, did we mess up preparing the query? We're not perfect, you know!
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }

        // Now, let's make their password secure with a pretty cool hash!
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters, cast the query, and add them to our user list!
        $stmt->bind_param("sssss", $username, $name, $surname, $mail, $hashedPassword);
        $stmt->execute();

        // If everything worked like it should, send them to the home of the brave (index page)!
        if ($stmt->affected_rows > 0) {
            redirectToIndex();
        } else {

            // Something went wrong, but we ain't liying bout it!
            redirectToSignup();
        }
    } catch (Exception $e) {

        // Oops, another bump in the road! Let's tell them gently.
        showError("Error: " . $e->getMessage());
    }
}

// Okay, we're done with the database and our tools. Time to close up!
$stmtCheck->close();
$stmt->close();
closeDatabaseConnection();