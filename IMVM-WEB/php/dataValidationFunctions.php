<?php

#region function --- Simple function to check if there are empty values
function areFieldsEmpty($fields) {
    // We gotta check if any value is empty
    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            return true;
        }
    }
    // If not, everything's allright, go on
    return false;
}
#endregion