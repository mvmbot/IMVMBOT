<?php
// Gets the data from every input form the form
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : 'nulo';
$username = isset($_POST['username']) ? $_POST['username'] : 'nulo';
$name = isset($_POST['name']) ? $_POST['name'] : 'nulo';
$surname = isset($_POST['surname']) ? $_POST['surname'] : 'nulo';
$mail = isset($_POST['mail']) ? $_POST['mail'] : 'nulo';
$password = isset($_POST['password']) ? $_POST['password'] : 'nulo';
$confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : 'nulo';
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