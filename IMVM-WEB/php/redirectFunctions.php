<?php
#region Define --- Locations for our redirects
define('SIGNUP_PAGE', '../signup.php');
define('SIGNIN_PAGE', '../signin.php');
define('INDEX_PAGE', '../index.php');
define('TICKET_PAGE', '../createTicket.php');
define('INDEX_PAGE_ADMIN', '../index.php');
define('VIEW_TICKET_ADMIN_PAGE', '../viewTicketAdmin.php');
define ('VIEW_TICKET_PAGE', '../viewTicket.php');
define('VIEW_PROFILE_PAGE', '../viewProfile.php');
define('EDIT_PROFILE_PAGE', '../editProfile.php');
#endregion

#region functions --- Redirects to our pages
# Function to redirect to the signup form
function redirectToSignup() {
    header('Location: ' . SIGNUP_PAGE);
    exit;
}

# Function to redirect to the signin form
function redirectToSignin() {
    header('Location: ' . SIGNIN_PAGE);
    exit;
}

# Function to redirect to the main page
function redirectToIndex() {
    header('Location: ' . INDEX_PAGE);
    exit;
}

# Function to redirect to the main page if ure not admin
function redirectToIndexAdmin() {
    header('Location: ' . INDEX_PAGE_ADMIN);
    exit;
}

# Function to redirect to the create ticket page
function redirectToTicket() {
    header('Location: ' . TICKET_PAGE);
    exit;
}
#endregion

# Function to redirect to the view tickets as admin page
function redirectToViewTicketAdmin() {
    header('Location: ' . VIEW_TICKET_ADMIN_PAGE);
    exit;
}

function redirectToViewTicket() {
    header('Location: ' . VIEW_TICKET_PAGE);
    exit;
}

function redirectToViewProfile() {
    header('Location: ' . VIEW_PROFILE_PAGE);
    exit;
}

function redirectToEditProfile() {
    header('Location: ' . EDIT_PROFILE_PAGE);
    exit;
}