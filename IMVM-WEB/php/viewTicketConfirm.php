<?php
function viewTicket($conn){

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

    try {
        # Get every ticket from X type from the user
        $sql = "SELECT idTicket, typeTicket, stateTicket FROM tickets WHERE idUsers = ?";

        # Prepare statement
        $stmt = $conn->prepare($sql);

        # Bind parameters
        $stmt->bind_param("s", $idUsers);

        # Execute statement
        $stmt->execute();

        # We store the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<th>".$row["idTicket"]."</th><br><th>".$row["typeTicket"]."</th><br><th>".$row["stateTicket"]."</th>[ <a href='viewTicket.php?ID=".$row['idTicket']."'>View</a> ]</th>";
                echo "</tr>";
            }
        }
        # Close statement
        $stmt->close();
    } catch (Exception $e) {
        showError("Error: " . $e->getMessage());
    }
}

