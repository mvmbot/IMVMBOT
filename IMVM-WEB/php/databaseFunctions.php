<?php
#region Function --- Simple function to connect to the database

function connectToDatabase() {
    # Check connection
    $conn = mysqli_connect("sql207.infinityfree.com", "if0_36018425", "bACONfRITO33", "if0_36018425_imvmdb");
    # We kill the script if the conn doesnt work
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
}
#endregion

#region Function --- Close the database connection
function closeDatabaseConnection($conn) {
    $conn->close();
}
#endregions


# CREATE TICKET FUNCTION WITHOUT TYPE!!
function insertTicketIntoDatabase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate) {
    try {
        $insertTicketSQL = "INSERT INTO ticket (typeTicket, creationDate, idUsers, modificationDate, resolvedDate) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTicketSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sssss", $type, $currentDate, $user, $modificationDate, $resolvedDate);
        $stmt->execute();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}



function createTicketHelpSupportFields($conn, $subject, $description, $fileAttachment) {
    $conn = mysqli_connect("sql207.infinityfree.com", "if0_36018425", "bACONfRITO33", "if0_36018425_imvmdb");
    $user = $_SESSION['user'];
    $type = "helpSupport";
    $currentDate = date('Y/m/d'); 
    $modificationDate = null;
    $resolvedDate = null;

    insertTicketIntoDatabase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate);

    try {
        $insertTypeSQL = "INSERT INTO helpSupport (subject, description, file) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("ssss", $type, $subject, $description, $fileAttachment);
        $stmt->execute();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }

    $stmt->close();
    closeDatabaseConnection($conn);
}

function createTicketBugReportFields($conn, $subject, $impactedPart, $operativeSystem, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage) {
    global $conn;
    $conn = mysqli_connect("sql207.infinityfree.com", "if0_36018425", "bACONfRITO33", "if0_36018425_imvmdb");
    $user = $_SESSION['user'];
    $type = "bugReport";
    $currentDate = date('Y/m/d'); 
    $modificationDate = null;
    $resolvedDate = null;

    insertTicketIntoDatabase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate);

    try {
        $insertTypeSQL = "INSERT INTO bugReport (subject, impactedPart, operativeSystem, description, stepsToReproduce, expectedResult, receivedResult, discordClient, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sssssssss", $subject, $impactedPart, $operativeSystem, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage);
        $stmt->execute();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }

    $stmt->close();
    closeDatabaseConnection($conn);
}