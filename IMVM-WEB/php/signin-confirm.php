<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        mysqli_close($conn);
        header('Location: ../signin.php');
        exit;
    }

    //First of all, we gotta check our database to see if the user exists
    //We do a lil query to check it
    $checkExisting = "SELECT id_users, password_users FROM users WHERE username_users = ?";
    //We prepare the statement
    $stmtCheck = $conn->prepare($checkExisting);
    //Then we bind the parameters
    $stmtCheck->bind_param("s", $username);
    
    //And then we execute the query (we do it on an if so if it doesnt work we can kill the script)
    if ($stmtCheck->execute()) {
        //We store the result on a var so we can work with it
        $result = $stmtCheck->get_result();

        //We check if the query got something
        if ($result->num_rows > 0) {
            //If yes, let's take the first row from the result (the password)
            $resultRow = $result->fetch_assoc();
            //Store the hashed password on a var to compare them
            $hashedPassword = $resultRow['password_users'];
            //Now we compare the passwords
            if (password_verify($password, $hashedPassword)) {
                //The passwords match, so now we create a session for this user
                $_SESSION['user'] = $username;
                header("Location: ../index.php");
                exit();
            //In case both passwords doesn't match
            } else {
                //We send an alert with an error message and go back to the form so the user can try again
                echo '<script>alert("Incorrect username or password!")</script>';
                mysqli_close($conn);
                header('Location: ../signin.php');
                exit;
            }
        //In case the query didn't get anything
        } else {
            //Same as before, we throw an alert and try again
            echo '<script>alert("Incorrect username or password!")</script>';
            mysqli_close($conn);
            header('Location: ../signin.php');
            exit;
        }
    } else {
        //If the query didn't execute, we throw an error and close the conn
        echo "Error in query execution: " . $stmtCheck->error;
        mysqli_close($conn);
        exit;
    }
} else {
    //If there is no POST method, we just redirect the user to signin page (for example if someone came to the page throught link instead of form redirect)
    header("Location: ./signin.html");
    mysqli_close($conn);
    exit;
}