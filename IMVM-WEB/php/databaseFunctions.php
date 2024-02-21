<?php
#region Function --- Simple function to connect to the database
function connectToDatabase() {
    // We create a global for the conn
    global $conn;
    // Check connection
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    // We kill the script if the conn doesnt work
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
}
#endregion

#region Function --- Close the database connection
function closeDatabaseConnection() {
    global $conn;
    $conn->close();
}
#endregion