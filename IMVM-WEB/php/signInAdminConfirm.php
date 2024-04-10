<?php
# Let's make sure we're keeping track of the user's info
session_start();

#region Required files --- Everything we need on this code
# Now, we get all the database stuff
require("config.php");
require("databaseFunctions.php");

# Grab some handy tools for our code
require("redirectFunctions.php");
require("dataValidationFunctions.php");
require("errorAlerts.php");
#endregion

#region errors --- Turn on the error reporting to catch any potential coding errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
#endregion

#region 'IF-ELSE' --- First things first, let's check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    # Checking our connection to the database!
    $conn = connectToDatabase();

    #region Variable Declaration
    # Getting the username and password entered in the form
    $username = $_POST['usernameAdmin'] ?? '';
    $password = $_POST['passwordAdmin'] ?? '';

    # We store the data from the user on a new var to check if they're empty or not
    $inputs = array(
        $username,
        $password
    );
    #endregion

    # If any of these is empty, we redirect them to the sign in so they can try again
    $inputs = validateInputs($inputs);

    if ($inputs === true) {
        redirectToSignin();
    }

    # We start with a quick query to find out if the user exists on the database
    $checkExisting = "SELECT idAdmin, passwordAdmin FROM admin WHERE usernameAdmin = ?";

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

            # Passwords match, create a session for this user
            $_SESSION['admin'] = $username;
            redirectToIndex();
        } else {
            # No luck in the query, informing the user and redirecting them to the form again
            showErrorUserJS();
        }
    } else {

        # Query execution didnt work, display an error message
        showError("Something went wrong: " . $stmtCheck->error);
    }

    # We're done, close the connection
    closeDatabaseConnection($conn);
} else {

    # No POST method detected, guiding the user to the signin page (we dont let them get here without the POST)
    redirectToSignin();
}
#endregion