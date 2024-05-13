<?php
function viewTicketDetail($conn, $type)
{
    $id = intval($_GET['ID']);
    switch ($type) {
        case 'Help ':
            # Get every ticket from X type from the user
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, hs.subject, hs.description, hs.file
            FROM ticket t
            JOIN helpSupport hs ON t.idTicket = hs.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Help & Support' AND t.idTicket = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql) ?: throw new Exception("Error preparing SELECT statement (view ticket detail confirm): " . $conn->error);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketDetail($type, $result);
            break;

        case 'Bug Reporting':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, br.operativeSystem, br.subject, br.description, stepsToReproduce, br.expectedResult, br.receivedResult, br.discordClient, br.discordClient, br.image
            FROM ticket t
            JOIN bugReport br ON t.idTicket = br.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Bug Reporting' AND t.idTicket = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql) ?: throw new Exception("Error preparing SELECT statement (view ticket detail confirm): " . $conn->error);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketDetail($type, $result);
            break;

        case 'Feature Request':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, fr.subject, fr.description, fr.requestType
            FROM ticket t
            JOIN featureRequest fr ON t.idTicket = fr.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Feature Request' AND t.idTicket = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql) ?: throw new Exception("Error preparing SELECT statement (view ticket detail confirm): " . $conn->error);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketDetail($type, $result);
            break;

        case 'Grammar':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, gi.subject, gi.description, gi.image
            FROM ticket t
            JOIN grammarIssues gi ON t.idTicket = gi.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Grammar' AND t.idTicket =?";

            # Prepare statement
            $stmt = $conn->prepare($sql) ?: throw new Exception("Error preparing SELECT statement (view ticket detail confirm): " . $conn->error);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketDetail($type, $result);
            break;

        case 'Information Update':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, iu.subject, iu.updateInfo
            FROM ticket t
            JOIN informationUpdate iu ON t.idTicket = iu.ticketId
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Information Update' AND t.idTicket = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql) ?: throw new Exception("Error preparing SELECT statement (view ticket detail confirm): " . $conn->error);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketDetail($type, $result);
            break;

        case 'Other':
            $sql = "SELECT t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, o.subject, o.description, o.extraText
            FROM ticket t
            JOIN other o ON t.idTicket = o.ticketId
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Other' AND t.idTicket = ?";

            # Prepare statement
            $stmt = $conn->prepare($sql) ?: throw new Exception("Error preparing SELECT statement (view ticket detail confirm): " . $conn->error);

            # Bind parameters
            $stmt->bind_param("i", $id);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketDetail($type, $result);
            break;
        default:
            break;
    }
}

function printTicketDetail($type, $result)
{
    switch ($type) {
        case 'Help ':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable1' style='background-color: #9900ff; color: white;'>
                <thead>
                    <tr>
                        <th>Ticket No.</th>
                        <th>Type</th>
                        <th>Creation Date</th>
                        <th>Modification Date</th>
                        <th>Resolved Date</th>
                        <th>Status</th>
                        <th>Subject</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<td>" . $row["idTicket"] . "</td><td>" . $row["typeTicket"] . "</td><td>" . $row["creationDate"] . "</td><td>" . $row["modificationDate"] . "</td><td>" . $row["resolvedDate"] . "</td><td>" . $row["stateTicket"] . "</td><td>" . $row["subject"] . "</td><td>" . $row["description"] . "</td>";
                        echo "</tr>";
                        echo "<img src='" . $row["file"] . "'>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p>Error, no ticket selected!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;

        case 'Bug Reporting':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable2' style='background-color:rgb(255, 255, 255)'>
                        <thead>
                            <tr>
                                <th>Ticket No.</th>
                                <th>Type</th>
                                <th>Creation Date</th>
                                <th>Modification Date</th>
                                <th>Resolved Date</th>
                                <th>Status</th>
                                <th>Operative System</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>Steps to reproduce</th>
                                <th>Expected result</th>
                                <th>Received result</th>
                                <th>Discord client</th>
                            </tr>
                        </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["creationDate"] . "</th><th>" . $row["modificationDate"] . "</th><th>" . $row["resolvedDate"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["operativeSystem"] . "</th><th>" . $row["subject"] . "</th><th>" . $row["description"] . "</th><th>" . $row["stepsToReproduce"] . "</th><th>" . $row["expectedResult"] . "</th><th>" . $row["receivedResult"] . "</th><th>" . $row["discordClient"] . "</th>";
                        echo "</tr>";
                        echo "<img src='" . $row["image"] . "'>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No tickets of this type!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;

        case 'Feature Request':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable3' style='background-color:rgb(255, 255, 255)'>
                        <thead>
                            <tr>
                                <th>Ticket No.</th>
                                <th>Type</th>
                                <th>Creation Date</th>
                                <th>Modification Date</th>
                                <th>Resolved Date</th>
                                <th>Status</th>
                                <th>Subject</th>
                                <th>Requested Type</th>
                            </tr>
                        </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["creationDate"] . "</th><th>" . $row["modificationDate"] . "</th><th>" . $row["resolvedDate"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>" . $row["requestType"] . "</th>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No tickets of this type!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;

        case 'Grammar':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable4' style='background-color:rgb(255, 255, 255)'>
                    <thead>
                        <tr>
                            <th>Ticket No.</th>
                            <th>Type</th>
                            <th>Creation Date</th>
                            <th>Modification Date</th>
                            <th>Resolved Date</th>
                            <th>Status</th>
                            <th>Subject</th>
                            <th>Description</th>
                        </tr>
                    </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["creationDate"] . "</th><th>" . $row["modificationDate"] . "</th><th>" . $row["resolvedDate"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>" . $row["description"] . "</th>";
                        echo "</tr>";
                        echo "<img src='" . $row["image"] . "'>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No tickets of this type!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;

        case 'Information Update':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable5' style='background-color:rgb(255, 255, 255)'>
                    <thead>
                        <tr>
                            <th>Ticket No.</th>
                            <th>Type</th>
                            <th>Creation Date</th>
                            <th>Modification Date</th>
                            <th>Resolved Date</th>
                            <th>Status</th>
                            <th>Subject</th>
                            <th>Update Info</th>
                        </tr>
                    </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["creationDate"] . "</th><th>" . $row["modificationDate"] . "</th><th>" . $row["resolvedDate"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>" . $row["updateInfo"] . "</th>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No tickets of this type!</p>";
                }
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
            }
            break;

        case 'Other':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable6' style='background-color:rgb(255, 255, 255)'>
                    <thead>
                        <tr>
                            <th>Ticket No.</th>
                            <th>Type</th>
                            <th>Creation Date</th>
                            <th>Modification Date</th>
                            <th>Resolved Date</th>
                            <th>Status</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Extra Text</th>
                        </tr>
                    </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["creationDate"] . "</th><th>" . $row["modificationDate"] . "</th><th>" . $row["resolvedDate"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>" . $row["description"] . "</th><th>" . $row["extraText"] . "</th>";
                        echo "</tr>";
                    }
                    echo "</table>";
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
