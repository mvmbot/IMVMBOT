<?php
# Get the user's session
session_start();

#region Required files
# Database files
require ("config.php");
require_once ("databaseFunctions.php");

# Other usefull functions
require_once ("redirectFunctions.php");
require_once ("dataValidationFunctions.php");
require_once ("errorAlerts.php");
#endregion

#region Errors
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
$inputs = validateInputs($inputs);

if ($inputs === true) {
    redirectToEditProfile();
}

editUserData($conn, $table, $data);
