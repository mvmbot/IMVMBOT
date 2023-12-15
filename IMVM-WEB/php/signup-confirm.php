<?php

include("config.php");

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully <br>";


// Gets the data from every input form the form
if (empty($_POST['username'])) {
    echo "That's empty";
} else {
    $username = isset($_POST['username']) ? $_POST['username'] : 'nulo';
}
if (empty($_POST['name'])) {
    echo "That's empty";
} else {
    $name = isset($_POST['name']) ? $_POST['name'] : 'nulo';
}
if (empty($_POST['surname'])) {
    echo "That's empty";
} else {
    $surname = isset($_POST['surname']) ? $_POST['surname'] : 'nulo';
}
if (empty($_POST['mail'])) {
    echo "That's empty";
} else {
    $mail = isset($_POST['mail']) ? $_POST['mail'] : 'nulo';
}
if (empty($_POST['password'])) {
    echo "That's empty";
} else {
    $password = isset($_POST['password']) ? $_POST['password'] : 'nulo';
}
if (empty($_POST['confirmPassword'])) {
    echo "That's empty";
} else {
    $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : 'nulo';
}


//$agreePrivacyPolicy = isset($_POST['privacy_policy']) ? 'Yes' : 'No';
// We're printing those to check if it works
echo 'Username: ' . $username . '<br>';
echo 'Name: ' . $name . '<br>';
echo 'Surname: ' . $surname . '<br>';
echo 'Mail: ' . $mail . '<br>';
echo 'Password: ' . $password . '<br>';
echo 'Confirmed Password: ' . $confirmPassword . '<br>';

//First of all, we gotta check our database to see if the user is trying to create an account with an already used email or username
//We do a lil query to check it
$checkExisting = "SELECT id_users FROM users WHERE username_users = ? OR email_users = ?";
//We prepare the statement
$stmtCheck = $conn->prepare($checkExisting);
//Then we bind the parameters (thx manu for the tip, it's actually quite easy to do it this way)
$stmtCheck->bind_param("ss", $username, $mail);
//And then we execute the query
$stmtCheck->execute();
//Finaly, we store the result so we can use it
$stmtCheck->store_result();

//If there are no results in the database with that user or mail, we go on. If not, we show an error message and stop everything
if ($stmtCheck->num_rows > 0) {
    echo "Username or email already on use!";
} else {
    //If everything is fine, we go ahead and insert the data into our database
    if ($password == $confirmPassword) {

        $insertSQL = "INSERT INTO users (id_users, username_users, name_users, surname_users, email_users, password_users) VALUES (NULL, ?, ?, ?, ?, ?)";
        //We prepare the query again...
        $stmt = $conn->prepare($insertSQL);
        //Bind the parameters
        $stmt->bind_param("sssss", $username, $name, $surname, $mail, $password);
        //And execute it!
        $stmt->execute();

        //We check if the query worked
        if ($stmt->affected_rows > 0) {
            //If it worked, we tell the user everything's allright
            echo "User created correctly";
        } else {
            //Otherwise, we tell him that something went wrong
            echo "Couldn't create the user!";
        }
    } else {
        //In case passwords doesnt match, we tell 'em
        echo "Passwords doesn't match!";
    }
}
//We close the statement since we're not using it anymore
$stmtCheck->close();

//echo 'Agreed to Privacy Policy: ' . $agreePrivacyPolicy . '<br>';