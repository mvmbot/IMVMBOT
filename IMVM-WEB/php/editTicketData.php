<?php
require_once ("redirectFunctions.php");
require_once ("databaseFunctions.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase();
    $newState = $_POST['newState'];
    $idTicket = $_POST['idTicket'];
    try {
        $sql = "UPDATE ticket SET stateTicket = ?, modificationDate = CURRENT_TIMESTAMP WHERE idTicket = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newState, $idTicket);
        $stmt->execute();
        if ($newState === "Closed") {
            try {
                $sql = "UPDATE ticket SET resolvedDate = CURRENT_TIMESTAMP WHERE idTicket = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $idTicket);
                $stmt->execute();
            } catch (Exception $e) {
                showError("Error: " . $e->getMessage());
                redirectToViewTicketAdmin();
            }
        }
        if ($stmt->execute()) {
            redirectToViewTicketAdmin();
        }
    } catch (Exception $e) {
        $stmt->close();
        showError("Error: " . $e->getMessage());
        redirectToSignup();
    }
} else {
    redirectToViewTicketAdmin();
}
