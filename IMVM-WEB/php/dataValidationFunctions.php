<?php

#region function --- Simple function to check if there are empty valu
es
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