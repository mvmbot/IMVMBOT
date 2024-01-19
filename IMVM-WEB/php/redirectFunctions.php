<?php

define('SIGNUP_PAGE', '../signup.php');
define('SIGNIN_PAGE', '../signin.php');
define('INDEX_PAGE', '../index.php');

// Function to redirect to the signup form
function redirectToSignup() {
    header('Location: ' . SIGNUP_PAGE);
    exit;
}

// Function to redirect to the signin form
function redirectToSignin() {
    header('Location: ' . SIGNIN_PAGE);
    exit;
}

function redirectToIndex() {
    header('Location: ' . INDEX_PAGE);
    exit;
}