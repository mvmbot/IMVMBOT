<?php
function showAlert($errorMessage) {
    echo '<script>alert("' . $errorMessage . '")</script>'; 
}

function showError($errorMessage) {
    echo "Error: " . $errorMessage;
}

function showErrorPasswordJS() {
    echo'<script type="text/javascript">
    alert("Error: incorrect Password");
    window.location.href="../signin.php";
    </script>';
}

function showErrorUserJS() {
    echo'<script type="text/javascript">
    alert("Error: User does not exists");
    window.location.href="../signin.php";
    </script>';
}