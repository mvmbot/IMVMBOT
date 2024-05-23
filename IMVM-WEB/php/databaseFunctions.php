<?php

/*
 * File: databaseFunctions
 * Author: Álvaro Fernández
 * Github 1: https://github.com/afernandezmvm (School acc)
 * Github 2: https://github.com/JisuKlk (Personal acc)
 * Desc: File that contains all the functions related to the database connections
 */

require_once('dataValidationFunctions.php');

#region Function --- Simple function to connect to the database
function connectToDatabase() {
    $conn = mysqli_connect("sql207.infinityfree.com", "if0_36018425", "bACONfRITO33", "if0_36018425_imvmbotdb") ?: die("Connection failed: " . mysqli_connect_error());
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
    $ticketId = mysqli_insert_id($conn) ?: showError("Error getting last inserted ID: " . $conn->error);
    return $ticketId;
}
#endregion

#region Function --- Insert base ticket into database
function createTicketBase($conn, $ticketType) {

    # Get current user and date
    session_start();
    $user = $_SESSION['user'];
    $currentDate = date('Y-m-d H:i:s');
    $idUsers = '';

    # Prepare the SQL query
    $sql = "SELECT idUsers FROM users WHERE usernameUsers = ?";

    # Prepare statement
    $stmt = $conn->prepare($sql) ?: throw new Exception("Error preparing SELECT statement: " . $conn->error);

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
        # Check if query preparation was successful
        $stmt = $conn->prepare($insertTicketSQL) ?: throw new Exception("Error preparing INSERT statement: " . $conn->error);


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

#region Function --- Help & support
function createTicketHelpSupport($conn, $inputs, $fileAttachment) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Help & Support";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO helpSupport (subject, description, file, ticketID) VALUES (?, ?, ?, ?)";
        # Check if the query preparation was successful
        $stmt = $conn->prepare($insertTypeSQL) ?: throw new Exception("Error preparing INSERT statement: " . $conn->error);


        # Bind parameters and execute query, we're using an array to get values so we just order them.
        $stmt->bind_param("sssi", $inputs[0], $inputs[1], $fileAttachment, $ticketId);
        $stmt->execute();

        # Close prepared statement
        $stmt->close();
    } catch (Exception $e) {

        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region Function --- Bug report
function createTicketBugReport($conn, $inputs, $bugImage) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Bug Reporting";
    $ticketId = createTicketBase($conn, $ticketType);

    try {
        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO bugReport (subject, operativeSystem, description, stepsToReproduce, expectedResult, receivedResult, discordClient, image, ticketID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        # Check if query preparation was successful
        $stmt = $conn->prepare($insertTypeSQL) ?: throw new Exception("Error preparing INSERT statement: " . $conn->error);

        # Bind parameters and execute query
        $stmt->bind_param("ssssssssi", $inputs[0], $inputs[1], $inputs[2], $inputs[3], $inputs[4], $inputs[5], $inputs[6], $bugImage, $ticketId);
        $stmt->execute();

        # Close prepared statement
        $stmt->close();
    } catch (Exception $e) {

        # Display error message
        showError("Error trycatch: " . $e->getMessage());
    }
}
#endregion

#region Function --- Create ticket feature request fields
function createTicketFeatureRequest($conn, $inputs) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Feature Request";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO featureRequest (subject, description, ticketID, requestType) VALUES (?, ?, ?, ?)";
        # Check if query preparation was successful
        $stmt = $conn->prepare($insertTypeSQL) ?: throw new Exception("Error preparing INSERT statement: " . $conn->error);

        # Bind parameters and execute query
        $stmt->bind_param("ssis", $inputs[0], $inputs[1], $ticketId, $inputs[2]);
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
function createTicketGrammarIssues($conn, $inputs, $fileAttachment) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Grammar";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO grammarIssues (subject, description, image, ticketID) VALUES (?, ?, ?, ?)";
        # Check if query preparation was successful
        $stmt = $conn->prepare($insertTypeSQL) ?: throw new Exception("Error preparing INSERT statement: " . $conn->error);

        # Bind parameters and execute query
        $stmt->bind_param("sssi", $inputs[0], $inputs[1], $fileAttachment, $ticketId);
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
function createTicketInformationUpdate($conn, $inputs) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Information Update";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO informationUpdate (subject, updateInfo, ticketID) VALUES (?, ?, ?)";
        # Check if query preparation was successful
        $stmt = $conn->prepare($insertTypeSQL) ?: throw new Exception("Error preparing INSERT statement: " . $conn->error);

        # Bind parameters and execute query
        $stmt->bind_param("ssi", $inputs[0], $inputs[1], $ticketId);
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
function createTicketOther($conn, $inputs) {

    # Get both the ticket type and the ticket ID
    $ticketType = "Other";
    $ticketId = createTicketBase($conn, $ticketType);

    try {

        # Prepare INSERT query
        $insertTypeSQL = "INSERT INTO other (subject, description, extraText, ticketID) VALUES (?, ?, ?, ?)";
        # Check if query preparation was successful
        $stmt = $conn->prepare($insertTypeSQL) ?: throw new Exception("Error preparing INSERT statement: " . $conn->error);

        # Bind parameters and execute query
        $stmt->bind_param("sssi", $inputs[0], $inputs[1], $inputs[2], $ticketId);
        $stmt->execute();

        # Close prepared statement
        $stmt->close();
    } catch (Exception $e) {

        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region --- Show the user's profile
function printUserData($conn) {
    # First, we grab the username of the user that's currently logged in to get all it's data from the database
    $username = $_SESSION["user"];

    # Now, we call a function that will do the SQL for us and will return the result
    $result = getUserData($conn, $username);

    # We create a $row variable to print the data
    while ($row = $result->fetch_assoc()) {
        echo "<tr style='background-color: white; color: #9900ff;'>";
        echo "<td>" . $_SESSION["user"] . "</td><td>" . $row["nameUsers"] . "</td><td>" . $row["surnameUsers"] . "</td><td>" . $row["emailUsers"] . "</td><td><img src='" . $row["profileImage"] . "'></td>";
        echo "</tr>";
    }
}

function getUserData($conn, $username) {

    try {
        # We prepare a SQL that gets all the data, simples as that 🦆
        $sql = "SELECT nameUsers, surnameUsers, emailUsers FROM users WHERE usernameUsers=?";
        $stmt = $conn->prepare($sql) ?: throw new Exception("Error preparing SELECT statement: " . $conn->error);
        $stmt->bind_param('s', $username);
        $stmt->execute();

        # Once executed, store the result in variable $result and return it
        return $stmt->get_result();
    } catch (Exception $e) {
        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
#endregion

#region ---- Edits the user's profile
function editUserData($conn, $table, $data) {
    try {
        # In this case, even if the user can choose what to update, he's updating one value at once, so we can let him choose which table will he update on a single query instead of using a switch case, just grab the table he want's to update
        $sql = "UPDATE users SET $table = ? WHERE usernameUsers = ?";
        $stmt = $conn->prepare($sql) ?: throw new Exception("Error preparing UPDATE statement: " . $conn->error);
        $stmt->bind_param('ss', $data, $_SESSION['user']);
        $stmt->execute();
        redirectToViewProfile();
    } catch (Exception $e) {
        # Display error message
        showError("Error: " . $e->getMessage());
    }
}
