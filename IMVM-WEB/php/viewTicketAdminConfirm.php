<?php
function viewTicketAdmin($conn, $type) {

    switch ($type) {
        case 'helpSupport':
            # Get every ticket from X type from the user
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, hs.subject, u.usernameUsers
            FROM ticket t
            JOIN helpSupport hs ON t.idTicket = hs.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Help & Support'";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketAdmin($type, $result);
            break;

        case 'bugReport':
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, br.operativeSystem, br.subject, u.usernameUsers
            FROM ticket t
            JOIN bugReport br ON t.idTicket = br.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Bug Reporting'";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketAdmin($type, $result);
            break;

        case 'featureRequest':
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, fr.subject, fr.requestType, u.usernameUsers
            FROM ticket t
            JOIN featureRequest fr ON t.idTicket = fr.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Feature Request'";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketAdmin($type, $result);
            break;

        case 'grammarIssues':
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, gi.subject, u.usernameUsers
            FROM ticket t
            JOIN grammarIssues gi ON t.idTicket = gi.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Grammar'";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketAdmin($type, $result);
            break;

        case 'informationUpdate':
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, iu.subject, u.usernameUsers
            FROM ticket t
            JOIN informationUpdate iu ON t.idTicket = iu.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Information Update'";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketAdmin($type, $result);
            break;

        case 'other':
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, o.subject, o.description, o.extraText, u.usernameUsers
            FROM ticket t
            JOIN other o ON t.idTicket = o.ticketId
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Other'";

            # Prepare statement
            $stmt = $conn->prepare($sql);

            # Execute statement
            $stmt->execute();

            # We store the result
            $result = $stmt->get_result();

            # Then just print the ticket
            printTicketAdmin($type, $result);
            break;
        default:
            break;
    }
}

