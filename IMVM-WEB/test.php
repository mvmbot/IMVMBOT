<?php

require_once 'vendor/autoload.php';
require_once 'configLogin.php';
 
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");


echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";

?>