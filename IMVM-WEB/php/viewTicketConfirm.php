<?php
function viewTicket($conn, $type) {

    #region --- Get the user ID
    $user = $_SESSION['user'];
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
    #endregion

    switch ($type) {
        case 'helpSupport':
            # Get every ticket from X type from the user
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, hs.subject
            FROM ticket t
            JOIN helpSupport hs ON t.idTicket = hs.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Help & Support' AND u.idUsers = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $idUsers);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($type, $result);
            break;

        case 'bugReport':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, br.operativeSystem, br.subject
            FROM ticket t
            JOIN bugReport br ON t.idTicket = br.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Bug Reporting' AND u.idUsers = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $idUsers);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($type, $result);
            break;

        case 'featureRequest':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, fr.subject, fr.requestType
            FROM ticket t
            JOIN featureRequest fr ON t.idTicket = fr.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Feature Request' AND u.idUsers = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $idUsers);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($type, $result);
            break;

        case 'grammarIssues':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, gi.subject
            FROM ticket t
            JOIN grammarIssues gi ON t.idTicket = gi.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Grammar Issues' AND u.idUsers =?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $idUsers);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($type, $result);
            break;

        case 'informationUpdate':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, iu.subject
            FROM ticket t
            JOIN informationUpdate iu ON t.idTicket = iu.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Information Update' AND u.idUsers = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $idUsers);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($type, $result);
            break;

        case 'other':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, o.subject, o.description, o.extraText
            FROM ticket t
            JOIN other o ON t.idTicket = o.ticketId
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Other' AND u.idUsers = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $idUsers);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($type, $result);
            break;
        default:
            break;
    }
}

function printTicket($type, $result) {
    switch ($type) {
        case 'helpSupport':
            try {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th> [ <a href='ticketDetailsView.php?ID=" . $row['idTicket'] . "'>View Details</a> ]</th>";
                        echo "</tr>";
                    }
                } else {
                    echo "<p>No tickets of this type!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;

        case 'bugReport':
            try {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["operativeSystem"] . "</th><th>" . $row["subject"] . "</th><th> [ <a href='ticketDetailsView.php?ID=" . $row['idTicket'] . "'>View Details</a> ]</th>";
                        echo "</tr>";
                    }
                } else {
                    echo "<p>No tickets of this type!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;

        case 'featureRequest':
            try {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>" . $row["requestedType"] . "</th><th> [ <a href='ticketDetailsView.php?ID=" . $row['idTicket'] . "'>View Details</a> ]</th>";
                        echo "</tr>";
                    }
                } else {
                    echo "<p>No tickets of this type!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;

        case 'grammarIssues':
            try {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th> [ <a href='ticketDetailsView.php?ID=" . $row['idTicket'] . "'>View Details</a> ]</th>";
                        echo "</tr>";
                    }
                } else {
                    echo "<p>No tickets of this type!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;

        case 'informationUpdate':
            try {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th> [ <a href='ticketDetailsView.php?ID=" . $row['idTicket'] . "'>View Details</a> ]</th>";
                        echo "</tr>";
                    }
                } else {
                    echo "<p>No tickets of this type!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;

        case 'other':
            try {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>" . $row["description"] . "</th><th>" . $row["extraText"] . "</th><th> [ <a href='ticketDetailsView.php?ID=" . $row['idTicket'] . "'>View Details</a> ]</th>";
                        echo "</tr>";
                    }
                } else {
                    echo "<p>No tickets of this type!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;
        default:
            break;
    }
}