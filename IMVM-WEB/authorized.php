<?php
require_once('./php/databaseFunctions.php');
require_once('./phpclient/google-api-php-client--PHP7.4/vendor/autoload.php');
include_once('./php/config.php');

# We declare the database connection
$conn = connectToDatabase();

# We get the acces token
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['access_token'])) {
        throw new Exception('ERROR #13: ' . json_encode($token));
    }
    $accessToken = $token['access_token'];

    # We assign to $client the $accessToken
    $client->setAccessToken($accessToken);

    # In case we get an error we handle it
    if (isset($token['error'])) {
        # Print the error
        die ("ERROR #23: " . $token['error']);
    }

    $_SESSION['access_token'] = $token;

    # We get via URL GET the state (discord user ID)
    if (isset($_GET['state'])) {

        # Declare the user ID
        $state = json_decode(urldecode($_GET['state']), true);
        $discordUserId = $state['discordUserId'];

        # First we gotta check if the user's already logged
        try {

            # Quick query to check it...
            $sql = "SELECT user_id FROM user_tokens WHERE user_id = ?";
            $stmt = $conn->prepare($sql) ?: throw new Exception("ERROR #37: " . $conn->error);
            $stmt->bind_param('s', $discordUserId);

            # Execute it
            $stmt->execute();

            # Store the result so we know if the user's logged in already
            $result = $stmt->get_result();

            # Close the statement
            $stmt->close();
        } catch (Exception $e) {
            showError("ERROR #52: " . $e->getMessage());
        }
        if ($result->num_rows == 1 || $result != NULL) {

            # If either the result isn't null or is 1, means that the users logged
            die("U're already logged!");
        } else {
            # Insert the data to the database
            try {
                $query = "REPLACE INTO user_tokens (user_id, access_token) VALUES (?, ?)";
                $stmt = $conn->prepare($query) ?: throw new Exception("ERROR #51: " . $conn->error);
                $stmt->bind_param('ss', $discordUserId, $accessToken);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows == 1 || $result != NULL ) {
                    # In case everythings allright, we tell the user
                    echo "You logged in correctly! You can close this window now.";
                }

            } catch (Exception $e) {
                showError("ERROR #74: " . $e->getMessage());
            }
        }
    } else {
        die("ERROR #78: COULDN'T GET THE USER ID");
    }
    exit;
} else {
    die("ERROR #82: NO ACCES TOKEN DETECTED");
}