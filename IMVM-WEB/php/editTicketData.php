<?php

/*
 * File: editTicketData
 * Author: Álvaro Fernández
 * Github 1: https://github.com/afernandezmvm (School acc)
 * Github 2: https://github.com/JisuKlk (Personal acc)
 * Desc: File responsible for managing the ability to edit ticket state as an admin
 */

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
