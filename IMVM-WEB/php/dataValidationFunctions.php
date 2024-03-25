<?php

#region function --- Simple function to check if there are empty values
function areFieldsEmpty($fields) {

    # We gotta check if any value is empty
    foreach ($fields as $field) {

        # In case there's something empty, we return 'true'
        if (empty($_POST[$field])) {
            return true;
        }
    }

    # If not, everything's allright, return 'false'
    return false;
}
#endregion

#region Function --- Simple function to sanitize the variables to try to stop Albert for destroying completely our website 🦆
function sanitizeInputs($inputs) {
    foreach ($inputs as $input) {
        return $input = htmlspecialchars($input);
    }
}
#endregion