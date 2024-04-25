<?php
#region Required files
# Let's get the database stuff ready!
#require("config.php");
require_once("databaseFunctions.php");

# Grab some tools for our code!
require_once("redirectFunctions.php");
require_once("dataValidationFunctions.php");
require_once("errorAlerts.php");
#endregion

#region errors
# Turn on the lights to see any coding errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
#endregion

# Now, let's connect to our database
$conn = connectToDatabase();

#region Variable declaration
# Get all the data and validate it.
$username = $_POST['username'] ?? '';
$name = $_POST['name'] ?? '';
$surname = $_POST['surname'] ?? '';
$mail = $_POST['mail'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';
$newsletterCheckBox = isset($_POST['newsletterCheckBox']) ? 1 : 0;

$fileAttachment = $targetDirectory . basename($_FILES["profileImage"]["name"]);

$check = validateFile($fileAttachment, $type) ?: redirectToSignup();

$inputs = array(
    $username,
    $name,
    $surname,
    $mail,
);

# Oops! Did they forget to check the privacy box?
if (!isset($_POST['privacyCheckbox'])) {
    redirectToSignup();
}

$inputs = validateInputs($inputs);

if ($inputs === true) {
    redirectToSignup();
}

#endregion

# Uh-oh! The passwords don't match. Let's guide them back!
if ($password != $confirmPassword) {
    redirectToSignup();
}

# Checking if the email is a valid one. We really need them to exist
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    redirectToSignup();
}


# Now, let's peek into the database and see if the chosen username or email is already taken
try {

    # Preparing a tiny query to check that
    $checkExisting = "SELECT idUsers FROM users WHERE usernameUsers = ? OR emailUsers = ?";
    $stmtCheck = $conn->prepare($checkExisting);

    # In case we did mess up in preparing the query. It happens to the best of us
    if ($stmtCheck === false) {
        throw new Exception("Oh no! Something went wrong: " . $conn->error);
    }

    # No mistakes so far Let's move on and check the results.

    # Thumbs up for binding parameters and executing the query
    $stmtCheck->bind_param("ss", $username, $mail);
    $stmtCheck->execute();
    $stmtCheck->store_result();
} catch (Exception $e) {

    # We missed there to be honest. Let's be honest about it.
    showError("Error: " . $e->getMessage());
}

# If we found any matches in the database, let them know the chosen username or email is taken
if ($stmtCheck->num_rows > 0) {
    redirectToSignup();
} else {

    # Looks like they're in the clear, let's add them to our cool users' database
    try {

        # Preparing the query to insert the user into the database
        $insertSQL = "INSERT INTO users (usernameUsers, nameUsers, surnameUsers, emailUsers, passwordUsers, acceptNewsletter, profileImage, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSQL);

        # In case we did mess up preparing the query.
        if ($stmt === false) {
            throw new Exception("Error preparing INSERT statement: " . $conn->error);
        }

        # Now, let's make their password secure with a hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        # Bind parameters, cast the query, and add them to our user list
        $stmt->bind_param("ssssssss", $username, $name, $surname, $mail, $hashedPassword, $newsletterCheckBox, $profileImage, $status);
        $stmt->execute();

        # If everything worked like it should, send them to our main page
        if ($stmt->affected_rows > 0) {
            redirectToIndex();
        } else {

            # Something went wrong, but we ain't liying bout it
            redirectToSignup();
        }
    } catch (Exception $e) {

        # Another bump in the road. Let's tell them.
        showError("Error: " . $e->getMessage());
    }
}

# Okay, we're done with the database and our tools. Time to close up
$stmtCheck->close();
$stmt->close();
closeDatabaseConnection($conn);