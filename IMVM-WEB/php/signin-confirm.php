<?php
session_start();

// First of all we gotta check if the form is sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include("config.php");

    // Check connection
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    /*echo "Connected successfully <br>";*/

    // We get the username and it's password!
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // If something's empty, it ends.
    if (empty($username) || empty($password)) {
        die("Something's wrong! check it out again pls");
    }

    //First of all, we gotta check our database to see if the user exists
    //We do a lil query to check it
    $checkExisting = "SELECT id_users FROM users WHERE username_users = ? AND password_users = ?";
    //We prepare the statement
    $stmtCheck = $conn->prepare($checkExisting);
    //Then we bind the parameters (thx manu for the tip, it's actually quite easy to do it this way)
    $stmtCheck->bind_param("ss", $username, $password);
    //And then we execute the query
    $stmtCheck->execute();
    //Finaly, we store the result so we can use it
    $stmtCheck->store_result();

    if ($result->num_rows > 0) {
        // If its ok, it creates a session!
        $_SESSION['user'] = $username;
        header("Location: ../index.html");
    } else {
        // If the user doesnt exists, we'll redirect it to an error page
        echo "ERROR";
        //header("Location: ruta_de_redireccionamiento_error.php");
    }

    $conn->close();
} else {
    // If someone goes into the page without sending the form, we redirect them
    header("Location: ./signin.html");
}
?>