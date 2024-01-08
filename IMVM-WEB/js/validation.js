document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("signupform").addEventListener('signup', validateForm);
});

function validateForm(event) {

    // We stop the form from getting send to the php
    event.preventDefault();

    // We get the values of everything
    var username = document.getElementById('username').value;
    var name = document.getElementById('name').value;
    var surname = document.getElementById('surname').value;
    var mail = document.getElementById('mail').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    var privacyCheckbox = document.getElementById('privacyCheckbox');

    // Now we check if the values are empty, in case they are, we send an error
    if (username.trim() === '' || name.trim() === '' || surname.trim() === '' || mail.trim() === '' || password.trim() === '' || confirmPassword.trim() === '') {
        alert('Fill the form properly!');
        return;
    }

    // We check if the mail is using a mail format
    var mailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!mailRegex.test(mail)) {
        alert(`That's not a valid email!`);
        return;
    }

    // Check if they agree with our privacy policy
    if (!privacyCheckbox.checked) {
        alert('Please confirm that you agree with our privacy policy!');
        return;
    }

    // If everything's alright, we send the form
    this.submit();
}