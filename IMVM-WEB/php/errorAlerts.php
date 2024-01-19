<?php
function signupError($errorType) {
    switch ($errorType) {
        case `noUser`:
            echo `<script>alert(Couldn't create the user!)</script>`;
            break;
        case `accountAlreadyExists`:
            echo `<script>alert(Account already exists, back to log in)</script>`;
            break;
        case `emptyValues`;
            echo `<script>alert(Empty values)</script>`;
            break;
        case `passwordWontMatch`;
            echo `<script>alert(Passwords doesn't match, try again!)</script>`;
            break;
        case `wrongMail`;
            echo `<script>alert(Email doesn't exist)</script>`;
            break;
    }
}