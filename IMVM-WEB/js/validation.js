// Function to make sure the sign-up form is good to go
function validateFormSignUp() {
    // Collecting user's details
    var username = document.getElementById('username').value;
    var name = document.getElementById('name').value;
    var surname = document.getElementById('surname').value;
    var mail = document.getElementById('mail').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    var privacyCheckbox = document.getElementById("privacyCheckbox");

    // Checking for empty fields incase the user is kind of dumb
    if (username.trim() === '' || name.trim() === '' || surname.trim() === '' || mail.trim() === '' || password.trim() === '' || confirmPassword.trim() === '') {
        alert('Please complete the form properly!.');
        return;
    }

    // Let's see if the email format is right
    var mailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!mailRegex.test(mail)) {
        alert(`That email doesn't seem quite right. Check and try again.`);
        return;
    }

    // Checking if the user agreed with the privacy policy
    if (!privacyCheckbox.checked) {
        alert('You must confirm that you agree with our privacy policy');
        return;
    }

}

// Function to ensure the sign-in form is good to go aswell
function validateFormSignIn() {
    // Grabbing your essentials
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // We check if something's empty
    if (username.trim() === '' || password.trim() === '') {
        alert('Fill the form properly.');
    }
}