<?php
function viewTicketDetail($conn, $id, $type) {
    $id = intval($_GET['ID']);
    switch ($type) {
        case 'helpSupport':
            # Get every ticket from X type from the user
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, hs.subject, hs.description, hs.file 
            FROM ticket t 
            JOIN helpSupport hs ON t.idTicket = hs.ticketID 
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Help & Support' AND t.idTicket = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($conn, $type);
            break;

        case 'bugReport':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, br.operativeSystem, br.subject, br.description, stepsToReproduce, br.expectedResult, br.receivedResult, br.discordClient, br.discordClient 
            FROM ticket t 
            JOIN bugReport br ON t.idTicket = br.ticketID 
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Bug Reporting' AND t.idTicket = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($conn, $type);
            break;

        case 'featureRequest':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, fr.subject, fr.description, fr.requestType 
            FROM ticket t
            JOIN featureRequest fr ON t.idTicket = fr.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Feature Request' AND t.idTicket = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($conn, $type);
            break;

        case 'grammarIssues':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, gi.subject, gi.description, gi.image 
            FROM ticket t 
            JOIN grammarIssues gi ON t.idTicket = gi.ticketID 
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Grammar Issues' AND t.idTicket =?";
            break;

        case 'informationUpdate':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, iu.subject, ui.updateInfo 
            FROM ticket t
            JOIN informationUpdate iu ON t.idTicket = iu.ticket
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Information Update' AND t.idTicket = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($conn, $type);
            break;

        case 'other':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, o.subject, o.description, o.extraText 
            FROM ticket t
            JOIN other o ON t.idTicket = o.ticketId
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Other' AND t.idTicket = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicket($conn, $type);
            break;
        default:
            break;
    }


    $sql = "SELECT idTicket, typeTicket, creationDate, modificationDate, resolvedDate, stateTicket FROM ticket WHERE idTicket = ?";
    # Prepare statement
    $stmt = $conn->prepare($sql);

    # Bind parameters
    $stmt->bind_param("i", $id);

    # Execute statement
    $stmt->execute();

    # Store the result
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<p>There's no tickets to process.</p>";
    } else {
        //llegim la linia de la consulta
        $row = $result->fetch_assoc();
        echo "<tr>";
        echo "<th>" . $row["idTicket"] . "</th><br><th>" . $row["typeTicket"] . "</th><br><th>" . $row["stateTicket"] . "</th>[ <a href='viewTicket.php?ID=" . $row['idTicket'] . "'>Edit</a> ]</th>";
        echo "</tr>";

    # Close statement
    $stmt->close();
    }
}