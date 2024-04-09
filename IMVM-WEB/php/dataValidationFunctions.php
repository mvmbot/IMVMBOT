<?php

#region function --- Simple function to check if there are empty values and sanitize them.
function validateInputs($inputs) {
    # We check if the input's an array or not.
    # In case it's not an array then we sanitize a single input.
    if (!is_array($inputs)) {

        # We check if its empty, in case it is, we return false.
        if (empty($sanitizedInput)) {
            return false;
        }

        # Otherwise, we sanitize the input and return it.
        return $input = htmlspecialchars($inputs);
    } else {
        # If it's an array, we make a new array that will grab every sanitized input.
        $sanitizedInputs = array();
        
        # We loop through the array with a foreach and sanitize every input.
        foreach ($inputs as $inputValue) {
            # We check if the input is empty, if any of them is empty, we return false.
            if (empty($inputValue)) {
                return false;
            }
            # Otherwise, we sanitize it as we store them on the new array.
            $sanitizedInputs[$inputValue] = htmlspecialchars($inputValue);
        }
        # Then we just return the new array with every sanitized input.
        return $sanitizedInputs;
    }
}
#endregion