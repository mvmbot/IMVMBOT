// Function to make sure the sign-up form is good to go!
function validateFormSignUp() {
    // Collecting your awesome details
    var username = document.getElementById('username').value;
    var name = document.getElementById('name').value;
    var surname = document.getElementById('surname').value;
    var mail = document.getElementById('mail').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    var privacyCheckbox = document.getElementById("privacyCheckbox");

    // Oops! Did you forget something? Checking for empty fields
    if (username.trim() === '' || name.trim() === '' || surname.trim() === '' || mail.trim() === '' || password.trim() === '' || confirmPassword.trim() === '') {
        alert('Uh-oh! It looks like you forgot to fill in some fields. Please make sure to complete all sections.');
    }

    // Let's see if that email shape is right
    var mailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!mailRegex.test(mail)) {
        alert(`Oh no! That email doesn't seem quite right. Double-check and try again, please.`);
    }

    // Did you agree to the privacy policy?
    if (!privacyCheckbox.checked) {
        alert('Hold on! Before we proceed, could you confirm that you agree with our privacy policy?');
    }

}

// Function to ensure the sign-in form is good to go too!
function validateFormSignIn() {
    // Grabbing your essentials
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // Uh-oh! Did you miss something? Checking for empty fields
    if (username.trim() === '' || password.trim() === '') {
        alert('Oopsie! It seems you forgot to fill in your username or password. Please make sure to provide both.');
    }
}
