<?php
# Let's make sure we're keeping track of the user's info
session_start();

#region Required files
# Now, time to set up the connection to our awesome database
require("config.php");
require("databaseFunctions.php");

# Grab some handy tools for our code
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

    # Checking our connection to the database!
    $conn = connectToDatabase();

    #region Variable Declaration
    # Getting the username and password entered in the form
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    # We store the data from the user on a new var to check if they're empty or not
    $fieldsToCheck = ['username', 'password'];
    #endregion

    # If any of these is empty, we redirect them to the sign in so they can try again
    if (areFieldsEmpty($fieldsToCheck)) {
        redirectToSignin();
    }

    # We start with a quick query to find out if the user exists on the database
    $checkExisting = "SELECT idUsers, passwordUsers FROM users WHERE usernameUsers = ?";

    # Preparing the statement
    $stmtCheck = $conn->prepare($checkExisting);

    # Now, we're getting ready to bind the parameters
    $stmtCheck->bind_param("s", $username);

    # Alright, time to execute the query and see what the database tells us
    if ($stmtCheck->execute()) {
        # Got the result, storing it in a variable
        $result = $stmtCheck->get_result();

        # Did we find anything in the query?
        if ($result->num_rows > 0) {

            # Yes, we got something. Grabbing the first row (the password)
            $resultRow = $result->fetch_assoc();

            # Saving the hashed password for future comparison
            $hashedPassword = $resultRow['passwordUsers'];

            # Now, let's check if the passwords match
            if (password_verify($password, $hashedPassword)) {

            # Passwords match, create a session for this user
            $_SESSION['user'] = $username;
                redirectToIndex();
            } else {

            # Passwords doesn't match, show error
            showErrorPasswordJS();
            }
        } else {

            # No luck in the query, informing the user and redirecting them to the form again
            showErrorUserJS();
        }
    } else {

        # Query execution didnt work, display an error message
        showError("Oops! Something went wrong: " . $stmtCheck->error);
    }

    # We're done, close the connection
    closeDatabaseConnection($conn);
} else {

    # No POST method detected, guiding the user to the signin page (we dont let them get here without the POST)
    redirectToSignin();
}
#endregion