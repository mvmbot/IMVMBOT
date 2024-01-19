<?php
function showAlert($errorMessage) {
    echo '<script>alert("' . $errorMessage . '")</script>'; 
}

function showError($errorMessage) {
    echo "Error: " . $errorMessage;
}