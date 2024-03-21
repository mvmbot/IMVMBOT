<?php
function viewTicketAdmin($conn, $type) {

    switch ($type) {
        case 'helpSupport':
            # Get every ticket from X type from the user
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, hs.subject
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
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, br.operativeSystem, br.subject
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
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, fr.subject, fr.requestType
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
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, gi.subject
            FROM ticket t
            JOIN grammarIssues gi ON t.idTicket = gi.ticketID
            JOIN users u ON t.idUsers = u.idUsers
            WHERE t.typeTicket = 'Grammar' AND u.idUsers =?";

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
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, iu.subject
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
            $sql = "SELECT t.idUsers, t.idTicket, t.typeTicket, t.creationDate, t.modificationDate, t.resolvedDate, t.stateTicket, o.subject, o.description, o.extraText
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

}