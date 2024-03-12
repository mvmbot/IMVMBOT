<?php
#region Function --- Simple function to connect to the database
function connectToDatabase() {
    $conn = mysqli_connect("sql207.infinityfree.com", "if0_36018425", "bACONfRITO33", "if0_36018425_imvmbotdb");
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
function createTicketBase($conn, $ticketType) {

    # Get current user and date
    $user = $_SESSION['user'];
    $currentDate = date('Y-m-d H:i:s');

    try {
        # Prepare INSERT query
        $insertTicketSQL = "INSERT INTO ticket (typeTicket, creationDate, idUsers) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTicketSQL);

        # Check if query preparation was successful
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }

        # Bind parameters and execute query
        $stmt->bind_param("sss", $ticketType, $currentDate, $user);
        $stmt->execute();

        # Get inserted ticket ID
        $ticketId = getTicketID($conn);

        # Close prepared statement
        $stmt->close();
    } catch (Exception $e) {
        # Display error message
        showError("Error: " . $e->getMessage());
    }

    # Return ticket ID
    return $ticketId;
}
#endregion

#region Function --- Create ticket help support fields
function createTicketHelpSupportFields($conn, $subject, $description, $fileAttachment) {
    
    # Get both the ticket type and the ticket ID
    $ticketType = "helpSupport";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO helpSupport (subject, description, file, ticketID) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);

        # Check if query preparation was successful
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }

        # Bind parameters and execute query
        $stmt->bind_param("sssi", $subject, $description, $fileAttachment, $ticketId);
        $stmt->execute();

        # Close prepared statement
        $stmt->close();
    } catch (Exception $e) {
        
        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket bug report fields
function createTicketBugReportFields($conn, $subject, $impactedPart, $operativeSystem, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage) {

    # Get both the ticket type and the ticket ID
    $ticketType = "bugReport";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO bugReport (subject, impactedPart, operativeSystem, description, stepsToReproduce, expectedResult, receivedResult, discordClient, image, ticketID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        
        # Check if query preparation was successful
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        
        # Bind parameters and execute query
        $stmt->bind_param("sssssssssi", $subject, $impactedPart, $operativeSystem, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage, $ticketId);
        $stmt->execute();

        # Close prepared statement
        $stmt->close();
    } catch (Exception $e) {

        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket feature request fields
function createTicketFeatureRequestFields($conn, $subject, $description, $requestType) {

    # Get both the ticket type and the ticket ID
    $ticketType = "featureRequest";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO featureRequest (subject, description, ticketID, requestType) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        
        # Check if query preparation was successful
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        
        # Bind parameters and execute query
        $stmt->bind_param("ssis", $subject, $description, $ticketId, $requestType);
        $stmt->execute();

        # Close prepared statement
        $stmt->close();
    } catch (Exception $e) {

        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket grammar issues fields
function createTicketGrammarIssuesFields($conn, $subject, $description, $fileAttachment) {

    # Get both the ticket type and the ticket ID
    $ticketType = "grammarIssues";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO grammarIssues (subject, description, image, ticketID) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        
        # Check if query preparation was successful
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        
        # Bind parameters and execute query
        $stmt->bind_param("sssi", $subject, $description, $fileAttachment, $ticketId);
        $stmt->execute();

        # Close prepared statement
        $stmt->close();
    } catch (Exception $e) {

        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket information update fields
function createTicketInformationUpdateFields($conn, $subject, $updateInfo) {

    # Get both the ticket type and the ticket ID
    $ticketType = "informationUpdate";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO informationUpdate (subject, updateInfo, ticketID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        
        # Check if query preparation was successful
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        
        # Bind parameters and execute query
        $stmt->bind_param("ssi", $subject, $updateInfo, $ticketId);
        $stmt->execute();

        # Close prepared statement
        $stmt->close();
    } catch (Exception $e) {

        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket other fields
function createTicketOtherFields($conn, $subject, $description, $extraText) {

    # Get both the ticket type and the ticket ID
    $ticketType = "other";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO other (subject, description, extraText, ticketID) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);
        
        # Check if query preparation was successful
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }
        
        # Bind parameters and execute query
        $stmt->bind_param("sssi", $subject, $description, $extraText, $ticketId);
        $stmt->execute();

        # Close prepared statement
        $stmt->close();
    } catch (Exception $e) {

        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
#endregion