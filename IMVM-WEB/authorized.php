<?php
require_once ('./php/databaseFunctions.php');
require_once ('./phpclient/google-api-php-client--PHP7.4/vendor/autoload.php');
include ('./php/config.php');

session_start();

$conn = connectToDatabase();

// Obtener el token de acceso
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['access_token'])) {
        throw new Exception('Failed to obtain access token. Token response: ' . json_encode($token));
    }
    $accessToken = $token['access_token'];
    $client->setAccessToken($accessToken);

    // Verifica si hubo un error al obtener el token
    if (isset($token['error'])) {
        // Manejar el error aquí (por ejemplo, mostrar un mensaje al usuario)
        echo "Error al obtener el token de acceso: " . $token['error'];
        exit;
    }

    $_SESSION['access_token'] = $token;
    $accessToken = $token['access_token'];

    // Obtener el ID de usuario de Discord del parámetro state
    if (isset($_GET['state'])) {
        echo "Te has logeado correctamente. Puedes cerrar esta ventana.";
    }
    exit;
}
