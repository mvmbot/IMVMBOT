<?php
// Let's make sure we're keeping track of the user's info
session_start();

#region Required files
// Now, time to set up the connection to our awesome database
require("config.php");
require("databaseFunctions.php");

// Grab some handy tools for our code
require("redirectFunctions.php");
require("dataValidationFunctions.php");
require("errorAlerts.php");
#endregion

#region errors --- Turn on the lights to catch any potential coding errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
#endregion

#region 'IF-ELSE' --- First things first, let's check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Checking our connection to the database!
    connectToDatabase();

    #region Variable Declaration
    // Getting the username and password entered in the form
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Let's make sure they filled out all the important fields
    $fieldsToCheck = ['username', 'password'];
    #endregion
    
    // If any of these is empty, let's kindly ask them to try again
    if (areFieldsEmpty($fieldsToCheck)) {
        redirectToSignin();
    }

    // Step 1: Let's check if the user exists in our awesome database

    // We start with a quick query to find out
    $checkExisting = "SELECT idUsers, passwordUsers FROM users WHERE usernameUsers = ?";

    // Preparing the statement for the big moment
    $stmtCheck = $conn->prepare($checkExisting);

    // Now, we're getting ready to bind the parameters
    $stmtCheck->bind_param("s", $username);

    // Alright, time to execute the query and see what the database tells us
    if ($stmtCheck->execute()) {
        // Got the result, storing it in a variable for some magic
        $result = $stmtCheck->get_result();

        // Did we find anything in the query?
        if ($result->num_rows > 0) {

            // Yes, we got something. Grabbing the first row (the password)
            $resultRow = $result->fetch_assoc();

            // Saving the hashed password for future comparison
            $hashedPassword = $resultRow['passwordUsers'];

            // Now, let's check if the passwords match
            if (password_verify($password, $hashedPassword)) {

                // Bingo! Passwords match, time to create a VIP session for this user
                $_SESSION['user'] = $username;
                redirectToIndex();
            } else {

                // Uh-oh! Password didn't match, sending a friendly alert and back to the form
                showErrorPasswordJS();
            }
        } else {

            // No luck in the query, informing the user and inviting them to try again
            showErrorUserJS();
        }
    } else {

        // Something went wrong with the query execution, showing a helpful error message
        showError("Oops! Something went wrong: " . $stmtCheck->error);
    }

    // Finally, let's close the database connection
    closeDatabaseConnection();
} else {

    // No POST method detected, gently guiding the user to the signin page
    redirectToSignin();
}
#endregion