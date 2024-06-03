<?php

/*
 * File: dataValidationFunctions
 * Author: Álvaro Fernández
 * Github 1: https://github.com/afernandezmvm (School acc)
 * Github 2: https://github.com/JisuKlk (Personal acc)
 * Desc: File containing all the functions to validate the data inputs, whether it's string or file
 */

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

        # We use this var so later our array is numeric (so we can insert the data correctly)
        $i = 0;

        # We loop through the array with a foreach and sanitize every input.
        foreach ($inputs as $inputValue) {
            # We check if the input is empty, if any of them is empty, we return false.
            if (empty($inputValue)) {
                return false;
            }
            # Otherwise, we sanitize it as we store them on the new array.
            $sanitizedInputs[$i] = htmlspecialchars($inputValue);
            $i++;
        }
        # Then we just return the new array with every sanitized input.
        return $sanitizedInputs;
    }
}
#endregion

#region Function --- Validate File
function validateFile($fileAttachment, $type) {

    # We check again if its empty in case somethings missing
    if (empty($fileAttachment)) {
        return false;
    }

    # We check if it already exists too
    if (file_exists($fileAttachment)) {
        return false;
    }

    # We get the extension of the file
    $imageFileType = strtolower(pathinfo($fileAttachment, PATHINFO_EXTENSION));

    # We store valid extensions on an array so it's easier to change them if we need to in the future
    $allowedExtensions = array("jpg", "jpeg", "png");

    # Then we check if the extension is inside the allowed extensions array
    if (!in_array($imageFileType, $allowedExtensions)) {
        return false;
    }

    # We check if the file is too big
    if ($fileAttachment > 500000) {
        return false;
    }

    # We try to move the file into the upload directory
    return move_uploaded_file($_FILES[$type]["tmp_name"], $fileAttachment);
}
#endregion
