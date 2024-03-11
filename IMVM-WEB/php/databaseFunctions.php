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

#region Function --- Get the ticket ID
function getTicketID($conn) {
    $ticketId = mysqli_insert_id($conn);
    if ($ticketId === false) {
        showError("Error getting last inserted ID: " . $conn->error);
    }
    return $ticketId;
}
#endregion

#region Function --- Insert ticket into database
function createTicketBase($conn, $type) {

    #region Vars
    $user = $_SESSION['user'];
    $currentDate = date('Y-m-d H:i:s');
    #endregion

    #region Try-Catch --- Prepare and execute SQL query
    try {
        $insertTicketSQL = "INSERT INTO ticket (typeTicket, creationDate, idUsers) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTicketSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sssss", $type, $currentDate, $user);
        $stmt->execute();
        $ticketId = getTicketID($conn);
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
    #endregion

    return $ticketId;
}
#endregion

#region Function --- Create ticket help support fields
function createTicketHelpSupportFields($conn, $subject, $description, $fileAttachment) {
    
    #region Vars
    $type = "helpSupport";
    $ticketId = createTicketBase($conn, $type);
    #endregion

    #region Try-Catch --- Prepare and execute SQL query
    try {
        $insertTypeSQL = "INSERT INTO helpSupport (subject, description, file, ticketId) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sssi", $subject, $description, $fileAttachment, $ticketId);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
    #endregion
}
#endregion

#region Function --- Create ticket bug report fields
function createTicketBugReportFields($conn, $subject, $impactedPart, $operativeSystem, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage) {

    $type = "bugReport";
    $ticketId = createTicketBase($conn, $type);

    createTicketBase($conn, $type);

    try {
        $insertTypeSQL = "INSERT INTO bugReport (subject, impactedPart, operativeSystem, description, stepsToReproduce, expectedResult, receivedResult, discordClient, image, ticketId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sssssssssi", $subject, $impactedPart, $operativeSystem, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage, $ticketId);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket feature request fields
function createTicketFeatureRequestFields($conn, $subject, $description) {
    
    $type = "featureRequest";
    $ticketId = createTicketBase($conn, $type);

    createTicketBase($conn, $type);

    try {
        $insertTypeSQL = "INSERT INTO featureRequest (subject, description, ticketId) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("ssi", $subject, $description, $ticketId);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket grammar issues fields
function createTicketGrammarIssuesFields($conn, $subject, $description, $fileAttachment) {
    
    $type = "featureRequest";
    $ticketId = createTicketBase($conn, $type);

    createTicketBase($conn, $type);

    try {
        $insertTypeSQL = "INSERT INTO grammarIssues (subject, description, fileAttachment, ticketId) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sssi", $subject, $description, $fileAttachment, $ticketId);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket information update fields
function createTicketInformationUpdateFields($conn, $subject, $updateInfo) {
    
    $type = "featureRequest";
    $ticketId = createTicketBase($conn, $type);

    createTicketBase($conn, $type);

    try {
        $insertTypeSQL = "INSERT INTO informationUpdate (subject, updateInfo, ticketId) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("ssi", $subject, $updateInfo, $ticketId);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket other fields
function createTicketOtherFields($conn, $subject, $description, $extraText) {
    
    $type = "featureRequest";
    $ticketId = createTicketBase($conn, $type);

    createTicketBase($conn, $type);

    try {
        $insertTypeSQL = "INSERT INTO other (subject, description, extraText, ticketId) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sssi", $subject, $description, $extraText, $ticketId);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion