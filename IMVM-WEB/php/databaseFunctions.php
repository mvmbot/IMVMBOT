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
function createTicketBase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate) {
    try {
        $insertTicketSQL = "INSERT INTO ticket (typeTicket, creationDate, idUsers, modificationDate, resolvedDate) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTicketSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sssss", $type, $currentDate, $user, $modificationDate, $resolvedDate);
        $stmt->execute();

        $ticketId = getTicketID($conn);

        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
    return $ticketId;
}

function getTicketID($conn) {
    $ticketId = mysqli_insert_id($conn);
    if ($ticketId === false) {
        showError("Error getting last inserted ID: " . $conn->error);
    }
    return $ticketId;
}
#endregion

#region Function --- Create ticket help support fields
function createTicketHelpSupportFields($conn, $subject, $description, $fileAttachment) {
    $user = $_SESSION['user'];
    $type = "helpSupport";
    $currentDate = date('Y-m-d H:i:s');
    $modificationDate = null;
    $resolvedDate = null;

    $ticketId = createTicketBase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate);

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
}
#endregion

#region Function --- Create ticket bug report fields
function createTicketBugReportFields($conn, $subject, $impactedPart, $operativeSystem, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage) {
    $user = $_SESSION['user'];
    $type = "bugReport";
    $currentDate = date('Y-m-d H:i:s');
    $modificationDate = null;
    $resolvedDate = null;

    createTicketBase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate);

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
function createTicketFeatureRequestFields($conn, $subject, $description) {
    $user = $_SESSION['user'];
    $type = "featureRequest";
    $currentDate = date('Y-m-d H:i:s');
    $modificationDate = null;
    $resolvedDate = null;

    createTicketBase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate);

    try {
        $insertTypeSQL = "INSERT INTO featureRequest (subject, description) VALUES (?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("ss", $subject, $description);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket grammar issues fields
function createTicketGrammarIssuesFields($conn, $subject, $description, $fileAttachment) {
    $user = $_SESSION['user'];
    $type = "featureRequest";
    $currentDate = date('Y-m-d H:i:s');
    $modificationDate = null;
    $resolvedDate = null;

    createTicketBase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate);

    try {
        $insertTypeSQL = "INSERT INTO grammarIssues (subject, description, fileAttachment) VALUES (?, ?, ?)";
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

#region Function --- Create ticket information update fields
function createTicketInformationUpdateFields($conn, $subject, $updateInfo) {
    $user = $_SESSION['user'];
    $type = "featureRequest";
    $currentDate = date('Y-m-d H:i:s');
    $modificationDate = null;
    $resolvedDate = null;

    createTicketBase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate);

    try {
        $insertTypeSQL = "INSERT INTO informationUpdate (subject, updateInfo) VALUES (?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("ss", $subject, $updateInfo);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket other fields
function createTicketOtherFields($conn, $subject, $description, $extraText) {
    $user = $_SESSION['user'];
    $type = "featureRequest";
    $currentDate = date('Y-m-d H:i:s');
    $modificationDate = null;
    $resolvedDate = null;

    createTicketBase($conn, $type, $currentDate, $user, $modificationDate, $resolvedDate);

    try {
        $insertTypeSQL = "INSERT INTO other (subject, description, extraText) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        $stmt->bind_param("sss", $subject, $description, $extraText);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}
#endregion