<?php
require_once('./php/databaseFunctions.php');
require_once('./phpclient/google-api-php-client--PHP7.4/vendor/autoload.php');
include_once('./php/config.php');

session_start();

$conn = connectToDatabase();

# Obtener el token de acceso
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['access_token'])) {
        throw new Exception('ERROR #14: ' . json_encode($token));
    }
    $accessToken = $token['access_token'];

    $client->setAccessToken($accessToken);

    # Verifica si hubo un error al obtener el token
    if (isset($token['error'])) {
        # Manejar el error aquí (por ejemplo, mostrar un mensaje al usuario)
        echo "ERROR #23: " . $token['error'];
        exit;
    }

    $_SESSION['access_token'] = $token;

    # Obtener el ID de usuario de Discord del parámetro state
    if (isset($_GET['state'])) {
        $state = json_decode(urldecode($_GET['state']), true);
        $discordUserId = $state['discordUserId'];

        # Revisar primero si el usuario ya está logueado
        try {
            $sql = "SELECT user_id FROM user_tokens WHERE user_id = ?";
            $stmt = $conn->prepare($sql) ?: throw new Exception("ERROR #37: " . $conn->error);
            $stmt->bind_param('s', $discordUserId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        } catch (Exception $e) {
            showError("ERROR #43: " . $e->getMessage());
        }
        if ($result->num_rows == 1 || $result != NULL) {
            die("U're already logged in #46");
        } else {
            # Guardar el token de acceso y el ID de usuario de Discord en la base de datos
            try {
                $query = "REPLACE INTO user_tokens (user_id, access_token) VALUES (?, ?)";
                $stmt = $conn->prepare($query) ?: throw new Exception("ERROR #51: " . $conn->error);
                $stmt->bind_param('ss', $discordUserId, $accessToken);
                $stmt->execute();
                $stmt->close();
                echo "You logged in correctly! You can close this window now.";
            } catch (Exception $e) {
                showError("ERROR #57: " . $e->getMessage());
            }
        }
    } else {
        die("ERROR #61: Couldn't get the User ID");
    }
    exit;
}