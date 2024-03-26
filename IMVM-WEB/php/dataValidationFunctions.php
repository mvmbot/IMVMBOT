<?php

#region function --- Simple function to check if there are empty values and sanitize them;
function sanitizeInputsAndCheckEmpty($inputs) {

    if (!is_array($inputs)) {
        # If the input is not an array (it's just a single var), we sanitize it this way (so we don't neet to create arrays with one value);
        return isset($_POST[$inputs]) ? htmlspecialchars($_POST[$inputs]) : "";
    } else {
        # If it's an array, we make a new array that will grab every sanitized input
        $sanitizedInputs = array();
        foreach ($inputs as $inputValue) {
            # This is how we sanitize it, first we check if they're empty, if it's not empty, we use the htmlspecialchars method to sanitize it
            $sanitizedInputs[$inputValue] = isset($_POST[$inputValue]) ? htmlspecialchars($_POST[$inputValue]) : '';
            # Otherwise, we return true, as it's empty
            if (empty($sanitizedInputs[$inputValue])) {
                return true;
            }
        }
        # Then we just return the new array with every sanitized input
        return $sanitizedInputs;
    }
}
#endregion