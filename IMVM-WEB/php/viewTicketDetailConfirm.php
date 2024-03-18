<?php
function viewTicketDetail($conn, $id, $type) {

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