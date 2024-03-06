<?php
#region Function --- Simple function to connect to the database

function connectToDatabase() {
    $conn = mysqli_connect("sql207.infinityfree.com", "if0_36018425", "bACONfRITO33", "if0_36018425_imvmdb");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
#endregion

#region Function --- Close the database connection
function closeDatabaseConnection($conn) {
    $conn->close();
}
#endregion

#region Function --- Insert ticket into database
function insertTicketIntoDatabase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate) {
    try {
        $insertTicketSQL = "INSERT INTO ticket (typeTicket, creationDate, idUsers, modificationDate, resolvedDate) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTicketSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sssss", $type, $currentDate, $user, $modificationDate, $resolvedDate);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket help support fields
function createTicketHelpSupportFields($conn, $subject, $description, $fileAttachment) {
    $user = $_SESSION['user'];
    $type = "helpSupport";
    $currentDate = date('Y/m/d'); 
    $modificationDate = null;
    $resolvedDate = null;

    insertTicketIntoDatabase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate);

    try {
        $insertTypeSQL = "INSERT INTO helpSupport (subject, description, file) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sss", $subject, $description, $fileAttachment);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket bug report fields
function createTicketBugReportFields($conn, $subject, $impactedPart, $operativeSystem, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage) {
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
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket feature request fields
function createTicketFeatureRequestFields($conn, $requestType, $subject, $description) {
    $user = $_SESSION['user'];
    $type = "featureRequest";
    $currentDate = date('Y/m/d'); 
    $modificationDate = null;
    $resolvedDate = null;

    insertTicketIntoDatabase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate);

    try {
        $insertTypeSQL = "INSERT INTO featureRequest (requestType, subject, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("ssss", $requestType, $subject, $description);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion