<?php
function signupError($errorType) {
    switch ($errorType) {
        case `noUser`:
            echo `<script>alert(Couldn't create the user!)</script>`;
            break;
        case `accountAlreadyExists`:
            echo `<script>alert(Account already exists, back to log in)</script>`;
            break;
    }
}