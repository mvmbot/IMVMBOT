<?php

#region function --- Simple function to check if there are empty values and sanitize them;
function sanitizeInputsAndCheckEmpty($inputs) {
    if (!is_array($inputs)) {
        # If the input is not an array (it's just a single var), we sanitize it this way (so we don't neet to create arrays with one value);
        if (empty($sanitizedInput)) {
            return false;
        }

        return $inputs = htmlspecialchars($inputs);

    } else {
        # If it's an array, we make a new array that will grab every sanitized input
        $sanitizedInputs = array();
        foreach ($inputs as $inputValue) {
            # This is how we sanitize it, first we check if they're empty, if it's not empty, we use the htmlspecialchars method to sanitize it
            if (empty($inputValue)) {
                return false;
            }

            $sanitizedInputs[$inputValue] = htmlspecialchars($inputValue);
        }
        # Then we just return the new array with every sanitized input
        return $sanitizedInputs;
    }
}
#endregion