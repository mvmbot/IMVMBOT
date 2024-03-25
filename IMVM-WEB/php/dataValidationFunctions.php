<?php

#region function --- Simple function to check if there are empty values and sanitize them
function sanitizeInputsAndCheckEmpty($inputs) {
    $sanitizedInputs = array();
    foreach ($inputs as $inputValue) {
        $sanitizedInputs[$inputValue] = isset($_POST[$inputValue]) ? htmlspecialchars($_POST[$inputValue]) : '';
        if (empty($sanitizedInputs[$inputValue])) {
            return true; // Return true if any field is empty
        }
    }
    return $sanitizedInputs; // Return sanitized inputs if all fields are filled
}
#endregion