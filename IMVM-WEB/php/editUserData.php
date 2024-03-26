<?php
# Get the user's session
session_start();

#region Required files
# Database files
require("config.php");
require("databaseFunctions.php");

# Other usefull functions
require("redirectFunctions.php");
require("dataValidationFunctions.php");
require("errorAlerts.php");
#endregion

#region errors
# We gotta check if there are any errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
#endregion

# We declare the connection to the database
$conn = connectToDatabase();

# Time to get the data from the user
$data = $_POST['dataNewValue'] ?? '';
$table = $_POST['table'] ?? '';

# Store them in an array
$inputs = array(
    $data,
    $table
);

# And sanitize them while checking they're not empty
$varCheck = sanitizeInputsAndCheckEmpty($inputs);

if ($varCheck === true) {
    redirectToEditProfile();
}

editUserData($conn, $table, $data);
