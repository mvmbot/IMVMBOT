<?php

/*
 * File: errorAlerts
 * Author: Álvaro Fernández
 * Github 1: https://github.com/afernandezmvm (School acc)
 * Github 2: https://github.com/JisuKlk (Personal acc)
 * Desc: File that contains some functions to print errors to the user if necessary
 */

# We just throw an alert
function showAlert($errorMessage) {
    echo '<script>alert("' . $errorMessage . '")</script>';
}

# Same as above, but with errors and not alerts
function showError($errorMessage) {
    echo "Error: " . $errorMessage;
}

# This one uses the JS redirect method, only for when the password doesnt match the database
function showErrorPasswordJS() {
    echo '<script type="text/javascript">
    alert("Error: incorrect Password");
    window.location.href="../signin.php";
    </script>';
}

# This is for when an user is not found
function showErrorUserJS() {
    echo '<script type="text/javascript">
    alert("Error: User does not exists");
    window.location.href="../signin.php";
    </script>';
}
