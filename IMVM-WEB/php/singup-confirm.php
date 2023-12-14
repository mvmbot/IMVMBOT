<?php
// Gets the data from every input form the form
if (empty($_POST['username'])) {
    echo "That's empty";
} else {
    $username = isset($_POST['username']);
}
if (empty($_POST['name'])) {
    echo "That's empty";
} else {
    $name = isset($_POST['name']);
}
if (empty($_POST['surname'])) {
    echo "That's empty";
} else {
    $surname = isset($_POST['surname']);
}
if (empty($_POST['mail'])) {
    echo "That's empty";
} else {
    $mail = isset($_POST['mail']);
}
if (empty($_POST['password'])) {
    echo "That's empty";
} else {
    $password = isset($_POST['password']);
}
if (empty($_POST['confirmPassword'])) {
    echo "That's empty";
} else {
    $confirmPassword = isset($_POST['confirmPassword']);
}




//$agreePrivacyPolicy = isset($_POST['privacy_policy']) ? 'Yes' : 'No';
// We're printing those to check if it works
echo 'Username: ' . $username . '<br>';
echo 'Name: ' . $name . '<br>';
echo 'Surname: ' . $surname . '<br>';
echo 'Mail: ' . $mail . '<br>';
echo 'Password: ' . $password . '<br>';
echo 'Confirmed Password: ' . $confirmPassword . '<br>';
//echo 'Agreed to Privacy Policy: ' . $agreePrivacyPolicy . '<br>';
?>