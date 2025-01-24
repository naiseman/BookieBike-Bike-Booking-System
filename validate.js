function validateRegistrationForm() {
    var username = document.forms["registrationForm"]["username"].value;
    var password = document.forms["registrationForm"]["password"].value;

    // Check if the username is empty
    if (username.trim() === "") {
        alert("Please enter a username.");
        return false;
    }

    // Check if the password is empty
    if (password.trim() === "") {
        alert("Please enter a password.");
        return false;
    }

    // Add additional validation logic if needed

    return true;
}
