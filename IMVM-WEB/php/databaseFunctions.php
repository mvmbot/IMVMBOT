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
    session_start();
    $user = $_SESSION['user'];
    $currentDate = date('Y-m-d H:i:s');
    $idUsers = '';

    # Prepare the SQL query
    $sql = "SELECT idUsers FROM users WHERE usernameUsers = ?";

    # Prepare statement
    $stmt = $conn->prepare($sql);

    # Bind parameters
    $stmt->bind_param("s", $user);

    # Execute statement
    $stmt->execute();

    # Bind result variables
    $stmt->bind_result($idUsers);

    # Fetch the result
    $stmt->fetch();

    # Close statement
    $stmt->close();

    try {
        # Prepare INSERT query
        $insertTicketSQL = "INSERT INTO ticket (typeTicket, creationDate, idUsers) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTicketSQL);

        # Check if query preparation was successful
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }

        # Bind parameters and execute query
        $stmt->bind_param("sss", $ticketType, $currentDate, $idUsers);
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
function createTicketHelpSupport($conn, $subject, $description, $fileAttachment) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Help & Support";
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
function createTicketBugReport($conn, $subject, $operativeSystem, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Bug Reporting";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO bugReport (subject, operativeSystem, description, stepsToReproduce, expectedResult, receivedResult, discordClient, image, ticketID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertTypeSQL);

        # Check if query preparation was successful
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }

        # Bind parameters and execute query
        $stmt->bind_param("ssssssssi", $subject, $operativeSystem, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage, $ticketId);
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
function createTicketFeatureRequest($conn, $requestType, $subject, $description) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Feature Request";
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
function createTicketGrammarIssues($conn, $subject, $description, $fileAttachment) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Grammar";
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
function createTicketInformationUpdate($conn, $subject, $updateInfo) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Information Update";
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
function createTicketOther($conn, $subject, $description, $extraText) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Other";
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

#region Function --- Get the Ticket ID
function updateTicketBase($ticketID, $stateTicket) {
    
    $conn = connectToDatabase();

    try {
        $updateSQL = "UPDATE ticket SET modificationDate = ?, stateTicket = ? WHERE ticketID = ?";
        $currentDate = date('Y-m-d H:i:s');
        $stmt = $conn->prepare($updateSQL);
        $stmt->bind_param("ssi", $currentDate, $stateTicket, $ticketID);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
#endregion