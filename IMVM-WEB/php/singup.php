<?php
// Gets the data from every input form the form
$username = $_POST['username'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$mail = $_POST['mail'];
$password = $_POST['password'];
$confirmPassword = $_POST['cPassword'];
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