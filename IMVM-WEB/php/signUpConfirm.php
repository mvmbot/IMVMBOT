<?php

/*
 * File: signUpConfirm
 * Author: Álvaro Fernández
 * Github 1: https://github.com/afernandezmvm (School acc)
 * Github 2: https://github.com/JisuKlk (Personal acc)
 * Desc: File responsible for creating a new user
 */

#region Required files
# Let's get the database stuff ready
#require("config.php");
require_once("databaseFunctions.php");

# Grab some tools for our code
require_once("redirectFunctions.php");
require_once("dataValidationFunctions.php");
require_once("errorAlerts.php");
#endregion

#region errors
# Turn on the lights to see any coding errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
#endregion

# Now, let's connect to our database
$conn = connectToDatabase();

#region Variable declaration
# Get all the data and validate it.
$inputs = validateInputs([
    $username = $_POST['username'] ?? '',
    $name = $_POST['name'] ?? '',
    $surname = $_POST['surname'] ?? '',
    $mail = $_POST['mail'] ?? '',
    $password = $_POST['password'] ?? '',
    $confirmPassword = $_POST['confirmPassword'] ?? ''
]);

$newsletterCheckBox = isset($_POST['newsletterCheckBox']) ? 1 : 0;

#Author of the profile image part: Joel Jara (https://github.com/jarasw)
$defaultProfileImage = './img/defaultavatar.jpg'; // Default logo user

$targetDirectory = '../userProfileImgs/' . $inputs[0] . '/';
$profileImage = $defaultProfileImage;

if (!file_exists($targetDirectory)) {
    if (!mkdir($targetDirectory, 0777, true)) {
        die('Failed to create directories...');
    }
}

#region Author of the profile image part: Joel Jara (https://github.com/jarasw)
if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
    $fileAttachment = $targetDirectory . basename($_FILES["profileImage"]["name"]);
    if (validateFile($fileAttachment, 'profileImage') && move_uploaded_file($_FILES["profileImage"]["tmp_name"], $fileAttachment)) {
        $profileImage = $fileAttachment;
    }
}
#endregion

# Make sure they accept the privacy box
if (!isset($_POST['privacyCheckbox'])) {
    redirectToSignup();
}

#endregion

# Passwords gotta match
if ($inputs[4] != $inputs[5]) {
    redirectToSignup();
}

# Checking if the email is a valid one. We really need them to exist
if (!filter_var($inputs[3], FILTER_VALIDATE_EMAIL)) {
    redirectToSignup();
}

# Now, let's check the database and see if the chosen username or email is already taken
try {
    # Preparing a tiny query to check that
    $checkExisting = "SELECT idUsers FROM users WHERE usernameUsers = ? OR emailUsers = ?";
    $stmtCheck = $conn->prepare($checkExisting);

    # In case we did mess up in preparing the query.
    if ($stmtCheck === false) {
        throw new Exception("Oh no! Something went wrong: " . $conn->error);
    }

    # No mistakes so far. Let's move on and check the results.
    $stmtCheck->bind_param("ss", $inputs[0], $inputs[3]);
    $stmtCheck->execute();
    $stmtCheck->store_result();
} catch (Exception $e) {
    # Print the error
    showError("Error: " . $e->getMessage());
}

# If we found any matches in the database, let them know the chosen username or email is taken
if ($stmtCheck->num_rows > 0) {
    redirectToSignup();
} else {
    # Everything's allright, we add 'em to the database
    try {
        # Preparing the query to insert the user into the database
        $insertSQL = "INSERT INTO users (usernameUsers, nameUsers, surnameUsers, emailUsers, passwordUsers, acceptNewsletter, profileImage, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSQL);

        # In case we did mess up preparing the query.
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }

        # Now, let's make their password secure with a hash
        $hashedPassword = password_hash($inputs[4], PASSWORD_DEFAULT);
        $status = 'active'; // o el estado que desees asignar

        # Bind parameters, cast the query, and add them to our user list
        $stmt->bind_param("ssssssss", $inputs[0], $inputs[1], $inputs[2], $inputs[3], $hashedPassword, $newsletterCheckBox, $profileImage, $status);
        $stmt->execute();

        # If everything worked like it should, send them to our main page
        if ($stmt->affected_rows > 0) {
            $_SESSION['user'] = $inputs[0];
            $_SESSION['profileImage'] = $profileImage;
            redirectToIndex();
        } else {
            # Something went wrong, try again
            redirectToSignup();
        }
    } catch (Exception $e) {
        # Another bump in the road. Let's tell them.
        showError("Error: " . $e->getMessage());
    }
}

# Once we're done, close it
$stmtCheck->close();
$stmt->close();
closeDatabaseConnection($conn);