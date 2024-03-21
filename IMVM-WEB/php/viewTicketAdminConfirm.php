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
                    echo "<table class='table' id='ticketTable1' style='background-color: #9900ff; color: white;'>
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
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idUsers"] . "</th><th>" . $row["idTicket"] . "</th><th>" . $row["usernameUsers"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "&type=" . $row['typeTicket'] . "'><svg width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' fill='#9900ff' stroke='#9900ff'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <path d='M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> </g></svg></a> </th>";
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
                    echo "<table class='table' id='ticketTable2' style='background-color: #9900ff; color: white;'>
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
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idUsers"] . "</th><th>" . $row["idTicket"] . "</th><th>" . $row["usernameUsers"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "&type=" . $row['typeTicket'] . "'><svg width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' fill='#9900ff' stroke='#9900ff'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <path d='M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> </g></svg></a> </th>";
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
                    echo "<table class='table' id='ticketTable3' style='background-color: #9900ff; color: white;'>
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
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idUsers"] . "</th><th>" . $row["idTicket"] . "</th><th>" . $row["usernameUsers"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "&type=" . $row['typeTicket'] . "'><svg width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' fill='#9900ff' stroke='#9900ff'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <path d='M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> </g></svg></a> </th>";
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
                    echo "<table class='table' id='ticketTable4' style='background-color: #9900ff; color: white;'>
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
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idUsers"] . "</th><th>" . $row["idTicket"] . "</th><th>" . $row["usernameUsers"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "&type=" . $row['typeTicket'] . "'><svg width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' fill='#9900ff' stroke='#9900ff'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <path d='M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> </g></svg></a> </th>";
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
                    echo "<table class='table' id='ticketTable5' style='background-color: #9900ff; color: white;'>
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
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idUsers"] . "</th><th>" . $row["idTicket"] . "</th><th>" . $row["usernameUsers"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "&type=" . $row['typeTicket'] . "'><svg width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' fill='#9900ff' stroke='#9900ff'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <path d='M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> </g></svg></a> </th>";
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
                    echo "<table class='table' id='ticketTable6' style='background-color: #9900ff; color: white;'>
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
                        echo "<tr style='background-color: white; color: #9900ff;'>";
                        echo "<th>" . $row["idUsers"] . "</th><th>" . $row["idTicket"] . "</th><th>" . $row["usernameUsers"] . "</th><th>" . $row["typeTicket"] . "</th><th>" . $row["stateTicket"] . "</th><th>" . $row["subject"] . "</th><th>  <a href='ticketDetailsEdit.php?ID=" . $row['idTicket'] . "&type=" . $row['typeTicket'] . "'><svg width='18' height='18' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' fill='#9900ff' stroke='#9900ff'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <path d='M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13' stroke='#9900ff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> </g></svg></a> </th>";
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
