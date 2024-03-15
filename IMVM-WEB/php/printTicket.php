<?php
function printTicket($conn){

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
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>".$row["idTicket"]." ".$row["typeTicket"]." ".$row["stateTicket"]." [ <a href='f_update_person.php?ID=".$row['ID']."'>Modificar</a> ]</li>";
            }
        }
        # Close statement
        $stmt->close();
    } catch (Exception $e) {

    } catch (\Throwable $th) {
        //throw $th;
    }

    $tickets = array(
        array("Ticket No.", "Title", "Category", "Reported By", "Status"),
    );

    foreach ($tickets as $ticket) {
        echo "<tr>";
        foreach ($ticket as $value) {
            echo "<td>$value</td>";
        }
        echo "<td><button class='icon-button' aria-label='Action'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path fill='#6602a8' d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z'/></svg></button></td>";
        echo "</tr>";
    }
}

