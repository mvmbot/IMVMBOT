<?php
#region Function --- Simple function to connect to the database
function connectToDatabase() {
    # We create a global for the conn
    global $conn;
    # Check connection
    $conn = mysqli_connect("sql207.infinityfree.com", "if0_36018425", "bACONfRITO33", "if0_36018425_imvmdb");
    # We kill the script if the conn doesnt work
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
#endregions

function createTicketHelpSupportFields($subject, $description, $fileAttachment) {
    global $conn;
    $conn = mysqli_connect("sql207.infinityfree.com", "if0_36018425", "bACONfRITO33", "if0_36018425_imvmdb");
    $user = $_SESSION['user'];
    $type = "helpSupport";
    $currentDate = date('Y/m/d'); 
    $modificationDate = null;
    $resolvedDate = null;
    # We prepare our variable with the SQL sentence
    try {
        $insertTicketSQL = "INSERT INTO ticket (typeTicket, creationDate, idUsers, modificationDate, resolvedDate) VALUES (?, ?, ?, ?, ?)";
        # And the statement to prepare it
        $stmt = $conn->prepare($insertTicketSQL);
        # In case we did mess up preparing the query.
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sssss", $type, $currentDate, $user, $modificationDate, $resolvedDate);
        $stmt->execute();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
    $stmt->close();
    closeDatabaseConnection();
}