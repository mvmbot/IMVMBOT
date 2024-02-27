<?php
#region Required files
// Get the database stuff ready
require("databaseFunctions.php");

// Grab some tools for our code
require("redirectFunctions.php");
require("dataValidationFunctions.php");
require("errorAlerts.php");
#endregion

#region errors
// Turn on the error reporting to see any coding errors!
error_reporting(E_ALL);
ini_set('display_errors', 1);
#endregion

// Now, let's connect to our database!
connectToDatabase();

#region Variable declaration
// We grab all the data from the form
$username = $_POST['username'] ?? '';
