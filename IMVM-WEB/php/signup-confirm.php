<?php
#region Required files
// Let's get the database stuff ready!
//require("config.php");
require("databaseFunctions.php");

// Grab some tools for our code!
require("redirectFunctions.php");
require("dataValidationFunctions.php");
require("errorAlerts.php");
#endregion

#region errors
// Turn on the lights to see any coding errors!
error_reporting(E_ALL);
ini_set('display_errors', 1);
#endregion

// Now, let's connect to our incredible database!
connectToDatabase();

#region Variable declaration
// Hey, give me the data from the user's form, okay? Thanks!
$username = $_POST['username'] ?? '';
$name = $_POST['name'] ?? '';
$surname = $_POST['surname'] ?? '';
$mail = $_POST['mail'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';
$newsletterCheckBox = isset($_POST['newsletterCheckBox']) ? 1 : 0;
#endregion

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

// Checking if the email is a valid one. We really need them to exist
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    redirectToSignup();
}

// Now, let's peek into the database and see if the chosen username or email is already taken
try {

    // Preparing a tiny query to check that
    $checkExisting = "SELECT idUsers FROM users WHERE usernameUsers = ? OR emailUsers = ?";
    $stmtCheck = $conn->prepare($checkExisting);

    // In case we did mess up in preparing the query. It happens to the best of us
    if ($stmtCheck === false) {
        throw new Exception("Oh no! Something went wrong: " . $conn->error);
    }

    // No mistakes so far Let's move on and check the results.

    // Thumbs up for binding parameters and executing the query
    $stmtCheck->bind_param("ss", $username, $mail);
    $stmtCheck->execute();
    $stmtCheck->store_result();

} catch (Exception $e) {

    // We missed there to be honest. Let's be honest about it.
    showError("Error: " . $e->getMessage());
}

// If we found any matches in the database, let them know the chosen username or email is taken
if ($stmtCheck->num_rows > 0) {
    redirectToSignin();
} else {

    // Looks like they're in the clear, let's add them to our cool users' database
    try {

        // Preparing the query to insert the user into the database
        $insertSQL = "INSERT INTO users (usernameUsers, nameUsers, surnameUsers, emailUsers, passwordUsers, acceptNewsletter) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSQL);

        // In case we did mess up preparing the query.
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }

        // Now, let's make their password secure with a hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters, cast the query, and add them to our user list
        $stmt->bind_param("ssssss", $username, $name, $surname, $mail, $hashedPassword, $newsletterCheckBox);
        $stmt->execute();

        // If everything worked like it should, send them to our main page
        if ($stmt->affected_rows > 0) {
            redirectToIndex();
        } else {

            // Something went wrong, but we ain't liying bout it
            redirectToSignup();
        }
    } catch (Exception $e) {

        // Another bump in the road. Let's tell them.
        showError("Error: " . $e->getMessage());
    }
}

// Okay, we're done with the database and our tools. Time to close up
$stmtCheck->close();
$stmt->close();
closeDatabaseConnection();