function printTicketAdmin($type, $result) {
    switch ($type) {
        case 'helpSupport':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable1' style='background-color:rgb(255, 255, 255)'>
                    <thead>
                        <tr>
                            <th>ID user</th>
                            <th>Ticket No.</th>
                            <th>Username</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Subject</th>                           
                            <th>Action</th>
                        </tr>
                    </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "'><svg fill='#9900ff' width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <title>view</title> <path d='M12.406 13.844c1.188 0 2.156 0.969 2.156 2.156s-0.969 2.125-2.156 2.125-2.125-0.938-2.125-2.125 0.938-2.156 2.125-2.156zM12.406 8.531c7.063 0 12.156 6.625 12.156 6.625 0.344 0.438 0.344 1.219 0 1.656 0 0-5.094 6.625-12.156 6.625s-12.156-6.625-12.156-6.625c-0.344-0.438-0.344-1.219 0-1.656 0 0 5.094-6.625 12.156-6.625zM12.406 21.344c2.938 0 5.344-2.406 5.344-5.344s-2.406-5.344-5.344-5.344-5.344 2.406-5.344 5.344 2.406 5.344 5.344 5.344z'></path> </g></svg></a> </th>";
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

        case 'bugReport':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable2' style='background-color:rgb(255, 255, 255)'>
                        <thead>
                        <tr>
                        <th>Ticket No.</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Subject</th>                           
                        <th>Action</th>
                    </tr>
                            </tr>
                        </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "'><svg fill='#9900ff' width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <title>view</title> <path d='M12.406 13.844c1.188 0 2.156 0.969 2.156 2.156s-0.969 2.125-2.156 2.125-2.125-0.938-2.125-2.125 0.938-2.156 2.125-2.156zM12.406 8.531c7.063 0 12.156 6.625 12.156 6.625 0.344 0.438 0.344 1.219 0 1.656 0 0-5.094 6.625-12.156 6.625s-12.156-6.625-12.156-6.625c-0.344-0.438-0.344-1.219 0-1.656 0 0 5.094-6.625 12.156-6.625zM12.406 21.344c2.938 0 5.344-2.406 5.344-5.344s-2.406-5.344-5.344-5.344-5.344 2.406-5.344 5.344 2.406 5.344 5.344 5.344z'></path> </g></svg></a> </th>";
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

        case 'featureRequest':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable3' style='background-color:rgb(255, 255, 255)'>
                        <thead>
                        <tr>
                        <th>Ticket No.</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Subject</th>                           
                        <th>Action</th>
                    </tr>
                        </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "'><svg fill='#9900ff' width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <title>view</title> <path d='M12.406 13.844c1.188 0 2.156 0.969 2.156 2.156s-0.969 2.125-2.156 2.125-2.125-0.938-2.125-2.125 0.938-2.156 2.125-2.156zM12.406 8.531c7.063 0 12.156 6.625 12.156 6.625 0.344 0.438 0.344 1.219 0 1.656 0 0-5.094 6.625-12.156 6.625s-12.156-6.625-12.156-6.625c-0.344-0.438-0.344-1.219 0-1.656 0 0 5.094-6.625 12.156-6.625zM12.406 21.344c2.938 0 5.344-2.406 5.344-5.344s-2.406-5.344-5.344-5.344-5.344 2.406-5.344 5.344 2.406 5.344 5.344 5.344z'></path> </g></svg></a> </th>";
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

        case 'grammarIssues':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable4' style='background-color:rgb(255, 255, 255)'>
                    <thead>
                    <tr>
                    <th>Ticket No.</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Subject</th>                           
                    <th>Action</th>
                </tr>
                    </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "'><svg fill='#9900ff' width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <title>view</title> <path d='M12.406 13.844c1.188 0 2.156 0.969 2.156 2.156s-0.969 2.125-2.156 2.125-2.125-0.938-2.125-2.125 0.938-2.156 2.125-2.156zM12.406 8.531c7.063 0 12.156 6.625 12.156 6.625 0.344 0.438 0.344 1.219 0 1.656 0 0-5.094 6.625-12.156 6.625s-12.156-6.625-12.156-6.625c-0.344-0.438-0.344-1.219 0-1.656 0 0 5.094-6.625 12.156-6.625zM12.406 21.344c2.938 0 5.344-2.406 5.344-5.344s-2.406-5.344-5.344-5.344-5.344 2.406-5.344 5.344 2.406 5.344 5.344 5.344z'></path> </g></svg></a> </th>";
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

        case 'informationUpdate':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable5' style='background-color:rgb(255, 255, 255)'>
                    <thead>
                    <tr>
                    <th>Ticket No.</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Subject</th>                           
                    <th>Action</th>
                </tr>
                    </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idTicket"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "'><svg fill='#9900ff' width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <title>view</title> <path d='M12.406 13.844c1.188 0 2.156 0.969 2.156 2.156s-0.969 2.125-2.156 2.125-2.125-0.938-2.125-2.125 0.938-2.156 2.125-2.156zM12.406 8.531c7.063 0 12.156 6.625 12.156 6.625 0.344 0.438 0.344 1.219 0 1.656 0 0-5.094 6.625-12.156 6.625s-12.156-6.625-12.156-6.625c-0.344-0.438-0.344-1.219 0-1.656 0 0 5.094-6.625 12.156-6.625zM12.406 21.344c2.938 0 5.344-2.406 5.344-5.344s-2.406-5.344-5.344-5.344-5.344 2.406-5.344 5.344 2.406 5.344 5.344 5.344z'></path> </g></svg></a> </th>";
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

        case 'other':
            try {
                if ($result->num_rows > 0) {
                    echo "<table class='table' id='ticketTable6' style='background-color:rgb(255, 255, 255)'>
                    <thead>
                    <tr>
                    <th>ID User</th>
                    <th>Ticket No.</th>
                    <th>Username</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Subject</th>                 
                    <th>Action</th>
                </tr>
                    </thead>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $row["idUsers"] . "</th><th>" . $row["idTicket"] . "</th><th>" . $row["usernameUsers"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "'><svg fill='#9900ff' width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <title>view</title> <path d='M12.406 13.844c1.188 0 2.156 0.969 2.156 2.156s-0.969 2.125-2.156 2.125-2.125-0.938-2.125-2.125 0.938-2.156 2.125-2.156zM12.406 8.531c7.063 0 12.156 6.625 12.156 6.625 0.344 0.438 0.344 1.219 0 1.656 0 0-5.094 6.625-12.156 6.625s-12.156-6.625-12.156-6.625c-0.344-0.438-0.344-1.219 0-1.656 0 0 5.094-6.625 12.156-6.625zM12.406 21.344c2.938 0 5.344-2.406 5.344-5.344s-2.406-5.344-5.344-5.344-5.344 2.406-5.344 5.344 2.406 5.344 5.344 5.344z'></path> </g></svg></a> </th>";
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