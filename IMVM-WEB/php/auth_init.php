<?php 
// Load the database configuration file
require_once 'dbConfig.php'; 

// Retrieve JSON from POST body
$jsonStr = file_get_contents('php://input'); 
$jsonObj = json_decode($jsonStr); 

if(!empty($jsonObj->request_type) && $jsonObj->request_type == 'user_auth'){ 
    $credential = !empty($jsonObj->credential) ? $jsonObj->credential : ''; 

    // Decode response payload from JWT token
    list($header, $payload, $signature) = explode(".", $credential); 
    $responsePayload = json_decode(base64_decode($payload)); 

    if(!empty($responsePayload)){ 
        // The user's profile info
        $oauth_provider = 'google'; 
        $oauth_uid  = !empty($responsePayload->sub) ? $responsePayload->sub : ''; 
        $usernameUsers = !empty($responsePayload->email) ? explode('@', $responsePayload->email)[0] : ''; // Assuming the part before @ is the username
        $nameUsers = !empty($responsePayload->given_name) ? $responsePayload->given_name : ''; 
        $surnameUsers  = !empty($responsePayload->family_name) ? $responsePayload->family_name : ''; 
        $emailUsers  = !empty($responsePayload->email) ? $responsePayload->email : ''; 
        $profileImage  = !empty($responsePayload->picture) ? $responsePayload->picture : ''; 
        $passwordUsers = ''; // Default or empty since not provided by OAuth
        $acceptNewsletter = 0; // Default value for acceptNewsletter
        $status = 'active'; // Default status

        // Check whether the user data already exists in the database
        $query = "SELECT * FROM users WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'"; 
        $result = $db->query($query); 

        if($result->num_rows > 0){  
            // Update user data if already exists
            $query = "UPDATE users SET 
                        usernameUsers = '".$usernameUsers."', 
                        nameUsers = '".$nameUsers."', 
                        surnameUsers = '".$surnameUsers."', 
                        emailUsers = '".$emailUsers."', 
                        profileImage = '".$profileImage."', 
                        modified = NOW() 
                      WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'"; 
            $update = $db->query($query); 
        }else{ 
            // Insert user data
            $query = "INSERT INTO users 
                        (oauth_provider, oauth_uid, usernameUsers, nameUsers, surnameUsers, emailUsers, passwordUsers, acceptNewsletter, profileImage, created, modified, status) 
                      VALUES 
                        ('".$oauth_provider."', '".$oauth_uid."', '".$usernameUsers."', '".$nameUsers."', '".$surnameUsers."', '".$emailUsers."', '".$passwordUsers."', '".$acceptNewsletter."', '".$profileImage."', NOW(), NOW(), '".$status."')"; 
            $insert = $db->query($query); 
        } 

        $output = [ 
            'status' => 1, 
            'msg' => 'Account data inserted successfully!', 
            'pdata' => $responsePayload 
        ]; 
        echo json_encode($output); 
    }else{ 
        echo json_encode(['error' => 'Account data is not available!']); 
    } 
} 
?>
