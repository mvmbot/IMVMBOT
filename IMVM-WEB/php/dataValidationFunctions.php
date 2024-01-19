<?php

function areFieldsEmpty($fields) {
    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            return true;
        }
    }
    return false;
}